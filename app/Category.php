<?php

namespace Judgement;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function users()
    {
        return $this->belongsToMany('Judgement\User');
    }

    public function contest()
    {
        return $this->belongsToMany('Judgement\Contest');
    }
}
