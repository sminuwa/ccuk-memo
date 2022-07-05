
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ myAsset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ myAsset('logo.jpg') }}">
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
    @yield('css')
    <script src="{{ myAsset('assets/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ myAsset('assets/ckeditor/samples/js/sample.js') }}"></script>
    @livewireStyles
</head>

<body class="">

<div class="wrapper" @auth() @else style="background: #f4f3ef;" @endauth>
    @include('commons.sidebar')
    <div class="main-panel">
        <!-- Navbar -->
        @include('commons.navbar')
        <!-- End Navbar -->
        <div class="content">
            @yield('content')
        </div>
        @include('commons.footer')

        @auth
            @php $user = auth()->user(); @endphp
        <div class="modal fade" id="remiderModal" tabindex="-1" role="dialog" aria-labelledby="remiderModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg mt-0 pt-0" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" style="float:right" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title text-left" id="remiderModalLabel">NOTICE BOARD{{--{{ greetings() }} {{$user?->details()?->gender == 'Male' ? 'Sir, ':'Madam, ' }} <small>{{ $user?->fullName() }}</small--}}</h5>

                    </div>
                    <div class="modal-body">
                        <P>{{ greetings() }} {{$user?->details()?->gender == 'Male' ? 'Sir, ':'Madam, ' }} <small>{{ $user?->fullName() }}</small></P>

                        Kindly note that we will be experiencing server downtime due to scheduled maintenance today <strong style="color:red">from 8:00PM (27th) until 4:00AM (28th) June, 2022</strong><br>
                        During this time, the memo application may be unavailable.<br>
                        Please accept our sincere apologies for any inconvenience that this may cause.<br><br>
                        Kind Regards,<br>
                        Developer
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a href="{{ route('memos.index') }}" type="button" class="btn btn-primary">Go to memos</a>
                    </div>
                </div>
            </div>
        </div>
        @endauth

    </div>
</div>
<!--   Core JS Files   -->

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
<script src="{{ myAsset('assets/DataTables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ myAsset('assets/js/select2.full.min.js') }}"></script>
<script src="{{ myAsset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ myAsset('master/js-cookies/js.cookie.min.js') }}"></script>
<script src="{{ myAsset('master/js-cookies/js.cookie.min.js') }}"></script>
{{--<script src="{{ myAsset('assets/js/jquery.dataTables.min.js') }}"></script>--}}
{{--<script src="{{ myAsset('assets/js/dataTables.jqueryui.min.js') }}"></script>--}}
@stack('js')
@yield('js')
<script>
    $('table.display').DataTable();

    $(document).ready(function() {
        if (localStorage.getItem('seen1{{ auth()->id() }}') != (new Date()).getDate()) {
            setTimeout(function(){
                // $('#remiderModal').modal();
                localStorage.setItem('seen1{{ auth()->id() }}', (new Date()).getDate());
            }, 4000);
        }

    });
    //general remider model

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
                        // alert(data)
                    }else{
                        audioElement.pause();
                    }
                    last = data
                }
            });

            /*$.ajax({
                url: "{{ route('api.local_to_remote') }}",
                success: function(response){
                    console.log(response)
                }
            })*/
        }, 120000);


    });
</script>
<script src="{{ myAsset('vendor/livewire/livewire.js?id=25f025805c3c370f7e87') }}"></script>
@livewireScripts
</body>
</html>

