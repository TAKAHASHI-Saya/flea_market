@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/purchase.css')}}">
@endsection

@section('content')
<form action="{{route('purchase.checkout', $product->id)}}" method="post" class="purchase">
    @csrf
    <div class="purchase__main">
        <div class="purchase__heading">
            <img src="{{asset('storage/' . $product['product_image'])}}" alt="商品画像" class="purchase__image">
            <div class="purchase__detail">
                <h1 class="purchase__title">
                    {{$product->product_name}}
                </h1>
                <div class="purchase__price">
                    <span class="purchase__price-yen">¥</span>
                    <input type="text" name="purchase_price" value="{{$product->sales_price}}" class="purchase__price-value" readonly>
                </div>
            </div>
        </div>
        <div class="purchase__info">
            <h2 class="purchase__info-title">
                支払い方法
            </h2>
            <select name="payment_method" id="payment_method" class="purchase__info-select">
                <option value="" disabled selected>選択してください</option>
                <option value="konbini">コンビニ払い</option>
                <option value="card">カード支払い</option>
            </select>
            <div class="form__error">
                    @if($errors->has('payment_method'))
                        @foreach($errors->get('payment_method') as $message)
                            <p>{{$message}}</p>
                        @endforeach
                    @endif
            </div>
        </div>
        <div class="purchase__info">
            <div class="purchase__info-heading">
                <h2 class="purchase__info-title">配送先</h2>
                <a href="{{route('shipping', ['item_id' => $product->id])}}" class="purchase__info-link">変更する</a>
            </div>
            <div class="purchase__info-detail">
                <div class="purchase__info-address">
                    <span>〒</span><input type="text" name="postcode" value="{{session('postcode', $user->postcode)}}" class="purchase__info-input" readonly>
                </div>
                <div class="purchase__info-address">
                    <input type="text" name="address" value="{{session('address', $user->address)}}" class="purchase__info-input" readonly>
                </div>
                <div class="purchase__info-address">
                    <input type="text" name="building" value="{{session('building',$user->building)}}" class="purchase__info-input" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="purchase__sidebar">
        <div class="purchase__summary">
            <table class="purchase__table">
                <tr class="purchase__table-row">
                    <th class="purchase__table-header">商品代金</th>
                    <td class="purchase__table-item">
                        <span>¥</span>{{$product->sales_price}}
                    </td>
                </tr>
                <tr class="purchase__table-row">
                    <th class="purchase__table-header">支払い方法</th>
                    <td class="purchase__table-item" id="payment_method_display"></td>
                </tr>
            </table>
        </div>
        <div class="purchase__sidebar-submit">
            <button type="submit" class="purchase__sidebar-button">購入する</button>
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
