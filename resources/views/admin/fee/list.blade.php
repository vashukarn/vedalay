@extends('layouts.admin')
@section('title', 'Fee List')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Fee List</h3>
                    <div class="card-tools">
                        <a href="{{ route('fee.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="p-1 col-lg-10">
                            <form action="" class="">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        {!! Form::select('keyword', [], @request()->keyword, ['class' => 'form-control select2', 'placeholder' =>
                                        'Search Name or Phone']) !!}
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <button class="btn btn-primary btn-flat"><i class="fa fa fa-search"></i>
                                            Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="float-right col-lg-2">
                            <div class="card-tools">
                                @can('fee-create')
                                <a href="{{ route('fee.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                                    <i class="fa fa-plus"></i> Add New Fee</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <div style="overflow-x: scroll" class="card-body card-format">
                    <table class="table table-striped table-hover"> {{-- table-bordered--}}
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Title</th>
                                @role('Student')
                                <th>Fee</th>
                                <th>Total Amount</th>
                                @else
                                <th>Level</th>
                                <th>Amount</th>
                                <th>Added By</th>
                                <th>Adding Date</th>
                                <th>Status</th>
                                <th style="text-align:center;" width="10%">Action</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$value)
                            <tr>
                            <td>{{ $key+1}}.</td>
                            <td>{{ @$value->title }}</td>
                            @role('Student')
                            <td>
                                <strong> Fee Details:</strong> <br>
                                Tuition Fee: {{ @$value->tuition_fee ?? 0 }} &emsp; &emsp;
                                Exam Fee: {{ @$value->exam_fee ?? 0 }} &emsp; &emsp;
                                Transport Fee: {{ @$value->transport_fee ?? 0 }} &emsp; &emsp;
                                Stationery Fee: {{ @$value->stationery_fee ?? 0 }} <br>
                                Sports Fee: {{ @$value->sports_fee ?? 0 }}  &emsp; &emsp;
                                Club Fee: {{ @$value->club_fee ?? 0 }} &emsp; &emsp;
                                Hostel Fee: {{ @$value->hostel_fee ?? 0 }} &emsp; &emsp;
                                Laundry Fee: {{ @$value->laundry_fee ?? 0 }} <br>
                                Education Tax: {{ @$value->education_tax ?? 0 }} &emsp; &emsp;
                                ECA Fee: {{ @$value->eca_fee ?? 0 }} &emsp; &emsp;
                                Late Fine: {{ @$value->late_fine ?? 0 }} &emsp; &emsp;
                                Extra Fee: {{ @$value->extra_fee ?? 0 }}
                            </td>
                            <td>{{ @$value->total_amount }}</td>
                            @else
                            <td>{{ $levels[@$value->level_id] }}</td>
                            <td>{{ @$value->total_amount }}</td>
                            <td>{{ @$value->creator->name }}</td>
                            <td>{{ ReadableDate(@$value->created_at, 'all') }}</td>
                            <td>
                                <span class="badge @if(@$value->get_user->publish_status  == '1')badge-success @elseif(@$value->get_user->publish_status  == '2') badge-danger @else badge-warning @endif">
                                    @if(@$value->get_user->publish_status  == '1') Active @elseif(@$value->get_user->publish_status  == '2') Banned @else Inactive @endif
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                  @can('fee-edit')
                                @if($value->created_at->toDateString() > date("Y-m-d", strtotime(date("Y-m-d"). ' - 5 days')) && $value->rollback == '0')
                                  {{Form::open(['method' => 'POST','route' => ['rollbackTransaction', 'fee' => @$value->unique],'style'=>'display:inline','onsubmit'=>'return confirm("Are you sure you want to undo this transaction?")']) }}
                                  {{Form::button('<i class="fas fa-undo"></i>',['class'=>'btn btn-danger btn-sm btn-flat','type'=>'submit','title'=>'Rollback Transaction'])}}
                                  {{ Form::close() }}
                                @elseif($value->rollback == '1')
                                    Already Rolledback
                                @else
                                    Rollback Timeout
                                @endif
                                  @endcan
                              </div>
                              </td>
                            @endrole
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-sm">
                                  Showing <strong>{{ $data->firstItem() }}</strong>  to <strong>{{ $data->lastItem() }} </strong>  of <strong> {{$data->total()}}</strong> entries
                                  <span> | Takes <b>{{ round((microtime(true) - LARAVEL_START),2) }}</b> seconds to render</span>
                                </p>
                            </div>
                            <div class="col-md-8">
                                <span class="pagination-sm m-0 float-right">{{$data->links()}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
