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
                                <td>{{ @$student_info->get_user->name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ @$student_info->get_user->email }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>{{ $student_info->get_student->phone }}</td>
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
                            <td>{{ @$student_info->get_student->updated_by ? @$student_info->get_student->updater->name : @$student_info->get_student->creator->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Last Changed At</td>
                            <td>{{ @$student_info->get_student->updated_at ? ReadableDate(@$student_info->get_student->updated_at, 'all') : ReadableDate(@$student_info->get_student->created_at, 'all') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Session</td>
                            <td>{{ @$student_info->get_student->get_session->start_year }} -
                                {{ @$student_info->get_student->get_session->end_year }}</td>
                        </tr>
                        <tr>
                            <td>Level</td>
                            <td>{{ @$student_info->get_student->get_level->standard }} - {{ @$student_info->get_student->get_level->section }}
                            </td>
                        </tr>
                        <tr>
                            <td>Date of Birth</td>
                            <td>{{ @$student_info->get_student->dob }}</td>
                        </tr>
                        <tr>
                            <td>Blood Group</td>
                            <td>{{ @$student_info->get_student->blood_group }}</td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td>{{ @$student_info->get_student->gender }}</td>
                        </tr>
                        <tr>
                            <td>Caste Category</td>
                            <td>{{ @$student_info->get_student->caste_category }}</td>
                        </tr>
                        <tr>
                            <td>Disability</td>
                            <td>
                                <span class="badge badge-primary">
                                    @if (@$student_info->get_student->disability == '1')
                                    Yes @else
                                        No @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Regular Private</td>
                            <td>{{ @$student_info->get_student->regpriv }}</td>
                        </tr>
                        <tr>
                            <td>Aadhar Number</td>
                            <td>{{ @$student_info->get_student->aadhar_number }}</td>
                        </tr>
                        <tr>
                            <td>Father Name</td>
                            <td>{{ @$student_info->get_student->fathername ? 'Mr. ' . @$student_info->get_student->fathername : '' }}</td>
                        </tr>
                        <tr>
                            <td>Mother Name</td>
                            <td>{{ @$student_info->get_student->mothername ? 'Mrs. ' . @$student_info->get_student->mothername : '' }}</td>
                        </tr>
                        <tr>
                            <td>Father's Occupation</td>
                            <td>{{ @$student_info->get_student->fatheroccupation }}</td>
                        </tr>
                        <tr>
                            <td>Mother's Occupation</td>
                            <td>{{ @$student_info->get_student->motheroccupation }}</td>
                        </tr>
                        <tr>
                            <td>Father's Income</td>
                            <td>{{ @$student_info->get_student->fatherincome }}</td>
                        </tr>
                        <tr>
                            <td>Mother's Income</td>
                            <td>{{ @$student_info->get_student->motherincome }}</td>
                        </tr>
                        <tr>
                            <td>Guardian Name</td>
                            <td>{{ @$student_info->get_student->guardian_name }}</td>
                        </tr>
                        <tr>
                            <td>Guardian Phone</td>
                            <td>{{ @$student_info->get_student->guardian_phone }}</td>
                        </tr>
                        <tr>
                            <td>Current Address</td>
                            <td>{{ @$student_info->get_student->current_address }}</td>
                        </tr>
                        <tr>
                            <td>Permanent Address</td>
                            <td>{{ @$student_info->get_student->permanent_address }}</td>
                        </tr>
                        <tr>
                            <td>Image</td>
                            <td><img src="{{ @$student_info->get_student->image }}" height="200px" alt="Image Not Found"></td>
                        </tr>
                        <tr>
                            <td>Last School</td>
                            <td>{{ @$student_info->last_schoolname }}</td>
                        </tr>
                        <tr>
                            <td>Last Level/Class</td>
                            <td>{{ @$student_info->last_level }}</td>
                        </tr>
                        <tr>
                            <td>Last State</td>
                            <td>{{ @$student_info->last_state }}</td>
                        </tr>
                        <tr>
                            <td>Last City</td>
                            <td>{{ @$student_info->last_city }}</td>
                        </tr>
                        <tr>
                            <td>Last School Marks Obtained</td>
                            <td>{{ @$student_info->last_marks }}</td>
                        </tr>
                        <tr>
                            <td>Last Marksheet</td>
                            <td><img src="{{ @$student_info->last_marksheet }}" height="200px" alt="Image Not Found"></td>
                        </tr>
                        <tr>
                            <td>Transfer Certificate</td>
                            <td><img src="{{ @$student_info->transfer_certificate }}" height="200px" alt="Image Not Found"></td>
                        </tr>
                        <tr>
                            <td>Migration Certificate</td>
                            <td><img src="{{ @$student_info->migration_certificate }}" height="200px" alt="Image Not Found"></td>
                        </tr>
                        <tr>
                            <td>Character Certificate</td>
                            <td><img src="{{ @$student_info->character_certificate }}" height="200px" alt="Image Not Found"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
