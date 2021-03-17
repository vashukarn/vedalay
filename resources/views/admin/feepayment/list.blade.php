@extends('layouts.admin')
@section('title', 'Fee Payment List')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Fee Payment List</h3>
                    <div class="card-tools">
                        <a href="{{ route('feepayment.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="float-right col-lg-2">
                            <div class="card-tools">
                                @can('feepayment-create')
                                    <a href="{{ route('feepayment.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                                        <i class="fa fa-plus"></i> Pay Fee</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <div style="overflow-x: scroll" class="card-body card-format">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                @role('Student')
                                <th>Fee Details</th>
                                <th>Amount Paid</th>
                                <th>Payment Method</th>
                                <th>Paid At</th>
                            @else
                                <th>Student Name</th>
                                <th>Fee Paid</th>
                                <th>Payment Method</th>
                                <th>Last Changed By</th>
                                <th>Last Changed At</th>
                                @endrole
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}.</td>
                                    @role('Student')
                                    <td>
                                        Tuition Fee: {{ @$value->tuition_fee ?? 0 }} &emsp; &emsp;
                                        Exam Fee: {{ @$value->exam_fee ?? 0 }} &emsp; &emsp;
                                        Transport Fee: {{ @$value->transport_fee ?? 0 }} &emsp; &emsp;
                                        Stationery Fee: {{ @$value->stationery_fee ?? 0 }} <br>
                                        Sports Fee: {{ @$value->sports_fee ?? 0 }} &emsp; &emsp;
                                        Club Fee: {{ @$value->club_fee ?? 0 }} &emsp; &emsp;
                                        Hostel Fee: {{ @$value->hostel_fee ?? 0 }} &emsp; &emsp;
                                        Laundry Fee: {{ @$value->laundry_fee ?? 0 }} <br>
                                        Education Tax: {{ @$value->education_tax ?? 0 }} &emsp; &emsp;
                                        ECA Fee: {{ @$value->eca_fee ?? 0 }} &emsp; &emsp;
                                        Late Fine: {{ @$value->late_fine ?? 0 }} &emsp; &emsp;
                                        Extra Fee: {{ @$value->extra_fee ?? 0 }}
                                    </td>
                                    <td>Rs. {{ @$value->total_amount }}</td>
                                    <td>{{ @$value->payment_method }}</td>
                                    <td>{{ ReadableDate(@$value->created_at, 'all') }}</td>
                                @else
                                    <td>{{ @$value->student->name }}</td>
                                    <td>Rs. {{ @$value->total_amount }}</td>
                                    <td>{{ @$value->payment_method }}</td>
                                    <td>{{ @$value->updated_by ? @$value->updater->name : @$value->creator->name }}</td>
                                    <td>{{ @$value->updated_at ? ReadableDate(@$value->updated_at, 'all') : ReadableDate(@$value->created_at, 'all') }}</td>
                                    @endrole
                                    <td>
                                        <a href="{{ route('feepayment.show', @$value->id) }}" title="View Student Details"
                                            class="btn btn-secondary btn-sm btn-flat"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-sm">
                                    Showing <strong>{{ $data->firstItem() }}</strong> to
                                    <strong>{{ $data->lastItem() }} </strong> of <strong> {{ $data->total() }}</strong>
                                    entries
                                    <span> | Takes <b>{{ round(microtime(true) - LARAVEL_START, 2) }}</b> seconds to
                                        render</span>
                                </p>
                            </div>
                            <div class="col-md-8">
                                <span class="pagination-sm m-0 float-right">{{ $data->links() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
