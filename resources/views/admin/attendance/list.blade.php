@extends('layouts.admin')
@section('title','Attendance List')
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#subject').select2({
                placeholder: "Search by Subject",
                allowClear: true
            });
            $('#level').select2({
                placeholder: "Search by Level/Class",
                allowClear: true
            });
            $('#session').select2({
                placeholder: "Search by Session",
                allowClear: true
            });
        });

        $('#level').change(function() {
                var level = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('getSubjects') }}",
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'level': level,
                    },
                    success: function(data) {
                        if (data.length < 1) {
                            alert("No Subjects found on this level");
                        } else {
                            subjects = data;
                            for (let index = 0; index < data.length; index++) {
                                subjectselect += '<option value="' + data[index]['id'] + '">' + data[index][
                                    'title'
                                ] + '</option>';
                            }
                        }
                    }
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
                    <h3 class="card-title">Attendance List</h3>
                    <div class="card-tools">
                        <a href="{{ route('attendance.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="p-1 col-lg-10">
                            <form action="" class="">
                                <div class="row">
                                    <div class="col-sm-3">
                                        {!! Form::select('session', $session, @request()->session, ['id' => 'session','class' => 'form-control select2', 'placeholder' => '']) !!}
                                    </div>
                                    <div class="col-sm-3">
                                        {!! Form::select('level', $levels, @request()->level, ['id' => 'level','class' => 'form-control select2', 'placeholder' => '']) !!}
                                    </div>
                                    <div class="col-sm-3">
                                        {!! Form::select('subject', $levels, @request()->subject, ['id' => 'subject','class' => 'form-control select2', 'placeholder' => '']) !!}
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
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Subject</th>
                                <th>Present Students</th>
                                <th>Absent Students</th>
                                <th>Total Students</th>
                                <th>Added By</th>
                                <th>Adding Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$value)
                            <tr>
                            <td>{{ $key+1}}.</td>
                            <td>{{ @$subject[$value->subject_id] }}</td>
                            <td>
                                @isset($value->students)
                                @foreach ($value->students as $key => $item)
                                    @if($item == '1')
                                    - {{ $students[$key] }}
                                    @endif
                                @endforeach
                                @endisset
                            </td>
                            <td>
                                @isset($value->students)
                                @foreach ($value->students as $key => $item)
                                    @if($item == '0')
                                    - {{ @$students[$key] }}
                                    @endif
                                @endforeach
                                @endisset
                            </td>
                            <td>{{ @count($value->students) }}</td>
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
