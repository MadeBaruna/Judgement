<?php

namespace Judgement\Http\Controllers;

use Judgement\Contest;

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
}