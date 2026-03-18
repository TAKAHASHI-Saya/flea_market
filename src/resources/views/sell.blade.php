@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/sell.css')}}">
@endsection

@section('content')
<div class="content">
    <div class="content__group">
        <div class="content__group-heading">
            <h1 class="content__group-title">商品の出品</h1>
        </div>
        <form action="{{route('sell.submit')}}" method="post" class="form" enctype="multipart/form-data">
            @csrf
            <div class="form__image-group">
                <span class="form__image-title">商品画像</span>
                <div class="form__preview">
                    <div class="form__image-preview">
                        <img id="imagePreview" src="" alt="" class="form__image">
                    </div>
                    <div class="form__image-input">
                        <label for="product_image" class="form__file-label">画像を選択する</label>
                        <input id="product_image" type="file" name="product_image" accept="image/*" onchange="previewImage(this)" class="form__file-input">
                    </div>
                </div>
                <div class="form__error">
                    @if($errors->has('product_image'))
                        @foreach($errors->get('product_image') as $message)
                            <p>{{$message}}</p>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="form__group">
                <div class="form__section">
                    <h2 class="form__section-title">商品の詳細</h2>
                </div>
                <div class="form__item">
                    <h3 class="form__item-title">カテゴリー</h3>
                    <div class="form__item-list">
                        @foreach($categories as $category)
                        <label for="category{{$category->id}}" class="form__list-label">
                            <input type="checkbox" name="categories[]" value="{{$category->id}}" id="category{{$category->id}}" class="form__list-checkbox">
                            <span class="form__list-name">{{$category->category_name}}</span>
                        </label>
                        @endforeach
                    </div>
                    <div class="form__error">
                    @if($errors->has('categories'))
                        @foreach($errors->get('categories') as $message)
                        <p>{{$message}}</p>
                        @endforeach
                    @endif
                    </div>
                </div>
                <div class="form__item">
                    <h3 class="form__item-title">商品の状態</h3>
                    <div class="form__item-select">
                        <select name="condition_type" id="" class="form__select">
                            <option value="" disabled selected>選択してください</option>
                            @foreach($conditions as $condition)
                            <option value="{{$condition->id}}">
                                {{$condition->condition_type}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form__error">
                    @if($errors->has('condition_type'))
                        @foreach($errors->get('condition_type') as $message)
                        <p>{{$message}}</p>
                        @endforeach
                    @endif
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__section">
                    <h2 class="form__section-title">商品名と説明</h2>
                </div>
                <div class="form__item">
                    <p class="form__item-label">商品名</p>
                </div>
                <div class="form__input">
                    <input type="text" name="product_name" value="{{old('product_name')}}" class="form__input-item">
                </div>
                <div class="form__error">
                    @if($errors->has('product_name'))
                        @foreach($errors->get('product_name') as $message)
                            <p>{{$message}}</p>
                        @endforeach
                    @endif
                </div>
                <div class="form__item">
                    <p class="form__item-label">ブランド名</p>
                </div>
                <div class="form__input">
                    <input type="text" name="brand" value="{{old('brand')}}" class="form__input-item">
                </div>
                <div class="form__item">
                    <p class="form__item-label">商品の説明</p>
                </div>
                <div class="form__item-textarea">
                    <textarea name="product_detail" class="form__textarea">{{old('product_detail')}}</textarea>
                </div>
                <div class="form__error">
                    @if($errors->has('product_detail'))
                        @foreach($errors->get('product_detail') as $message)
                        <p>{{$message}}</p>
                        @endforeach
                    @endif
                </div>
                <div class="form__item">
                    <p class="form__item-label">販売価格</p>
                </div>
                <div class="form__input">
                    <input type="number" name="sales_price" value="{{old('sales_price')}}" class="form__input-item">
                </div>
                <div class="form__error">
                    @if($errors->has('sales_price'))
                        @foreach($errors->get('sales_price') as $message)
                        <p>{{$message}}</p>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="form__button">
                <button type="submit" class="form__button-submit">出品する</button>
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
                const img = document.getElementById('imagePreview');
                img.src = e.target.result;

                document.querySelector('.form__image-preview').style.display = 'block';
                document.querySelector('.form__image-input').style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush