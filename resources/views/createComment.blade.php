@extends('layouts.mainLayout')

@section('sidebar')
    @parent
@endsection

@section('content')
    <h1>Create Comment</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ route('createComment') }}">
        {{ csrf_field() }}
        <label for="title">title</label>
        <input type="text" name="title" required>

        <label for="idPost">idPost</label>
        <input type="nunmber" name="idPost" required>

        <label for="content">content</label>
        <input type="text" name="content" required>

        <label for="rating">rating</label>
        <input type="number" name="rating" required>

        <button type="submit">comment</button>
    </form>
@endsection
