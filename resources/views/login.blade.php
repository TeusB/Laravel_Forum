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
@endsection
