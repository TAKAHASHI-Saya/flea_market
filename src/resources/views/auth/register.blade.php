@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/auth/register.css')}}">
@endsection

@section('content')
<div class="content">
    <div class="content__group">
        <div class="content__group-heading">
            <h1 class="content__group-title">会員登録</h1>
        </div>
        <form action="/register" method="post" class="form">
            @csrf
            <div class="form__group">
                <div class="form__label">
                    <p class="form__label-item">ユーザー名</p>
                </div>
                <div class="form__input">
                    <input type="text" name="username" value="{{old('username')}}" class="form__input-item">
                </div>
                <div class="form__error">
                    @if($errors->has('username'))
                        @foreach($errors->get('username') as $message)
                            <p>{{$message}}</p>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="form__group">
                <div class="form__label">
                    <p class="form__label-item">メールアドレス</p>
                </div>
                <div class="form__input">
                    <input type="email" name="email" value="{{old('email')}}" class="form__input-item">
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
                    <input type="password" name="password" id="" class="form__input-item">
                </div>
                <div class="form__error">
                    @if($errors->has('password'))
                        @foreach($errors->get('password') as $message)
                            <p>{{$message}}</p>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="form__group">
                <div class="form__label">
                    <p class="form__label-item">確認用パスワード</p>
                </div>
                <div class="form__input">
                    <input type="password" name="password_confirmation" id="" class="form__input-item">
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
                <button type="submit" class="form__button-submit">登録する</button>
            </div>
        </form>
        <div class="content__group-link">
            <a href="{{route('login')}}" class="content__link">ログインはこちら</a>
        </div>
    </div>
</div>
@endsection