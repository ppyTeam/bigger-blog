@extends('layouts.app')
@section('content')
    @forelse($main as $category)
        <li>
            <a href="{{ route('categories.show.default',$category->category_name) }}">{{ $category->category_name }}</a>
        </li>
        <hr>
    @empty
        <li>暂无分类</li>
    @endforelse
@endsection
