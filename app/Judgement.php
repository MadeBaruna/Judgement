<?php

namespace Judgement;

use Illuminate\Database\Eloquent\Model;

class Judgement extends Model
{
    protected $table = 'judgement';

    public static function title()
    {
        return static::find(1)->option_value;
    }
}
