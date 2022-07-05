@extends('layouts.form')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{--                    {{ \App\Models\User::find(auth()->id())->referenceCode() }}--}}
                    {{--                    {{ \App\Models\Memo::getLastMemo() }}--}}
                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6 text-right" >
                            <a href="javascript:history.back();" class="btn btn-warning btn-sm">
                                <span class="fa fa-close"></span> Close
                            </a>
                            <a href="#" class="btn btn-dark btn-sm btn-flat" id="btn-create-new">
                              <span class="btn-label">
                                <i class="fa fa-print"></i>
                              </span>
                                Print
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="text-center">
                        <img src="{{ myAsset("logo.jpg") }}" width="150" />
                    </div>
                    <h4 align="center"><strong style="font-weight: bolder">CAPITAL CITY UNIVERSITY, KANO</strong> <br>
                        <small>No. 20 Yusuf Maitama Sule Road, Nassarawa GRA, Kano - Nigeria</small>
                    </h4>
                    <h5 align="center"><span style="background: black; color:white;">&nbsp; MEAL ALLOWANCE FORM &nbsp;</span></h5>
                    <row>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Date</th>
                                    <th>No. Days</th>
                                    <th>Amount</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mealAllowance->details as $detail)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $detail->fullName() }}</td>
                                        <td>{{ optional($detail->department())->name }}</td>
                                        <td>{{ $detail->date }}</td>
                                        <td>{{ $detail->no_of_days }}</td>
                                        <td>{{ $detail->amount }}</td>
                                        <td>{{ $detail->remark }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </row>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="create-new-modal" role="dialog">
        <div class="modal-dialog modal-lg" style="padding-top:0;margin-top:0;">
            <!-- Modal content-->
            <div class="modal-content" style="padding-top: 0; margin-top:0;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-left">Meal Allowance</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('forms.meal_allowances.store') }}">
                        @csrf
                        <div class="form-group">
                            <div id="new-meal-allowance">
                                <div class="row" id="item1">
                                    <div class="col-md-4" style="padding-bottom:2px;">
                                        <label>Name</label>
                                        {{--<input type="text" name="name[]" class="form-control" style="padding: 2px 10px;">--}}
                                        {{--<select class="form-control" id="mySelect3" name="user[]" style="display: grid !important;padding: 2px 10px;"></select>--}}
                                        <select type="text" name="name[]" class="form-control mySelect3" style="padding: 2px 10px;"></select>
                                    </div>
                                    <div class="col-md-3" style="padding-bottom:2px;">
                                        <label>Date</label>
                                        <input type="date" name="date[]" class="form-control" style="padding: 2px 10px;">
                                    </div>
                                    <div class="col-md-2" style="padding-bottom:2px;">
                                        <label>No of Days</label>
                                        <input type="text" name="no_of_days[]" class="form-control" style="padding: 2px 10px;">
                                    </div>
                                    <div class="col-md-3" style="padding-bottom:2px;">
                                        <label>Amount</label>
                                        <input type="text" name="amount[]" class="form-control" style="padding: 2px 10px;">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a href="javascript:;" class="btn btn-success btn-sm btn-add-row">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-info btn-sm">Save</button>
                                    <button type="button" class="btn btn-default btn-sm waves-effect" data-dismiss="modal">Close</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection


@push('js')
    <script>
        $(document).ready(function(){

            $('#btn-create-new').click(function(){
                $('#create-new-modal').modal();
            });

            let num = 1;
            $('body').on('click', '.btn-add-row', function() {
                num += 1;
                let data = `
                    <div class="row" id="item` + num + `">
                        <div class="col-md-4" style="padding-bottom:2px;">
                            <select type="text" name="name[]" class="form-control mySelect3" style="padding: 2px 10px;"></select>
                        </div>
                        <div class="col-md-3" style="padding-bottom:2px;">
                            <input type="date" name="date[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-2" style="padding-bottom:2px;">
                            <input type="text" name="no_of_days[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-2" style="padding-bottom:2px;">
                            <input type="text" name="amount[]" class="form-control" style="padding: 2px 10px;">
                        </div>
                        <div class="col-md-1 text-right" style="padding-bottom:2px;">
                            <a href="javascript:;" class="btn btn-danger btn-sm btn-remove" data-num="`+num+`" style="margin: 0 !important;">
                                <i class="fa fa-minus"></i>
                            </a>
                        </div>
                    </div>
                    `;
                $('#new-meal-allowance').append(data);
                $('.mySelect3').select2({
                    minimumInputLength:2,
                    ajax: {
                        type:'GET',
                        dataType:'json',
                        url: '{{ route('users.search.user','all') }}',
                        data: function (params) {
                            console.log(params);
                            var query = {
                                search: params.term,
                                type: 'public'
                            }
                            console.log(query);

                            // Query parameters will be ?search=[term]&type=public
                            return query;
                        },
                        processResults:function (data) {
                            console.log(data);
                            return {
                                results:data
                            }
                        }
                        ,cache:true
                    }
                });
                $('.btn-remove').click(function(){
                    $('#item'+$(this).data('num')).remove();
                    // alert($(this).data('num'))
                });

            });


            $('.mySelect3').select2({
                minimumInputLength:2,
                ajax: {
                    type:'GET',
                    dataType:'json',
                    url: '{{ route('users.search.user','all') }}',
                    data: function (params) {
                        console.log(params);
                        var query = {
                            search: params.term,
                            type: 'public'
                        }
                        console.log(query);

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults:function (data) {
                        console.log(data);
                        return {
                            results:data
                        }
                    }
                    ,cache:true
                }
            });

            $('#table_id').dataTable()
        });
    </script>
@endpush
