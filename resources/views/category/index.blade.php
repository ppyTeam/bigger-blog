@extends('layouts.app')
@section('content')
    @forelse($main as $category)
        <li>
            <a href="/categories/{{ $category->id }}">{{ $category->category_name }}</a>
        </li>
        <hr>
    @empty
        <li>暂无分类</li>
    @endforelse
@endsection
