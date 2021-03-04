@extends('layouts.admin')
@section('title', 'Admission List')
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#keyword').select2({
                    placeholder: "Search Name or Phone",
                });
                $('#level').select2({
                    placeholder: "Search by Level/Class",
                });
                $('#session').select2({
                    placeholder: "Search by Session",
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
                        <div class="p-1 col-lg-10">
                            <form action="" class="">
                                <div class="row">
                                    <div class="col-sm-3">
                                        {!! Form::select('keyword', $filter, @request()->keyword, ['id' => 'keyword','class' => 'form-control select2', 'placeholder' => '']) !!}
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <button class="btn btn-primary btn-flat"><i class="fa fa fa-search"></i>
                                            Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div style="overflow-x: scroll" class="card-body card-format">
                    <table class="table table-striped table-hover"> {{-- table-bordered --}}
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Standard</th>
                                <th>Profile Image</th>
                                <th>Last School</th>
                                <th>Last Level</th>
                                <th>Last City</th>
                                <th>Last State</th>
                                <th style="text-align:center;" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}.</td>
                                    <td>{{ @$value->get_user->name }}</td>
                                    <td>{{ @$value->get_student->get_level->standard . ' ' . @$value->get_student->get_level->section }}</td>
                                    <td>
                                        <img src="{{ $value->get_student->image }}" alt="{{ @$value->get_user->name }}"
                                            class="img img-thumbail" style="width:60px">
                                    </td>
                                    <td>{{ @$value->last_schoolname }}</td>
                                    <td>{{ @$value->last_level }}</td>
                                    <td>{{ @$value->last_city }}</td>
                                    <td>{{ @$value->last_state }}</td>

                                <td>
                                    <div class="btn-group">
                                        @can('student-list')
                                            <a href="{{ route('admissionshow', @$value->id) }}" title="View Student Details"
                                                class="btn btn-secondary btn-sm btn-flat"><i class="fas fa-eye"></i></a>
                                        @endcan
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
                                Showing <strong>{{ $data->firstItem() }}</strong> to
                                <strong>{{ $data->lastItem() }} </strong> of <strong>
                                    {{ $data->total() }}</strong>
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
