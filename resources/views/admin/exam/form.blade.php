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
            placeholder: "",
        });
        $('#level_id').select2({
            placeholder: "",
        });
    });
    $('#end_date').change(function () {
        if(!$('#start_date').val()){
            alert('Start Date Column is empty');
        }else{
            routinemaker();
        }
    });
    $('#start_date').change(function () {
        if($('#end_date').val()){
            routinemaker();
        }
    });
    $('#shiftbtn').click(function () {
        console.log("Add");

        if(!$('#start_time').val()){
            alert("Please Enter Start Time Properly");
        }
        else if(!$('#end_time').val()){
            alert("Please Enter End Time Properly");
        }
        else {
            $('#table_row').append('<tr><td>'+$('#start_time').val()+' - '+$('#start_time').val()+'</td>');
            var diff = routinemaker();
            console.log(diff);
            for (let index = 0; index < diff; index++) {
                $('#table_row').append('<td>{{ Form::select("publish_status", [1 => 1, 0 => 0], null, ["id" => "publish_status", "required" => true, "class" => "form-control"]) }}</td></tr>');
            }
        }
    });


    function routinemaker() {
        var enddate = new Date($('#end_date').val());
        var startdate = new Date($('#start_date').val());
        var timeDiff = Math.abs(enddate.getTime() - startdate.getTime());
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
        $('#table_head').html("<th>Date</th>");
        for (let index = 1; index < diffDays+2; index++) {
            $('#table_head').append('<th>Day '+ index +'</th>');
        }
        return diffDays+1;
    }
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
                        {{ Form::open(['url' => route('exam.store'), 'files' => true, 'class' => 'form', 'name' => 'exam_form']) }}
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
                                    {{ Form::select('level_id', @$levels, @$level_id, ['id' => 'level_id', 'class' => 'form-control select2', 'style' => 'width:80%; border-color:none']) }}
                                    @error('level_id')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('start_date') ? 'has-error' : '' }}">
                                {{ Form::label('start_date', 'Start Date :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::date('start_date', @$exam_info->start_date, ['class' => 'form-control', 'id' => 'start_date','style' => 'width:80%']) }}
                                    @error('start_date')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('end_date') ? 'has-error' : '' }}">
                                {{ Form::label('end_date', 'End Date :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::date('end_date', @$exam_info->end_date, ['class' => 'form-control', 'id' => 'end_date','style' => 'width:80%']) }}
                                    @error('end_date')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$slider_info->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('publish_status')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div id="tohide">
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
