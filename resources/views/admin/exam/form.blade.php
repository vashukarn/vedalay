@extends('layouts.admin')
@section('title', $title)
    @push('scripts')
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
        <script>
            var datecounter = 0;
            var dates = [];
            var subjects = null;
            var subjectselect = '';
            var diffcounter = 0;
            $(document).ready(function() {
                $('#session_id').select2({
                    placeholder: "Please Select Session",
                    allowClear: true
                });
                $('#level_id').select2({
                    placeholder: "Please Select Level",
                    allowClear: true
                });
            });
            $('#level_id').change(function() {
                $('#table_row').empty();
                $('#table_head').empty();
                $('#table_head').append('<th>Date</th>');
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
                            datecounter = 0;
                            dates = [];
                            subjects = null;
                            subjectselect = '';
                            diffcounter = 0;
                            for (let index = 0; index < data.length; index++) {
                                subjectselect += '<option value="' + data[index]['id'] + '">' + data[index][
                                    'title'
                                ] + '</option>';
                            }
                            console.log(subjectselect)
                        }
                    }
                });
            });
            $('#shiftbtn').click(function() {
                if (!$('#exam_date').val()) {
                    alert("Please Add Date First");
                } else {
                    if (!$('#start_time').val()) {
                        alert("Please Enter Start Time Properly");
                    } else if (!$('#end_time').val()) {
                        alert("Please Enter End Time Properly");
                    } else {
                        $('#table_row').append('<tr>');
                        $('#table_row').append('<td><input type="text" class="form-control" value="' + $('#start_time')
                            .val() + ' - ' + $('#end_time').val() + '" readonly></td>');
                        dates.forEach(element => {
                            $('#table_row').append('<td><select name="exam_routine[' + $('#' + element).val() +
                                '][' + $('#start_time').val() + ' - ' + $('#end_time').val() +
                                '][subject]" class="form-control" id="diff_' + diffcounter + '">');
                            $('#diff_' + diffcounter).append('<option value="">Select Subject</option>');
                            $('#diff_' + diffcounter).append(subjectselect);
                            diffcounter++;
                            $('#table_row').append('</select></td>');
                        });
                        $('#table_row').append('</tr>');
                    }
                }
            });
            $('#datebtn').click(function() {
                if (!$('#exam_date').val()) {
                    alert("Please Enter Date");
                } else {
                    document.getElementById("table_head").innerHTML += '<th><input id="date_' + datecounter +
                        '" type="text" class="form-control" value="' + $('#exam_date').val() + '" readonly></th>';
                    dates.push('date_' + datecounter);
                    datecounter++;
                }
            });

        </script>

    @endpush
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ @$title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('exam.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($exam_info))
                        {{ Form::open(['url' => route('exam.update', $exam_info->id), 'files' => true, 'class' => 'form', 'name' => 'exam_form', 'enctype' => 'multipart/form-data']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('exam.store'), 'files' => true, 'class' => 'form', 'id' => 'exam_form', 'name' => 'exam_form', 'enctype' => 'multipart/form-data']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">

                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Title :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$exam_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Title', 'style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('session_id') ? 'has-error' : '' }}">
                                {{ Form::label('session_id', 'Session :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('session_id', @$sessions, @$session_id, ['id' => 'session_id', 'class' => 'form-control select2', 'style' => 'width:80%; border-color:none']) }}
                                    @error('session_id')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('level_id') ? 'has-error' : '' }}">
                                {{ Form::label('level_id', 'Level :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('level_id', @$levels, null, ['id' => 'level_id', 'class' => 'form-control select2', 'placeholder' => 'Select Level', 'style' => 'width:80%; border-color:none']) }}
                                    @error('level_id')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('exam_date') ? 'has-error' : '' }}">
                                {{ Form::label('exam_date', 'Date of Exam :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-4">
                                    {{ Form::date('exam_date', @$exam_info->exam_date, ['class' => 'form-control', 'id' => 'exam_date', 'style' => 'width:80%']) }}
                                    @error('exam_date')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::button("<i class='fa fa-plus'></i> &nbsp; Add Date", ['id' => 'datebtn', 'class' => 'btn btn-primary btn-flat']) }}
                            </div>

                            <div class="form-group row {{ $errors->has('start_time') ? 'has-error' : '' }}">
                                {{ Form::label('start_time', 'Start Time :*', ['class' => 'col-sm-2']) }}
                                <div class="col-sm-2">
                                    {{ Form::time('start_time', null, ['id' => 'start_time', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('start_time')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('end_time', 'End Time :*', ['class' => 'col-sm-2']) }}
                                <div class="col-sm-2">
                                    {{ Form::time('end_time', null, ['id' => 'end_time', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('end_time')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::button("<i class='fa fa-plus'></i> &nbsp; Add Shift", ['id' => 'shiftbtn', 'class' => 'btn btn-primary btn-flat']) }}
                            </div>
                            <div style="overflow-x: scroll" class="card-body card-format">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr id="table_head">
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_row">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('', '', ['class' => 'col-sm-3']) }}
                        <div class="col-sm-9">
                            {{ Form::button("<i class='fa fa-paper-plane'></i> Submit", ['class' => 'btn btn-success btn-flat', 'type' => 'submit']) }}
                            {{ Form::button("<i class='fas fa-sync-alt'></i> Reset", ['class' => 'btn btn-danger btn-flat', 'type' => 'reset']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
