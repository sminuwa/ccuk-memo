@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="card ">
                <div class="card-header">
                    <div style="float: right">
                        <a href="javascript:history.back()" class="btn btn-warning btn-sm">
                            <span class="fa fa-close"></span> Close
                        </a>
                    </div>
                    <h5 class="card-title">Raise a Memo</h5>
                </div>
                <div class="card-body ">
                    @if(session()->has('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form class="memo-form" action="{{ route('memos.store') }}"
                          onsubmit="return confirm('Are you sure you want to send this memo?')" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="Memo">
                        <input type="hidden" name="draft" class="draft-box">
                        <input type="hidden" name="draft_id" class="draft-id">
                        <div class="form-group">
                            <label>Send To:</label>
                            <select class="form-control mySelect3" name="sendto">
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Subject:</label>
                            <input type="text" class="form-control subject" placeholder="Subject" name="title"
                                   value="@if(session()->has('draft-title')) {!! session('draft-title') !!} @endif">
                        </div>

                        <div>
                            <label>Content:
                                <a href="javascript:;" id="draft-memos" class="btn btn-outline-info btn-sm"
                                   style="padding:0 .5rem; font-size:10px">Draft Memos</a>
                            </label>
                            <textarea name='body' class="memo-body" id='ckeditor1'
                                      placeholder="Please enter Mail Body Contents." cols="4" rows="4"
                                      aria-invalid="false">@if(session()->has('draft-body')) {!! session('draft-body') !!} @endif</textarea>
                        </div>
                        <div>
                            <hr>
                        </div>
                        <div class="form-group">
                            <label>Attachment Name</label>
                            <div id="attachment">
                                <div class="row" id="item1">
                                    <div class="col-md-6" style="padding-bottom:2px;">
                                        <input type="text" name="attachment_name[]" class="form-control"
                                               placeholder="Attachment Name (if any)"
                                               style="padding: 2px 10px;">
                                    </div>
                                    <div class="col-md-6" style="padding-bottom:2px;">
                                        <input type="file" name="attachment[]" style="opacity: 100%;">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="javascript:;" class="btn btn-success btn-sm add-attachment">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Copy To:</label>
                            <select class="form-control mySelect2" multiple="multiple" name="copy[]"></select>
                            <span class="autocomplete-select"></span>
                        </div>

                    </form>
                </div>
                <div class="card-footer ">
                    <a class="btn btn-default btn-send" type="submit"><i class="fa fa-save"></i> Send </a>
                    <a name="draft" class="btn btn-info btn-draft"><i class="fa fa-clipboard"></i> Save as Draft </a>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="draft-memos-modal" role="dialog">
        <div class="modal-dialog modal-lg" style="padding-top:0;margin-top:0;">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Draft Memos</h4>
                </div>
                <div class="modal-body">
                    <table class="table" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Date</th>
                            {{--<th>Body</th>--}}
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $memoDraft = \App\Models\MemoDraft::where('user_id', auth()->id())->get();
                        @endphp
                        @foreach($memoDraft as $draft)
                            <tr data-id="{{ $draft->id }}">
                                <td>{{ $loop->index+1 }}</td>
                                <td><a href="javascript:;" class="draft" draft-id="{{ $draft->id }}"
                                       title="{{ $draft->title }}" body="{{ $draft->body }}">{{ $draft->title }}</a>
                                </td>
                                <td>{{ $draft->created_at }}</td>
                                {{--<td>
                                    <a href="javascript:;"
                                       class="draft"
                                       draft-id="{{ $draft->id }}"
                                       title="{{ $draft->title }}"
                                       body="{{ $draft->body }}"
                                       style="width:200px !important;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">{!! $draft->body !!}</a>
                                </td>--}}
                                <td class="text-right">
                                    <a href="javascript:;" class="btn btn-danger btn-sm btn-delete"
                                       draft-id="{{ $draft->id }}">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm waves-effect" data-dismiss="modal">Close
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection


@push('js')
    <script>
        // initSample();
    </script>

    <script type="text/javascript">
        CKEDITOR.replace('ckeditor1', function (config) {
            config.toolbarGroups = [
                {name: 'document', groups: ['mode', 'document', 'doctools']},
                {name: 'clipboard', groups: ['clipboard', 'undo']},
                {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
                {name: 'forms', groups: ['forms']},
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
                {name: 'links', groups: ['links']},
                {name: 'insert', groups: ['insert']},
                '/',
                {name: 'styles', groups: ['styles']},
                {name: 'colors', groups: ['colors']},
                {name: 'tools', groups: ['tools']},
                {name: 'others', groups: ['others']},
                {name: 'about', groups: ['about']}
            ];
            config.height = 1000;
            config.removeButtons = 'Save,NewPage,ExportPdf,Preview,Print,Source,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Replace,Find,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CopyFormatting,RemoveFormat,CreateDiv,Link,Unlink,Anchor,Image,Flash,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,ShowBlocks,About';
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.btn-send').click(function () {
                window.onbeforeunload = null;
                $('.draft-box').val('');
                $('.memo-form').submit();
            });

            $('.btn-draft').click(function () {
                window.onbeforeunload = null;
                $('.draft-box').val('draft');
                $('.memo-form').submit();
            });

            $('.draft').on('click', function () {
                window.onbeforeunload = function () {
                    return true;
                };
                $('.subject').val($(this).attr('title'));
                $('.draft-id').val($(this).attr('draft-id'));
                let oEditor = CKEDITOR.instances.ckeditor1;
                oEditor.insertHtml($(this).attr('body'));
                $("#draft-memos-modal").modal("toggle");
            });

            $('.btn-delete').click(function () {
                let draft = $(this).attr('draft-id');
                let url = "{{ route('memos.draft.destroy') }}";
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {draft_id: draft, _token: "{{ @csrf_token() }}"},
                    success: function (data) {
                        $('tr[data-id="' + draft + '"]').remove();
                    }
                });
            });

            $("#draft-memos").on("click", function () {
                $("#draft-memos-modal").modal("toggle");
            });


            let num = 1;
            $('body').on('click', '.add-attachment', function () {
                num += 1;
                let data = `
                <div class="row" id="item` + num + `">
                    <div class="col-md-6" style="padding-bottom:2px;">
                        <input type="text" name="attachment_name[]" class="form-control" placeholder="Attachment Name (if any)"
                        style="padding: 2px 10px;">
                    </div>
                    <div class="col-md-4" style="padding-bottom:2px;">
                        <input type="file" name="attachment[]" style="opacity: 100%;">
                    </div>
                    <div class="col-md-2 text-right" style="padding-bottom:2px;">
                        <a href="javascript:;" class="btn btn-danger btn-sm btn-remove" data-num="` + num + `" style="margin: 0 !important;">
                            <i class="fa fa-minus"></i>
                        </a>
                    </div>
                </div>
                `;
                $('#attachment').append(data);

                $('.btn-remove').click(function () {
                    $('#item' + $(this).data('num')).remove();
                    // alert($(this).data('num'))
                })
            });

            $('.mySelect2').select2({
                minimumInputLength: 2,
                ajax: {
                    type: 'GET',
                    dataType: 'json',
                    url: '{{ route('users.search','all') }}',
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
                    processResults: function (data) {
                        console.log(data);
                        return {
                            results: data
                        }
                    }
                    , cache: true
                }
            });

            $('.mySelect3').select2({
                minimumInputLength: 2,
                ajax: {
                    type: 'GET',
                    dataType: 'json',
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
                    processResults: function (data) {
                        console.log(data);
                        return {
                            results: data
                        }
                    }
                    , cache: true
                }
            });
        });
    </script>
@endpush
