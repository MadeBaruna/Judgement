<?php

namespace Judgement\Http\Controllers\Profile;

use Illuminate\Http\Request;
use Judgement\Group;
use Judgement\GroupInvite;
use Judgement\Http\Controllers\Controller;
use Auth;
use Judgement\Scoreboard;
use Judgement\User;
use Judgement\Contest;
use Validator;
use Image;

class ProfileGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function groups()
    {
        $user = Auth::user();
        $groups = $user->groups;
        $invites = $user->invites;
        return view('profile/groups', [
            'groups' => $groups,
            'invites' => $invites
        ]);
    }

    public function newGroupPost(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'group_name' => 'required|max:255'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $group = Group::create([
            'leader_id' => $user->id,
            'name' => $request->group_name
        ]);

        if ($user->groups->count() == 0) {
            $user->current_group_id = $group->id;
            $user->save();
        }

        $user->groups()->attach($group);

        return redirect()->back();
    }

    public function deleteGroupPost($id)
    {
        $group = Group::findOrFail($id);
        $user = Auth::user();

        if ($group->leader_id != $user->id) {
            return response(403);
        }

        Scoreboard::where('type', '=', 'group')->where('group_id', '=', $group->id)->delete();

        $users = User::where('current_group_id', '=', $group->id)->get();
        foreach ($users as $u) {
            $u->current_group_id = 0;
            $u->save();
        }

        $contests = Contest::where('type', '=', 'group')->get();
        foreach ($contests as $contest) {
            $contest->users()->detach($users);
        }

        $group->delete();

        return redirect()->back();
    }

    public function activeGroupPost($id)
    {
        $group = Group::findOrFail($id);
        $user = Auth::user();

        if (!$user->groups->contains($group)) {
            return response(403);
        }

        $user->current_group_id = $group->id;
        $user->save();

        return redirect()->back();
    }

    public function leave($id)
    {
        $group = Group::find($id);
        $user = Auth::user();

        if ($user->current_group_id == $group->id) {
            $user->current_group_id = 0;
            $user->save();

            $contests = Contest::where('type', '=', 'group')->get();
            foreach ($contests as $contest) {
                $contest->users()->detach($user);
            }
        }

        $user->groups()->detach($group);

        return redirect()->back();
    }

    public function invite(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $user = Auth::user();

        if ($group->leader_id != $user->id) {
            return response(403);
        }

        $emails = explode(',', $request->invite);

        foreach ($emails as $email) {
            $u = User::where('email', '=', $email)->first();
            if ($u != null) {
                GroupInvite::create([
                    'user_id' => $u->id,
                    'group_id' => $id
                ]);
            }
        }

        return redirect()->back();
    }

    public function confirm(Request $request, $id)
    {
        $user = Auth::user();

        $status = $request->group_invite;

        $invite = GroupInvite::where('group_id', '=', $id)->where('user_id', '=', $user->id)->get();

        if ($invite && $status == 'accept') {
            $user->groups()->attach($id);
        }

        GroupInvite::where('group_id', '=', $id)->where('user_id', '=', $user->id)->delete();

        return redirect()->back();
    }

    public function upload(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $user = Auth::user();

        if ($group->leader_id != $user->id) {
            return response(403);
        }

        $rules = [
            'image' => 'required|image|max:2000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        } else {
            if ($request->file('image')->isValid()) {
                $destinationPath = public_path('profiles/pictures/groups');
                $fileName = $id . '.png';
                $path = $destinationPath . '/' . $fileName;

                Image::make($request->file('image'))->fit(200, 200)->save($path);
                return redirect()->back();
            } else {
                return response()->json(['image' => ['Invalid picture']]);
            }
        }
    }
}
