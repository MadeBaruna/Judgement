<?php

namespace Judgement;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Scoreboard extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'type',
        'contest_id',
        'problem_id',
        'group_id',
        'user_id',
        'submission_count',
        'time_penalty',
        'accepted'
    ];

    public static function updateScore(Submission $submission)
    {
        $score = static::firstOrNew([
            'type' => $submission->type,
            'contest_id' => $submission->contest_id,
            'problem_id' => $submission->problem_id,
            'group_id' => $submission->group_id,
            'user_id' => $submission->user_id
        ]);

        if ($score->accepted == 1) {
            return;
        }

        $startTime = Carbon::parse(Contest::find($submission->contest_id)->start_time);
        $submittedTime = Carbon::parse($submission->submitted_at);
        if ($submission->status == 'AC') {
            $diff = $submittedTime->diffInMinutes($startTime);
            $diff == 0 ?: 1;
            $score->time_penalty += $diff;
        } else {
            $score->time_penalty = 0;
        }
        $score->submission_count++;
        $score->accepted = $submission->status == 'AC' ? 1 : 0;

        $score->save();
    }

    public static function getScores(Contest $contest)
    {
        $type = $contest->type == 'individual' ? 'user_id' : 'group_id';

        $scoreId = [];
        $scoreTotal = [];
        $scoreProblem = [];
        $scoreProblemTotal = [];
        $scorePenalty = [];
        $scoreProblemPenalty = [];

        if ($type == 'user_id') {
            $submitter = $contest->users;
        } else {
            foreach ($contest->users as $user) {
                $submitter = [];
                $group = Group::find($user->current_group_id);
                if (!in_array($group, $submitter)) {
                    array_push($submitter, $group);
                }
            }
        }

        foreach ($submitter as $i => $user) {
            $scoreboards = static::where($type, '=', $user->id)->get();
            $key = $i;

            if (!isset($scoreTotal[$key])) $scoreTotal[$key] = 0;
            if (!isset($scorePenalty[$key])) $scorePenalty[$key] = 0;
            if (!isset($scoreProblem[$key])) $scoreProblem[$key] = [];
            if (!isset($scoreProblemPenalty[$key])) $scoreProblemPenalty[$key] = [];

            array_push($scoreId, $user->id);
            foreach ($scoreboards as $scoreboard) {
                $scoreTotal[$key] += $scoreboard->accepted;
                $scorePenalty[$key] += $scoreboard->time_penalty + ($scoreboard->submission_count - 1) * 20;
                array_push($scoreProblem[$key], $scoreboard->submission_count);
                array_push($scoreProblemPenalty[$key], $scoreboard->time_penalty);
            }
        }

        array_multisort(
            $scoreTotal, SORT_DESC,
            $scorePenalty, SORT_ASC,
            $scoreId,
            $scoreProblem,
            $scoreProblemPenalty
        );

        return [$scoreId, $scoreTotal, $scorePenalty, $scoreProblem, $scoreProblemPenalty];
    }
}
