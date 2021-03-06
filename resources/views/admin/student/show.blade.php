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
                    <table class="table table-striped table-hover"> {{-- table-bordered --}}
                        <thead>
                            <tr>
                                <th>Detail</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>{{ @$student_info->get_user->name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ @$student_info->get_user->email }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>{{ @$student_info->phone }}</td>
                            </tr>
                            <tr>
                                <td>Publish Status</td>
                                <td>
                                    <span class="badge @if ($student_info->get_user->publish_status ==
                                    '1') badge-success @elseif($student_info->get_user->publish_status
                                    == '2') badge-danger @else badge-warning @endif">
                                        @if ($student_info->get_user->publish_status == '1')
                                    Active @elseif($student_info->get_user->publish_status == '2') Banned @else
                                        Inactive @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Last Changed By</td>
                            <td>{{ @$student_info->updater->name ? @$student_info->updater->name : @$student_info->creator->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Last Changed At</td>
                            <td>{{ @$student_info->get_user->updated_at ? ReadableDate(@$student_info->get_user->updated_at, 'all') : ReadableDate(@$student_info->get_user->created_at, 'all') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Session</td>
                            <td>{{ @$student_info->get_session->start_year }} -
                                {{ @$student_info->get_session->end_year }}</td>
                        </tr>
                        <tr>
                            <td>Level</td>
                            <td>{{ @$student_info->get_level->standard }} - {{ @$student_info->get_level->section }}
                            </td>
                        </tr>
                        <tr>
                            <td>Date of Birth</td>
                            <td>{{ @$student_info->dob }}</td>
                        </tr>
                        <tr>
                            <td>Blood Group</td>
                            <td>{{ @$student_info->blood_group }}</td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td>{{ @$student_info->gender }}</td>
                        </tr>
                        <tr>
                            <td>Caste Category</td>
                            <td>{{ @$student_info->caste_category }}</td>
                        </tr>
                        <tr>
                            <td>Disability</td>
                            <td>
                                <span class="badge badge-primary">
                                    @if (@$student_info->disability == '1')
                                    Yes @else
                                        No @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Regular Private</td>
                            <td>{{ @$student_info->regpriv }}</td>
                        </tr>
                        <tr>
                            <td>Aadhar Number</td>
                            <td>{{ @$student_info->aadhar_number }}</td>
                        </tr>
                        <tr>
                            <td>Father Name</td>
                            <td>{{ @$student_info->fathername ? 'Mr. ' . @$student_info->fathername : '' }}</td>
                        </tr>
                        <tr>
                            <td>Mother Name</td>
                            <td>{{ @$student_info->mothername ? 'Mrs. ' . @$student_info->mothername : '' }}</td>
                        </tr>
                        <tr>
                            <td>Father's Occupation</td>
                            <td>{{ @$student_info->fatheroccupation }}</td>
                        </tr>
                        <tr>
                            <td>Mother's Occupation</td>
                            <td>{{ @$student_info->motheroccupation }}</td>
                        </tr>
                        <tr>
                            <td>Father's Income</td>
                            <td>{{ @$student_info->fatherincome }}</td>
                        </tr>
                        <tr>
                            <td>Mother's Income</td>
                            <td>{{ @$student_info->motherincome }}</td>
                        </tr>
                        <tr>
                            <td>Guardian Name</td>
                            <td>{{ @$student_info->guardian_name }}</td>
                        </tr>
                        <tr>
                            <td>Guardian Phone</td>
                            <td>{{ @$student_info->guardian_phone }}</td>
                        </tr>
                        <tr>
                            <td>Current Address</td>
                            <td>{{ @$student_info->current_address }}</td>
                        </tr>
                        <tr>
                            <td>Permanent Address</td>
                            <td>{{ @$student_info->permanent_address }}</td>
                        </tr>
                        <tr>
                            <td>Image</td>
                            <td><img src="{{ @$student_info->image }}" height="200px" alt="Image Not Found"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
