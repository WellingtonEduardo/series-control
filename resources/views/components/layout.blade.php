<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} - Controle de Séries</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="text-bg-dark">
    @auth
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button class="btn btn-link">
                Sair
            </button>
        </form>
    @endauth

    @guest

        <form action="{{ route('login') }}" method="post">
            @csrf
            <button class="btn btn-link">
                Entrar
            </button>
        </form>
    @endguest

    <div class="container">
        <h1>{{ $title }}</h1>

        @isset($message)
            @if ($message)
                <div class="alert alert alert-success" role="alert">
                    {{ $message }}
                </div>
            @endif
        @endisset


        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{ $slot }}
    </div>
</body>

</html>
