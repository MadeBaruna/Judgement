<?php

namespace Judgement\Http\Controllers\Contest;

use Illuminate\Http\Request;
use Judgement\Http\Requests;
use Judgement\Http\Controllers\Controller;
use Judgement\Contest;
use DB;
use Validator;
use Judgement\Problem;
use Judgement\Submission;
use Auth;

class SubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'contest', 'contestSubmission']);
    }

    public function submitPost(Request $request, $id, $problemId)
    {
        $contest = Contest::findOrFail($id);
        $problem = Problem::findOrFail($problemId);

        $rules = $rules = [
            'input_file' => 'required|file',
            'language' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        } else {
            if ($request->file('input_file')->isValid()) {
                $user = Auth::user();
                $language = $contest->languages()->where('id', '=', $request->get('language'));

                if ($language->count() != 1) {
                    return redirect()->back()->withErrors(['Language not available']);
                }

                $contestType = $contest->type;
                $groupId = $contestType == 'group' ? $user->current_group_id : NULL;

                $submission = Submission::create([
                    'type' => $contestType,
                    'contest_id' => $id,
                    'problem_id' => $problemId,
                    'group_id' => $groupId,
                    'user_id' => $user->id,
                    'language_id' => $language->first()->id,
                    'status' => 'Submitted',
                    'filename' => $request->input_file->getClientOriginalName()
                ]);

                $destinationPath = storage_path(
                    'contest/' . $id .
                    '/problem/' . $problemId .
                    '/' . $user->id .
                    '/' . $submission->id . '/');
                $fileName = $request->input_file->getClientOriginalName();

                $request->file('input_file')->move($destinationPath, $fileName);

                $submission->judge();

                return redirect()->back();
            } else {
                return redirect()->back()->withErrors(['File Error']);
            }
        }
    }
}
