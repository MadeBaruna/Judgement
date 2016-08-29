<?php

namespace Judgement\Jobs;

use Judgement\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Judgement\Sandbox;
use Judgement\Submission;
use Judgement\Scoreboard;

class JudgeSubmission extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $submission;

    public function __construct(Submission $submission)
    {
        $this->submission = $submission;
    }

    public function handle()
    {
        echo 'Judging submission id: ' . $this->submission->id . PHP_EOL;

        $sandbox = Sandbox::getAvailableSandbox();
        $sandbox->init();
        echo 'Initializing sandbox id: ' . $sandbox->id . PHP_EOL;

        echo 'Compiling submission id: ' . $this->submission->id . PHP_EOL;
        $status = $this->submission->compile($sandbox);

        if ($status != 0) {
            $this->submission->status = 'CE';
            $this->submission->save();
            echo 'Compile error' . PHP_EOL;
            $sandbox->clean();
            Scoreboard::updateScore($this->submission);
            return;
        }

        echo 'Running submission id: ' . $this->submission->id . PHP_EOL;
        $this->submission->grade($sandbox);

        Scoreboard::updateScore($this->submission);

        echo 'Cleaning up sandbox id: ' . $sandbox->id . PHP_EOL;
        $sandbox->clean();
    }
}
