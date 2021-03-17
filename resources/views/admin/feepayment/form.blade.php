@extends('layouts.admin')
@section('title', $title)
@push('scripts')
{{-- <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script> --}}
{{-- <script src="{{ asset('/custom/feepayment.js') }}"></script> --}}
<script>
    $(document).ready(function() {
        $('#level_id').val('');
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
        $('#feedetail').hide();
        $('#feepayment').hide();
        $('#tablebody').empty();
        var id = $(this).val();
        var students = $('#student_id');
        students.empty();
        $.ajax({
            type: 'POST',
            url: "{{ route('getStudents') }}",
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
    $('#student_id').change(function () {
        $('#feedetail').hide();
        $('#feepayment').hide();
        var tablebody = $('#tablebody');
        tablebody.empty();
        var id = $(this).val();
        $.ajax({
            type: 'POST',
            url: "{{ route('getFeeDetails') }}",
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
                    for (var i = 0; i < data.length; i++) {
                        total += Number(data[i].total_amount);
                        late += Number(data[i].late_fine);
                        extra += Number(data[i].extra_fee);
                        eca += Number(data[i].eca_fee);
                        education += Number(data[i].education_tax);
                        laundry += Number(data[i].laundry_fee);
                        hostel += Number(data[i].hostel_fee);
                        club += Number(data[i].club_fee);
                        sports += Number(data[i].sports_fee);
                        stationery += Number(data[i].stationery_fee);
                        transport += Number(data[i].transport_fee);
                        exam += Number(data[i].exam_fee);
                        tuition += Number(data[i].tuition_fee);
                            tablebody.append('<tr>');
                            tablebody.append('<td>'+data[i].created_at.split("T")[0]+'</td>');
                            tablebody.append('<td>'+data[i].tuition_fee+'</td>');
                            tablebody.append('<td>'+data[i].exam_fee+'</td>');
                            tablebody.append('<td>'+data[i].transport_fee+'</td>');
                            tablebody.append('<td>'+data[i].stationery_fee+'</td>');
                            tablebody.append('<td>'+data[i].sports_fee+'</td>');
                            tablebody.append('<td>'+data[i].club_fee+'</td>');
                            tablebody.append('<td>'+data[i].hostel_fee+'</td>');
                            tablebody.append('<td>'+data[i].laundry_fee+'</td>');
                            tablebody.append('<td>'+data[i].education_tax+'</td>');
                            tablebody.append('<td>'+data[i].eca_fee+'</td>');
                            tablebody.append('<td>'+data[i].late_fine+'</td>');
                            tablebody.append('<td>'+data[i].extra_fee+'</td>');
                            tablebody.append('<td>'+data[i].total_amount+'</td>');
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
        var calculatetotal = Number($('#tuition_fee').val()) +
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
        $("#total_amount").val(calculatetotal);
        $("#advancewarn").empty();
        var advancefee = Number(calculatetotal)-Number(total);
        console.log(calculatetotal);
        console.log(total);
        if(calculatetotal > total){
            $("#advancewarn").append('You will be paying advance fee amount : '+ advancefee +'. It can be deducted on next fee payment.');
        }
    });
    
    $("#autofill").click(function() {
        $('#tuition_fee').val(Number(tuition));
        $('#exam_fee').val(Number(exam));
        $('#transport_fee').val(Number(transport));
        $('#stationery_fee').val(Number(stationery));
        $('#sports_fee').val(Number(sports));
        $('#club_fee').val(Number(club));
        $('#hostel_fee').val(Number(hostel));
        $('#laundry_fee').val(Number(laundry));
        $('#education_tax').val(Number(education));
        $('#eca_fee').val(Number(eca));
        $('#late_fine').val(Number(late));
        $('#extra_fee').val(Number(extra));
        $("#total_amount").val(Number(total));
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
                                
                            {{ Form::button("<i class='fa fa-fill-drip'></i> Auto Fill", ['id' => 'autofill','class' => 'mt-4 btn btn-primary btn-flat']) }}

                                <div class="form-group row mt-4">
                                    {{ Form::label('tuition_fee', 'Tuition Fee :', ['class' => 'col-sm-2']) }}
                                    {{ Form::number('tuition_fee', null , ['id' => 'tuition_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                    {{ Form::label('exam_fee', 'Exam Fee :', ['class' => 'ml-4 col-sm-2']) }}
                                    {{ Form::number('exam_fee', null , ['id' => 'exam_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('transport_fee', 'Transport Fee :', ['class' => 'col-sm-2']) }}
                                    {{ Form::number('transport_fee', null , ['id' => 'transport_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                    {{ Form::label('stationery_fee', 'Stationery Fee :', ['class' => 'ml-4 col-sm-2']) }}
                                    {{ Form::number('stationery_fee', null , ['id' => 'stationery_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('sports_fee', 'Sports Fee :', ['class' => 'col-sm-2']) }}
                                    {{ Form::number('sports_fee', null , ['id' => 'sports_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                    {{ Form::label('club_fee', 'Club Fee :', ['class' => 'ml-4 col-sm-2']) }}
                                    {{ Form::number('club_fee', null , ['id' => 'club_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('hostel_fee', 'Hostel Fee :', ['class' => 'col-sm-2']) }}
                                    {{ Form::number('hostel_fee', null , ['id' => 'hostel_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                    {{ Form::label('laundry_fee', 'Laundry Fee :', ['class' => 'ml-4 col-sm-2']) }}
                                    {{ Form::number('laundry_fee', null , ['id' => 'laundry_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('education_tax', 'Education Tax :', ['class' => 'col-sm-2']) }}
                                    {{ Form::number('education_tax', null , ['id' => 'education_tax','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                    {{ Form::label('eca_fee', 'ECA Fee :', ['class' => 'ml-4 col-sm-2']) }}
                                    {{ Form::number('eca_fee', null , ['id' => 'eca_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('late_fine', 'Late Fine :', ['class' => 'col-sm-2']) }}
                                    {{ Form::number('late_fine', null , ['id' => 'late_fine','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
                                    {{ Form::label('extra_fee', 'Extra Fee :', ['class' => 'ml-4 col-sm-2']) }}
                                    {{ Form::number('extra_fee', null , ['id' => 'extra_fee','class' => 'col-sm-3 form-control','style' => 'width:80%']) }}
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
                                          <small class="text-danger" id="advancewarn"></small>
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
                                        {{ Form::select('upi_type', [''=> 'Select UPI Type','Google Pay'=> 'Google Pay', 'Phonepe'=> 'Phonepe', 'BHIM UPI'=> 'BHIM UPI','Amazon Pay'=> 'Amazon Pay', 'Paytm Payments Bank'=> 'Paytm Payments Bank', 'Uber'=> 'Uber', 'Chillr'=> 'Chillr', 'MobiKwik'=> 'MobiKwik', 'SBI Pay'=> 'SBI Pay', 'iMobile'=> 'iMobile', 'Axis Pay'=> 'Axis Pay', 'BOB UPI'=> 'BOB UPI'], @$feepayment_info->upi_type, ['class' => 'form-control', 'id' => 'upi_type','style' => 'width:80%']) }}
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
