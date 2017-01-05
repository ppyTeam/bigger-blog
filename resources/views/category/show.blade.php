@extends('layouts.app')
@section('content')
    <h4>
        <a href="{{ route('categories.show.default',$category->category_name) }}">
            {{$category_name}}
        </a>
    </h4>
    @forelse($main as $post)
        <li>
            <a href="{{ route('blog.show',$post->id) }}">{{ $post->title }}</a>
        </li>
        <hr>
    @empty
        <li>该分类下暂无文章</li>
    @endforelse
@endsection
