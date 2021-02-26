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
 <script src="{{ asset('/custom/salary.js') }}"></script> 
    <script>
    $(document).ready(function() {
        $('#forteacher').hide();
        $('#forstaff').hide();
        $('#user').select2({
            placeholder: "Select Salary Gainer",
        });
    });

    
    $('#type').change(function () {
        var type = $(this).val();
        if(type == 'Teacher'){
            $('#forteacher').show();
            $('#forstaff').hide();
        }
        if(type == 'Staff'){
            $('#forteacher').hide();
            $('#forstaff').show();
        }
        var users = $('#user');
        $.ajax({
            type: 'POST',
            url: "/admin/getSalary",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'type': type,
            },
            success: function (data) {
                if(data == "Please select a valid employee type"){
                    users.empty();
                    alert(data);
                }
                else{
                    users.empty();
                    for (var i = 0; i < data.length; i++) {
                        users.append('<option value=' + data[i].id + '>' + data[i].value + '</option>');
                    }
                    users.change();
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
                        <a href="{{ route('salary.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($salary_info))
                        {{ Form::open(['url' => route('salary.update', $salary_info->id), 'files' => true, 'class' => 'form', 'name' => 'salary_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('salary.store'), 'files' => true, 'class' => 'form', 'name' => 'salary_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">

                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Title :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$salary_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Title','style' => 'width:80%']) }}
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

                            <div class="form-group row {{ $errors->has('type') ? 'has-error' : '' }}">
                                {{ Form::label('type', 'Select Type :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('type', ['' => 'Select Type','Teacher' => 'Teacher','Staff' => 'Staff'], @$type, ['id' => 'type', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%; border-color:none']) }}
                                    @error('type')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('user') ? 'has-error' : '' }}">
                                {{ Form::label('user', 'Select :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('user', [], @$user, ['id' => 'user', 'class' => 'form-control select2', 'style' => 'width:80%; border-color:none']) }}
                                    @error('user')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('monthly_salary') ? 'has-error' : '' }}">
                                {{ Form::label('monthly_salary', 'Monthly Salary :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('monthly_salary', @$salary_info->monthly_salary, ['class' => 'form-control', 'id' => 'monthly_salary', 'placeholder' => 'Monthly Salary','style' => 'width:80%']) }}
                                    @error('monthly_salary')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row {{ $errors->has('tada') ? 'has-error' : '' }}">
                                {{ Form::label('tada', 'Travelling Allowances & Daily Allowances :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('tada', @$salary_info->tada, ['class' => 'form-control', 'id' => 'tada', 'placeholder' => 'TADA','style' => 'width:80%']) }}
                                    @error('tada')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div id="forteacher">
                                <div class="form-group row {{ $errors->has('extra_class_salary') ? 'has-error' : '' }}">
                                    {{ Form::label('extra_class_salary', 'Extra Class Bonus :', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::number('extra_class_salary', @$salary_info->extra_class_salary, ['class' => 'form-control', 'id' => 'extra_class_salary', 'placeholder' => 'Extra Class Bonus','style' => 'width:80%']) }}
                                        @error('extra_class_salary')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div id="forstaff">
                                <div class="form-group row {{ $errors->has('incentive') ? 'has-error' : '' }}">
                                    {{ Form::label('incentive', 'Incentive :', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::number('incentive', @$salary_info->incentive, ['class' => 'form-control', 'id' => 'incentive', 'placeholder' => 'Incentive','style' => 'width:80%']) }}
                                        @error('incentive')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('transport_charges') ? 'has-error' : '' }}">
                                {{ Form::label('transport_charges', 'Transport Charges :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('transport_charges', @$salary_info->transport_charges, ['class' => 'form-control', 'id' => 'transport_charges', 'placeholder' => 'Transport Charges','style' => 'width:80%']) }}
                                    @error('transport_charges')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('leave_charges') ? 'has-error' : '' }}">
                                {{ Form::label('leave_charges', 'Leave Charges :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('leave_charges', @$salary_info->leave_charges, ['class' => 'form-control', 'id' => 'leave_charges', 'placeholder' => 'Leave Charges','style' => 'width:80%']) }}
                                    @error('leave_charges')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('bonus') ? 'has-error' : '' }}">
                                {{ Form::label('bonus', 'Bonus :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('bonus', @$salary_info->bonus, ['class' => 'form-control', 'id' => 'bonus', 'placeholder' => 'Bonus','style' => 'width:80%']) }}
                                    @error('bonus')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('advance_salary') ? 'has-error' : '' }}">
                                {{ Form::label('advance_salary', 'Advance Salary :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('advance_salary', @$salary_info->advance_salary, ['class' => 'form-control', 'id' => 'advance_salary', 'placeholder' => 'Advance Salary','style' => 'width:80%']) }}
                                    @error('advance_salary')
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
