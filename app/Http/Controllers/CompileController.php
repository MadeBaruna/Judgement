<?php

namespace Judgement\Http\Controllers;

use Judgement\Submission;

class CompileController extends Controller
{
    public function compile($id)
    {
        Submission::find($id)->judge();
    }
}
