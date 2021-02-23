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
        $('#exam_id').select2({
            placeholder: "Please Select Exam",
        });
        $('#student_id').select2({
            placeholder: "Please Select Student",
        });
    });

    $('#level_id').change(function () {
        var level = $(this).val();
        var students = $('#student_id');
        var exams = $('#student_id');
        $.ajax({
            type: 'POST',
            url: "/admin/getResultData",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'level': level,
            },
            success: function (data) {
                console.log(data);
                if(data.exams.length < 1){
                    alert("No Exams for this level");
                }
                if(data.students.length < 1){
                    alert("No Students found on this level");
                }
                else{
                    students.empty();
                    exams.empty();
                    for (var i = 0; i < data.students.length; i++) {
                        students.append('<option value=' + data.students[i].id + '>' + data.students[i].value + '</option>');
                    }
                    for (var i = 0; i < data.exams.length; i++) {
                        exams.append('<option value=' + data.exams[i].id + '>' + data.exams[i].value + '</option>');
                    }
                    students.change();
                    exams.change();
                }
            }
        });
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
                        <a href="{{ route('result.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($result_info))
                        {{ Form::open(['url' => route('result.update', $result_info->id), 'files' => true, 'class' => 'form', 'name' => 'result_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('result.store'), 'files' => true, 'class' => 'form', 'name' => 'result_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">

                            <div class="form-group row {{ $errors->has('level_id') ? 'has-error' : '' }}">
                                {{ Form::label('level_id', 'Select Level :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('level_id', @$levels , @$result_info->level_id, ['id' => 'level_id', 'required' => true, 'class' => 'form-control select2', 'style' => 'width:80%; border-color:none']) }}
                                    @error('level_id')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('exam_id') ? 'has-error' : '' }}">
                                {{ Form::label('exam_id', 'Select Exam :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('exam_id', [], @$result_info->$exam_id, ['id' => 'exam_id', 'placeholder' => 'Select Students', 'class' => 'form-control select2', 'style' => 'width:80%; border-color:none']) }}
                                    @error('exam_id')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('student_id') ? 'has-error' : '' }}">
                                {{ Form::label('student_id', 'Select Student :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('student_id', [], @$result_info->$student_id, ['id' => 'student_id', 'placeholder' => 'Select Students', 'class' => 'form-control select2', 'style' => 'width:80%; border-color:none']) }}
                                    @error('student_id')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('monthly_result') ? 'has-error' : '' }}">
                                {{ Form::label('monthly_result', 'Monthly result :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('monthly_result', @$result_info->monthly_result, ['class' => 'form-control', 'id' => 'monthly_result', 'placeholder' => 'Monthly result','style' => 'width:80%']) }}
                                    @error('monthly_result')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row {{ $errors->has('tada') ? 'has-error' : '' }}">
                                {{ Form::label('tada', 'Travelling Allowances & Daily Allowances :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('tada', @$result_info->tada, ['class' => 'form-control', 'id' => 'tada', 'placeholder' => 'TADA','style' => 'width:80%']) }}
                                    @error('tada')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div id="forteacher">
                                <div class="form-group row {{ $errors->has('extra_class_result') ? 'has-error' : '' }}">
                                    {{ Form::label('extra_class_result', 'Extra Class Bonus :', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::number('extra_class_result', @$result_info->extra_class_result, ['class' => 'form-control', 'id' => 'extra_class_result', 'placeholder' => 'Extra Class Bonus','style' => 'width:80%']) }}
                                        @error('extra_class_result')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div id="forstaff">
                                <div class="form-group row {{ $errors->has('incentive') ? 'has-error' : '' }}">
                                    {{ Form::label('incentive', 'Incentive :', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::number('incentive', @$result_info->incentive, ['class' => 'form-control', 'id' => 'incentive', 'placeholder' => 'Incentive','style' => 'width:80%']) }}
                                        @error('incentive')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('transport_charges') ? 'has-error' : '' }}">
                                {{ Form::label('transport_charges', 'Transport Charges :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('transport_charges', @$result_info->transport_charges, ['class' => 'form-control', 'id' => 'transport_charges', 'placeholder' => 'Transport Charges','style' => 'width:80%']) }}
                                    @error('transport_charges')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('leave_charges') ? 'has-error' : '' }}">
                                {{ Form::label('leave_charges', 'Leave Charges :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('leave_charges', @$result_info->leave_charges, ['class' => 'form-control', 'id' => 'leave_charges', 'placeholder' => 'Leave Charges','style' => 'width:80%']) }}
                                    @error('leave_charges')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('bonus') ? 'has-error' : '' }}">
                                {{ Form::label('bonus', 'Bonus :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('bonus', @$result_info->bonus, ['class' => 'form-control', 'id' => 'bonus', 'placeholder' => 'Bonus','style' => 'width:80%']) }}
                                    @error('bonus')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('advance_result') ? 'has-error' : '' }}">
                                {{ Form::label('advance_result', 'Advance result :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('advance_result', @$result_info->advance_result, ['class' => 'form-control', 'id' => 'advance_result', 'placeholder' => 'Advance result','style' => 'width:80%']) }}
                                    @error('advance_result')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
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
