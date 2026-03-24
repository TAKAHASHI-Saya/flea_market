<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Purchase;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $product = Product::findOrFail($item_id);

        $user = Auth::user();

        return view('purchase', compact('product', 'user'));
    }

    // Stripe決済
    public function checkout(PurchaseRequest $request, $item_id)
    {
        $product = Product::findOrFail($item_id);

        session([
            'purchase_data' => [
                'product_id' => $product->id,
                'purchase_price' => $request->purchase_price,
                'payment_method' => $request->payment_method,
                'postcode' => $request->postcode,
                'address' => $request->address,
                'building' => $request->building,
            ]
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => [$request->payment_method],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $product->product_name,
                    ],
                    'unit_amount' => $product->sales_price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchase.success', $item_id),
            'cancel_url' => route('purchase', $item_id),
        ]);

        return redirect($session->url);
    }

    public function success($item_id)
    {
        $data = session('purchase_data');

        Purchase::create([
            'user_id' => auth()->id(),
            'product_id' => $data['product_id'],
            'purchase_price' => $data['purchase_price'],
            'payment_method' => $data['payment_method'],
            'postcode' => $data['postcode'],
            'address' => $data['address'],
            'building' => $data['building'],
        ]);

        $product = Product::findOrFail($item_id);
        $product->status = 1;
        $product->save();

        return redirect()->route('product');
    }

    public function editShippingAddress($item_id)
    {
        $product = Product::FindOrFail($item_id);

        return view('shipping_address', compact('product'));
    }

    public function confirm(AddressRequest $request, $item_id)
    {
        return redirect()->route('purchase', ['item_id' => $item_id])
        ->with([
            'postcode' => $request->postcode,
            'address' => $request->address,
            'building' => $request->building,
        ]);
    }
}
