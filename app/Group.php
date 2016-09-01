<?php

namespace Judgement;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'leader_id',
        'name'
    ];

    public function members()
    {
        return $this->belongsToMany('Judgement\User');
    }

    public function leader()
    {
        return $this->belongsTo('Judgement\User', 'leader_id');
    }

    public function picture()
    {
        if (file_exists(public_path('/profiles/pictures/groups/') . $this->id . '.png')) {
            return '/profiles/pictures/groups/' . $this->id . '.png';
        } else {
            return '/assets/images/default.png';
        }
    }
}
