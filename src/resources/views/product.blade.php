@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/product.css')}}">
@endsection

@section('content')
<div class="content">
    <div class="content__tab">
        <a href="/?tab=recommend&keyword={{request('keyword')}}" class="content__tab-label {{$activeTab === 'recommend' ? 'is-active' : ''}}">おすすめ</a>
        <a href="/?tab=mylist&keyword={{request('keyword')}}" class="content__tab-label {{$activeTab === 'mylist' ? 'is-active' : ''}}">マイリスト</a>
    </div>

    <!-- おすすめ商品の表示 -->
     @if($activeTab === 'recommend')
    <div class="product-list">
        @foreach($products as $product)
        <div class="product-card">
            <a href="{{route('detail', ['item_id' => $product->id])}}" class="product-card__link">
                <img src="{{asset('storage/' . $product->product_image)}}" alt="商品画像" class="product-card__image">
                <div class="product-card__body">
                    @if((int)$product->status === 1)
                    <p class="product-card__sold">sold</p>
                    @endif
                    <p class="product-card__name">
                        {{$product->product_name}}
                    </p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @endif

    <!-- マイリストの表示 -->
     @if($activeTab === 'mylist')
        @auth
            @if($myListProducts->isEmpty())
                <p>マイリストに商品がありません</p>
            @else
                <div class="product-list">
                    @foreach($myListProducts as $product)
                    <div class="product-card">
                        <a href="{{route('detail', ['item_id' => $product->id])}}" class="product-card__link">
                        <img src="{{asset('storage/' . $product->product_image)}}" alt="商品画像" class="product-card__image">
                            <div class="product-card__body">
                                @if((int)$product->status === 1)
                                <p class="product-card__sold">sold</p>
                                @endif
                                <p class="product-card__name">
                                {{$product->product_name}}
                                </p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            @endif
        @else
        <!-- 未認証時は非表示 -->
        @endauth
    @endif
</div>
@endsection
