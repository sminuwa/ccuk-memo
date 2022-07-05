
<div class="text-right">
    <button class="btn btn-primary bg-gradient-primary" onclick="print()"><i class="las la-print"></i> Print</button>
</div>
<div id="section-to-print" class="animated animatedFadeInUp fadeInUp w-100">
    <div class="row inv--head-section mb-4">
        <div class="col-sm-12 col-12 text-center">
            <div class="company-info">
                <img src="{{ myAsset("logo.jpg") }}" width="150"/>
            </div>
            <h3 class="m-0">CAPITAL CITY UNIVERSITY, KANO</h3>
            <h5 class="m-0 bg-gradient-primary" style="color:white">
                Salary Items Summary Report for the Month of @if(isset($month)) {{ date("F, Y", strtotime($month)) }} @else {{ date('F, Y') }}  @endif
            </h5>
        </div>
    </div>

    <div class="row inv--product-table-section">
        <div class="col-12">
            <div class="w-100">
                <h4 class="text-warning">Incomes</h4>
                <table class="table table-bordered w-100">
                    <thead class="">
                    <tr>
                        <th scope="col" style="width:5%">S.NO</th>
                        <th scope="col" style="width:10%">Code</th>
                        <th scope="col" style="width:35%">Item</th>
                        <th scope="col" style="width:25%">MTD</th>
                        <th scope="col" style="width:25%">YTD</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $totalMTD = 0; $totalYTD = 0;@endphp
                    @foreach($allowances as $allowance)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $allowance->item_code }}</td>
                            <td><a href="#">{{ $allowance->item }}</a></td>
                            <td class="text-right">{{ number_format($allowance->mtd, 2) }}</td>
                            <td class="text-right">{{ number_format($allowance->ytd, 2) }}</td>
                        </tr>
                        @php $totalMTD+=$allowance->mtd; $totalYTD+=$allowance->ytd; @endphp
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="3" class="text-left">Total</th>
                        <th class="text-right">{{ number_format($totalMTD, 2) }}</th>
                        <th class="text-right">{{ number_format($totalYTD, 2) }}</th>
                    </tr>
                    </tfoot>
                </table>

                <h4 class="text-warning">Deductions</h4>
                <table class="table table-bordered w-100">
                    <thead class="">
                    <tr>
                        <th scope="col" style="width:5%">S.NO</th>
                        <th scope="col" style="width:10%">Code</th>
                        <th scope="col" style="width:35%">Item</th>
                        <th scope="col" style="width:25%">MTD</th>
                        <th scope="col" style="width:25%">YTD</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $totalMTDD = 0; $totalYTDD = 0; @endphp
                    @foreach($deductions as $deduction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $deduction->item_code }}</td>
                            <td><a href="#">{{ $deduction->item }}</a></td>
                            <td class="text-right">{{ number_format($deduction->mtd, 2) }}</td>
                            <td class="text-right">{{ number_format($deduction->ytd, 2) }}</td>
                        </tr>
                        @php $totalMTDD+=$deduction->mtd; $totalYTDD+=$deduction->ytd; @endphp
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="3" class="text-left">Total</th>
                        <th class="text-right">{{ number_format($totalMTDD, 2) }}</th>
                        <th class="text-right">{{ number_format($totalYTDD, 2) }}</th>
                    </tr>
                    </tfoot>
                </table>

                <h4 class="text-warning">Company Pension Contribution (10% of regular salary of confirmed staff)</h4>
                <table class="table table-bordered w-100">
                    <thead class="">
                    <tr>
                        <th scope="col" style="width:5%">S.NO</th>
                        <th scope="col" style="width:10%">Code</th>
                        <th scope="col" style="width:35%">Item</th>
                        <th scope="col" style="width:25%">MTD</th>
                        <th scope="col" style="width:25%">YTD</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $totalMTDP = 0; $totalYTDP = 0; @endphp
                    @foreach($pensions as $pension)
                        @php $totalMTDP+= ($pension->mtd / 100) * 10; $totalYTDP+= ($pension->pytd / 100) * 10; @endphp
                    @endforeach
                        <tr>
                            <td>1</td>
                            <td>0000</td>
                            <td><a href="#">Company Pension Contribution</a></td>
                            <td class="text-right">{{ number_format($totalMTDP, 2) }}</td>
                            <td class="text-right">{{ number_format($totalYTDP, 2) }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="3" class="text-left">Total</th>
                        <th class="text-right">{{ number_format($totalMTDP, 2) }}</th>
                        <th class="text-right">{{ number_format($totalYTDP, 2) }}</th>
                    </tr>
                    </tfoot>
                </table>

                <h4 class="text-warning font-weight-bolder">SUMMARY</h4>
                <table class="table table-bordered w-100">
                    <thead class="">
                    <tr>
                        <th scope="col" style="width:5%">S.NO</th>
                        <th scope="col" style="width:45%">Item</th>
                        <th scope="col" style="width:25%">MTD</th>
                        <th scope="col" style="width:25%">YTD</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Gross Pay</td>
                            <td class="text-right">{{ number_format($totalMTD, 2) }}</td>
                            <td class="text-right">{{ number_format($totalYTD, 2) }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Net Pay</td>
                            <td class="text-right">{{ number_format($totalMTD - $totalMTDD, 2) }}</td>
                            <td class="text-right">{{ number_format($totalYTD - $totalYTDD, 2) }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>3</th>
                            <th>Company Cost</th>
                            <th class="text-right">{{ number_format($totalMTD + $totalMTDP, 2) }}</th>
                            <th class="text-right">{{ number_format($totalYTD + $totalYTDP, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>


            </div>
        </div>
    </div>

</div>

