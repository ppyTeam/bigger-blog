@include('layouts.assets',['type'=>'frontend'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    {{-- 移动端访问时使用 ls --}}
    @section('mobile-header')
    @show

    {{-- 直接输出到前端的 JavaScript Object --}}
    @section('common-data')
    @show
</head>

<body>
<div id="app">
    <router-view></router-view>
</div>

<div id="html-seo-container">
    <script>
        /**
         * For search engine snapshot
         *
         * Baidu snapshot 不执行任何脚本，将显示 SEO 内容
         * Google、Bing snapshot 会执行部分脚本，此时引导跳转至原网站
         *
         */
        document.getElementById('html-seo-container').style.display = 'none';
    </script>

    @yield('content')
</div>

{{-- 移动端访问时使用 ls --}}
@section('mobile-body')
@show
</body>
</html>