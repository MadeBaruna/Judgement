<?php

namespace Judgement;

use Illuminate\Database\Eloquent\Model;

class GroupInvite extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'group_id'
    ];
}
