<?php

namespace Judgement\Http\Controllers;

use Judgement\Contest;
use Auth;

trait ContestTrait
{
    public function getContest($id)
    {
        $contest = Contest::findOrFail($id);
        $contest->updateStatus();
        return $contest;
    }

    public function getContests()
    {
        $contests = Contest::all();
        foreach ($contests as $contest) $contest->updateStatus();
        return $contests;
    }

    public function getAvailableContests()
    {
        $user = Auth::user();
        $contests = Contest::where('active', '=', 1)->get();

        $availableContests = [];

        foreach ($contests as $contest) {
            $contestType = $contest->type;

            $userGroups = $user->groups;

            $allowedUsers = $contest->allowedUsers;
            if ($allowedUsers->count() > 0) {
                if($contestType == 'group') {
                    foreach ($userGroups as $userGroup) {
                        $leaderEmail = $userGroup->leader->email;
                        if($allowedUsers->contains('email', $leaderEmail)) {
                            array_push($availableContests, $contest);
                        }
                    }
                } else {
                    if($allowedUsers->contains('email', $user->email)) {
                        array_push($availableContests, $contest);
                    }
                }
            } else {
                array_push($availableContests, $contest);
            }
        }

        return $availableContests;
    }
}