<?php

namespace Judgement;

use Illuminate\Database\Eloquent\Model;

class Clarification extends Model
{
    protected $fillable = [
        'user_id',
        'contest_id',
        'problem_id',
        'title',
        'question',
        'answer',
        'is_answered',
    ];

    public function contests()
    {
        return $this->belongsTo('Judgement\Contest');
    }

    public function user()
    {
        return $this->belongsTo('Judgement\User');
    }
}
