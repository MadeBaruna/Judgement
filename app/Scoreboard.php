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

        if ($submission->type == 'AC') {
            return;
        }

        $startTime = Carbon::parse(Contest::find($submission->contest_id)->start_time);
        $submittedTime = Carbon::parse($submission->submitted_at);
        $score->time_penalty += $submittedTime->diffInMinutes($startTime);
        $score->time_penalty += $score->submission_count * 20;
        $score->submission_count++;
        $score->accepted = $submission->status == 'AC' ? 1 : 0;

        $score->save();
    }
}
