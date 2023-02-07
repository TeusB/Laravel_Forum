@extends('layouts.mainLayout')

@section('sidebar')
    @parent
@endsection

@section('content')
    <h1>Register</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ route('registerUser') }}">
        {{ csrf_field() }}
        <label for="name">name</label>
        <input type="text" name="name" required>
        <label for="email">email</label>
        <input type="text" name="email" required>
        <label for="password">password</label>
        <input type="password" name="password" required>
        <label for="password_repeat">password</label>
        <input type="password" name="password_repeat" required>
        <button type="submit">login</button>
    </form>
@endsection
