
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
                    Staff Salary for the Month of @if(isset($month)) {{ date("F, Y", strtotime($month)) }} @else {{ date('F, Y') }}  @endif
                </h5>
                @if(isset($bank)) <h6 class="m-0 text-danger">Bank Name: {{ $bank->name }}</h6> @endif
            </div>
        </div>

        <div class="row inv--product-table-section">
            <div class="col-12">
                <div class="w-100">
                    <h4 class="text-warning">{{ $user->completeName() }}</h4>
                    <table class="table table-bordered w-100">
                        <thead class="">
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Item</th>
                            <th scope="col">Type</th>
                            <th scope="col">Category</th>
                            <th scope="col">Grade</th>
                            <th class="text-right" scope="col">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $total = 0; @endphp
                            @foreach($reports as $report)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $report->item }}</td>
                                    <td>{{ $report->type }}</td>
                                    <td>{{ $report->category }}</td>
                                    <td>{{ $report->level }}/{{ $report->step }}</td>
                                    <td class="text-right">{{ number_format($report->amount, 2) }}</td>
                                </tr>
                                @php $total+=$report->amount @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="5" class="text-left">Total</th>
                            <th class="text-right">{{ number_format($total, 2) }}</th>
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>

