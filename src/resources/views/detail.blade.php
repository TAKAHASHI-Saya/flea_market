@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/detail.css')}}">
@endsection

@section('content')
<div class="content">
    <div class="content__image">
        <img src="{{asset('storage/' . $product['product_image'])}}" alt="商品画像" class="content__image-img">
    </div>
    <div class="content__body">
        <div class="content__body-group">
            <h1 class="content__body-title">
                {{$product->product_name}}
            </h1>
            <p class="content__body-brand">
                {{$product->brand}}
            </p>
            <div class="content__body-price">
                <span class="content__price-yen">¥</span><span class="content__price-value">{{$product->sales_price}}</span><span class="content__price-tax">（税込）</span>
            </div>
            <div class="content__body-icon">
                <div class="content__icon-like">
                    <form action="/item/{{$product->id}}/like" method="post" class="content__icon-form">
                        @csrf
                        <button type="submit" class="content__icon-button">
                            <img src="{{$isLiked ? '/images/heart_pink.png' : '/images/heart_default.png'}}" alt="いいね" class="content__icon-heart">
                        </button>
                    </form>
                    <span class="content__icon-count">{{$product->likes_count}}</span>
                </div>
                <div class="content__icon-comment">
                    <img src="/images/speech-bubble.png" alt="コメント" class="content__icon-speech">
                    <span class="content__icon-count">{{$product->comments_count}}</span>
                </div>
            </div>
            @if($product->status == 0)
            <div class="content__body-link">
                <a href="{{route('purchase', ['item_id' => $product->id])}}" class="content__link-button">購入手続きへ</a>
            </div>
            @else
            <div class="content__body-sold">
                <span class="content__sold">sold</span>
            </div>
            @endif
            <div class="content__body-desc">
                <h2 class="content__desc-title">商品説明</h2>
                <p class="content__desc-text">
                    {{$product->product_detail}}
                </p>
            </div>
            <div class="content__body-info">
                <h2 class="content__info-title">商品の情報</h2>
                <div class="content__category">
                    <h3 class="content__category-title">カテゴリー</h3>
                    @foreach($product->categories as $category)
                    <p class="content__category-name">{{$category->category_name}}</p>
                    @endforeach
                </div>
                <div class="content__condition">
                    <h3 class="content__condition-title">商品の状態</h3>
                    <p class="content__condition-name">{{$product->condition->condition_type}}</p>
                </div>
            </div>
            <div class="content__body-comment">
                <div class="content__comment-heading">
                    <h2 class="content__comment-title">コメント</h2>
                    <span class="content__comment-count">({{$product->comments_count}})</span>
                </div>
                @foreach($product->comments as $comment)
                <div class="content__comment-user">
                    <div class="content__comment-image">
                        <img src="{{asset('storage/' . $comment->user->profile_image)}}" alt="" class="content__comment-img">
                    </div>
                    <p class="content__comment-username">{{$comment->user->username}}</p>
                </div>
                <p class="content__comment-output">{{$comment->comment}}
                </p>
                @endforeach
                @if($product->comments->isEmpty())
                <p>コメントはまだありません</p>
                @endif
                <div class="content__comment-field">
                    <form action="/item/{{$product->id}}/comment" method="post" class="content__field-form">
                        @csrf
                        <p class="content__field-title">商品へのコメント</p>
                        <textarea name="comment" id="" class="content__field-text"></textarea>
                        <div class="content__field-error">
                        @if($errors->has('comment'))
                            @foreach($errors->get('comment') as $message)
                            <p>{{$message}}</p>
                            @endforeach
                        @endif
                        </div>
                        <div class="content__field-submit">
                            <button type="submit" class="content__field-button">コメントを送信する</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection