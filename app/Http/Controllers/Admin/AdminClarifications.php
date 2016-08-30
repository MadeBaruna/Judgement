<?php

namespace Judgement\Http\Controllers\Admin;

use Judgement\Clarification;
use Judgement\Http\Controllers\ContestTrait;
use Judgement\Http\Controllers\Controller;
use Judgement\Contest;
use Judgement\Scoreboard;
use Illuminate\Http\Request;
use Validator;

class AdminClarifications extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function clarifications($id)
    {
        $contest = Contest::findOrFail($id);
        $allproblems = $contest->problems;
        $clarifications = $contest->clarifications()
            ->orderBy('is_answered', 'ASC')
            ->orderBy('id', 'DESC')
            ->paginate(15);
        return view('admin/clarifications', [
            'contest' => $contest,
            'clarifications' => $clarifications,
            'allproblems' => $allproblems,
        ]);
    }

    public function answer(Request $request, $id, $cla)
    {
        $contest = Contest::findOrFail($id);
        $clarification = Clarification::findOrFail($cla);

        $rules = [
            'answer' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator->errors());
        }

        $clarification->update([
            'answer' => $request->answer,
            'is_answered' => 1
        ]);

        return redirect('/admin/clarifications/' . $contest->id);
    }
}
