@include('layouts.assets',['type'=>'frontend'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>
<script>console.time('lsload');</script>
    <!-- 正常内容，即遮罩层相关css和js，无论如何都要加载，内联 -->

    <!-- 这是第一部分，另一部分放在</body>前 -->
    @section('mobile-header')
    @show
</head>

<body>
<div id="app">
    <router-view></router-view>
</div>

<div id="html-seo-container">
    @yield('content')
</div>

<!-- 这是第二部分 -->
@section('mobile-body')
@show
</body>
</html>