@extends('layouts.admin')
@section('title', $title)
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <div style="overflow-x: scroll" class="card-body card-format">
                    <table class="table table-striped table-hover"> {{-- table-bordered --}}
                        <thead>
                            <tr>
                                <th>Detail</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td> <a href="{{ route('student.show', @$student_info[$feepayment_info->student_id]) }}">
                                        {{ @$feepayment_info->student->name }}</a></td>
                            </tr>
                            <tr>
                                <td>Payment Method</td>
                                <td>{{ @$feepayment_info->payment_method }}</td>
                            </tr>
                            <tr>
                                <td>Transfer Date</td>
                                <td>{{ @$feepayment_info->transfer_date }}</td>
                            </tr>
                            @if(@$feepayment_info->payment_method == 'Bank Transfer')
                            <tr>
                                <td>Bank IFSC</td>
                                <td>{{ @$feepayment_info->bank_ifsc }}</td>
                            </tr>
                            <tr>
                                <td>Bank Account Number</td>
                                <td>{{ @$feepayment_info->bank_accountno }}</td>
                            </tr>
                            @endif
                            @if(@$feepayment_info->payment_method == 'UPI' || @$feepayment_info->payment_method == 'Paytm')
                            <tr>
                                <td>Transferred From</td>
                                <td>{{ @$feepayment_info->transfer_phone }}</td>
                            </tr>
                            @if(@$feepayment_info->payment_method == 'UPI')
                            <tr>
                                <td>UPI Type</td>
                                <td>{{ @$feepayment_info->upi_type }}</td>
                            </tr>
                            @endif
                            @endif
                            @if(@$feepayment_info->payment_method == 'Card')
                            <tr>
                                <td>Card Type</td>
                                <td>{{ @$feepayment_info->card_type }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td>Fee</td>
                                <td>
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Fee</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(@$feepayment_info->tuition_fee > 0)
                                            <tr>
                                                <td>Tuition Fee</td>
                                                <td>Rs. {{ @$feepayment_info->tuition_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$feepayment_info->exam_fee > 0)
                                            <tr>
                                                <td>Exam Fee</td>
                                                <td>Rs. {{ @$feepayment_info->exam_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$feepayment_info->transport_fee > 0)
                                            <tr>
                                                <td>Transport Fee</td>
                                                <td>Rs. {{ @$feepayment_info->transport_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$feepayment_info->stationery_fee > 0)
                                            <tr>
                                                <td>Stationery Fee</td>
                                                <td>Rs. {{ @$feepayment_info->stationery_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$feepayment_info->sports_fee > 0)
                                            <tr>
                                                <td>Sports Fee</td>
                                                <td>Rs. {{ @$feepayment_info->sports_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$feepayment_info->club_fee > 0)
                                            <tr>
                                                <td>Club Fee</td>
                                                <td>Rs. {{ @$feepayment_info->club_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$feepayment_info->hostel_fee > 0)
                                            <tr>
                                                <td>Hostel Fee</td>
                                                <td>Rs. {{ @$feepayment_info->hostel_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$feepayment_info->laundry_fee > 0)
                                            <tr>
                                                <td>Laundry Fee</td>
                                                <td>Rs. {{ @$feepayment_info->laundry_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$feepayment_info->education_tax > 0)
                                            <tr>
                                                <td>Education Tax</td>
                                                <td>Rs. {{ @$feepayment_info->education_tax }}</td>
                                            </tr>
                                            @endif
                                            @if(@$feepayment_info->eca_fee > 0)
                                            <tr>
                                                <td>ECA Fee</td>
                                                <td>Rs. {{ @$feepayment_info->eca_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$feepayment_info->late_fine > 0)
                                            <tr>
                                                <td>Late Fine</td>
                                                <td>Rs. {{ @$feepayment_info->late_fine }}</td>
                                            </tr>
                                            @endif
                                            @if(@$feepayment_info->extra_fee > 0)
                                            <tr>
                                                <td>Extra Fee</td>
                                                <td>Rs. {{ @$feepayment_info->extra_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$feepayment_info->total_amount > 0)
                                            <tr>
                                                <td> <b> Total Amount</b></td>
                                                <td>Rs. {{ @$feepayment_info->total_amount }}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>Added By</td>
                                <td>{{ @$feepayment_info->creator->name }}
                                </td>
                            </tr>
                            <tr>
                                <td>Added At</td>
                                <td>{{ ReadableDate(@$feepayment_info->created_at, 'all') }}
                                </td>
                            </tr>
                            <tr>
                                <td>Remarks</td>
                                <td>{{ @$feepayment_info->remarks ?? 'No Remarks Found' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
