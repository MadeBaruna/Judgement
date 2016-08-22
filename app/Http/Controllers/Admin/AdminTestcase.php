<?php

namespace Judgement\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Judgement\Http\Controllers\Controller;
use Judgement\Http\Requests;
use Judgement\Problem;
use Validator;
use Auth;
USE Judgement\Testcase;

class AdminTestcase extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }


    public function testcases($id)
    {
        $problem = Problem::findOrFail($id);
        $testcases = $problem->testcases;
        return view('admin/problem/testcase', [
            'problem' => $problem,
            'testcases' => $testcases
        ]);
    }

    public function newTestcasePost(Request $request, $id)
    {
        $problem = Problem::findOrFail($id);

        $rules = $rules = [
            'input_file' => 'required|file',
            'output_file' => 'required|file'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        } else {
            if ($request->file('input_file')->isValid() && $request->file('output_file')->isValid()) {
                $testcase = Testcase::create([
                    'problem_id' => $problem->id,
                    'input_size' => filesize($request->file('input_file')),
                    'output_size' => filesize($request->file('output_file')),
                ]);

                $destinationPath = storage_path('problems/' . $id . '/testcases/');
                $fileNameInput = $testcase->id . '.in';
                $fileNameOutput = $testcase->id . '.out';

                $request->file('input_file')->move($destinationPath, $fileNameInput);
                $request->file('output_file')->move($destinationPath, $fileNameOutput);

                return redirect()->back();
            } else {
                return redirect()->back()->withErrors(['File Error']);
            }
        }
    }

    public function deleteTestCasePost(Request $request, $id)
    {
        Problem::findOrFail($id);
        $testcaseIds = explode(',', $request->get('testcase'));

        foreach ($testcaseIds as $testcaseId) {
            $testcase = Testcase::find($testcaseId);
            if($testcase != null) {
                $testcase->delete();

                $path = storage_path('problems/' . $id . '/testcases/');
                $fileNameInput = $testcase->id . '.in';
                $fileNameOutput = $testcase->id . '.out';

                if(file_exists($path . $fileNameInput)) unlink($path . $fileNameInput);
                if(file_exists($path . $fileNameOutput)) unlink($path . $fileNameOutput);
            }
        }

        return redirect()->back();
    }
}
