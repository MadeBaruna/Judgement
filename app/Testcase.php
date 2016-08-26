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

    public function in()
    {
        return $this->location() . '.in';
    }

    public function out()
    {
        return $this->location() . '.out';
    }

    public function location()
    {
        $problemId = $this->problem->id;
        return storage_path('problems/' . $problemId . '/testcases/' . $this->id);
    }
}
