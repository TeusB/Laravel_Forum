@extends('layouts.mainLayout')

@section('sidebar')
    @parent
@endsection

@section('content')
    <h1>Create Post</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ route('createPost') }}">
        {{ csrf_field() }}
        <label for="title">title</label>
        <input type="text" name="title" required>

        <label for="content">content</label>
        <input type="text" name="content" required>

        <label for="rating">rating</label>
        <input type="rating" name="rating" required>

        <button type="submit">post</button>
    </form>
@endsection
