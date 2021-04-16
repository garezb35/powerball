<script src="/assets/popper/popper.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
@empty(!$js)
    <script src="/assets/js/{{$js}}"></script>
@endempty
<script src="/assets/js/all.js"></script>
