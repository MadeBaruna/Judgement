<?php

namespace Judgement;

use Illuminate\Database\Eloquent\Model;

class Testcase extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'problem_id',
        'input_size',
        'output_size'
    ];

    public function problem() {
        return $this->belongsTo('Judgement\Problem');
    }
}
