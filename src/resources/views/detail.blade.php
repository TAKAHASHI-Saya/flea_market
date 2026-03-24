@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/detail.css')}}">
@endsection

@section('content')
<div class="product-detail">
    <div class="product-detail__image">
        <img src="{{asset('storage/' . $product['product_image'])}}" alt="商品画像" class="product-detail__img">
    </div>
    <div class="product-detail__info">
        <div>
            <h1 class="product-detail__title">
                {{$product->product_name}}
            </h1>
            <p class="product-detail__brand">
                {{$product->brand}}
            </p>
            <div class="product-detail__price">
                <span class="product-detail__yen">¥</span><span class="product-detail__value">{{$product->sales_price}}</span><span class="product-detail__tax">（税込）</span>
            </div>
            <div class="product-actions">
                <div class="product-actions__like">
                    <form action="/item/{{$product->id}}/like" method="post">
                        @csrf
                        <button type="submit" class="product-actions__button">
                            <img src="{{$isLiked ? '/images/heart_pink.png' : '/images/heart_default.png'}}" alt="いいね" class="product-actions__heart">
                        </button>
                    </form>
                    <span class="product-actions__count">{{$product->likes_count}}</span>
                </div>
                <div class="product-actions__comment">
                    <img src="/images/speech-bubble.png" alt="コメント" class="product-actions__speech">
                    <span class="product-actions__count">{{$product->comments_count}}</span>
                </div>
            </div>
            @if($product->status == 0)
            <div class="product-detail__link">
                <a href="{{route('purchase', ['item_id' => $product->id])}}" class="product-detail__button">購入手続きへ</a>
            </div>
            @else
            <div class="product-detail__sold">
                <span class="product-detail__sold--span">sold</span>
            </div>
            @endif
            <div class="product-description">
                <h2 class="product-description__title">商品説明</h2>
                <p class="product-description__text">
                    {{$product->product_detail}}
                </p>
            </div>
            <div class="product-meta">
                <h2 class="product-meta__title">商品の情報</h2>
                <div class="product-meta__category">
                    <h3 class="category__title">カテゴリー</h3>
                    @foreach($product->categories as $category)
                    <p class="category__name">{{$category->category_name}}</p>
                    @endforeach
                </div>
                <div class="product-meta__condition">
                    <h3 class="condition__title">商品の状態</h3>
                    <p class="condition__name">{{$product->condition->condition_type}}</p>
                </div>
            </div>
            <div class="product-comments">
                <div class="product-comments__heading">
                    <h2 class="product-comments__title">コメント</h2>
                    <span class="product-comments__count">({{$product->comments_count}})</span>
                </div>
                @foreach($product->comments as $comment)
                <div class="product-comments__user">
                    <div class="product-comments__image">
                        <img src="{{asset('storage/' . $comment->user->profile_image)}}" alt="" class="product-comments__img">
                    </div>
                    <p class="product-comments__username">{{$comment->user->username}}</p>
                </div>
                <p class="product-comments__output">{{$comment->comment}}
                </p>
                @endforeach
                @if($product->comments->isEmpty())
                <p>コメントはまだありません</p>
                @endif
                <div class="product-comments__field">
                    <form action="/item/{{$product->id}}/comment" method="post" class="product-comments__form">
                        @csrf
                        <p class="comment-form__title">商品へのコメント</p>
                        <textarea name="comment" class="comment-form__textarea"></textarea>
                        <div class="comment-form__error">
                        @if($errors->has('comment'))
                            @foreach($errors->get('comment') as $message)
                            <p>{{$message}}</p>
                            @endforeach
                        @endif
                        </div>
                        <div class="comment-form__submit">
                            <button type="submit" class="comment-form__button">コメントを送信する</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection