<?php

namespace Judgement\Http\Controllers;

use Judgement\Submission;

class CompileController extends Controller
{
    public function compile()
    {
        Submission::find(1)->first()->run();
    }
}
