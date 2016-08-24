<?php

namespace Judgement\Http\Controllers\Contest;

use Illuminate\Http\Request;
use Judgement\Http\Requests;
use Judgement\Http\Controllers\Controller;
use Judgement\Contest;

class ContestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'contest']);
    }

    public function index($id)
    {
        $contest = Contest::findOrFail($id);
        $problems = $contest->problems;
        $currentProblem = 0;
        return view('contest/announcement', [
            'contest' => $contest,
            'problems' => $problems,
            'currentProblem' => $currentProblem
        ]);
    }
}
