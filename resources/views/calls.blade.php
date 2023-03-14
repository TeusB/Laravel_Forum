@extends('layouts.mainLayout')

@section('sidebar')
    @parent
@endsection

@section('content')
    <h1>Login</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    login
    <form id="login" method="post">
        <label for="email">email</label>
        <input type="text" name="email" required>
        <label for="password">password</label>
        <input type="password" name="password" required></textarea>
        <button type="submit">login</button>
    </form>
    <br>
    get posts
    <form id="getPosts" method="post">
        <button type="submit">getPosts</button>
    </form>

    <br>
    get post
    <form id="getPost" method="post">
        <label for="idPost">idPost</label>
        <input type="text" name="idPost" required>
        <button type="submit">getPost</button>
    </form>
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    {{-- variables needed --}}
    <script>
        const AUTH_TOKEN_KEY = 'authToken'
    </script>

    {{-- login script --}}
    <script>
        $("form#login").submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: "POST",
                url: "api/login",
                data: {
                    email: this.elements["email"].value,
                    password: this.elements["password"].value,
                },
                success: function(data) {
                    console.log(data);
                    switch (data.status) {
                        case "error":

                            break;
                        case "succes":
                            sessionStorage.setItem(AUTH_TOKEN_KEY, data.token)
                            break;
                    }
                },
                error: function(data) {
                    console.log(data)
                }
            });
        })
    </script>


    {{-- getPosts script --}}
    <script>
        $("form#getPosts").submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: "GET",
                url: "api/getAllPosts",
                headers: {
                    Authorization: "Bearer " + sessionStorage.getItem(AUTH_TOKEN_KEY),
                },
                success: function(data) {
                    console.log(data);
                    switch (data.status) {
                        case "error":
                            break;
                        case "succes":
                            console.log(data.posts);
                            break;
                    }
                },
                error: function(data) {
                    console.log(data)
                }
            });
        })
    </script>

    {{-- getPost script --}}
    <script>
        $("form#getPost").submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: "GET",
                url: "api/getPostById/" + this.elements["idPost"].value,
                headers: {
                    Authorization: "Bearer " + sessionStorage.getItem(AUTH_TOKEN_KEY),
                },
                success: function(data) {
                    console.log(data);
                    switch (data.status) {
                        case "error":
                            break;
                        case "succes":
                            // console.log(data.posts);
                            break;
                    }
                },
                error: function(data) {
                    console.log(data)
                }
            });
        })
    </script>
@endsection
