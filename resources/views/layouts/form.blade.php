
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ myAsset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ myAsset('assets/img/favicon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        CAPITAL CITY UNIVERSITY, KANO
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    {{--<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />--}}
    {{--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">--}}
    <link rel="stylesheet" type="text/css" href="{{ myAsset('assets/DataTables/datatables.min.css') }}"/>
    <!-- CSS Files -->
    @include('commons.style')
    <script src="{{ myAsset('assets/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ myAsset('assets/ckeditor/samples/js/sample.js') }}"></script>
    @livewireStyles
</head>

<body class="">

<div class="wrapper" @auth() @else style="background: #f4f3ef;" @endauth>
    @include('commons.form-sidebar')
    <div class="main-panel">
        <!-- Navbar -->
    @include('commons.navbar')
    <!-- End Navbar -->
        <div class="content">
            @yield('content')
        </div>
        @include('commons.footer')
    </div>
</div>
<!--   Core JS Files   -->
@yield('css')
<script src="{{ myAsset('assets/js/core/jquery.min.js') }}"></script>
<script src="{{ myAsset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ myAsset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ myAsset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<!--  Notifications Plugin    -->
<script src="{{ myAsset('assets/js/plugins/bootstrap-notify.js') }}"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ myAsset('assets/js/paper-dashboard.min.js') }}" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ myAsset('assets/js/datatables.min.js') }}" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ myAsset('assets/js/dataTables.bootstrap4.min.js') }}" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ myAsset('assets/js/bootstrap-select.min.js') }}" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script type="text/javascript" src="{{ myAsset('assets/DataTables/datatables.min.js') }}"></script>
<script src="{{ myAsset('assets/js/select2.full.min.js') }}"></script>
@stack('js')
@yield('js')

<script>
    $(document).ready(function() {
        let audioElement = document.createElement('audio');
        audioElement.setAttribute('src', '{{ myAsset('ring.mp3') }}');

        audioElement.autoplay;

        audioElement.addEventListener('ended', function() {
            this.play();
        }, false);


        audioElement.addEventListener("canplay",function(){
            $("#length").text("Duration:" + audioElement.duration + " seconds");
            $("#source").text("Source:" + audioElement.src);
            $("#status").text("Status: Ready to play").css("color","green");
        });

        audioElement.addEventListener("timeupdate",function(){
            $("#currentTime").text("Current second:" + audioElement.currentTime);
        });

        $('#play').click(function() {
            audioElement.play();
            $("#status").text("Status: Playing");
        });

        $('#pause').click(function() {
            audioElement.pause();
            $("#status").text("Status: Paused");
        });

        $('#restart').click(function() {
            audioElement.currentTime = 0;
        });


        audioElement.addEventListener("canplaythrough", function() {
            /* the audio is now playable; play it if permissions allow */

        });
        // audioElement.play();
        let last = 0;
        setInterval(function(){
            $.ajax({
                url: "{{ route('memos.ringing') }}",
                success: function(data){
                    if(last != data && last > 0){
                        audioElement.currentTime = 0;
                        audioElement.play();
                        alert(data)
                    }else{
                        audioElement.pause();
                    }
                    last = data
                }
            })
        }, 10000);


    });
</script>
<script src="{{ myAsset('vendor/livewire/livewire.js?id=25f025805c3c370f7e87') }}"></script>
@livewireScripts
</body>
</html>

