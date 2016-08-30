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

    public static function lang()
    {
        return static::find(2)->option_value;
    }
}
