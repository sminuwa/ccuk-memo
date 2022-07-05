
<link href="{{ myAsset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />
<link href="{{ myAsset('assets/css/paper-dashboard.css')}}" rel="stylesheet" />
<link href="{{ myAsset('assets/css/paper-dashboard-pro.min.css')}}" rel="stylesheet" />
<!-- CSS Just for demo purpose, don't include it in your project -->
<link href="{{ myAsset('assets/demo/demo.css')}}" rel="stylesheet" />
<link href="{{ myAsset('assets/css/autoFill.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{ myAsset('assets/css/datatables.min.css')}}" rel="stylesheet" />
<link href="{{ myAsset('assets/css/autoFill.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{ myAsset('assets/css/autoFill.dataTables.min.css')}}" rel="stylesheet" />
<link href="{{ myAsset('assets/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{ myAsset('assets/css/buttons.dataTables.min.css')}}" rel="stylesheet" />
<link href="{{ myAsset('assets/css/buttons.dataTables.min.css')}}" rel="stylesheet" />
<link href="{{ myAsset('assets/css/bootstrap-select.min.css')}}" rel="stylesheet" />
<link href="{{ myAsset('assets/css/font-awesome.min.css')}}" rel="stylesheet" />
<link href="{{ myAsset('assets/css/select2.min.css')}}" rel="stylesheet" />
<link href="{{ myAsset('master/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css"/>
{{--<link href="{{ myAsset('assets/css/jquery-ui.css')}}" rel="stylesheet" />--}}
{{--<link href="{{ myAsset('assets/css/jqueryui.min.css')}}" rel="stylesheet" />--}}
<style>
    table.dataTable > thead .sorting:before, table.dataTable > thead .sorting_asc:before{
        right: 1em;
        content: "" !important;
    }
    table.dataTable > thead .sorting:before, table.dataTable > thead .sorting_asc:after{
        right: 1em;
        content: "" !important;
    }
    table.dataTable > thead .sorting:after{
        content: "" !important;
    }
    /* TOGGLE STYLING */
    .toggle {
        margin: 0 0 1.5rem;
        box-sizing: border-box;
        font-size: 0;
        display: flex;
        flex-flow: row nowrap;
        justify-content: flex-start;
        align-items: stretch;
    }

    .toggle input {
        width: 0;
        height: 0;
        position: absolute;
        left: -9999px;
    }

    .toggle input + label {
        margin: 0;
        padding: 0.05rem 1rem;
        box-sizing: border-box;
        position: relative;
        display: inline-block;
        border: solid 1px #DDD;
        background-color: #FFF;
        font-size: 1rem;
        line-height: 140%;
        /*font-weight: 600;*/
        text-align: center;
        box-shadow: 0 0 0 rgba(255, 255, 255, 0);
        transition: border-color 0.15s ease-out, color 0.25s ease-out, background-color 0.15s ease-out, box-shadow 0.15s ease-out;
        /* ADD THESE PROPERTIES TO SWITCH FROM AUTO WIDTH TO FULL WIDTH */
        /*flex: 0 0 50%; display: flex; justify-content: center; align-items: center;*/
        /* ----- */
    }

    .toggle input + label:first-of-type {
        border-radius: 6px 0 0 6px;
        border-right: none;
    }

    .toggle input + label:last-of-type {
        border-radius: 0 6px 6px 0;
        border-left: none;
    }

    .toggle input:hover + label {
        border-color: #ef8157;
    }

    .toggle input:checked + label {
        background-color: #ef8157;
        color: #FFF;
        box-shadow: 0 0 10px rgba(102, 179, 251, 0.5);
        border-color: #ef8157;
        z-index: 1;
    }

    .toggle input:focus + label {
        outline: dotted 1px #CCC;
        outline-offset: 0.45rem;
    }

    @media (max-width: 800px) {
        .toggle input + label {
            padding: 10px 0.05rem;
            flex: 0 0 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    }

    .form-control, .select2, input[type=search], div.dataTables_wrapper div.dataTables_length select {
        /*box-shadow: 0 0 3px #ef8157;*/
        box-shadow: 1px 1px 14px -6px #ef8157;
        -webkit-box-shadow: 1px 1px 14px -6px #ef8157;
        -moz-box-shadow: 1px 1px 14px -6px #ef8157;
    }
    .form-control:disabled, .form-control[readonly]{
        background-color:#ffffff;
    }
</style>


<style>
    body {
        font-family: "Roboto", sans-serif;
    }
    .paginate_button.current{
        /*border:none !important;*/
        background: #ffffff !important;
    }
    .paginate_button.current:hover{
        /*border:none !important;*/
        background: #ffffff !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: .1em .5em;
    }

    table.dataTable.no-footer {
         border-bottom:1px solid #dee2e6;
    }


    .select-wrapper {
        margin: auto;
        max-width: 600px;
        width: calc(100% - 40px);
    }

    .select-pure__select {
        align-items: center;
        background: #f9f9f8;
        border-radius: 4px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        box-sizing: border-box;
        color: #363b3e;
        cursor: pointer;
        display: flex;
        font-size: 16px;
        font-weight: 500;
        justify-content: left;
        min-height: 44px;
        padding: 5px 10px;
        position: relative;
        transition: 0.2s;
        width: 100%;
    }

    .select-pure__options {
        border-radius: 4px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        box-sizing: border-box;
        color: #363b3e;
        display: none;
        left: 0;
        max-height: 221px;
        overflow-y: scroll;
        position: absolute;
        top: 50px;
        width: 100%;
        z-index: 5;
    }

    .select-pure__select--opened .select-pure__options {
        display: block;
    }

    .select-pure__option {
        background: #fff;
        border-bottom: 1px solid #e4e4e4;
        box-sizing: border-box;
        height: 44px;
        line-height: 25px;
        padding: 10px;
    }

    .select-pure__option--disabled {
        color: #e4e4e4;
    }

    .select-pure__option--selected {
        color: #e4e4e4;
        cursor: initial;
        pointer-events: none;
    }

    .select-pure__option--hidden {
        display: none;
    }

    .select-pure__selected-label {
        align-items: 'center';
        background: #5e6264;
        border-radius: 4px;
        color: #fff;
        cursor: initial;
        display: inline-flex;
        justify-content: 'center';
        margin: 5px 10px 5px 0;
        padding: 3px 7px;
    }

    .select-pure__selected-label:last-of-type {
        margin-right: 0;
    }

    .select-pure__selected-label i {
        cursor: pointer;
        display: inline-block;
        margin-left: 7px;
    }

    .select-pure__selected-label img {
        cursor: pointer;
        display: inline-block;
        height: 18px;
        margin-left: 7px;
        width: 14px;
    }

    .select-pure__selected-label i:hover {
        color: #e4e4e4;
    }

    .select-pure__autocomplete {
        background: #f9f9f8;
        border-bottom: 1px solid #e4e4e4;
        border-left: none;
        border-right: none;
        border-top: none;
        box-sizing: border-box;
        font-size: 16px;
        outline: none;
        padding: 10px;
        width: 100%;
    }

    .select-pure__placeholder--hidden {
        display: none;
    }
    input, select {
        height: auto !important;
        padding: 2px 10px !important;
    }

    /* Loader */
    .loader__overlay {
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        position: fixed;
        background: #2229;
        z-index: 2000;
    }
    .overlay {
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        position: fixed;
        background: #2229;
        z-index: 999;
    }
    .overlay__inner {
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        position: absolute;
        overflow: auto;
    }
    .overlay__content {
        left: 50% ;
        position: absolute;
        top: 50%;
        transform: translate(-50%, -50%);
    }
    .overlay__modal {
        margin: 5px auto;
        width: 50%;
    }
    .spinner {
        width: 75px;
        height: 75px;
        display: inline-block;
        border-width: 2px;
        border-color: rgba(255, 255, 255, 0.05);
        border-top-color: #fff;
        animation: spin 1s infinite linear;
        border-radius: 100%;
        border-style: solid;
    }
    @keyframes spin {
        100% {
            transform: rotate(360deg);
        }
    }
    .right{
        float:right;
    }
    .ellipsis{
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    @media only screen and (max-width: 600px) {
        .border-right-dashes{
            border-right: none;
        }
        .overlay__modal{
            width:100%;
        }
    }
</style>
<style>
    .card{
        border-radius: 0;
    }
</style>
