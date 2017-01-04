@extends('layouts.app')
@section('content')
    @forelse($main as $post)
        <li>
            <a href="/blog/{{ $post->id }}">{{ $post->title }}</a>
            <p>创建时间:{{ $post->created_at }}</p>
        </li>
        <hr>
    @empty
        <li>暂无文章</li>
    @endforelse
@endsection
