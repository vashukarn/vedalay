@extends('layouts.admin')
@section('title', $title)


@push('scripts')
{{-- <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script> --}}
{{-- <script src="{{ asset('/custom/feepayment.js') }}"></script> --}}
<script>
    $(document).ready(function() {
        $('#feedetail').hide();
        $('#forbanktransfer').hide();
        $('#forupi').hide();
        $('#forcard').hide();
        $('#forpaytm').hide();
        $('#student_id').select2({
            placeholder: "Please Select Student",
        });
    });
    $('#level_id').change(function () {
        var id = $(this).val();
        var students = $('#student_id');
        students.empty();
        $.ajax({
            type: 'POST',
            url: "/admin/getStudents",
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

    $('#student_id').change(function () {
        var id = $(this).val();
        var tablebody = $('#tablebody');
        $.ajax({
            type: 'POST',
            url: "/admin/getFeeDetails",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': id,
            },
            success: function (data) {
                if(data.length < 1){
                    alert("No Fee Data Found");
                }
                else{
                    $('#feedetail').show();
                    tablebody.empty();
                    for (var i = 0; i < data.length; i++) {
                            tablebody.append('<tr>');
                            tablebody.append('<td>'+data[i].created_at.split("T")[0]+'</td>');
                            tablebody.append('<td>'+data[i].fees.tuition_fee+'</td>');
                            tablebody.append('<td>'+data[i].fees.exam_fee+'</td>');
                            tablebody.append('<td>'+data[i].fees.transport_fee+'</td>');
                            tablebody.append('<td>'+data[i].fees.stationery_fee+'</td>');
                            tablebody.append('<td>'+data[i].fees.sports_fee+'</td>');
                            tablebody.append('<td>'+data[i].fees.club_fee+'</td>');
                            tablebody.append('<td>'+data[i].fees.hostel_fee+'</td>');
                            tablebody.append('<td>'+data[i].fees.laundry_fee+'</td>');
                            tablebody.append('<td>'+data[i].fees.education_tax+'</td>');
                            tablebody.append('<td>'+data[i].fees.eca_fee+'</td>');
                            tablebody.append('<td>'+data[i].fees.late_fine+'</td>');
                            tablebody.append('<td>'+data[i].fees.extra_fee+'</td>');
                            tablebody.append('<td>'+data[i].fees.total_amount+'</td>');
                            tablebody.append('</tr>');
                    }
                }
            }
        });
    });
    
    $('#payment_method').change(function () {
        var val = $(this).val();
        if(val == 'Bank Transfer'){
            $('#forbanktransfer').show();
        }
        else if(val == 'UPI'){
            $('#forupi').show();
        }
        else if(val == 'Paytm'){
            $('#forpaytm').show();
        }
        else if(val == 'Card'){
            $('#forcard').show();
        }
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
                        <a href="{{ route('feepayment.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($feepayment_info))
                        {{ Form::open(['url' => route('feepayment.update', $feepayment_info->id), 'files' => true, 'class' => 'form', 'name' => 'feepayment_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('feepayment.store'), 'files' => true, 'class' => 'form', 'name' => 'feepayment_form']) }}
                    @endif
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">

                            <div class="form-group row {{ $errors->has('session') ? 'has-error' : '' }}">
                                {{ Form::label('session', 'Session :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('session', $session, @$feepayment_info->session, ['class' => 'form-control', 'id' => 'session','style' => 'width:80%']) }}
                                    @error('session')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('level_id') ? 'has-error' : '' }}">
                                {{ Form::label('level_id', 'Level :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('level_id', $levels, @$feepayment_info->level_id, ['placeholder' => 'Select Level', 'class' => 'form-control', 'id' => 'level_id','style' => 'width:80%']) }}
                                    @error('level_id')
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

                            <div id="feedetail" style="overflow-x: scroll" class="card-body card-format">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr id="tablehead">
                                            <th>Fee Details</th>
                                            <th>Tuition Fee</th>
                                            <th>Exam Fee</th>
                                            <th>Transport Fee</th>
                                            <th>Stationery Fee</th>
                                            <th>Sports Fee</th>
                                            <th>Club Fee</th>
                                            <th>Hostel Fee</th>
                                            <th>Laundry Fee</th>
                                            <th>Education Tax</th>
                                            <th>ECA Fee</th>
                                            <th>Late Fee</th>
                                            <th>Extra Fee</th>
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablebody">
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 form-group row {{ $errors->has('payment_method') ? 'has-error' : '' }}">
                                {{ Form::label('payment_method', 'Payment Method :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('payment_method', ['Cash'=> 'Cash', 'Bank Transfer'=> 'Bank Transfer','UPI'=> 'UPI', 'Card'=> 'Card','Paytm'=> 'Paytm'], @$feepayment_info->payment_method, ['class' => 'form-control', 'id' => 'payment_method','style' => 'width:80%']) }}
                                    @error('payment_method')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div id="forbanktransfer">

                            </div>
                            <div id="forupi">

                            </div>
                            <div id="forcard">

                            </div>
                            <div id="forpaytm">

                            </div>

                            <div class="form-group row {{ $errors->has('payment_method') ? 'has-error' : '' }}">
                                {{ Form::label('payment_method', 'Payment Method :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('payment_method', ['Cash'=> 'Cash', 'Bank Transfer'=> 'Bank Transfer','UPI'=> 'UPI', 'Card'=> 'Card','Paytm'=> 'Paytm'], @$feepayment_info->payment_method, ['class' => 'form-control', 'id' => 'payment_method','style' => 'width:80%']) }}
                                    @error('payment_method')
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
