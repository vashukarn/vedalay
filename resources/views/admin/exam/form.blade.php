@extends('layouts.admin')
@section('title', $title)
@push('styles')
    <style>
        .btn-default.active,
        .btn-default.active:hover {
            background-color: #17a2b8;
            border-color: #138192;
            color: #fff;
        }
    </style>
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
{{-- <script src="{{ asset('/custom/slider.js') }}"></script> --}}
    <script>
    $(document).ready(function() {
        $('#session_id').select2({
            placeholder: "Please Select Session",
        });
        $('#level_id').select2({
            placeholder: "Please Level Session",
        });
    });
    var subjects = null;
    var diff_value = 1;
    var shift_counter = 0;
    var thead_counter = 0;
    $('#level_id').change(function () {
        var level = $(this).val();
        $.ajax({
            type: 'POST',
            url: "/admin/getSubjects",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'level': level,
            },
            success: function (data) {
                if(data.length < 1){
                    alert("No Subjects found on this level");
                }
                else{
                    subjects = data;
                }
            }
        });
    });
    $('#shiftbtn').click(function () {
        if(!$('#start_time').val()){
            alert("Please Enter Start Time Properly");
        }
        else if(!$('#end_time').val()){
            alert("Please Enter End Time Properly");
        }
        else {
            shift_counter++;
            $('#table_row').append('<tr>');
                $('#table_row').append('<td><input id="shift_'+shift_counter+'" type="text" class="form-control" value="'+$('#start_time').val()+' - '+$('#end_time').val()+'" readonly></td>');
                for (let index = 0; index < thead_counter; index++) {
                    $('#table_row').append('<td><select class="form-control" id="subject_'+diff_value+'">');
                        const subjectArray = [];
                        Object.keys(subjects).forEach(key => subjectArray.push({
                            id: key,
                            name: subjects[key]
                        }));
                        $('#subject_'+diff_value).append('<option value="">Select Subject</option>');
                        for (let index = 0; index < subjectArray.length; index++) {
                            $('#subject_'+diff_value).append('<option value='+subjectArray[index]['id']+'>'+subjectArray[index]['name']+'</option>');
                        }
                        diff_value++;
                    $('#table_row').append('</select></td>');

                }
            $('#table_row').append('</tr>');
        }
    });
    $('#datebtn').click(function () {
        if(!$('#exam_date').val()){
            alert("Please Enter Date");
        }
        else {
            document.getElementById("table_head").innerHTML += '<th><input id="'+thead_counter+'" type="text" class="form-control" value="'+ $('#exam_date').val() +'" readonly></th>';
            thead_counter++;
        }
    });
    var request_count = 0;
    $('#exam_form').on('submit', function(e) {
        e.preventDefault();
        var temp = 1;
        var senddata = $('#exam_form').serializeArray();
        for (let index = 0; index < thead_counter; index++) {
            for (let inde = 1; inde <= shift_counter; inde++) {
                var shiftsubject = {
                    date : $('#'+index).val(),
                    shift : $('#shift_'+inde).val(),
                    subject : $('#subject_'+temp).val() ? $('#subject_'+temp).val() : null,
                };
                temp++;
                request_count++;
                senddata.push({name: 'routine_'+request_count, value: shiftsubject});
            }
        }
        $.ajax({
            type: 'POST',
            url: "/admin/addExam",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'data': senddata,
                'request_count': request_count,
            },
            success: function (data) {
                if(data.length < 1){
                    alert("No Data Found");
                }
                else{
                    if(!data.title){
                        alert("Error has been occurred");
                    }
                    else{
                        alert("Exam Added Successfully");
                        window.location = "{{ route('exam.index') }}";
                    }
                }
            }
        });
        request_count = 0;
    });
    </script>

@endpush
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ @$title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('exam.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($exam_info))
                        {{ Form::open(['url' => route('exam.update', $exam_info->id), 'files' => true, 'class' => 'form', 'name' => 'exam_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('exam.store'), 'files' => true, 'class' => 'form', 'id' => 'exam_form', 'name' => 'exam_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">

                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Title :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$exam_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Title','style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('month') ? 'has-error' : '' }}">
                                {{ Form::label('month', 'Month :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::selectMonth('month', @$month, ['id' => 'month', 'required' => true, 'class' => 'form-control select2', 'style' => 'width:80%; border-color:none']) }}
                                    @error('month')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('session_id') ? 'has-error' : '' }}">
                                {{ Form::label('session_id', 'Session :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('session_id', @$sessions, @$session_id, ['id' => 'session_id', 'class' => 'form-control select2', 'style' => 'width:80%; border-color:none']) }}
                                    @error('session_id')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('level_id') ? 'has-error' : '' }}">
                                {{ Form::label('level_id', 'Level :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('level_id', @$levels, null, ['id' => 'level_id', 'class' => 'form-control select2', 'placeholder' => 'Select Level', 'style' => 'width:80%; border-color:none']) }}
                                    @error('level_id')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('exam_date') ? 'has-error' : '' }}">
                                {{ Form::label('exam_date', 'Date of Exam :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-4">
                                    {{ Form::date('exam_date', @$exam_info->exam_date, ['class' => 'form-control', 'id' => 'exam_date','style' => 'width:80%']) }}
                                    @error('exam_date')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::button("<i class='fa fa-plus'></i> &nbsp; Add Date", ['id' => 'datebtn','class' => 'btn btn-primary btn-flat']) }}
                            </div>

                            <div class="form-group row {{ $errors->has('start_time') ? 'has-error' : '' }}">
                                {{ Form::label('start_time', 'Start Time :*', ['class' => 'col-sm-2']) }}
                                <div class="col-sm-2">
                                    {{ Form::time('start_time', null, ['id' => 'start_time', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('start_time')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('end_time', 'End Time :*', ['class' => 'col-sm-2']) }}
                                <div class="col-sm-2">
                                    {{ Form::time('end_time', null, ['id' => 'end_time', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('end_time')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::button("<i class='fa fa-plus'></i> &nbsp; Add Shift", ['id' => 'shiftbtn','class' => 'btn btn-primary btn-flat']) }}
                            </div>                            
                            <div style="overflow-x: scroll" class="card-body card-format">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr id="table_head">
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_row">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('', '', ['class' => 'col-sm-3']) }}
                        <div class="col-sm-9">
                            {{ Form::button("<i class='fa fa-paper-plane'></i> Submit", ['class' => 'btn btn-success btn-flat', 'type' => 'submit']) }}
                            {{ Form::button("<i class='fas fa-sync-alt'></i> Reset", ['class' => 'btn btn-danger btn-flat', 'type' => 'reset']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
