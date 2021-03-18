<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="assets/images/logo2.png" type="image/x-icon">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>파워볼 게임</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/pball.css">
    <link rel="stylesheet" href="/assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <script>
        var remainTime = 0;
        var speedRemain = 0;
    </script>
    <script src="/assets/js/handlebars.js"></script>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/jquery-ui.min.js"></script>
    <script src="/assets/chart/Chart.min.js"></script>
    <script src="/assets/js/common.js"></script>
    @empty(!$css)
        <link rel="stylesheet" href="/assets/css/{{$css}}">
    @endempty
</head>
<body>
    <div class="modal sm-message bd-example-modal-sm"  role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">안내</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
    @yield('header')
    @yield('content')
</body>
@include('includes.empty_footer')
</html>
<script>
    $(document).ready(function(){
        heightResize();
    })
</script>
