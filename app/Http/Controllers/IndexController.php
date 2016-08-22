<?php

namespace Judgement\Http\Controllers;

use Illuminate\Http\Request;
use Judgement\Http\Requests;

class IndexController extends Controller
{
    use ContestTrait;

    public function index()
    {
        return view('index', ['contests' => $this->getContests()]);
    }
}
