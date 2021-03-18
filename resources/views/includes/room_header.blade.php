<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="assets/images/logo2.png" type="image/x-icon">
    <meta name="description" content="">
    <title>파워볼 게임</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/pball.css">
    <link rel="stylesheet" href="/assets/css/jquery-ui.min.css">
    <script>
        var remainTime = 0;
        var speedRemain = 0;
    </script>
    @empty(!$css)
        <link rel="stylesheet" href="/assets/css/{{$css}}">
    @endempty
</head>
<body>

</body>
@include('includes.room_footer')
</html>
