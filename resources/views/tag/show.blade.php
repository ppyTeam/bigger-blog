@extends('layouts.app')
@section('content')
    <h4>
        <a href="/tags/{{$tag_id}}">
            {{$tag_name}}
        </a>
    </h4>
    @forelse($main as $post)
        <li>
            <a href="/blog/{{ $post->id }}">{{ $post->title }}</a>
        </li>
        <hr>
    @empty
        <li>该标签下暂无文章</li>
    @endforelse
@endsection
