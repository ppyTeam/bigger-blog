<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- TODO 没有指定cookie则输出下列内容，否则输出<link><script> -->
    <script>{!! str_replace('\'%replace(assetsObj)%\'', $res['assets-hash'], $res['assets-getter']) !!}</script>
</head>
<body>
<div id="app">{{ $res['content'] }}</div>
</body>
</html>