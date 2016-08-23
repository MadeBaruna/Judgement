<?php

namespace Judgement\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Judgement\Http\Controllers\Controller;
use Judgement\Http\Requests;
use Judgement\Contest;
use Judgement\Problem;
use Validator;

class AdminContestProblem extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }


    public function problems($id)
    {
        $contest = Contest::findOrFail($id);
        $problems = $contest->problems;
        $allProblems = Problem::whereDoesntHave('contests', function ($query) use ($id) {
            $query->whereId($id);
        })->get();
        return view('admin/contest/problems', [
            'contest' => $contest,
            'problems' => $problems,
            'allproblems' => $allProblems
        ]);
    }

    public function addProblemPost(Request $request, $id)
    {
        $contest = Contest::findOrFail($id);

        $rules = [
            'contest' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        } else {
            $problem = Problem::findOrFail($request->get('contest'));

            $contest->problems()->attach($problem);

            return redirect()->back();
        }
    }

    public function deleteProblemPost(Request $request, $id)
    {
        $contest = Contest::findOrFail($id);

        $problemIds = explode(',', $request->get('problem'));

        $contest->problems()->detach($problemIds);

        return redirect()->back();
    }
}
