<?php

namespace Judgement;

use Illuminate\Database\Eloquent\Model;
use Judgement\Judgement;
use Auth;

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
            return 1;
        }

        $judge = $this->grade();
        dump($judge);
        if ($judge['status'] != null) {
            $this->status = $judge['status'];
            $this->score = $judge['score'];
            $this->save();
            return 1;
        } else {
            $this->status = 'AC';
            $this->score = $judge['score'];
            $this->save();
            Scoreboard::updateScore($this);
            return 0;
        }
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

    public function run($in)
    {
        $userId = 1;

        if (!is_dir('/tmp/box/' . $userId . '/box')) {
            exec('isolate --cg -b' . $userId . ' --init');
        }

        if (!is_writable('/tmp/box/' . $userId . '/box')) {
            exec('isolate --cg -b' . $userId . ' --init');
        }

        $language = Language::detail($this->language_id);

        $fileNameNoExt = pathinfo($this->filename)['filename'];
        $fileName = str_replace('%filename', $fileNameNoExt, $language->compiled_name);

        $isolatePath = '/tmp/box/' . $userId . '/box/' . $this->getPath();

        $problem = Problem::find($this->problem_id)->first();
        $executor = str_replace(
            ['%filename', '%isolatePath', '%mem'],
            [$fileNameNoExt, $this->getPath(), $problem->memory_limit],
            $language->executor_path);

        copy($in['path'], $isolatePath . $in['id'] . '.in');

        $cgEnabled = $language->cg == 1 ? true : false;
        $builder =
            'isolate' .
            ($cgEnabled ? ' --cg' : '') .
            ' -b' . $userId .
            ' --processes=' . ($language->threads_num > 1 ? $language->threads_num : 1) .
            ($problem->time_limit > 0 ? ' --wall-time=' . $problem->time_limit : '') .
            ($problem->memory_limit > 0 && !$cgEnabled ? ' --mem=' . $problem->memory_limit : '') .
            ($problem->memory_limit > 0 && $cgEnabled ? ' --cg-mem=' . $problem->memory_limit : '') .
            ' --stdin=' . $this->getPath() . $in['id'] . '.in' .
            ' --meta=' . $this->getPathWithStorage() . 'detail.txt' .
            ' --stdout=' . $this->getPath() . 'output.txt' .
            ' --run -- ' . $executor . ' 2>&1';

        exec($builder, $output, $status);

        $status = $this->getDetail($this->getPathWithStorage() . 'detail.txt', 'status');

        if ($status == null) {
            copy($isolatePath . 'output.txt', $this->getPathWithStorage() . 'output.txt');
        }

        return $status;
    }

    public function grade()
    {
        $userId = 1;

        $language = Language::detail($this->language_id);

        $fileNameNoExt = pathinfo($this->filename)['filename'];
        $fileName = str_replace('%filename', $fileNameNoExt, $language->compiled_name);

        $compiled = $this->getPathWithStorage() . $fileName;

        $isolatePath = '/tmp/box/' . $userId . '/box/' . $this->getPath();

        if (!is_dir($isolatePath)) {
            mkdir($isolatePath, 0777, true);
        }

        rename($compiled, $isolatePath . $fileName);

        $testcases = $this->problem->testcases;
        $result['status'] = null;
        $result['right_answer'] = 0;
        $result['score'] = 0;
        foreach ($testcases as $testcase) {
            $inputFile['path'] = $testcase->in();
            $inputFile['id'] = $testcase->id;

            $run = $this->run($inputFile);
            if ($run != null) {
                $result['status'] = $run;
                return $result;
            }

            $answer = fopen($testcase->out(), 'r');
            $output = fopen($this->getPathWithStorage() . 'output.txt', 'r');

            $result['status'] = null;
            while (!feof($answer)) {
                $lineA = fgets($answer);
                $lineO = fgets($output);
                if ($lineA !== $lineO) {
                    $result['status'] = 'WA';
                    break;
                }
            }

            fclose($answer);
            fclose($output);

            if ($result['status'] != null) return $result;
            $result['right_answer']++;
            $result['score'] = $result['right_answer'] / $testcases->count() * 100;
        }

        return $result;
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

    public function getDetail($file, $name)
    {
        $lines = file($file);
        foreach ($lines as $line) {
            if (strpos($line, $name) !== false) {
                $value = explode(':', $line);
                return $value[1];
            }
        }
    }
}
