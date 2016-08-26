<?php

namespace Judgement\Http\Controllers\Contest;

use Illuminate\Http\Request;
use Judgement\Http\Requests;
use Judgement\Http\Controllers\Controller;
use Judgement\Contest;
use DB;
use Judgement\Language;
use Judgement\Scoreboard;
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

    public function scoreboard($id)
    {
        $contest = Contest::findOrFail($id);
        list($scoreId, $scoreTotal, $scorePenalty, $scoreProblem, $scoreProblemPenalty) = Scoreboard::getScores($contest);
        $type = $contest->type;
        $problemCount = $contest->problems->count();
        return view('contest/scoreboard', [
            'contest' => $contest,
            'type' => $type,
            'problem_count' => $problemCount,
            'score_id' => $scoreId,
            'score_total' => $scoreTotal,
            'score_penalty' => $scorePenalty,
            'score_problem' => $scoreProblem,
            'score_problem_penalty' => $scoreProblemPenalty
        ]);
    }
}
