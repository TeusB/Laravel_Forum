@extends('layouts.mainLayout')

@section('sidebar')
@parent
@endsection

@section('content')
<h1>post Index</h1>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<table>
    <tr>
        <th>rating</th>
        <th>comments</th>
        <th>title</th>
        <th>author</th>
        <th>update</th>
        <th>delete</th>
    </tr>
    @foreach ($posts as $key => $post)
    <tr>
        <td>0</td>
        <td>{{ $post['comments_count'] }}</td>
        <td>{{ $post['title'] }}</td>
        <td>{{ $post['user']['name'] }}</td>
        <td>
            @if (Auth::user()->can('update', $post))
            <form method="get" action="{{ route('showUpdatePost') }}">
                {{ csrf_field() }}
                <input type="hidden" name="idPost" value="@php echo $post['id']; @endphp">
                <input type="submit" value="update" />
            </form>
            @endif
        </td>
        <td>
            @if (Auth::user()->can('update', $post))
            <form method="post" action="{{ route('deletePost') }}">
                {{ csrf_field() }}
                <input type="hidden" name="idPost" value="@php echo $post['id']; @endphp">
                <input type="submit" value="delete" />
            </form>
            @endif
        </td>
    </tr>
    @endforeach
</table>

@endsection