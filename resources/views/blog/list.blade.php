@extends('layouts.app')
@section('content')
    @forelse($main as $post)
        <li>
            <a href="{{ route('blog.show',$post->id) }}">{{ $post->title }}</a>
            <p>
                &nbsp;分类:
                <a class="category" href="{{ route('categories.show.default',$post->category->category_name) }}">
                    {{$post->category->category_name}}
                </a>
                @if ($post->tags->count() )
                    &nbsp;标签:
                    @foreach ($post->tags as $each_tag)
                        <a class="tag" href="{{ route('tags.show.default',$each_tag->tag_name) }}">{{$each_tag->tag_name}}</a>
                        @if ($post->tags->last() !== $each_tag)
                            ,
                        @endif
                    @endforeach
                @endif
                &nbsp;最后更新:{{ $post->updated_at }}
            </p>
            <p>
                {{ str_limit($post->content, 50, '...') }}
            </p>
        </li>
        <hr>
    @empty
        <li>暂无文章</li>
    @endforelse
@endsection
