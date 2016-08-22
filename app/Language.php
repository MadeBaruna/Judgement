<?php

namespace Judgement;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $visible = [
        'id',
        'name'
    ];

    public function contests()
    {
        return $this->belongsTo('Judgement\Contest');
    }

    public static function compiler($lang)
    {
        return Language::where('name', $lang)->first()->compiler_path;
    }

    public static function executor($lang)
    {
        return Language::where('name', $lang)->first()->executor_path;
    }

    public static function ext($lang)
    {
        return '.' . Language::where('name', $lang)->first()->compiled_ext;
    }
}
