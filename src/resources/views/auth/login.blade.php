@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/auth/login.css')}}">
@endsection

@section('content')
<div class="content">
    <div class="content__group">
        <div class="content__group-heading">
            <h1 class="content__group-title">ログイン</h1>
        </div>
        <form action="/login" method="post" class="form">
            @csrf
            <div class="form__group">
                <div class="form__label">
                    <p class="form__label-item">メールアドレス</p>
                </div>
                <div class="form__input">
                    <input type="email" name="email" id="" class="form__input-item">
                </div>
                <div class="form__error">
                    @if($errors->has('email'))
                        @foreach($errors->get('email') as $message)
                            <p>{{$message}}</p>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="form__group">
                <div class="form__label">
                    <p class="form__label-item">パスワード</p>
                </div>
                <div class="form__input">
                    <input type="password" name="password" class="form__input-item">
                </div>
                <div class="form__error">
                    @if($errors->has('password'))
                        @foreach($errors->get('password') as $message)
                            <p>{{$message}}</p>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="form__button">
                <button type="submit" class="form__submit">ログインする</button>
            </div>
        </form>
        <div class="content__group-link">
            <a href="{{route('register')}}" class="content__link">会員登録はこちら</a>
        </div>
    </div>
</div>
@endsection