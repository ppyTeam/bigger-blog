<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- TODO 后端通过 1.判断UA为移动端；2.不存在提示不支持ls的cookie，则输出下列缓存ls的js，其余桌面端、蜘蛛和不支持ls的移动端（可能出现写满等情况）都默认引用<link>和<script>标签。**想办法使用绝对路径** -->
    @if (true)
        {!! str_replace('\'%replace(assetsObj)%\'', $res['assets-hash'], $res['assets-getter']) !!}
    @else
        <link href="css/app-43a490ad.css" rel="stylesheet">
        <script src="js/common-fbdb3600.js"></script>
        <script src="js/app-a423232b.js"></script>
    @endif
</head>
<body>
<div id="app">{{ $res['content'] }}</div>

<script>

</script>
</body>
</html>