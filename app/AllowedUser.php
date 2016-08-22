<?php

namespace Judgement;

use Illuminate\Database\Eloquent\Model;

class AllowedUser extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'contest_id',
        'email'
    ];

    public function contest()
    {
        return $this->belongsTo('Judgement\Contest');
    }
}
