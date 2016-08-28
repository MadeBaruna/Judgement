<?php

namespace Judgement\Http\Controllers\Admin;

use Judgement\Http\Controllers\ContestTrait;
use Judgement\Http\Controllers\Controller;
use Judgement\Contest;
use Judgement\Scoreboard;

class AdminScoreboard extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function scoreboard($id)
    {
        $contest = Contest::findOrFail($id);
        list($scoreId, $scoreTotal, $scorePenalty, $scoreProblem, $scoreProblemPenalty) = Scoreboard::getScores($contest);
        $type = $contest->type;
        $problemCount = $contest->problems->count();
        return view('admin/scoreboard', [
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