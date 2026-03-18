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
    <div class="content__inner">
        @foreach($products as $product)
        <div class="content__inner-group">
            <a href="{{route('detail', ['item_id' => $product->id])}}" class="content__inner-link">
                <img src="{{asset('storage/' . $product->product_image)}}" alt="商品画像" class="content__inner-image">
                <div class="content__inner-text">
                    @if((int)$product->status === 1)
                    <p class="content__inner-sold">sold</p>
                    @endif
                    <p class="content__inner-name">
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
                <div class="content__inner">
                    @foreach($myListProducts as $product)
                    <div class="content__inner-group">
                        <a href="{{route('detail', ['item_id' => $product->id])}}" class="content__inner-link">
                        <img src="{{asset('storage/' . $product->product_image)}}" alt="商品画像" class="content__inner-image">
                            <div class="content__inner-text">
                                @if((int)$product->status === 1)
                                <p class="content__inner-sold">sold</p>
                                @endif
                                <p class="content__inner-name">
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
