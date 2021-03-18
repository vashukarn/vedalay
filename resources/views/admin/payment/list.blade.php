@extends('layouts.admin')
@section('title', 'Payment List')
@push('scripts')
<script>
    $(document).ready(function() {
        $('#student').select2({
            placeholder: "Search by Student / Phone",
            allowClear: true
        });
        $('#level').select2({
            placeholder: "Search by Level",
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
                    <div class="row">
                        @hasanyrole('Super Admin|Admin|Staff')
                        <div class="p-1 col-lg-10">
                            <form action="" class="">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        {!! Form::select('student', $filter, @request()->student, ['id'=> 'student','class' => 'form-control select2', 'placeholder' =>'']) !!}
                                    </div>
                                    {{-- <div class="col-lg-4 col-md-4 col-sm-4">
                                        {!! Form::select('level', $levels, @request()->level, ['id'=> 'level','class' => 'form-control select2', 'placeholder' =>'']) !!}
                                    </div> --}}
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <button class="btn btn-primary btn-flat"><i class="fa fa fa-search"></i>
                                            Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endhasrole
                    </div>
                </div>
                <div style="overflow-x: scroll" class="card-body card-format">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Type</th>
                                <th>Amount Paid</th>
                                @role('Student')
                                @else
                                <th>Payment Id</th>
                                <th>Paid By</th>
                                @endrole
                                <th>Paid On</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$value)
                            <tr>
                            <td>{{ $key+1}}.</td>
                            <td>{{ @$value->type }}</td>
                            <td>Rs. {{ @$value->amount }}</td>
                            @role('Student')
                            @else
                            <td><span class="badge badge-primary">{{ @$value->payment_id }}</span></td>
                            <td> <a href="{{ route('student.show', @$value->user_id) }}">{{ @$value->payer->name }}</a></td>
                            @endrole
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
