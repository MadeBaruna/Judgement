<?php

namespace Judgement\Http\Controllers\Profile;

use Illuminate\Http\Request;
use Judgement\Http\Controllers\Controller;
use Auth;
use Hash;
use Validator;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('profile/profile');
    }

    public function changeProfile()
    {
        return view('profile/change');
    }

    public function edit(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|max:255',
            'institution' => 'max:255',
        ];

        $password = false;
        if ($request->get('password') != null) {
            $password = true;
            $rules += [
                'password' => 'hash:' . $user->password,
                'new_password' => 'required|different:password|min:6|confirmed'
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        if ($password) $user->password = Hash::make($request->get('new_password'));
        $user->name = $request->get('name');
        $user->institution = $request->get('institution');

        $user->save();

        return view('profile/profile');
    }
}
