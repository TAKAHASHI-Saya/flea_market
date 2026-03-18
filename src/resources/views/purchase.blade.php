@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/purchase.css')}}">
@endsection

@section('content')
<form action="{{route('purchase.checkout', $product->id)}}" method="post" class="content">
    @csrf
    <div class="content__main">
        <div class="content__section-heading">
            <img src="{{asset('storage/' . $product['product_image'])}}" alt="商品画像" class="content__section-image">
            <div class="content__section-detail">
                <h1 class="content__section-title">
                    {{$product->product_name}}
                </h1>
                <div class="content__section-price">
                    <span class="content__section-yen">¥</span>
                    <input type="text" name="purchase_price" value="{{$product->sales_price}}" class="content__section-value" readonly>
                </div>
            </div>
        </div>
        <div class="content__section">
            <h2 class="content__section-subtitle">
                支払い方法
            </h2>
            <select name="payment_method" id="payment_method" class="content__section-select">
                <option value="" disabled selected>選択してください</option>
                <option value="konbini">コンビニ払い</option>
                <option value="card">カード支払い</option>
            </select>
        </div>
        <div class="content__section">
            <div class="content__section-inner">
                <h2 class="content__section-subtitle">配送先</h2>
                <a href="{{route('shipping', ['item_id' => $product->id])}}" class="content__section-link">変更する</a>
            </div>
            <div class="content__section-detail">
                <div class="content__section-info">
                    <span>〒</span><input type="text" name="postcode" value="{{session('postcode', $user->postcode)}}" class="content__info-input" readonly>
                </div>
                <div class="content__section-info">
                    <input type="text" name="address" value="{{session('address', $user->address)}}" class="content__info-input" readonly>
                </div>
                <div class="content__section-info">
                    <input type="text" name="building" value="{{session('building',$user->building)}}" class="content__info-input" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="content__sidebar">
        <div class="content__summary">
            <table class="content__table">
                <tr class="content__table-row">
                    <th class="content__table-header">商品代金</th>
                    <td class="content__table-item">
                        <span>¥</span>{{$product->sales_price}}
                    </td>
                </tr>
                <tr class="content__table-row">
                    <th class="content__table-header">支払い方法</th>
                    <td class="content__table-item" id="payment_method_display"></td>
                </tr>
            </table>
        </div>
        <div class="content__sidebar-button">
            <button type="submit" class="content__sidebar-submit">購入する</button>
        </div>
    </div>
</form>
@endsection

@push('script')
<script>
    const select = document.getElementById('payment_method');
    const display = document.getElementById('payment_method_display');

    select.addEventListener('change', function(){
        const selectedText = select.options[select.selectedIndex].text;
        display.textContent = selectedText;
    });
</script>
@endpush
