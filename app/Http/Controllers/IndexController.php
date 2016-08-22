<?php

namespace Judgement\Http\Controllers;

use Illuminate\Http\Request;
use Judgement\Http\Requests;
use Auth;

class IndexController extends Controller
{
    use ContestTrait;

    public function index()
    {
        if(Auth::check()) {
            if(Auth::user()->type == 'admin') {
                $contest = $this->getContests();
            } else {
                $contest = $this->getAvailableContests();
            }
        } else {
            $contest = [];
        }

        return view('index', ['contests' => $contest]);
    }
}
