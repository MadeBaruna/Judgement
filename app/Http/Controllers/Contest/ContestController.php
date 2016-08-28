<?php

namespace Judgement\Http\Controllers\Contest;

use Illuminate\Http\Request;
use Judgement\Http\Requests;
use Judgement\Http\Controllers\Controller;
use Judgement\Contest;
use DB;
use Judgement\Language;
use Judgement\Problem;
use Judgement\Scoreboard;
use Judgement\Submission;
use Auth;

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

    public function submissions($id)
    {
        $contest = Contest::findOrFail($id);
        $user = Auth::user();
        $submissions = $user->submissions()->where('contest_id', '=', $id)->paginate(15);
        $type = $contest->type;
        return view('contest/submissions', [
            'contest' => $contest,
            'submissions' => $submissions
        ]);
    }

    public function submissionView($id, $sub)
    {
        $contest = Contest::findOrFail($id);
        $submission = Submission::find($sub);
        $user = Auth::user();
        if ($submission->user_id != $user->id) {
            return redirect('/contest/' . $id . '/submissions');
        }

        $problem = Problem::find($submission->problem_id);
        $language = Language::find($submission->language_id);

        $source = storage_path(
            'contest/' . $id .
            '/problem/' . $problem->id .
            '/' . $user->id .
            '/' . $submission->id .
            '/' . $submission->filename);
        $code = file_get_contents($source);

        return view('contest/submission', [
            'contest' => $contest,
            'problem' => $problem,
            'submission' => $submission,
            'language' => $language,
            'code' => $code
        ]);
    }
}
