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
                                <td>{{ @$teacher_info->get_user->name }}</td>
                            </tr>
                            <tr>
                                <td>Short Name</td>
                                <td>{{ @$teacher_info->short_name }}</td>
                            </tr>
                            <tr>
                                <td>Subjects</td>
                                <td>
                                    @foreach ($teacher_info->subject as $item)
                                        {{ @$subjects[$item] }}
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ @$teacher_info->get_user->email }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>{{ @$teacher_info->phone }}</td>
                            </tr>
                            <tr>
                                <td>Publish Status</td>
                                <td>
                                    <span class="badge @if ($teacher_info->get_user->publish_status ==
                                    '1') badge-success @elseif($teacher_info->get_user->publish_status
                                    == '2') badge-danger @else badge-warning @endif">
                                        @if ($teacher_info->get_user->publish_status == '1')
                                    Active @elseif($teacher_info->get_user->publish_status == '2') Banned @else
                                        Inactive @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Last Changed By</td>
                            <td>{{ @$teacher_info->updated_by ? @$teacher_info->updater->name : @$teacher_info->creator->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Last Changed At</td>
                            <td>{{ @$teacher_info->get_user->updated_at ? ReadableDate(@$teacher_info->get_user->updated_at, 'all') : ReadableDate(@$teacher_info->get_user->created_at, 'all') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Joining Date</td>
                            <td>{{ ReadableDate(@$teacher_info->joining_date, 'all') }}</td>
                        </tr>
                        <tr>
                            <td>Aadhar Number</td>
                            <td>{{ @$teacher_info->aadhar_number }}</td>
                        </tr>
                        <tr>
                            <td>Current Address</td>
                            <td>{{ @$teacher_info->current_address }}</td>
                        </tr>
                        <tr>
                            <td>Permanent Address</td>
                            <td>{{ @$teacher_info->permanent_address }}</td>
                        </tr>
                        <tr>
                            <td>Image</td>
                            <td><img src="{{ @$teacher_info->image }}" height="200px" alt="Image Not Found"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
