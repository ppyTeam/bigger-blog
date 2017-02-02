@extends('layouts.app')
@section('content')
    <header>
        <h2 class="title">{{ $main->title }}</h2>
        <p>Post at <span class="date">{{ $main->updated_at }}</span></p>
        <p>
            <a class="category" href="{{ route('categories.show.default',$main->category->category_name) }}">
                {{ $main->category->category_name }}
            </a>
            @if ($main->tags->count() )
                &nbsp;标签:
                @foreach ($main->tags as $each_tag)
                    <a class="tag" href="{{ route('tags.show.default',$each_tag->tag_name) }}">
                        {{$each_tag->tag_name}}
                    </a>
                    @if ($main->tags->last() !== $each_tag)
                        ,
                    @endif
                @endforeach
            @endif
        </p>
    </header>
    <div id="content">
        {!! $main->content !!}
    </div>
@endsection
