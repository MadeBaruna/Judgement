<?php

namespace Judgement;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function categories()
    {
        return $this->belongsToMany('Judgement\Category');
    }

    public function groups()
    {
        return $this->belongsToMany('Judgement\Group');
    }

    public function group()
    {
        return Group::find($this->current_group_id);
    }

    public function submissions()
    {
        return $this->hasMany('Judgement\Submission');
    }

    public function contests()
    {
        return $this->belongsToMany('Judgement\Contest');
    }

    public function problems()
    {
        return $this->hasMany('Judgement\Problem');
    }

    public function clarifications()
    {
        return $this->hasMany('Judgement\Clarification');
    }

    public function invites()
    {
        return $this->hasMany('Judgement\GroupInvite');
    }

    public function picture()
    {
        if (file_exists(public_path('/profiles/pictures/') . $this->id . '.png')) {
            return '/profiles/pictures/' . $this->id . '.png';
        } else {
            return '/assets/images/default.png';
        }
    }

    public function isAdmin()
    {
        return $this->type == 'admin' ? true : false;
    }
}
