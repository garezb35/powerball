<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="assets/images/logo2.png" type="image/x-icon">
    <meta name="description" content="">
    <title>채팅</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/chat.css">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <script>
        var remainTime ={{$p_remain[0]}};
        var speedRemain = 0;
    </script>
    <script src="/assets/popper/popper.min.js"></script>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/js/all.js"></script>
    <script src="/assets/js/chat.js"></script>
</head>
<body>
    @yield("content")
</body>
</html>
