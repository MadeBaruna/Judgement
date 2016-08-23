<?php

namespace Judgement\Http\Controllers\Admin;

use Judgement\Http\Controllers\ContestTrait;
use Judgement\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Judgement\Contest;
use Validator;
use Carbon\Carbon;
use Judgement\AllowedUser;

class AdminContest extends Controller
{
    use ContestTrait;

    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function returnContestView()
    {
        return redirect('/admin/contests');
    }

    public function contests()
    {
        echo view('admin/contest/contest', ['contests' => $this->getContests()]);
    }

    public function contestSummary($id)
    {
        $contest = $this->getContest($id);

        $languages = $contest->languages;
        $categories = $contest->categories;
        $emails = $contest->allowedUsers;
        return view('admin/contest/summary', [
            'contest' => $contest,
            'languages' => $languages,
            'categories' => $categories,
            'emails' => $emails,
        ]);
    }

    public function newContest()
    {
        return view('admin/contest/new');
    }

    public function newContestPost(Request $request)
    {
        $rules = [
            'contest_name' => 'required|max:255',
            'type' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'language' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator->errors());
        }

        $data = $request->all();

        $now = Carbon::now();
        $start = Carbon::parse($data['start_time']);
        $status = 'Not Started';
        if ($now->gte($start)) {
            $status = 'Started';
        }

        $active = 0;
        if (isset($data['active'])) {
            $active = $data['active'] == 'on' ? 1 : 0;
        }

        $contest = Contest::create([
            'name' => $data['contest_name'],
            'type' => $data['type'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'status' => $status,
            'active' => $active,
            'announcement' => $data['announcement']
        ]);

        $languages = explode(',', $data['language']);
        $contest->languages()->attach($languages);

        $categories = explode(',', $data['category']);
        $contest->categories()->attach($categories);

        $emails = explode(',', $data['allowed_user']);
        if ($data['allowed_user'] != '') {
            foreach ($emails as $email) {
                $allowedUser = AllowedUser::create([
                    'contest_id' => $contest->id,
                    'email' => $email
                ]);
                $contest->allowedUsers()->save($allowedUser);
            }
        }

        return $this->returnContestView();
    }

    public function editContest($id)
    {
        $contest = Contest::findOrFail($id);

        $languages = $contest->languages;
        $langIds = '';
        for ($i = 0; $i < count($languages); $i++) {
            $langIds .= $languages[$i]->id;
            if ($i != count($languages) - 1) $langIds .= ',';
        }

        $categories = $contest->categories;
        $categoryIds = '';
        for ($i = 0; $i < count($categories); $i++) {
            $categoryIds .= $categories[$i]->id;
            if ($i != count($categories) - 1) $categoryIds .= ',';
        }

        $allowedUsers = $contest->allowedUsers;
        $emails = '';
        for ($i = 0; $i < count($allowedUsers); $i++) {
            $emails .= $allowedUsers[$i]->email;
            if ($i != count($allowedUsers) - 1) $emails .= ',';
        }

        return view('admin/contest/edit', [
            'contest' => $contest,
            'languages' => $langIds,
            'categories' => $categoryIds,
            'allowed_users' => $emails
        ]);
    }

    public function editContestPost(Request $request, $id)
    {
        $contest = Contest::findOrFail($id);

        $rules = [
            'contest_name' => 'required|max:255',
            'type' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'language' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator->errors());
        }

        $data = $request->all();

        $now = Carbon::now();
        $start = Carbon::parse($data['start_time']);
        $status = 'Not Started';
        if ($now->gte($start)) {
            $status = 'Started';
        }

        $active = 0;
        if (isset($data['active'])) {
            $active = $data['active'] == 'on' ? 1 : 0;
        }

        $contest->update([
            'name' => $data['contest_name'],
            'type' => $data['type'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'status' => $status,
            'active' => $active,
            'announcement' => $data['announcement']
        ]);

        $languages = explode(',', $data['language']);
        $contest->languages()->detach();
        $contest->languages()->attach($languages);

        $categories = explode(',', $data['category']);
        $contest->categories()->detach();
        $contest->categories()->attach($categories);

        $contest->allowedUsers()->delete();
        if($data['allowed_user'] != '') {
            $emails = explode(',', $data['allowed_user']);
            foreach ($emails as $email) {
                $allowedUser = AllowedUser::create([
                    'contest_id' => $contest->id,
                    'email' => $email
                ]);
                $contest->allowedUsers()->save($allowedUser);
            }
        }

        return $this->returnContestView();
    }

    public function deleteContestPost($id)
    {
        $contest = Contest::findOrFail($id);

        $contest->languages()->detach();
        $contest->categories()->detach();
        $contest->allowedUsers()->delete();

        $contest->delete();

        return $this->returnContestView();
    }
}
