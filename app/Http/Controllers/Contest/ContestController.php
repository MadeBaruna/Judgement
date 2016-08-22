<?php

namespace Judgement\Http\Controllers\Contest;

use Illuminate\Http\Request;
use Judgement\Http\Requests;
use Judgement\Http\Controllers\Controller;

class ContestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'contest']);
    }

    public function index($id)
    {

    }
}
