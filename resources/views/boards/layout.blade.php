<!doctype html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <title>게시판</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="container">
    <header>
        @section('header')
            <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
                <span class="fs-4">{{ $boardTitle }}</span>
                <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
                @guest()
                    <a href="{{route('auth.login')}}" class="text-xl">로그인</a> / 
                    <a href="{{route('auth.signup')}}" class="text-xl">회원가입</a>
                @endguest
                @auth()
                    <form action="/logout" method="post" class="inline-block">
                        @csrf
                        <span class="text-xl text-blue-500">{{auth()->user()->userid}}</span> / 
                        <a href="/logout"><button class="text-xl">로그아웃</button></a>
                    </form>
                @endauth
                </nav>
            </div>
        @endsection
    </header>
    @yield('content')
</div>

</body>
</html>
