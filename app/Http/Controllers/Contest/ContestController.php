<?php

namespace Judgement\Http\Controllers\Contest;

use Illuminate\Http\Request;
use Judgement\Http\Requests;
use Judgement\Http\Controllers\Controller;
use Judgement\Contest;
use DB;
use Judgement\Language;
use Judgement\Submission;

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
        return view('contest/announcement', [
            'contest' => $contest,
            'problems' => $problems,
        ]);
    }

    public function problem($id, $problemId)
    {
        $contest = Contest::findOrFail($id);
        $problem = $contest->problems()->findOrFail($problemId);
        $problems = $contest->problems;
        $languages = $contest->languages;
        return view('contest/problem', [
            'contest' => $contest,
            'problems' => $problems,
            'currentProblem' => $problem,
            'languages' => $languages
        ]);
    }
}
