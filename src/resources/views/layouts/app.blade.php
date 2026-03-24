<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/common.css')}}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__heading">
            <a href="{{route('product')}}" class="header__link">
                <img src="/images/header-logo.png" alt="タイトルロゴ" class="header__logo">
            </a>
        </div>
        <div class="header__search">
            <form action="/" method="get" class="header__search-form">
                <input type="text" name="keyword" value="{{request('keyword')}}" placeholder="なにをお探しですか？" class="header__search-input">
                <input type="hidden" name="tab" value="{{$activeTab ?? ''}}">
            </form>
        </div>
        <div class="header__menu">
            <nav class="header__nav">
                <ul class="header__nav-list">
                    @auth
                    <li class="header__nav-item">
                        <form action="/logout" method="post" class="header__nav-link">
                            @csrf
                            <button type="submit" class="nav__button">ログアウト</button>
                        </form>
                    </li>
                    @endauth
                    @guest
                    <li class="header__nav-item">
                        <a href="/login" class="header__nav-link">ログイン</a>
                    </li>
                    @endguest
                    <li class="header__nav-item">
                        <a href="{{route('mypage')}}" class="header__nav-link">マイページ</a>
                    </li>
                    <li class="header__nav-item">
                        <a href="{{route('sell')}}" class="header__nav-link--sell">出品</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
@stack('script')
</html>