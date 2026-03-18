@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
@endsection

@section('content')
<div class="content">
    <div class="content__header">
        <div class="content__heading">
            <div class="content__heading-group">
                <div class="content__heading-image">
                    @if(auth()->user()->profile_image)
                    <img src="{{asset('storage/' . auth()->user()->profile_image)}}" alt="プロフィール画像" class="content__heading-img">
                    @else
                    <img src="" alt="" class="content__heading-img">
                    @endif
                </div>
                <h1 class="content__heading-username">
                    {{auth()->user()->username}}
                </h1>
            </div>
            <a href="{{route('edit.mypage')}}" class="content__heading-link">プロフィールを編集</a>
        </div>
    </div>
    <div class="content__tab">
        <a href="/mypage?page=sell" class="content__tab-label {{$activeTab === 'sell' ? 'is-active' : ''}}">出品した商品</a>
        <a href="/mypage?page=buy" class="content__tab-label {{$activeTab === 'buy' ? 'is-active' : ''}}">購入した商品</a>
    </div>

    <!-- 出品した商品の表示 -->
    @if($activeTab === 'sell')
        @if($products->isEmpty())
            <p>出品した商品がありません</p>
        @else
        <div class="content__inner">
            @foreach($products as $product)
            <div class="content__inner-group">
                <a href="{{route('detail', ['item_id' => $product->id])}}" class="content__inner-link">
                    <img src="{{asset('storage/' . $product->product_image)}}" alt="商品画像" class="content__inner-image">
                    <p class="content__inner-text">
                        {{$product->product_name}}
                    </p>
                </a>
            </div>
            @endforeach
        </div>
        @endif
    @endif

    <!-- 購入した商品の表示 -->
     @if($activeTab === 'buy')
        @auth
            @if($buyProducts->isEmpty())
                <p>購入した商品がありません</p>
            @else
                <div class="content__inner">
                    @foreach($buyProducts as $product)
                    <div class="content__inner-group">
                    <a href="{{route('detail', ['item_id' => $product->id])}}" class="content__inner-link">
                    <img src="{{asset('storage/' . $product->product_image)}}" alt="商品画像" class="content__inner-image">
                    <p class="content__inner-text">
                    {{$product->product_name}}
                    </p>
                    </a>
                    </div>
                    @endforeach
                </div>
            @endif
        @endauth
    @endif
</div>
@endsection