<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Condition;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'recommend');
        $keyword = $request->query('keyword');

        $products = Product::KeywordSearch($keyword)
        ->when(Auth::check(), function($query){
            $query->where('user_id', '!=', Auth::id());
        })->get();

        $myListProducts = collect();

        if($activeTab === 'mylist' && Auth::check()){
            $myListProducts = Product::KeywordSearch($keyword)
            ->whereHas('likes', function($query){
                $query->where('user_id', Auth::id());
            })
            ->where('user_id', '!=', Auth::id())
            ->get();
        }

        return view('product', compact('products', 'myListProducts', 'activeTab', 'keyword'));
    }

    public function show($item_id)
    {
        $product = Product::with(['comments.user', 'categories', 'condition'])
        ->withCount(['likes', 'comments'])
        ->findOrFail($item_id);

        $isLiked = Like::where('user_id', Auth::id())
        ->where('product_id', $item_id)
        ->exists();

        return view('detail', compact('product', 'isLiked'));
    }

    public function showSell()
    {
        $categories = Category::all();

        $conditions = Condition::all();

        return view('sell', compact('categories', 'conditions'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->only([
            'product_name',
            'brand',
            'product_detail',
            'sales_price'
        ]);
        $data['user_id'] = Auth::id();
        $data['condition_id'] = $request->condition_type;
        $data['status'] = 0;


        if($request->hasFile('product_image'))
            {
                $path = $request->file('product_image')->store('product_images', 'public');
                $data['product_image'] = $path;
            }

        $product = Product::create($data);

        if($request->has('categories'))
            {
                $product->categories()->attach($request->categories);
            }

        return redirect()->route('mypage');
    }
}
