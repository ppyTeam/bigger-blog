@extends('layouts.app')
@section('content')
    <a class="category" href="#">
        {{$main->category->category_name}}
    </a>
    @if ($main->tags->count() )
        &nbsp;标签:
        @foreach ($main->tags as $each_tag)
            <a class="tag" href="#">{{$each_tag->tag_name}}</a>
            @if ($main->tags->last() !== $each_tag)
                ,
            @endif
        @endforeach
    @endif
    &nbsp;最后更新:{{ $main->updated_at }}
    <hr>
    {{$main->content}}
@endsection
