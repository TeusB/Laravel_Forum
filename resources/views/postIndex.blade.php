@extends('layouts.mainLayout')

@section('sidebar')
    @parent
@endsection

@section('content')
    <h1>post Index</h1>
    <?php
    ?>
    @foreach ($posts as $key => $value)
        <br>
        <a href="{{ route('showPost', ['idPost' => $value['id']]) }}">{{ $value['title'] }}</a>
        <br>
        user: {{ $value['user']['name'] }}
        <br>
        comments: {{ $value['comments_count'] }}
        <br>
        @foreach ($value['comments'] as $key2 => $value2)
            {{ $value2['title'] }}
            <br>
        @endforeach
        <br>
    @endforeach
@endsection
