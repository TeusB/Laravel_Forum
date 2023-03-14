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

    <form method="post" action="{{ route('authenticateUser') }}">
        {{ csrf_field() }}
        <label for="email">email</label>
        <input type="text" name="email" required>
        <label for="password">password</label>
        <input type="password" name="password" required></textarea>
        <button type="submit">login</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script>
        $.ajax({
            method: "POST",
            type: "POST",
            url: "api/login",
            data: {
                email: "teusbrom@gmail.com",
                password: "Kip12345!",
                // _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                console.log(data);
                switch (data["status"]) {
                    case "error":
                        console.log(data["msg"]);
                        break;
                    case "succes":
                        console.log(data["msg"]);
                        break;
                    default:
                        console.log("error json return array unkown key");
                        break;
                }
            },
            error: function(httpObj, textStatus) {
                console.log(textStatus);
                console.log(httpObj);
                console.log(httpObj.status);
                switch (httpObj.status) {
                    case 401:
                        console.log("not authorized to do this");
                        break;
                    case 422:
                        let errorObj = httpObj.responseJSON.errors;
                        let firstError = Object.values(errorObj)[0][0];
                        console.log(firstError);
                        console.log("validation error");
                        break;
                    case 0:
                        console.log("no internet connection");
                        break;
                    default:
                        console.log("uncaught case");
                        break;
                }
            }
        });
    </script>
@endsection
