@extends('layouts.app')
@section('content')
    @forelse($main as $tag)
        <li>
            <a href="{{ route('tags.show.default',$tag->tag_name) }}">{{ $tag->tag_name }}</a>
        </li>
        <hr>
    @empty
        <li>暂无标签</li>
    @endforelse
@endsection
