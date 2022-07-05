<!-- Common Script Starts -->
<script src="{{ myAsset('master/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
<script src="{{ myAsset('master/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ myAsset('master/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ myAsset('master/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ myAsset('master/assets/js/app.js') }}"></script>
<!-- Page Level Plugin/Script Starts -->
<script src="{{ myAsset('master/plugins/table/datatable/datatables.js') }}"></script>
<!--  The following JS library files are loaded to use Copy CSV Excel Print Options-->
<script src="{{ myAsset('master/plugins/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
<script src="{{ myAsset('master/plugins/table/datatable/button-ext/jszip.min.js') }}"></script>
<script src="{{ myAsset('master/plugins/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
<script src="{{ myAsset('master/plugins/table/datatable/button-ext/buttons.print.min.js') }}"></script>
<script src="{{ myAsset('master/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ myAsset('master/assets/js/basicui/sweet_alerts.js') }}"></script>

<!-- The following JS library files are loaded to use PDF Options-->
<script src="{{ myAsset('master/plugins/table/datatable/button-ext/pdfmake.min.js') }}"></script>
<script src="{{ myAsset('master/plugins/table/datatable/button-ext/vfs_fonts.js') }}"></script>
{{-- date picker --}}

<script src="{{ myAsset('master/plugins/select2/select2.min.js') }}"></script>
<script src="{{ myAsset('master/assets/js/forms/custom-select2.js') }}"></script>
{{--<script src="{{ myAsset('master/assets/js/basicui/counter.js') }}"></script>--}}

<script src="{{ myAsset('master/plugins/flatpickr/flatpickr.js') }}"></script>
<script src="{{ myAsset('master/plugins/flatpickr/custom-flatpickr.js') }}"></script>
{{--<script src="{{ myAsset('master/assets/js/custom.js') }}"></script>--}}

<script>
    $(document).ready(function() {
        App.init();
        $(".profile-tabs .nav-link").click(function() {
            $('html,body').animate({
                scrollTop: $(".cover-image-area").offset().top
            },'slow');
        });
    });

    $('.export-data').DataTable( {
        dom: '<"row"<"col-md-6"B><"col-md-6"f> ><""rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>>',
        buttons: {
            buttons: [
                // { extend: 'copy', className: 'btn btn-primary' },
                // { extend: 'csv', className: 'btn btn-primary' },
                { extend: 'excel', className: 'btn btn-primary' },
                { extend: 'pdf', className: 'btn btn-primary' },
                { extend: 'print', className: 'btn btn-primary' }
            ]
        },
        "language": {
            "paginate": {
                "previous": "<i class='las la-angle-left'></i>",
                "next": "<i class='las la-angle-right'></i>"
            }
        },
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 10
    } );

    $('.datatable').DataTable( {


        "language": {
            "paginate": {
                "previous": "<i class='las la-angle-left'></i>",
                "next": "<i class='las la-angle-right'></i>"
            }
        },
        "lengthMenu": [10, 20, 50, 100],
        "pageLength": 10
    } );

</script>
<script src="{{ myAsset('master/assets/js/custom.js') }}"></script>
<!-- Common Script Ends -->
@yield('js')
<script>
    @if(session()->has('success'))
    swal({
        title: 'Done!',
        text: '{{ session('success') }}',
        type: 'success',
        timer: 2000,
        padding: '2em',
    }).then(function (result) {
        if (
            result.dismiss === swal.DismissReason.timer
        ) {
            console.log('I was closed by the timer')
        }
    })
    @endif
    @if(session()->has('error'))
    swal({
        title: 'Failed!',
        text: '{{ session('error') }}',
        type: 'error',
        timer: 2000,
        padding: '2em',
    }).then(function (result) {
        if (
            result.dismiss === swal.DismissReason.timer
        ) {
            console.log('I was closed by the timer')
        }
    })
    @endif

</script>
