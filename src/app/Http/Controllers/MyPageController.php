<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Purchase;
use App\Http\Requests\ProfileRequest;

class MyPageController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('page', 'sell');

        $products = Product::where('user_id', auth()->id())->get();

        $buyProducts = collect();

        if($activeTab === 'buy' && auth()->check())
            {
                $buyProducts = Product::whereHas('purchase', function($query)
                {
                    $query->where('user_id', auth()->id());
                })->get();
            }

        return view('profile', compact('products', 'buyProducts', 'activeTab'));
    }

    public function showEditProfile()
    {
        $user = Auth::user();

        return view('edit_profile', compact('user'));
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

        return redirect()->route('mypage');
    }
}
