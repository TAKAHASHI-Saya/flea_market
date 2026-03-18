<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle($item_id)
    {
        $product = Product::findOrFail($item_id);

        $like = $product
        ->likes()
        ->where('user_id', Auth::id())
        ->first();

        if($like){
            $like->delete();
        }else{
            $product->likes()->create([
                'user_id' => Auth::id()
            ]);
        }

        return redirect()->route('detail', ['item_id' => $item_id]);
    }
}
