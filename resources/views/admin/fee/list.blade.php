@extends('layouts.admin')
@section('title', 'Fee List')

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var SITEURL = '{{ URL::to('') }}';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('body').on('click', '.buy_now', function(e) {
        var totalAmount = $(this).attr("data-amount");
        var product_id = $(this).attr("data-id");
        var options = {
            "key": "{{ env('RAZOR_KEY') }}",
            "amount": (totalAmount * 100), // 2000 paise = INR 20
            "name": "Tutsmake",
            "description": "Payment",
            "image": "{{ asset('assets/img/logo.png') }}",
            "handler": function(response) {
                window.location.href = SITEURL + '/' + 'paysuccess?payment_id=' + response
                    .razorpay_payment_id + '&amp;product_id=' + product_id + '&amp;amount=' +
                    totalAmount;
            },
            "prefill": {
                "contact": '9988665544',
                "email": 'tutsmake@gmail.com',
            },
            "theme": {
                "color": "#528FF0"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
        e.preventDefault();
    });
</script>
@endpush
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
                                <th>Total Amount</th>
                                <th>Payment</th>
                                @else
                                <th>Level</th>
                                <th>Amount</th>
                                <th>Added By</th>
                                <th>Adding Date</th>
                                <th>Status</th>
                                <th>Roll Back</th>
                                @endrole
                                <th style="text-align:center;" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$value)
                            <tr>
                            <td>{{ $key+1}}.</td>
                            <td>{{ @$value->title }}</td>
                            @role('Student')
                            <td>{{ @$value->total_amount }}</td>
                            <td>
                                <div class="btn-group">
                                    {{Form::open(['method' => 'POST','route' => ['razorPaySuccess'],'style'=>'display:inline']) }}
                                    {{Form::button('<i class="fas fa-money-bill"></i> &nbsp; Pay Now', ['class'=>'btn btn-success btn-sm btn-flat','title'=>'Pay This Fee']) }}
                                    {{-- , 'data-amount'=>"{{ @$value->total_amount }}",'data-id'=>"{{ @$value->level_id }}" --}}
                                  {{ Form::close() }}
                              </div>
                              </td>
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
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('fee.show', @$value->id) }}" title="View Fee Details"
                                        class="btn btn-secondary btn-sm btn-flat"><i class="fas fa-eye"></i></a>
                              </div>
                              </td>
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
