<link href="{{ myAsset('master/assets/css/loader.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ myAsset('master/assets/js/loader.js') }}"></script>
<!-- Common Styles Starts -->

<!-- Common Styles Ends -->
<!-- Page Level Plugin/Style Starts -->
<link rel="stylesheet" type="text/css" href="{{ myAsset('master/plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ myAsset('master/plugins/table/datatable/dt-global_style.css') }}">
<link href="{{ myAsset('master/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ myAsset('master/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ myAsset('master/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ myAsset('master/assets/css/basic-ui/custom_sweetalert.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ myAsset('master/assets/css/forms/checkbox-theme.css') }}" rel="stylesheet" type="text/css">

{{--<link href="{{ myAsset('master/assets/css/forms/form-widgets.css') }}" rel="stylesheet" type="text/css">--}}
<link href="{{ myAsset('master/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ myAsset('master/plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
<!-- Page Level Plugin/Style Ends -->
<link rel="stylesheet" type="text/css" href="{{ myAsset('master/plugins/select2/select2.min.css') }}">
<link href="{{ myAsset('master/assets/css/forms/form-widgets.css') }}" rel="stylesheet" type="text/css">
<link href="{{ myAsset('master/assets/css/pages/profile.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ myAsset('master/assets/css/basic-ui/custom_counter.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ myAsset('master/assets/css/basic-ui/accordion.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ myAsset('master/plugins/sweetalerts/promise-polyfill.js') }}"></script>

<link href="{{ myAsset('master/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ myAsset('master/assets/css/google-font.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ myAsset('master/assets/css/main.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ myAsset('master/assets/css/structure.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ myAsset('master/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ myAsset('master/plugins/highlight/styles/monokai-sublime.css') }}" rel="stylesheet" type="text/css"/>
<!-- Common Icon Starts -->
<link href="{{ myAsset('master/assets/line-awesome/css/line-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ myAsset('master/assets/css/basic-ui/tabs.css') }}" rel="stylesheet" type="text/css" />
{{--    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">--}}
<!-- Common Icon Ends -->
<style>
    .form-control, .select2{
        box-shadow: 0 0 1rem rgb(0 0 0 / 12%) !important;
        border: 1px solid #bfc9d4;

    }
    .select2-container{
        border:none;
    }
    .select2-container{
        z-index: 1050;
    }
</style>

@stack('css')
