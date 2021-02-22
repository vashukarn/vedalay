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
{{-- <script src="{{ asset('/custom/attendance.js') }}"></script> --}}
<script>
    $("#submit").click(function() {
        submitAttendance();
    });
    function submitAttendance() {
        var attendance = [];
        @foreach ($employee_info as $item)
        if ($("#{{ $item->id }}_attendance").is(":checked")){
            var temp = 1;
        }else{
            var temp = 0;
        }
        attendance['{{ $item->id }}'] = temp;
        @endforeach
        $.ajax({
            type: 'PUT',
            url: {{ route("staffattendance.store") }},
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'attendance' : attendance,
            },
            success: function (data) {
                if(data == "Attendance Already Marked"){
                    alert(data);
                }
                else if(data.id){
                    alert("Attendance Marked");
                }
                else{
                    alert("Error Occurred");
                }
                console.log(data);
            }
        });
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
                        <a href="{{ route('attendance.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($attendance_info))
                    {{ Form::open(['url' => route('attendance.update', $attendance_info->id), 'files' => true, 'class' => 'form', 'name' => 'attendance_form']) }}
                    @method('put')
                    @else
                    {{ Form::open(['url' => route('attendance.store'), 'files' => true, 'class' => 'form', 'name' => 'attendance_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">
                            
                            <div class="form-group row">
                                {{ Form::label('date', 'Date', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                {{ Form::text('date', ReadableDate(date('Y-m-d'), 'ymd'), ['class' => 'form-control', 'id' => 'date','style' => 'width:80%', 'readonly'=>true]) }}
                                    @error('date')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <h3 class="m-4 card-title">Employees : </h3> <br>
                            <div class="mt-4" id="attendance">
                                <div class="form-group row">
                                    @foreach ($employee_info as $item)
                                    <label class="mt-2 col-sm-2">{{ $item->name }}</label>
                                    <div class="mt-2 btn-group btn-group-toggle col-sm-4" data-toggle="buttons">
                                        <label class="btn btn-default">
                                            <input type="radio" id="{{ $item->id }}_attendance" autocomplete="off" value="1"
                                                {{ @$attendance_info->attendance == 1 ? 'checked' : '' }}> Present
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" id="{{ $item->id }}_attendance" autocomplete="off" value="2"
                                                {{ @$attendance_info->attendance == 2 ? 'checked' : '' }}> Half Day
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" id="{{ $item->id }}_attendance" autocomplete="off" value="0"
                                                {{ @$attendance_info->attendance == 0 ? 'checked' : '' }}> Absent
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('', '', ['class' => 'col-sm-3']) }}
                        <div class="col-sm-9">
                            {{ Form::button("<i class='fa fa-plus'></i> Submit", ['class' => 'btn btn-success btn-flat', 'id'=>'submit']) }}
                            {{ Form::button("<i class='fas fa-ban'></i> Holiday", ['class' => 'btn btn-danger btn-flat', 'type' => 'reset']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
