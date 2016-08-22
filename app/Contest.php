<?php

namespace Judgement;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Contest extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'type',
        'start_time',
        'end_time',
        'status',
        'active'
    ];

    public function updateStatus()
    {
        $now = Carbon::now();
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);

        if ($now->gte($end)) {
            $this->status = 'Ended';
            $this->save();
        } elseif ($now->gte($start)) {
            $this->status = 'Started';
            $this->save();
        } else {
            $this->status = 'Not Started';
            $this->save();
        }
    }

    public function problems()
    {
        return $this->belongsToMany('\Judgement\Problem');
    }

    public function categories()
    {
        return $this->belongsToMany('\Judgement\Category');
    }

    public function users()
    {
        return $this->belongsToMany('\Judgement\User');
    }

    public function languages()
    {
        return $this->belongsToMany('Judgement\Language');
    }

    public function allowedUsers()
    {
        return $this->hasMany('Judgement\AllowedUser');
    }
}
