<div class="card">
    @if($memo->paymentProcess()->count() > 0)
    <div class="card-body">
        <h4 align="center"><span style="background: black; color:white;font-size: 18px">&nbsp; Payment Process (Memo ID: {{ $memo->reference }}) &nbsp;</span>
        </h4>
        @foreach($memo->paymentProcess()->get() as $payment)
    <table class="" width="100%">
        <tr>
            <td class="text-right" style="text-align: right;width: 200px;"><strong>Memo
                    ID:</strong></td>
            <td class="text-left">{{ $memo->reference }}</td>
        </tr>
        <tr>
            <td class="text-right" style="text-align: right;"><strong>Account
                    Debited:</strong></td>
            <td class="text-left">{{ optional($payment)->account_debited }}</td>
        </tr>
        <tr>
            <td class="text-right" style="text-align: right;"><strong>Account
                    Credited:</strong></td>
            <td class="text-left">{{ optional($payment)->account_credited }}</td>
        </tr>
        <tr>
            <td class="text-right" style="text-align: right;"><strong>Amount:</strong>
            </td>
            <td class="text-left">&#8358; {{ number_format(optional($payment)->amount) }}</td>
        </tr>
        {!! optional($payment)->beneficiary !!}
        <tr>
            <td class="text-right" style="text-align: right;">
                <strong>Narration:</strong></td>
            <td class="text-left">{{ optional($payment)->narration }}</td>
        </tr>
        <tr>
            <td class="text-right" style="text-align: right;"><strong>Date:</strong>
            </td>
            <td class="text-left">{{ optional($payment)->created_at }}</td>
        </tr>
        <tr>
            <td class="text-right" style="text-align: right;height:60px">
                <strong>Signature:</strong>
            </td>
            <td></td>
        </tr>
    </table>

@endforeach
    </div>
    @endif
</div>
