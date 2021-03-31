@extends('layouts.admin')
@section('title', 'Result List')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Result List</h3>
                    <div class="card-tools">
                        <a href="{{ route('result.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="float-right col-lg-2">
                            <div class="card-tools">
                                @can('result-create')
                                    <a href="{{ route('result.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                                        <i class="fa fa-plus"></i> Add Result</a>
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
                                <th>Student</th>
                                <th>Status</th>
                                <th>Marks By Subject</th>
                                <th>Percentage / Grade</th>
                                @if (Auth::user()->type != 'student')
                                    <th>Last Changed</th>
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}.</td>
                                    <td>{{ @$value->student->name }} <br> Class :
                                        {{ @$value->get_level->standard }}{{ @$value->get_level->section ? ' - ' . @$value->get_level->section : '' }}
                                    </td>
                                <td><span class="badge @if (@$value->status == 'PASS') badge-success @elseif(@$value->status == "FAIL")
                                        badge-danger @else badge-warning @endif">{{ @$value->status }}</span> <br> <small>
                                            {{ @$value->status == 'WITHHELD' ? @$value->withheld_reason : '' }}</small>
                                        @if (@$value->status == 'FAIL')
                                            <small>Failed Subjects : </small> <br>
                                            @foreach ($value->backlogs as $key => $item)
                                                <small>{{ @$subjects[$item] }}</small> <br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @isset($value->marks)
                                            <table class="table table-striped table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Subjects</th>
                                                        @if ($value->gper != 'Percentage')
                                                            <th>Credits</th>
                                                            <th>Grade Obtained</th>
                                                        @else
                                                            <th>Marks Obtained</th>
                                                            <th>Pass Marks</th>
                                                            <th>Total Marks</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $marks = 0;
                                                    $pass = 0;
                                                    $total = 0;
                                                    ?>
                                                    @foreach ($value->marks as $key => $item)
                                                        <tr>
                                                            <td>{{ @$subjects[$key] }}</td>
                                                            @if ($value->gper == 'Percentage')
                                                            <?php
                                                            $marks += $item['obtained'];
                                                            $pass += $item['pass'];
                                                            $total += $item['full'];
                                                            ?>
                                                                <td>{{ $item['obtained'] }}</td>
                                                                <td>{{ $item['pass'] }}</td>
                                                                <td>{{ $item['full'] }}</td>
                                                            @else
                                                                <td>{{ $item['credits'] }}</td>
                                                                <td>{{ $item['grade'] }}</td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td>Total</td>
                                                        @if ($value->gper == 'Percentage')
                                                            <td>{{ $marks }}</td>
                                                            <td>{{ $pass }}</td>
                                                            <td>{{ $total }}</td>
                                                        @else
                                                            <td>{{ $value->sgpa }}</td>
                                                            <td>{{ $value->grade }}</td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @else
                                            Error while fetching data
                                        @endisset
                                    </td>
                                    <td>
                                        @if ($value->gper == 'Percentage')
                                        {{ @$value->percentage }} % @else {{ @$value->grade }} @endif
                                    </td>
                                    @if (Auth::user()->type != 'student')
                                        <td> Changed By
                                            :{{ @$value->updated_by ? @$value->updater->name : @$value->creator->name }}
                                            Changed At:
                                            {{ @$value->updated_at ? ReadableDate(@$value->updated_at, 'all') : ReadableDate(@$value->created_at, 'all') }}
                                        </td>
                                        <td>{{ $value->publish_status == 0 ? 'Unpublished' : 'Published' }}
                                            <div class="mt-2 btn-group float-right">
                                                @can('staff-edit')
                                                    <a href="{{ route('publishResult', @$value->id) }}"
                                                        title="{{ $value->publish_status == 0 ? 'Publish Result' : 'Unpublish Result' }}"
                                                        class="btn {{ $value->publish_status == 0 ? 'btn-success' : 'btn-warning' }} btn-sm btn-flat"><i
                                                            class="fas {{ $value->publish_status == 0 ? 'fa-eye' : 'fa-eye-slash' }}"></i></a>
                                                @endcan
                                            </div>
                                        </td>
                                    @endif
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
