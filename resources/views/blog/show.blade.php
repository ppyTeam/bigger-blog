<!DOCTYPE html>
<html lang="en">
<head>
    @if ($is_mobile)
        @include('layouts.assets',['type'=>'frontend'])
    @endif
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> {{$main->title}} - {{ config('app.name') }}</title>

    <?php // TODO 以下对象仅用于开发调试，上线时移除
        $baseRoute = preg_replace('/^http(s)?:\/\/(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])(?=\/)|^http(s)?:\/\/(([a-zA-Z0-9]*|[a-zA-Z0-9]([a-zA-Z0-9\-][a-zA-Z0-9])*[a-zA-Z0-9]?|xn--[A-Za-z0-9]+)\.)*(xn--[A-Za-z0-9]+|[A-Za-z]+)(?=\/)/', '', config('app.url'));
    ?>
    <script>var baseRoute = '{{ $baseRoute }}';</script>

    <?php /*正常内容，即遮罩层相关css和js，无论如何都要加载，内联*/ ?>


<!-- 这是第一部分，另一部分放在</body>前 -->
    @if ($is_mobile)
    @section('mobile-header')
    @show
    @else
        <link href="{{ $assets['url'].$assets['frontend']['appcss']['filename'] }}" rel="stylesheet">
    @endif
</head>

<body>
<div id="app">
    <router-view></router-view>
</div>

<div id="html-seo-container">
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
</div>

<!-- 这是第二部分 -->
@if ($is_mobile)
@section('mobile-body')
@show
@else
    <script src="{{ $assets['url'] . $assets['frontend']['commonjs']['filename'] }}"></script>
    <script src="{{ $assets['url'] . $assets['frontend']['appjs']['filename'] }}"></script>
@endif
</body>
</html>