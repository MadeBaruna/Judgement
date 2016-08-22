<?php

namespace Judgement;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function members()
    {
        return $this->belongsToMany('Judgement\User');
    }

    public function leader()
    {
        return $this->belongsTo('Judgement\User', 'leader_id');
    }
}
