<?php

namespace Judgement\Http\Controllers\Contest;

use Illuminate\Http\Request;
use Judgement\Clarification;
use Judgement\Http\Requests;
use Judgement\Http\Controllers\Controller;
use Judgement\Contest;
use DB;
use Judgement\Language;
use Judgement\Problem;
use Judgement\Scoreboard;
use Judgement\Submission;
use Validator;
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
        $submissions = $user->submissions()->where('contest_id', '=', $id)->orderBy('id', 'DESC')->paginate(15);
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

    public function clarifications($id)
    {
        $contest = Contest::findOrFail($id);
        $allproblems = $contest->problems;
        $clarifications = $contest->clarifications()->orderBy('id', 'DESC')->paginate(15);
        return view('contest/clarifications', [
            'contest' => $contest,
            'clarifications' => $clarifications,
            'allproblems' => $allproblems,
        ]);
    }

    public function newClarificationPost(Request $request, $id)
    {
        $contest = Contest::findOrFail($id);

        $rules = [
            'title' => 'required|max:255',
            'problem' => 'required',
            'question' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator->errors());
        }

        if (!($contest->problems->contains($request->problem))) {
            $request->flash();
            $error = [
                'title' => 'Problem not found',
            ];
            return redirect()->back()->withErrors($error);
        }

        Clarification::create([
            'user_id' => Auth::user()->id,
            'contest_id' => $contest->id,
            'problem_id' => $request->problem,
            'title' => $request->title,
            'question' => $request->question,
        ]);

        return redirect()->back();
    }

    public function clarificationView($id, $cla)
    {
        $contest = Contest::findOrFail($id);
        if ($contest->clarifications->contains($cla)) {
            $clarification = Clarification::findOrFail($cla);
        } else {
            return response(404);
        }

        $problem = Problem::find($clarification->problem_id);

        return response()->json([
            'title' => $clarification->title,
            'problem' => $problem->name,
            'question' => $clarification->question,
            'answer' => $clarification->is_answered ? $clarification->answer : 'Not answered yet'
        ]);
    }
}
