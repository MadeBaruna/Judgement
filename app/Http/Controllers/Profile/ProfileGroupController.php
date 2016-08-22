<?php

namespace Judgement\Http\Controllers\Profile;

use Illuminate\Http\Request;
use Judgement\Http\Controllers\Controller;
use Auth;
use Hash;
use Validator;

class ProfileGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function groups()
    {
        $user = Auth::user();
        $groups = $user->groups;
        return view('profile/groups', ['groups' => $groups]);
    }
}
