<?php

namespace Judgement\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Judgement\Contest;
use Judgement\User;

class ContestCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $contestId = $request->route('id');
        $contest = Contest::findOrFail($contestId);
        $contestType = $contest->type;

        if ($contest->status == 'Not Started') {
            $startTime = Carbon::parse($contest->start_time)->diffForHumans();
            $error = [
                'title' => 'Contest Not Yet Started',
                'description' => 'The contest ' . $contest->name . ' will start ' . $startTime
            ];
            return redirect()->route('index')->withErrors($error);
        }

        $user = Auth::user();

        $userGroups = $user->groups;
        if ($contestType == 'group' && count($userGroups) == 0) {
            $error = [
                'title' => 'Group Contest',
                'description' => 'You need a group to join contest ' . $contest->name
            ];
            return redirect()->route('index')->withErrors($error);
        }

        $allowedUsers = $contest->allowedUsers;
        if ($allowedUsers->count() > 0) {
            if($contestType == 'group') {
                foreach ($userGroups as $userGroup) {
                    $leaderEmail = $userGroup->leader->email;
                    if(!$allowedUsers->contains('email', $leaderEmail)) {
                        $error = [
                            'title' => 'Access Forbidden',
                            'description' => 'You cannot access the contest'
                        ];
                        return redirect()->route('index')->withErrors($error);
                    }
                }
            } else {
                if(!$allowedUsers->contains('email', $user->email)) {
                    $error = [
                        'title' => 'Access Forbidden',
                        'description' => 'You cannot access the contest'
                    ];
                    return redirect()->route('index')->withErrors($error);
                }
            }
        }

        //TODO: category check

        return $next($request);
    }
}
