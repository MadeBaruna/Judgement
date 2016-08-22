<?php

namespace Judgement;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'statement',
        'time_limit',
        'memory_limit',
        'author_id'
    ];

    protected $hidden = ['statement'];

    public function contests()
    {
        return $this->belongsToMany('Judgement\Contest');
    }

    public function submissions()
    {
        return $this->hasMany('Judgement\Submission');
    }

    public function author()
    {
        return $this->belongsTo('Judgement\User');
    }
}
