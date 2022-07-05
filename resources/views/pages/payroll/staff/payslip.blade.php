

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>CAPITAL CITY UNIVERSITY KANO</title>
    <link rel="icon" type="image/x-icon" href="{{ myAsset('logo.jpg') }}"/>
    <!-- Common Styles Starts -->
{{--    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">--}}
    <link href="{{ myAsset('master/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ myAsset('master/assets/css/main.css') }}" rel="stylesheet" type="text/css" />
    <!-- Common Styles Ends -->
    <!-- Common Icon Starts -->
{{--    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">--}}
    <!-- Common Icon Ends -->
    <!-- Page Level Plugin/Style Starts -->
    <link href="{{ myAsset('master/assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ myAsset('master/assets/css/pages/privacy_policy.css') }}" rel="stylesheet" type="text/css" />
    <!-- Page Level Plugin/Style Ends -->
    <style>
        .table td, .table th {
            padding: 0.1rem;
        }
        @media print {
            body * {
                visibility: hidden;
            }
            #section-to-print, #section-to-print * {
                visibility: visible;
            }
            #section-to-print {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
</head>
<body>
<!-- Loader Starts -->
{{--<div id="load_screen">
    <div class="boxes">
        <div class="box">
            <div></div><div></div><div></div><div></div>
        </div>
        <div class="box">
            <div></div><div></div><div></div><div></div>
        </div>
        <div class="box">
            <div></div><div></div><div></div><div></div>
        </div>
        <div class="box">
            <div></div><div></div><div></div><div></div>
        </div>
    </div>
    <!-- <p class="xato-loader-heading">Xato</p> -->
</div>--}}
<!--  Loader Ends -->
<!-- Main Body Starts -->
<div class="privacy-header-wrapper">
    <nav class="navbar navbar-expand">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>
    </nav>
    <div class="container">
        <div class="row mt-5 pb-5">
            <div class="col-md-12 align-self-center order-md-0 order-1">
                <h1 class="text-center mb-2">Monthly Payslip</h1>
                <p class="text-center mb-5">This is salary payslip of only one month</p>
            </div>
        </div>
    </div>
</div>
<div class="container mb-3 pb-3" style="margin-top:-50px;">

        <div class="row">
            <div class="col-md-12">
                <div class="card px-5 py-3">
                <div class="card-box">
                    <div class="text-right">
                        <button class="btn btn-primary bg-gradient-primary" onclick="print()"><i class="las la-print"></i> Print</button>
                    </div>
                    <div id="section-to-print" class="content-section py-1 animated animatedFadeInUp fadeInUp">
                        <div class="row inv--head-section mb-4">
                            <div class="col-sm-12 col-12 text-center">
                                <div class="company-info">
                                    <img src="{{ myAsset("logo.jpg") }}" width="100"/>
                                </div>
                                <h3 class="m-0">CAPITAL CITY UNIVERSITY KANO</h3>
                                <h5 class="m-0 bg-gradient-primary" style="color:white">
                                    Salary payslip for the month of @if(isset($month)) {{ date("F, Y", strtotime($month)) }} @else {{ date('F, Y') }}  @endif
                                </h5>
                                @if(isset($branch)) <h6 class="m-0 text-danger">Branch Name: {{ $branch->name }}</h6> @endif
                            </div>
                        </div>
                        @php $totalGross = $totalDeduction = $totalNet = 0 @endphp
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                    <tr>
                                        <th class="px-2 w-25">Full Name</th>
                                        <td class="px-2" colspan="3">{{ $user->fullName() }}</td>
                                    </tr>
                                    <tr>
                                        <th class="px-2 w-25">Gender</th>
                                        <td class="px-2 w-25">{{ $user->details()->gender ?? null }}</td>
                                        <th class="px-2 w-25">Marital Status</th>
                                        <td class="px-2">{{ $user->details()->marital_status ?? null }}</td>
                                    </tr>
                                    <tr>
                                        <th class="px-2 w-25">Designation</th>
                                        <td class="px-2 w-25">{{ $user->position()->name ?? null }}</td>
                                        <th class="px-2 w-25">Level/Step</th>
                                        <td class="px-2 w-25">{{ $user->payslip($month)[0]->level ?? null }}/{{ $user->payslip($month)[0]->step ?? null }}</td>
                                    </tr>
                                    <tr>
                                        <th class="px-2 w-25">Account Number</th>
                                        <td class="px-2">{{ $user->payroll_user()->account_number ?? null }}</td>
                                        <th class="px-2 w-25">Bank Name</th>
                                        <td class="px-2">{{ $user->payroll_user()->bank->name ?? null }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6 w-50">
                                <h4 class="text-warning">Earnings</h4>
                                <table class="table table-bordered table-striped">
                                    <thead class="">
                                    <tr>
                                        <th class="px-2" scope="col">Item</th>
                                        <th scope="col" class="px-2 text-right">Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user->payslip($month)->where('type','!=','Deduction')->where('category', 'Regular') as $pay)
                                        <tr>
                                            <td class="px-2 w-50">{{ $pay->item }}</td>
                                            <td class="px-2 text-right">{{ number_format($pay->amount,2) ?? null }} </td>
                                        </tr>
                                        @php $totalGross += $pay->amount @endphp
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="px-2">Total Earnings</th>
                                        <th class="px-2 text-right">{{ number_format($totalGross,2) }} </th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-6 w-50">
                                <h4 class="text-warning">Deductions</h4>
                                <table class="table table-bordered table-striped">
                                    <thead class="">
                                    <tr>
                                        <th class="px-2 w-50" scope="col">Item</th>
                                        <th scope="col" class="px-2 text-right">Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user->payslip($month)->where('type', 'Deduction')->where('category', 'Regular') as $pay)
                                        <tr>
                                            <td class="px-2">{{ $pay->item }}</td>
                                            <td class="px-2 text-right">{{ number_format($pay->amount, 2)?? null }} </td>
                                        </tr>
                                        @php $totalDeduction += $pay->amount @endphp
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="px-2">Total Deductions</th>
                                        <th class="px-2 text-right">{{ number_format($totalDeduction,2) }} </th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-warning">Summary</h4>
                                <table class="table table-bordered table-striped w-100">
                                    <tbody>
                                    <tr>
                                        <th class="px-2 w-50">Total Gross Salary</th>
                                        <th class="px-2">{{ number_format($totalGross,2) }}</th>
                                    </tr>
                                    <tr>
                                        <th class="px-2">Total Deductions</th>
                                        <th class="px-2">{{ number_format($totalDeduction,2)}}</th>
                                    </tr>
                                    <tr>
                                        <th class="px-2">Net Salary</th>
                                        <th class="px-2">{{ number_format($totalGross - $totalDeduction,2) }}</th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-12 text-center">
                                <h6 class=" inv-title">This is salary payslip of only one month</h6>
                            </div>
                        </div>
                        <div class="footer-contact">
                            <div class="row">
                                <div class="col-sm-12 col-12">
{{--                                    <p class="">Email: payroll@albabello.com &nbsp;|&nbsp; Contact: 08135067070 &nbsp;|&nbsp; Website: www.albabello.com</p>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>

</div>
<!-- Main Body Ends -->
<!-- Footer Starts -->
<div class="privacy-footer">
    <div class="d-flex align-items-center justify-content-between">
        <p class="">Copyright © {{ date('Y') }} | All rights reserved.</p>
        <p class="">Capital City University, Kano <i class="las la-heart text-danger"></i></p>
    </div>
</div>
<!-- Footer Ends -->
<!-- Common Script Starts -->
<div class="arrow" style="display: none;">
    <i class="las la-angle-up"></i>
    </p>
    <!-- Common Script Ends -->
    <!-- Common Script Starts -->
    <script src="../public/master/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="../public/master/bootstrap/js/popper.min.js"></script>
    <script src="../public/master/bootstrap/js/bootstrap.min.js"></script>
    <!-- Common Script Ends -->
    <!-- Page Level Plugin/Script Starts -->
    <script src="../public/master/assets/js/loader.js"></script>
    <script src="../public/master/assets/js/pages/faq/faq.js"></script>
    <!-- Page Level Plugin/Script Ends -->
</body>
</html>

