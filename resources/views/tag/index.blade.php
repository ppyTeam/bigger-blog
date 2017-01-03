@extends('layouts.app')
@section('content')
    @forelse($main as $tag)
        <li>
            <a href="/tags/{{ $tag->id }}">{{ $tag->tag_name }}</a>
        </li>
        <hr>
    @empty
        <li>暂无标签</li>
    @endforelse
@endsection
