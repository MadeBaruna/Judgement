<?php

namespace Judgement\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Judgement\Http\Controllers\Controller;
use Judgement\Http\Requests;
use Judgement\Problem;
use Validator;
use Auth;
USE DB;

class AdminProblem extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    private function getProblems()
    {
        $problems = DB::table('problems')->paginate(15);
        return $problems;
    }

    public function returnProblemsView()
    {
        return redirect('/admin/problems');
    }

    public function newProblem()
    {
        return view('admin/problem/new');
    }

    public function problems()
    {
        return view('admin/problem/problem', ['problems' => $this->getProblems()]);
    }

    public function problemSummary($id)
    {
        $problem = Problem::findOrFail($id);
        return view('admin/problem/summary', ['problem' => $problem]);
    }

    public function newProblemPost(Request $request)
    {
        $rules = [
            'problem_name' => 'required|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator->errors());
        }

        $data = $request->all();
        $problem = Problem::create([
            'name' => $data['problem_name'],
            'statement' => $data['statement'],
            'time_limit' => $data['time_limit'],
            'memory_limit' => $data['memory_limit'],
            'author_id' => Auth::user()->id
        ]);

        return $this->returnProblemsView();
    }

    public function editProblem($id)
    {
        $problem = Problem::findOrFail($id);
        return view('admin/problem/edit', ['problem' => $problem]);
    }

    public function editProblemPost(Request $request, $id)
    {
        $problem = Problem::findOrFail($id);

        $rules = [
            'problem_name' => 'required|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator->errors());
        }

        $data = $request->all();
        $problem->update([
            'name' => $data['problem_name'],
            'statement' => $data['statement'],
            'time_limit' => $data['time_limit'],
            'memory_limit' => $data['memory_limit'],
        ]);

        return $this->returnProblemsView();
    }

    public function deleteProblemPost($id)
    {
        $problem = Problem::findOrFail($id);

        $problem->contests()->detach();
        $problem->submissions()->delete();

        $problem->delete();

        return $this->returnProblemsView();
    }
}
