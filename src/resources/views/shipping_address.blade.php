@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/shipping_address.css')}}">
@endsection

@section('content')
<div class="content">
    <div class="content__group">
        <div class="content__group-heading">
            <h1 class="content__group-title">住所の変更</h1>
        </div>
        <form action="/purchase/change_address/{{$product->id}}" method="post" class="form">
            @csrf
            <div class="form__group">
                <div class="form__label">
                    <p class="form__label-item">郵便番号</p>
                </div>
                <div class="form__input">
                    <input type="text" name="postcode" value="{{old('postcode')}}" inputmode="numeric" class="form__input-item">
                </div>
                <div class="form__error">
                    @if($errors->has('postcode'))
                        @foreach($errors->get('postcode') as $message)
                            <p>{{$message}}</p>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="form__group">
                <div class="form__label">
                    <p class="form__label-item">住所</p>
                </div>
                <div class="form__input">
                    <input type="text" name="address" value="{{old('address')}}" class="form__input-item">
                </div>
                <div class="form__error">
                    @if($errors->has('address'))
                        @foreach($errors->get('address') as $message)
                            <p>{{$message}}</p>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="form__group">
                <div class="form__label">
                    <p class="form__label-item">建物名</p>
                </div>
                <div class="form__input">
                    <input type="text" name="building" value="{{old('building')}}" class="form__input-item">
                </div>
                <div class="form__error">
                    @if($errors->has('building'))
                        @foreach($errors->get('building') as $message)
                            <p>{{$message}}</p>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="form__button">
                <button type="submit" class="form__button-submit">更新する</button>
            </div>
        </form>
    </div>
</div>
@endsection
