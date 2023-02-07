<html>

<head>
    <title>Laravel Forum - @yield('title')</title>
</head>

<body>
    @section('sidebar')
        <a href="{{ route('showMain') }}">main</a>
        <a href="{{ route('showLogin') }}">login</a>
        <a href="{{ route('showRegister') }}">register</a>
        <a href="{{ route('showPostIndex') }}">post Index</a>
        <a href="{{ route('showCreateComment') }}">create comment</a>
        <a href="{{ route('showCreatePost') }}">create post</a>

        <div class="container">
            @yield('content')
        </div>
    </body>

    </html>
