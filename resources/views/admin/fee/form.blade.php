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
<script src="{{ asset('/custom/fee.js') }}"></script>
    <script>
    $(document).ready(function() {
        $('#level').select2({
            placeholder: "Choose Level",
        });
        $('#student').select2({
            placeholder: "Choose Students",
        });
    });

    
    $('#level').change(function () {
        var id = $(this).val();
        var students = $('#student');
        $.ajax({
            type: 'POST',
            url: "/user/getStudents",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': id,
            },
            success: function (data) {
                if(data == "No Data Found"){
                    students.empty();
                    alert(data);
                }
                else{
                    students.empty();
                    for (var i = 0; i < data.length; i++) {
                        students.append('<option value=' + data[i].id + '>' + data[i].value + '</option>');
                    }
                    students.change();
                }
            }
        });

    });

    $("#calculate").click(function() {
        var total = 
            Number($('#tuition_fee').val()) +
            Number($('#exam_fee').val()) +
            Number($('#transport_fee').val()) +
            Number($('#stationery_fee').val()) +
            Number($('#sports_fee').val()) +
            Number($('#club_fee').val()) +
            Number($('#hostel_fee').val()) +
            Number($('#laundry_fee').val()) +
            Number($('#education_tax').val()) +
            Number($('#eca_fee').val()) +
            Number($('#late_fine').val()) +
            Number($('#extra_fee').val());
        $("#total_amount").val(total);
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
                        <a href="{{ route('fee.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($fee_info))
                        {{ Form::open(['url' => route('fee.update', $fee_info->id), 'files' => true, 'class' => 'form', 'name' => 'fee_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('fee.store'), 'files' => true, 'class' => 'form', 'name' => 'fee_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">

                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Title :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$fee_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Title','style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('level') ? 'has-error' : '' }}">
                                {{ Form::label('level', 'Level :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('level', $levels, @$fee_info->level, ['class' => 'level form-control select2', 'placeholder' => 'Select Level', 'id' => 'level','style' => 'width:80%']) }}
                                    @error('level')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has(' ') ? 'has-error' : '' }}">
                                {{ Form::label('student', 'Students:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('student[]', [], @$student, ['id' => 'student', 'class' => 'form-control select2', 'placeholder' => 'Select Student(s)', 'multiple', 'style' => 'width:80%; border-color:none']) }}
                                    @error('student')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('tuition_fee') ? 'has-error' : '' }}">
                                {{ Form::label('tuition_fee', 'Tuition Fee :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('tuition_fee', @$fee_info->tuition_fee, ['class' => 'form-control', 'id' => 'tuition_fee', 'placeholder' => 'Tuition Fee','style' => 'width:80%']) }}
                                    @error('tuition_fee')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('exam_fee') ? 'has-error' : '' }}">
                                {{ Form::label('exam_fee', 'Exam Fee :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('exam_fee', @$fee_info->exam_fee, ['class' => 'form-control', 'id' => 'exam_fee', 'placeholder' => 'Exam Fee','style' => 'width:80%']) }}
                                    @error('exam_fee')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('transport_fee') ? 'has-error' : '' }}">
                                {{ Form::label('transport_fee', 'Transport Fee :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('transport_fee', @$fee_info->transport_fee, ['class' => 'form-control', 'id' => 'transport_fee', 'placeholder' => 'Transport Fee','style' => 'width:80%']) }}
                                    @error('transport_fee')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('sports_fee') ? 'has-error' : '' }}">
                                {{ Form::label('sports_fee', 'Sports Fee :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('sports_fee', @$fee_info->sports_fee, ['class' => 'form-control', 'id' => 'sports_fee', 'placeholder' => 'Sports Fee','style' => 'width:80%']) }}
                                    @error('sports_fee')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('stationery_fee') ? 'has-error' : '' }}">
                                {{ Form::label('stationery_fee', 'Stationery Fee :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('stationery_fee', @$fee_info->stationery_fee, ['class' => 'form-control', 'id' => 'stationery_fee', 'placeholder' => 'Stationery Fee','style' => 'width:80%']) }}
                                    @error('stationery_fee')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('club_fee') ? 'has-error' : '' }}">
                                {{ Form::label('club_fee', 'Club Fee :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('club_fee', @$fee_info->club_fee, ['class' => 'form-control', 'id' => 'club_fee', 'placeholder' => 'Club Fee','style' => 'width:80%']) }}
                                    @error('club_fee')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('hostel_fee') ? 'has-error' : '' }}">
                                {{ Form::label('hostel_fee', 'Hostel Fee :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('hostel_fee', @$fee_info->hostel_fee, ['class' => 'form-control', 'id' => 'hostel_fee', 'placeholder' => 'Hostel Fee','style' => 'width:80%']) }}
                                    @error('hostel_fee')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('laundry_fee') ? 'has-error' : '' }}">
                                {{ Form::label('laundry_fee', 'Laundry Fee :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('laundry_fee', @$fee_info->laundry_fee, ['class' => 'form-control', 'id' => 'laundry_fee', 'placeholder' => 'Laundry Fee','style' => 'width:80%']) }}
                                    @error('laundry_fee')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('education_tax') ? 'has-error' : '' }}">
                                {{ Form::label('education_tax', 'Eduaction Tax:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('education_tax', @$fee_info->education_tax, ['class' => 'form-control', 'id' => 'education_tax', 'placeholder' => 'Eduaction Tax','style' => 'width:80%']) }}
                                    @error('education_tax')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('eca_fee') ? 'has-error' : '' }}">
                                {{ Form::label('eca_fee', 'Extra Curricular Activities Fee :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('eca_fee', @$fee_info->eca_fee, ['class' => 'form-control', 'id' => 'eca_fee', 'placeholder' => 'ECA Fee','style' => 'width:80%']) }}
                                    @error('eca_fee')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('late_fine') ? 'has-error' : '' }}">
                                {{ Form::label('late_fine', 'Late Fine :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('late_fine', @$fee_info->late_fine, ['class' => 'form-control', 'id' => 'late_fine', 'placeholder' => 'Late Fine','style' => 'width:80%']) }}
                                    @error('late_fine')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('extra_fee') ? 'has-error' : '' }}">
                                {{ Form::label('extra_fee', 'Extra Fee :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('extra_fee', @$fee_info->extra_fee, ['class' => 'form-control', 'id' => 'extra_fee', 'placeholder' => 'Extra Fee','style' => 'width:80%']) }}
                                    @error('extra_fee')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row {{ $errors->has('total_amount') ? 'has-error' : '' }}">
                                {{ Form::label('total_amount', 'Total Amount :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="total_amount" name="total_amount" placeholder="Total Amount">
                                        <div class="input-group-append">
                                          <button class="btn btn-outline-secondary" id="calculate" type="button">Calculate</button>
                                        </div>
                                      </div>
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
