@extends('layouts.admin')
@section('title', $title)
@push('scripts')
{{-- <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script> --}}
{{-- <script src="{{ asset('/custom/feepayment.js') }}"></script> --}}
<script>
    $(document).ready(function() {
        $('#feedetail').hide();
        $('#feepayment').hide();
        $('#bank_details').hide();
        $('#forupi').hide();
        $('#forcard').hide();
        $('#phone_det').hide();
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
        $('#feedetail').hide();
        $('#feepayment').hide();
        var tablebody = $('#tablebody');
        tablebody.empty();
        var id = $(this).val();
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
                    $('#feepayment').show();
                    tablebody.empty();
                    var tuition = 0;
                    var exam = 0;
                    var transport = 0;
                    var stationery = 0;
                    var sports = 0;
                    var club = 0;
                    var hostel = 0;
                    var laundry = 0;
                    var education = 0;
                    var eca = 0;
                    var extra = 0;
                    var late = 0;
                    var total = 0;
                    for (var i = 0; i < data.length; i++) {
                        total += Number(data[i].fees.total_amount);
                        late += Number(data[i].fees.late_fine);
                        extra += Number(data[i].fees.extra_fee);
                        eca += Number(data[i].fees.eca_fee);
                        education += Number(data[i].fees.education_tax);
                        laundry += Number(data[i].fees.laundry_fee);
                        hostel += Number(data[i].fees.hostel_fee);
                        club += Number(data[i].fees.club_fee);
                        sports += Number(data[i].fees.sports_fee);
                        stationery += Number(data[i].fees.stationery_fee);
                        transport += Number(data[i].fees.transport_fee);
                        exam += Number(data[i].fees.exam_fee);
                        tuition += Number(data[i].fees.tuition_fee);
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
                    
                    tablebody.append('<tr>');
                    tablebody.append('<td>Grand Total</td>');
                    tablebody.append('<td>'+tuition+'</td>');
                    tablebody.append('<td>'+exam+'</td>');
                    tablebody.append('<td>'+transport+'</td>');
                    tablebody.append('<td>'+stationery+'</td>');
                    tablebody.append('<td>'+sports+'</td>');
                    tablebody.append('<td>'+club+'</td>');
                    tablebody.append('<td>'+hostel+'</td>');
                    tablebody.append('<td>'+laundry+'</td>');
                    tablebody.append('<td>'+education+'</td>');
                    tablebody.append('<td>'+eca+'</td>');
                    tablebody.append('<td>'+late+'</td>');
                    tablebody.append('<td>'+extra+'</td>');
                    tablebody.append('<td>'+total+'</td>');
                    tablebody.append('</tr>');
                }
            }
        });
    });
    
    $('#payment_method').change(function () {
        var val = $(this).val();
        if(val == 'Bank Transfer'){
            $('#bank_details').show();
            $('#forupi').hide();
            $('#phone_det').hide();
            $('#forcard').hide();
        }
        else if(val == 'UPI'){
            $('#bank_details').hide();
            $('#forcard').hide();
            $('#forupi').show();
            $('#phone_det').show();
        }
        else if(val == 'Paytm'){
            $('#bank_details').hide();
            $('#forupi').hide();
            $('#forcard').hide();
            $('#phone_det').show();
        }
        else if(val == 'Card'){
            $('#bank_details').hide();
            $('#forupi').hide();
            $('#phone_det').hide();
            $('#forcard').show();
        }
        else{
            $('#bank_details').hide();
            $('#forupi').hide();
            $('#phone_det').hide();
            $('#forcard').hide();
        }
    });
    
    
    $("#calculate").click(function() {
        var total = Number($('#tuition_fee').val()) +
            Number($('#exam_fee').val()) +
            Number($('#transport_fee').val()) +
            Number($('#stationery_fee').val()) +
            Number($('#sports_fee').val()) +
            Number($('#club_fee').val()) +
            Number($('#hostel_fee').val()) +
            Number($('#laundry_fee').val()) +
            Number($('#education_tac').val()) +
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

                            
                            <div id="feepayment">

                                <div class="form-group row mt-4">
                                    {{ Form::label('fee_details[tuition_fee]', 'Tuition Fee :', ['class' => 'col-sm-2']) }}
                                    {{ Form::number('fee_details[tuition_fee]', @$feepayment_info->fee_details['tuition_fee'], ['id' => 'tuition_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                    {{ Form::label('fee_details[exam_fee]', 'Exam Fee :', ['class' => 'ml-4 col-sm-2']) }}
                                    {{ Form::number('fee_details[exam_fee]', @$feepayment_info->fee_details['exam_fee'], ['id' => 'exam_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('fee_details[transport_fee]', 'Transport Fee :', ['class' => 'col-sm-2']) }}
                                    {{ Form::number('fee_details[transport_fee]', @$feepayment_info->fee_details['transport_fee'], ['id' => 'transport_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                    {{ Form::label('fee_details[stationery_fee]', 'Stationery Fee :', ['class' => 'ml-4 col-sm-2']) }}
                                    {{ Form::number('fee_details[stationery_fee]', @$feepayment_info->fee_details['stationery_fee'], ['id' => 'stationery_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('fee_details[sports_fee]', 'Sports Fee :', ['class' => 'col-sm-2']) }}
                                    {{ Form::number('fee_details[sports_fee]', @$feepayment_info->fee_details['sports_fee'], ['id' => 'sports_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                    {{ Form::label('fee_details[club_fee]', 'Club Fee :', ['class' => 'ml-4 col-sm-2']) }}
                                    {{ Form::number('fee_details[club_fee]', @$feepayment_info->fee_details['club_fee'], ['id' => 'club_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('fee_details[hostel_fee]', 'Hostel Fee :', ['class' => 'col-sm-2']) }}
                                    {{ Form::number('fee_details[hostel_fee]', @$feepayment_info->fee_details['hostel_fee'], ['id' => 'hostel_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                    {{ Form::label('fee_details[laundry_fee]', 'Laundry Fee :', ['class' => 'ml-4 col-sm-2']) }}
                                    {{ Form::number('fee_details[laundry_fee]', @$feepayment_info->fee_details['laundry_fee'], ['id' => 'laundry_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('fee_details[education_tac]', 'Education Tax :', ['class' => 'col-sm-2']) }}
                                    {{ Form::number('fee_details[education_tac]', @$feepayment_info->fee_details['education_tac'], ['id' => 'education_tac','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                    {{ Form::label('fee_details[eca_fee]', 'ECA Fee :', ['class' => 'ml-4 col-sm-2']) }}
                                    {{ Form::number('fee_details[eca_fee]', @$feepayment_info->fee_details['eca_fee'], ['id' => 'eca_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('fee_details[late_fine]', 'Late Fine :', ['class' => 'col-sm-2']) }}
                                    {{ Form::number('fee_details[late_fine]', @$feepayment_info->fee_details['late_fine'], ['id' => 'late_fine','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                    {{ Form::label('fee_details[extra_fee]', 'Extra Fee :', ['class' => 'ml-4 col-sm-2']) }}
                                    {{ Form::number('fee_details[extra_fee]', @$feepayment_info->fee_details['extra_fee'], ['id' => 'extra_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
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

                            <div class="mt-4 form-group row {{ $errors->has('payment_method') ? 'has-error' : '' }}">
                                {{ Form::label('payment_method', 'Payment Method :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('payment_method', ['Cash'=> 'Cash', 'Bank Transfer'=> 'Bank Transfer','UPI'=> 'UPI', 'Card'=> 'Card','Paytm'=> 'Paytm'], @$feepayment_info->payment_method, ['class' => 'form-control', 'id' => 'payment_method','style' => 'width:80%']) }}
                                    @error('payment_method')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div id="bank_details">

                                <div class="form-group row {{ $errors->has('bank_ifsc') ? 'has-error' : '' }}">
                                    {{ Form::label('bank_ifsc', 'Bank IFSC :', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::text('bank_ifsc', @$feepayment_info->bank_ifsc, ['class' => 'form-control', 'id' => 'bank_ifsc','style' => 'width:80%']) }}
                                        @error('bank_ifsc')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="form-group row {{ $errors->has('bank_accountno') ? 'has-error' : '' }}">
                                    {{ Form::label('bank_accountno', 'Bank Account Number :', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::text('bank_accountno', @$feepayment_info->bank_accountno, ['class' => 'form-control', 'id' => 'bank_accountno','style' => 'width:80%']) }}
                                        @error('bank_accountno')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div id="forcard">

                                <div class="form-group row {{ $errors->has('card_type') ? 'has-error' : '' }}">
                                    {{ Form::label('card_type', 'Card Type :', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::select('card_type', ['Debit'=> 'Debit','Credit'=> 'Credit'], @$feepayment_info->card_type, ['class' => 'form-control', 'id' => 'card_type','style' => 'width:80%']) }}
                                        @error('card_type')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div id="phone_det">

                                <div class="form-group row {{ $errors->has('transfer_phone') ? 'has-error' : '' }}">
                                    {{ Form::label('transfer_phone', 'Transfered From (Phone No) :', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::number('transfer_phone', @$feepayment_info->transfer_phone, ['class' => 'form-control', 'id' => 'transfer_phone','style' => 'width:80%']) }}
                                        @error('transfer_phone')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div id="forupi">

                                <div class="form-group row {{ $errors->has('upi_type') ? 'has-error' : '' }}">
                                    {{ Form::label('upi_type', 'UPI Type :', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::select('upi_type', ['Google Pay'=> 'Google Pay', 'Phonepe'=> 'Phonepe', 'BHIM UPI'=> 'BHIM UPI','Amazon Pay'=> 'Amazon Pay', 'Paytm Payments Bank'=> 'Paytm Payments Bank', 'Uber'=> 'Uber', 'Chillr'=> 'Chillr', 'MobiKwik'=> 'MobiKwik', 'SBI Pay'=> 'SBI Pay', 'iMobile'=> 'iMobile', 'Axis Pay'=> 'Axis Pay', 'BOB UPI'=> 'BOB UPI'], @$feepayment_info->upi_type, ['class' => 'form-control', 'id' => 'upi_type','style' => 'width:80%']) }}
                                        @error('upi_type')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>


                            <div class="form-group row {{ $errors->has('transfer_date') ? 'has-error' : '' }}">
                                {{ Form::label('transfer_date', 'Date of Transfer :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::date('transfer_date', @$feepayment_info->transfer_date, ['class' => 'form-control', 'id' => 'transfer_date','style' => 'width:80%']) }}
                                    @error('transfer_date')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('remarks') ? 'has-error' : '' }}">
                                {{ Form::label('remarks', 'Remarks :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('remarks', @$feepayment_info->remarks, ['class' => 'form-control', 'id' => 'remarks','style' => 'width:80%']) }}
                                    @error('remarks')
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
