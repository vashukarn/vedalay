@extends('layouts.admin')
@section('title', $title)
    @push('scripts')
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
         {{-- <script src="{{ asset('/custom/result.js') }}"></script> --}}
        <script>
            var failed_subjects = [];
            $(document).ready(function() {
                $('#gper').val('');
                $('#level_id').val('');
                $('#percentagediv').hide();
                $('#gradediv').hide();
                $('#forms').hide();
                $('#with').hide();
                $('#exam_id').select2({
                    placeholder: "Please Select Exam",
                    allowClear: true
                });
                $('#student_id').select2({
                    placeholder: "Please Select Student",
                    allowClear: true
                });
                $('#backlogs').select2({
                    placeholder: "Failed Subjects",
                    id: "failed_subs",
                    allowClear: true
                });
            });

            function calculateData() {
                $("#backlogs").empty();
                failed_subjects = [];
                var sgpa = 0;
                if ($('#gper').val() == 'Grade') {
                    for (let i = 0; i < main_interation.length; i++) {
                        sgpa += Number($('[name="marks[' + main_interation[i].id + '][credits]"]').val());
                        if ($('[name="marks[' + main_interation[i].id + '][grade]"]').val() == 'F') {
                            $("#backlogs").append('<option selected="selected" value="' + main_interation[i].id + '">' +
                                main_interation[i].value + '</option>');
                            failed_subjects.push({
                                id: main_interation[i].id,
                                value: main_interation[i].value
                            });
                        }
                    }
                    sgpa = Number(sgpa) / Number(main_interation.length);
                    $('#sgpa').val(sgpa.toFixed(2));
                    if (failed_subjects.length > 0) {
                        $('#status').val('FAIL');
                        $('#grade').val('F');
                    } else {
                        $('#status').val('');
                        $('#grade').val('');
                    }
                } else if ($('#gper').val() == 'Percentage') {
                    var total = 0;
                    var obtained = 0;
                    var percentage = 0;
                    for (let i = 0; i < main_interation.length; i++) {
                        total += Number($('[name="marks[' + main_interation[i].id + '][full]"]').val());
                        obtained += Number($('[name="marks[' + main_interation[i].id + '][obtained]"]').val());
                        if ($('[name="marks[' + main_interation[i].id + '][pass]"]').val() > $('[name="marks[' +
                                main_interation[i].id + '][obtained]"]').val()) {
                            $("#backlogs").append('<option selected="selected" value="' + main_interation[i].id + '">' +
                                main_interation[i].value + '</option>');
                            failed_subjects.push({
                                id: main_interation[i].id,
                                value: main_interation[i].value
                            });
                        }
                    }
                    percentage = (Number(obtained) * 100) / Number(total);
                    $('#marks_obtained').val(obtained.toFixed(2));
                    $('#total_marks').val(total.toFixed(2));
                    $('#percentage').val(percentage.toFixed(2));
                    if (failed_subjects.length > 0) {
                        $('#status').val('FAIL');
                        $('#grade').val('F');
                    } else {
                        $('#status').val('');
                        $('#grade').val('');
                    }
                } else {
                    alert('Please select marks schema first');
                }
            };
            $('#status').change(function() {
                if ($('#status').val() == 'WITHHELD') {
                    $('#with').show();
                } else {
                    $('#with').hide();
                }
            });
            $('#gper').change(function() {
                $('#forms').hide();
                $('#level_id').val('');
                if ($('#gper').val() == 'Grade') {
                    $('#gradediv').show();
                    $('#percentagediv').hide();
                } else if ($('#gper').val() == 'Percentage') {
                    $('#gradediv').hide();
                    $('#percentagediv').show();
                } else {
                    $('#percentagediv').hide();
                    $('#gradediv').hide();
                }
            });

            var main_interation = null;
            $('#exam_id').change(function() {
                var exam_id = $(this).val();
                if (exam_id != '') {
                    var subjects = $('#subjects');
                    subjects.empty();
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('getSubjectExam') }}",
                        data: {
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            'exam_id': exam_id,
                        },
                        success: function(data) {
                            if (data.length < 1) {
                                alert("No subjects in this exam");
                            } else {
                                console.log(subjects);
                                subjects.empty();
                                main_interation = data.subjects;
                                for (var i = 0; i < data.subjects.length; i++) {
                                    subjects.append(
                                        '<div id="temp' + i +
                                        '" class="col-sm-12 form-group row mt-4"><label class="col-sm-2 mt-2">' +
                                        data.subjects[i].value + ' :</label>');
                                    if ($('#gper').val() != 'Grade') {
                                        $('#temp' + i).append(
                                            '<input type="number" name="marks[' + data.subjects[i].id +
                                            '][obtained]" placeholder="Marks Obtained" class="form-control col-sm-3 mt-2"><input type="number" name="marks[' +
                                            data.subjects[i].id +
                                            '][pass]" placeholder="Pass Marks" class="form-control col-sm-3 ml-2 mt-2"><input type="number" name="marks[' +
                                            data.subjects[i].id +
                                            '][full]" placeholder="Full Marks" class="form-control col-sm-3 ml-2 mt-2">'
                                        );
                                    } else {
                                        $('#temp' + i).append(
                                            '<input type="number" name="marks[' + data.subjects[i].id +
                                            '][credits]" placeholder="Credits Obtained" class="form-control col-sm-3 mt-2"><select name="marks[' +
                                            data.subjects[i].id +
                                            '][grade]" class="form-control ml-4 col-sm-3 mt-2"><option value="A+">A+</option><option value="A">A</option><option value="B+">B+</option><option value="B">B</option><option value="C+">C+</option><option value="C">C</option><option value="D">D</option><option value="F">F</option></select>'
                                        );
                                    }
                                    subjects.append('</div>');
                                }
                                subjects.append(
                                    '<button onclick="calculateData();" type="button" class="float-center m-2 btn btn-primary"><i class="fa fa-calculator"></i> Calculate</button>'
                                );
                                subjects.change();
                            }
                        }
                    });
                }
            });

            $('#level_id').change(function() {
                $('#forms').hide();
                var level = $(this).val();
                if (level != '') {
                    var students = $('#student_id');
                    var exams = $('#exam_id');
                    exams.empty();
                    students.empty();
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('getResultData') }}",
                        data: {
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            'level': level,
                        },
                        success: function(data) {
                            if (data.exams.length < 1) {
                                alert("No Exams for this level");
                            } else {
                                if (data.students.length < 1) {
                                    alert("No Students found on this level");
                                } else {
                                    $('#forms').show();
                                    students.empty();
                                    exams.empty();
                                    for (var i = 0; i < data.students.length; i++) {
                                        students.append('<option value=' + data.students[i].id + '>' + data
                                            .students[i].value + '</option>');
                                    }
                                    for (var i = 0; i < data.exams.length; i++) {
                                        exams.append('<option value=' + data.exams[i].id + '>' + data.exams[
                                                i]
                                            .value + '</option>');
                                    }
                                    students.change();
                                    exams.change();
                                }
                            }
                        }
                    });
                } else {
                    $('#forms').hide();
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
                        <a href="{{ route('result.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($result_info))
                        {{ Form::open(['url' => route('result.update', $result_info->id), 'files' => true, 'class' => 'form', 'name' => 'result_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('result.store'), 'files' => true, 'class' => 'form', 'id' => 'result_form', 'name' => 'result_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">

                            <div class="form-group row {{ $errors->has('gper') ? 'has-error' : '' }}">
                                {{ Form::label('gper', 'Select Schema :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('gper', ['Grade' => 'Grade', 'Percentage' => 'Percentage'], @$result_info->gper, ['id' => 'gper', 'placeholder' => 'Select Schema', 'class' => 'form-control select2', 'style' => 'width:80%; border-color:none']) }}
                                    @error('gper')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('level_id') ? 'has-error' : '' }}">
                                {{ Form::label('level_id', 'Select Level :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('level_id', @$levels, @$result_info->level_id, ['id' => 'level_id', 'placeholder' => 'Select Level', 'class' => 'form-control select2', 'style' => 'width:80%; border-color:none']) }}
                                    @error('level_id')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div id="forms">
                                <div class="form-group row {{ $errors->has('exam_id') ? 'has-error' : '' }}">
                                    {{ Form::label('exam_id', 'Select Exam :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::select('exam_id', [], @$result_info->$exam_id, ['id' => 'exam_id', 'placeholder' => 'Select Students', 'class' => 'form-control select2', 'style' => 'width:80%; border-color:none']) }}
                                        @error('exam_id')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('student_id') ? 'has-error' : '' }}">
                                    {{ Form::label('student_id', 'Select Student :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::select('student_id', [], @$result_info->$student_id, ['id' => 'student_id', 'placeholder' => 'Select Students', 'class' => 'form-control select2', 'style' => 'width:80%; border-color:none']) }}
                                        @error('student_id')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="mt-3" id="subjects">

                                </div>
                                <div class="mt-3" id="failedsubjects">

                                </div>

                                <div class="form-group row {{ $errors->has('backlogs') ? 'has-error' : '' }}">
                                    {{ Form::label('backlogs', 'Failed Subjects :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        <select id="backlogs" style="width:80%; border-color:none" multiple
                                            class="form-control select2" name="backlogs[]">
                                            <option value="">Failed Subjects</option>
                                        </select>
                                        @error('backlogs')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div id="gradediv">
                                    <div class="form-group row {{ $errors->has('sgpa') ? 'has-error' : '' }}">
                                        {{ Form::label('sgpa', 'SGPA :*', ['class' => 'col-sm-3']) }}
                                        <div class="col-sm-9">
                                            {{ Form::text('sgpa', @$result_info->$sgpa, ['id' => 'sgpa', 'placeholder' => 'SGPA', 'class' => 'form-control', 'style' => 'width:80%; border-color:none']) }}
                                            @error('sgpa')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mt-4 {{ $errors->has('grade') ? 'has-error' : '' }}">
                                        {{ Form::label('grade', 'Select Grade :*', ['class' => 'col-sm-3']) }}
                                        <div class="col-sm-9">
                                            {{ Form::select('grade', ['A+' => 'A+', 'A' => 'A', 'B+' => 'B+', 'B' => 'B', 'C+' => 'C+', 'C' => 'C', 'D' => 'D', 'F' => 'F'], @$result_info->$grade, ['id' => 'grade', 'placeholder' => 'Select grade', 'class' => 'form-control', 'style' => 'width:80%; border-color:none']) }}
                                            @error('grade')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div id="percentagediv">
                                    <div
                                        class="form-group row mt-4 {{ $errors->has('total_marks') ? 'has-error' : '' }}">
                                        {{ Form::label('total_marks', 'Total Marks :*', ['class' => 'col-sm-3']) }}
                                        <div class="col-sm-9">
                                            {{ Form::text('total_marks', @$result_info->$total_marks, ['id' => 'total_marks', 'placeholder' => 'Total Marks', 'class' => 'form-control', 'style' => 'width:80%; border-color:none']) }}
                                            @error('total_marks')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div
                                        class="form-group row mt-4 {{ $errors->has('marks_obtained') ? 'has-error' : '' }}">
                                        {{ Form::label('marks_obtained', 'Total Marks Obtained :*', ['class' => 'col-sm-3']) }}
                                        <div class="col-sm-9">
                                            {{ Form::text('marks_obtained', @$result_info->$marks_obtained, ['id' => 'marks_obtained', 'placeholder' => 'Marks Obtained', 'class' => 'form-control', 'style' => 'width:80%; border-color:none']) }}
                                            @error('marks_obtained')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('percentage') ? 'has-error' : '' }}">
                                        {{ Form::label('percentage', 'Percentage :*', ['class' => 'col-sm-3']) }}
                                        <div class="col-sm-9">
                                            {{ Form::text('percentage', @$result_info->$percentage, ['id' => 'percentage', 'placeholder' => '%', 'class' => 'form-control', 'style' => 'width:80%; border-color:none']) }}
                                            @error('percentage')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row mt-4 {{ $errors->has('status') ? 'has-error' : '' }}">
                                    {{ Form::label('status', 'Select Status :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::select('status', ['PASS' => 'PASS', 'FAIL' => 'FAIL', 'WITHHELD' => 'WITHHELD'], @$result_info->$status, ['id' => 'status', 'placeholder' => 'Select Status', 'class' => 'form-control', 'style' => 'width:80%; border-color:none']) }}
                                        @error('status')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div id="with">
                                    <div class="form-group row {{ $errors->has('withheld_reason') ? 'has-error' : '' }}">
                                        {{ Form::label('withheld_reason', 'Withheld Reason :*', ['class' => 'col-sm-3']) }}
                                        <div class="col-sm-9">
                                            {{ Form::text('withheld_reason', @$result_info->$withheld_reason, ['id' => 'withheld_reason', 'placeholder' => 'Withheld Reason', 'class' => 'form-control', 'style' => 'width:80%; border-color:none']) }}
                                            @error('withheld_reason')
                                                <span class="help-block error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group row mt-4">
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
