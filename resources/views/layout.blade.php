<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production Management System</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    @yield('css')
</head>

<body>

<header class="header">
    @if (!request()->routeIs('dashboard'))
        <a href="{{ route('dashboard') }}">ホームへ</a>
    @endif

    <div class="user-info">
        <div>{{ now()->format('Y/m/d H:i') }}</div>

        @auth
            <div>ユーザー：{{ auth()->user()->name }}</div>
        @endauth
        
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
</header>

<main class="main">
    @yield('content')
</main>

</body>
</html>