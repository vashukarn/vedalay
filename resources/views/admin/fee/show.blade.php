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
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Detail</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td> <a href="{{ route('student.show', @$fee_info->student_id) }}">
                                        {{ @$fee_info->get_user->name }}</a></td>
                            </tr>
                            <tr>
                                <td>Title</td>
                                <td>{{ @$fee_info->title }}</td>
                            </tr>
                            <tr>
                                <td>Added By</td>
                                <td>{{ @$fee_info->added_by }}</td>
                            </tr>
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
                                            @if(@$fee_info->tuition_fee > 0)
                                            <tr>
                                                <td>Tuition Fee</td>
                                                <td>Rs. {{ @$fee_info->tuition_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$fee_info->exam_fee > 0)
                                            <tr>
                                                <td>Exam Fee</td>
                                                <td>Rs. {{ @$fee_info->exam_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$fee_info->transport_fee > 0)
                                            <tr>
                                                <td>Transport Fee</td>
                                                <td>Rs. {{ @$fee_info->transport_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$fee_info->stationery_fee > 0)
                                            <tr>
                                                <td>Stationery Fee</td>
                                                <td>Rs. {{ @$fee_info->stationery_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$fee_info->sports_fee > 0)
                                            <tr>
                                                <td>Sports Fee</td>
                                                <td>Rs. {{ @$fee_info->sports_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$fee_info->club_fee > 0)
                                            <tr>
                                                <td>Club Fee</td>
                                                <td>Rs. {{ @$fee_info->club_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$fee_info->hostel_fee > 0)
                                            <tr>
                                                <td>Hostel Fee</td>
                                                <td>Rs. {{ @$fee_info->hostel_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$fee_info->laundry_fee > 0)
                                            <tr>
                                                <td>Laundry Fee</td>
                                                <td>Rs. {{ @$fee_info->laundry_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$fee_info->education_tax > 0)
                                            <tr>
                                                <td>Education Tax</td>
                                                <td>Rs. {{ @$fee_info->education_tax }}</td>
                                            </tr>
                                            @endif
                                            @if(@$fee_info->eca_fee > 0)
                                            <tr>
                                                <td>ECA Fee</td>
                                                <td>Rs. {{ @$fee_info->eca_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$fee_info->late_fine > 0)
                                            <tr>
                                                <td>Late Fine</td>
                                                <td>Rs. {{ @$fee_info->late_fine }}</td>
                                            </tr>
                                            @endif
                                            @if(@$fee_info->extra_fee > 0)
                                            <tr>
                                                <td>Extra Fee</td>
                                                <td>Rs. {{ @$fee_info->extra_fee }}</td>
                                            </tr>
                                            @endif
                                            @if(@$fee_info->total_amount > 0)
                                            <tr>
                                                <td> <b> Total Amount</b></td>
                                                <td>Rs. {{ @$fee_info->total_amount }}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            @role('Super Admin|Admin|Staff')
                            <tr>
                                <td>Added By</td>
                                <td>{{ @$fee_info->creator->name }}
                                </td>
                            </tr>
                            <tr>
                                <td>Added At</td>
                                <td>{{ ReadableDate(@$fee_info->created_at, 'all') }}
                                </td>
                            </tr>
                            <tr>
                                <td>Unique</td>
                                <td>{{ @$fee_info->unique }}</td>
                            </tr>
                            @endrole
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
