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
                                <td>{{ @$staff_info->get_user->name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ @$staff_info->get_user->email }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>{{ @$staff_info->phone }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>{{ @$staff_info->phone }}</td>
                            </tr>
                            <tr>
                                <td>Publish Status</td>
                                <td>
                                    <span class="badge @if ($staff_info->get_user->publish_status ==
                                    '1') badge-success @elseif($staff_info->get_user->publish_status
                                    == '2') badge-danger @else badge-warning @endif">
                                        @if ($staff_info->get_user->publish_status == '1')
                                    Active @elseif($staff_info->get_user->publish_status == '2') Banned @else
                                        Inactive @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Last Changed By</td>
                            <td>{{ @$staff_info->updated_by ? @$staff_info->updater->name : @$staff_info->creator->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Last Changed At</td>
                            <td>{{ @$staff_info->get_user->updated_at ? ReadableDate(@$staff_info->get_user->updated_at, 'all') : ReadableDate(@$staff_info->get_user->created_at, 'all') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Joining Date</td>
                            <td>{{ ReadableDate(@$staff_info->joining_date, 'all') }}</td>
                        </tr>
                        <tr>
                            <td>Salary</td>
                            <td>{{ @$staff_info->salary ? 'Rs. '.@$staff_info->salary : '' }}</td>
                        </tr>
                        <tr>
                            <td>Aadhar Number</td>
                            <td>{{ @$staff_info->aadhar_number }}</td>
                        </tr>
                        <tr>
                            <td>Current Address</td>
                            <td>{{ @$staff_info->current_address }}</td>
                        </tr>
                        <tr>
                            <td>Permanent Address</td>
                            <td>{{ @$staff_info->permanent_address }}</td>
                        </tr>
                        <tr>
                            <td>Image</td>
                            <td><img src="{{ @$staff_info->image }}" height="200px" alt="Image Not Found"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
