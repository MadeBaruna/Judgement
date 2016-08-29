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

    public function compile(Sandbox $sandbox)
    {
        copy($this->getSourcePath(), $sandbox->path() . $this->filename);

        $language = $this->getLanguage();
        $problem = $this->problem;

        $fileNameNoExt = $this->getFileName();
        $compiler = str_replace(
            ['%filename', '%source'],
            [$fileNameNoExt, $this->filename],
            $language->compiler_path
        );

        $command = [
            'cg' => $language->cg,
            'time' => 60,
            'command' => $compiler
        ];

        if ($language->cg) {
            $command['mem'] = 0;
            $command['cgmem'] = $problem->memory_limit;
            $command['process'] = 0;
        } else {
            $command['mem'] = $problem->memory_limit;
            $command['cgmem'] = 0;
            $command['process'] = 0;
        }

        $status = $sandbox->run(
            $command['cg'],
            $command['mem'],
            $command['cgmem'],
            $command['time'],
            null,
            null,
            null,
            $command['process'],
            $command['command']
        );

        return $status;
    }

    public function run(Sandbox $sandbox, $testcaseId)
    {
        $language = $this->getLanguage();
        $problem = $this->problem;

        $fileNameNoExt = $this->getFileName();
        $executor = str_replace(
            ['%filename', '%mem'],
            [$fileNameNoExt, $problem->memory_limit],
            $language->executor_path
        );

        $command = [
            'cg' => $language->cg,
            'time' => $problem->time_limit,
            'command' => $executor
        ];

        if ($language->cg) {
            $command['mem'] = 0;
            $command['cgmem'] = $problem->memory_limit;
            $command['process'] = $language->threads_num;
        } else {
            $command['mem'] = $problem->memory_limit;
            $command['cgmem'] = 0;
            $command['process'] = $language->threads_num;
        }

        $status = $sandbox->run(
            $command['cg'],
            $command['mem'],
            $command['cgmem'],
            $command['time'],
            $sandbox->path() . 'meta.txt',
            $testcaseId . '.in',
            'output.txt',
            $command['process'],
            $command['command']
        );

        return $status;
    }

    public function grade(Sandbox $sandbox)
    {
        $testcases = $this->problem->testcases;

        $score = 0;
        $rightAnswer = 0;
        foreach ($testcases as $testcase) {
            $sandboxStdin = $sandbox->path() . $testcase->id . '.in';
            copy($testcase->in(), $sandboxStdin);

            $this->run($sandbox, $testcase->id);
            $status = $this->getDetail($sandbox->path() . 'meta.txt', 'status');

            if ($status == null) {
                $output = $sandbox->path() . 'output.txt';

                $answer = fopen($testcase->out(), 'r');
                $output = fopen($output, 'r');

                while (!feof($answer)) {
                    $lineA = fgets($answer);
                    $lineO = fgets($output);
                    if ($lineA !== $lineO) {
                        $this->status = 'WA';
                        $this->score = $score;
                        $this->save();
                        return;
                    }
                }

                fclose($answer);
                fclose($output);

                $rightAnswer++;
                $score = $rightAnswer / $testcases->count() * 100;
            } else {
                $this->status = $status;
                $this->score = $score;
                $this->save();
                return;
            }
        }

        $this->status = 'AC';
        $this->score = $score;
        $this->save();
        return;
    }

    private function getLanguage()
    {
        return Language::find($this->language_id);
    }

    public function getSourcePath()
    {
        $userId = $this->user_id;
        $source =
            storage_path(
                'contest/' . $this->contest_id .
                '/problem/' . $this->problem_id .
                '/' . $userId .
                '/' . $this->id .
                '/' . $this->filename
            );
        return $source;
    }

    public function getFileName()
    {
        $fileNameNoExt = pathinfo($this->filename)['filename'];
        return $fileNameNoExt;
    }

    public function getDetail($file, $name)
    {
        $lines = file($file);
        foreach ($lines as $line) {
            if (strpos($line, $name) !== false) {
                $value = explode(':', $line);
                return trim($value[1]);
            }
        }
    }
}
