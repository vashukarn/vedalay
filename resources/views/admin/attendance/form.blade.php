@extends('layouts.admin')
@section('title', $title)
@push('styles')
    <style>
        .btn-default.active,
        .btn-default.active:hover {
            background-color: #17a2b8;
            border-color: #138192;
            color: #fff;
        }
    </style>
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
{{-- <script src="{{ asset('/custom/attendance.js') }}"></script> --}}
<script>
    $("#submit").click(function() {
        submitAttendance();
    });
    $("#holiday").click(function() {
        console.log('clicked');
        var attendance = [];
        @foreach ($student_info as $item)
        attendance['{{ $item->user_id }}'] = 0;
        @endforeach
        $.ajax({
            type: 'POST',
            url: "{{ route('updateAttendance') }}",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'subject' : {{ $subject_info->id }},
                'level' : {{ $subject_info->level_id }},
                'attendance' : attendance,
                'holiday_reason' : $('#holiday_reason').val(),
                'holiday' : '1',
            },
            success: function (data) {
                if(data == "Attendance Updated Successfully"){
                    alert(data);
                }
                else if(data.id){
                    alert("Attendance Marked");
                }
                else{
                    alert("Error Occurred");
                }
                console.log(data);
            }
        });
    });
    function submitAttendance() {
        var attendance = [];
        @foreach ($student_info as $item)
        if ($("#{{ $item->user_id }}_attendance").is(":checked")){
            var temp = 1;
        }else{
            var temp = 0;
        }
        attendance['{{ $item->user_id }}'] = temp;
        @endforeach
        $.ajax({
            type: 'POST',
            url: "{{ route('updateAttendance') }}",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'subject' : {{ $subject_info->id }},
                'level' : {{ $subject_info->level_id }},
                'holiday_reason' : $('#holiday_reason').val(),
                'holiday' : '0',
                'attendance' : attendance,
            },
            success: function (data) {
                if(data == "Attendance Updated Successfully"){
                    alert(data);
                }
                else if(data.id){
                    alert("Attendance Marked");
                }
                else{
                    alert("Error Occurred :"+data);
                }
                console.log(data);
            }
        });
    }
</script>
@endpush
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($attendance_info))
                    {{ Form::open(['url' => route('attendance.update', $attendance_info->id), 'files' => true, 'class' => 'form', 'name' => 'attendance_form']) }}
                    @method('put')
                    @else
                    {{ Form::open(['url' => route('attendance.store'), 'files' => true, 'class' => 'form', 'name' => 'attendance_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">
                            
                            <div class="form-group row">
                                {{ Form::label('date', 'Date', ['class' => 'col-sm-2']) }}
                                <div class="col-sm-4">
                                {{ Form::text('date', ReadableDate(date('Y-m-d'), 'ymd'), ['class' => 'form-control', 'id' => 'date','style' => 'width:80%', 'readonly'=>true]) }}
                                    @error('date')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('subject', 'Subject', ['class' => 'col-sm-2']) }}
                                <div class="col-sm-4">
                                {{ Form::text('subject', @$subject_info->title, ['class' => 'form-control', 'id' => 'subject','style' => 'width:80%', 'readonly'=>true]) }}
                                    @error('subject')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                {{ Form::label('level', 'Level', ['class' => 'col-sm-2']) }}
                                <div class="col-sm-4">
                                {{ Form::text('level', @$subject_info->get_level->standard, ['class' => 'form-control', 'id' => 'level','style' => 'width:80%', 'readonly'=>true]) }}
                                    @error('level')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('section', 'Section', ['class' => 'col-sm-2']) }}
                                <div class="col-sm-4">
                                {{ Form::text('section', @$subject_info->get_level->section, ['class' => 'form-control', 'id' => 'section','style' => 'width:80%', 'readonly'=>true]) }}
                                    @error('section')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <h3 class="m-4 card-title">Students : </h3> <br>
                            <div class="mt-4" id="attendance">
                                <div class="form-group row">
                                    @foreach ($student_info as $item)
                                    <label class="mt-2 col-sm-2">{{ $item->get_user->name }}</label>
                                    <div class="mt-2 btn-group btn-group-toggle col-sm-4" data-toggle="buttons">
                                        <label class="btn btn-default">
                                            <input type="radio" id="{{ $item->user_id }}_attendance" autocomplete="off" value="1"
                                                {{ @$attendance_info->attendance == 1 ? 'checked' : '' }}> Present
                                        </label>
                                        <label class="btn btn-default">
                                            <input type="radio" id="{{ $item->user_id }}_attendance" autocomplete="off" value="0"
                                                {{ @$attendance_info->attendance == 0 ? 'checked' : '' }}> Absent
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('', '', ['class' => 'col-sm-3']) }}
                        <div class="col-sm-9">
                            {{ Form::button("<i class='fa fa-plus'></i> Submit", ['class' => 'btn btn-success btn-flat', 'id'=>'submit']) }}
                            {{ Form::button("<i class='fas fa-ban'></i> Cancel Class", ['data-toggle'=>"modal",'data-target'=>"#holidayModal",'class' => 'btn btn-danger btn-flat', 'type' => 'reset']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="holidayModal" tabindex="-1" role="dialog" aria-labelledby="holidayModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="holidayModalLabel">Cancel Class</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="m-4">
                <div class="form-group">
                  <label for="holiday_reason">Class Cancellation Reason</label>
                  <input type="text" class="form-control" id="holiday_reason" placeholder="Enter Holiday Reason">
                </div>
                <div class="modal-footer">
                    <button id="holiday" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
          </div>
        </div>
      </div>
@endsection
