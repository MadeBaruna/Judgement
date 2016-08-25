<?php

namespace Judgement;

use Illuminate\Database\Eloquent\Model;
use Judgement\Judgement;

class Submission extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'type',
        'contest_id',
        'problem_id',
        'group_id',
        'user_id',
        'language_id',
        'score',
        'status',
        'submitted_at',
        'filename'
    ];

    public function problem()
    {
        return $this->belongsTo('Judgement\Problem');
    }

    public function user()
    {
        return $this->belongsTo('Judgement\User');
    }

    public function judge()
    {
        $compile = $this->compile();

        if ($compile != 0) {
            $this->status = 'Compile Error';
            $this->save();
            return $compile;
        }

        $this->status = 'Compiled';
        $this->save();

        $this->run();
    }

    function compile()
    {
        $language = Language::detail($this->language_id);

        $source = $this->getPathWithStorage() . $this->filename;

        $fileNameNoExt = pathinfo($this->filename)['filename'];

        $compiler = str_replace('%filename', $fileNameNoExt, $language->compiler_path);

        $command = 'cd ' . $this->getPathWithStorage() . ' && ' . $compiler . ' ' . $source . ' 2>&1';

        exec($command, $output, $status);
        return $status;
    }

    public function run()
    {
        if (!is_dir('/tmp/box/0/box')) {
            echo 'creating isolate dir';
            exec('isolate --cg --init');
        }

        if (!is_writable('/tmp/box/0/box')) {
            echo 'cleaning up isolate dir';
            exec('isolate --cg --init');
        }

        $language = Language::detail($this->language_id);

        $fileNameNoExt = pathinfo($this->filename)['filename'];
        $fileName = str_replace('%filename', $fileNameNoExt, $language->compiled_name);

        $compiled = $this->getPathWithStorage() . $fileName;

        $isolatePath = '/tmp/box/0/box/' . $this->getPath();

        if (!is_dir($isolatePath)) {
            mkdir($isolatePath, 0777, true);
        }

        rename($compiled, '/tmp/box/0/box/' . $this->getPath() . $fileName);

        $problem = Problem::find($this->problem_id)->first();
        $executor = str_replace(
            ['%filename', '%isolatePath', '%mem'],
            [$fileNameNoExt, $this->getPath(), $problem->memory_limit],
            $language->executor_path);

        $cgEnabled = $language->cg == 1 ? true : false;
        $builder =
            'isolate' .
            ($cgEnabled ? ' --cg' : '') .
            ' --processes=' . ($language->threads_num > 1 ? $language->threads_num : 1) .
            ($problem->time_limit > 0 ? ' --wall-time=' . $problem->time_limit : '') .
            ($problem->memory_limit > 0 && !$cgEnabled ? ' --mem=' . $problem->memory_limit : '') .
            ($problem->memory_limit > 0 && $cgEnabled ? ' --cg-mem=' . $problem->memory_limit : '') .
            ' --meta=' . $isolatePath . 'detail.txt' .
            ' --stdout=' . $this->getPath() . 'output.txt' .
            ' --run -- ' . $executor . ' 2>&1';

        exec($builder, $output, $status);
        return $status;
    }

    public function getPathWithStorage()
    {
        $source = storage_path($this->getPath());
        return $source;
    }

    public function getPath()
    {
        $typeId = $this->type == 'individual' ? $this->user_id : $this->group_id;
        $source = 'contest/' . $this->contest_id .
            '/problem/' . $this->problem_id .
            '/' . $typeId .
            '/' . $this->id .
            '/';
        return $source;
    }
}
