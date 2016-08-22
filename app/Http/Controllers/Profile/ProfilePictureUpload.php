<?php

namespace Judgement\Http\Controllers\Profile;

use Judgement\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Image;

class ProfilePictureUpload extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upload(Request $request)
    {
        $rules = [
            'image' => 'image|max:2000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        } else {
            if ($request->file('image')->isValid()) {
                $destinationPath = public_path('profiles/pictures');
                $fileName = Auth::user()->id . '_tmp.png';
                $path = $destinationPath . '/' . $fileName;

                Image::make($request->file('image'))->fit(200, 200)->save($path);
                return 'profiles/pictures/' . $fileName;
            } else {
                return response()->json(['image' => ['Invalid picture']]);
            }
        }
    }

    public function confirmation(Request $request)
    {
        $accept = $request->get('confirm');
        $destinationPath = public_path('profiles/pictures');
        $fileName = Auth::user()->id . '_tmp.png';
        $newFileName = Auth::user()->id . '.png';

        $path = $destinationPath . '/' . $fileName;
        $newPath = $destinationPath . '/' . $newFileName;

        if ($accept == 1) {
            rename($path, $newPath);
            return 'profiles/pictures/' . $newFileName;
        } else {
            if (file_exists($path)) unlink($path);
            return '';
        }
    }
}
