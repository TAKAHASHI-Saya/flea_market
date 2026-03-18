@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/auth/setting_profile.css')}}">
@endsection

@section('content')
<div class="content">
    <div class="content__group">
        <div class="content__group-heading">
            <h1 class="content__group-title">プロフィール設定</h1>
        </div>
        <form action="{{route('update')}}" method="post" class="form" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="form__image-group">
                <div class="form__image-preview">
                    <img id="imagePreview" src="" alt="" class="form__image">
                </div>
                <div class="form__image-input">
                    <label for="profile_image" class="form__file-label">画像を選択する</label>
                    <input id="profile_image" type="file" name="profile_image" accept="image/*" onchange="previewImage(this)" class="form__file-input">
                </div>
            </div>
            <div class="form__error">
                @if($errors->has('profile_image'))
                    @foreach($errors->get('profile_image') as $message)
                        <p>{{$message}}</p>
                    @endforeach
                @endif
            </div>
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

@push('script')
<script>
    function previewImage(input)
    {
        if(input.files && input.files[0])
        {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('imagePreview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush