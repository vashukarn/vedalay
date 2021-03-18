@extends('layouts.admin')
@section('title', 'Salary List')
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#keyword').select2({
                placeholder: "Search Name or Phone",
                allowClear: true
            });
        });

    </script>
@endpush
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Salary List</h3>
                    <div class="card-tools">
                        <a href="{{ route('salary.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="p-1 col-lg-10">
                            <form action="" class="">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        {!! Form::select('keyword', $users, @request()->keyword, ['id' => 'keyword','class' => 'form-control select2', 'placeholder' =>
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
                                @can('salary-create')
                                <a href="{{ route('salary.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                                    <i class="fa fa-plus"></i> Add Salary</a>
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
                                <th>Title</th>
                                <th>Teacher/Staff</th>
                                <th>Month</th>
                                <th>Amount</th>
                                <th>Added By</th>
                                <th>Adding Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$value)
                            <tr>
                            <td>{{ $key+1}}.</td>
                            <td>{{ @$value->title }}</td>
                            <td>{{ @$value->get_user->name }}</td>
                            <td>
                                <span class="badge badge-primary">
                                    @if(@$value->month  == '1') January
                                    @elseif(@$value->month  == '2') February
                                    @elseif(@$value->month  == '3') March
                                    @elseif(@$value->month  == '4') April
                                    @elseif(@$value->month  == '5') May
                                    @elseif(@$value->month  == '6') June
                                    @elseif(@$value->month  == '7') July
                                    @elseif(@$value->month  == '8') August
                                    @elseif(@$value->month  == '9') September
                                    @elseif(@$value->month  == '10') October
                                    @elseif(@$value->month  == '11') November
                                    @elseif(@$value->month  == '12') December
                                    @else Not Defined
                                    @endif
                                </span>
                            </td>
                            <td>{{ @$value->total_amount }}</td>
                            <td>{{ @$value->creator->name }}</td>
                            <td>{{ ReadableDate(@$value->created_at, 'all') }}</td>
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
