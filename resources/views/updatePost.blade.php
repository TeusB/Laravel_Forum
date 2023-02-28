@extends('layouts.mainLayout')

@section('sidebar')
@parent
@endsection

@section('content')
<h1>update Post</h1>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form method="post" action="{{ route('updatePost') }}">
    {{ csrf_field() }}
    <label for="title">title</label>
    <input type="text" name="title" value="@php echo $data[0]['title']; @endphp" required>

    <label for="content">content</label>
    <input type="text" name="content" value="@php echo $data[0]['content']; @endphp" required>

    <input type="hidden" name="idPost" value="@php echo $data[0]['id']; @endphp" required>

    <button type="submit">update Post</button>
</form>
@endsection