@include('layouts.assets')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <?php /*正常内容，即遮罩层相关css和js，无论如何都要加载，内联*/ ?>

    <?php // TODO 以下对象仅用于开发调试，上线时移除
        $baseRoute = preg_replace('/^http(s)?:\/\/(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])(?=\/)|^http(s)?:\/\/(([a-zA-Z0-9]*|[a-zA-Z0-9]([a-zA-Z0-9\-][a-zA-Z0-9])*[a-zA-Z0-9]?|xn--[A-Za-z0-9]+)\.)*(xn--[A-Za-z0-9]+|[A-Za-z]+)(?=\/)/', '', config('app.url'));
    ?>
    <script>var baseRoute = '{{ $baseRoute }}';</script>

    <?php
    // TODO
    // 1.判断UA为移动端
    // 2.不存在提示不支持ls的cookie
    // 则输出用于缓存ls的js，其余桌面端、蜘蛛和不支持ls的移动端（可能出现写满等情况）都默认引用<link>和<script>标签。
    // 为快照考虑，是否能使用绝对路径？

    $desktop = true;
    ?>

    <!-- 这是第一部分，另一部分放在</body>前 -->
    @if ($desktop)
        <?php /*希望能传入参数自动获取*/ ?>
        <link href="{{ $res['assets-appcss'] }}" rel="stylesheet">
    @else
        @section('mobile-header')
        @show
    @endif
</head>

<body>
<div id="app">
    <router-view></router-view>
</div>

<div id="html-seo-container">
    {{ $res['content'] }}
</div>

    <!-- 这是第二部分 -->
    @if ($desktop)
        <?php /*希望能传入参数自动获取*/ ?>
        <script src="{{ $res['assets-commonjs'] }}"></script>
        <script src="{{ $res['assets-appjs'] }}"></script>
    @else
        @section('mobile-body')
        @show
    @endif
</body>
</html>