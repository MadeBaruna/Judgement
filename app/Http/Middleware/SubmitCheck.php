<?php

namespace Judgement\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Judgement\Contest;
use Judgement\User;

class SubmitCheck
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
        $contest->updateStatus();

        if ($contest->status == 'Ended') {
            $endTime = Carbon::parse($contest->end_time)->diffForHumans();
            $error = [
                'title' => 'Contest Has Ended',
                'description' => 'The contest ' . $contest->name . ' has ended ' . $endTime
            ];
            return redirect()->back()->withErrors($error);
        }

        return $next($request);
    }
}
