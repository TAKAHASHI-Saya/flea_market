<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;

class AuthController extends Controller
{
    public function showSettingProfile()
    {
        return view('auth.setting_profile');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $data = $request->only(['username', 'postcode', 'address', 'building']);

        if($request->hasFile('profile_image'))
            {
                $path = $request->file('profile_image')->store('profile_images', 'public');
                $data['profile_image'] = $path;
            }
        
        $user->update($data);

        return redirect()->route('product');

    }
}
