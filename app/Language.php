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

    public static function detail($id)
    {
        return static::find($id);
    }
}
