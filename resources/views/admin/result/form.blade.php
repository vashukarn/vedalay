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
    <script>
        var failed_subjects = [];
        function calculateData() {
        failed_subjects = [];
        var marks_obtained = 0;
        var total_marks = 0;
        var failedsubjects = $('#failedsubjects');
            for (let i = 0; i < main_interation.length; i++) {
                marks_obtained += Number($('#marks_'+main_interation[i].id).val());
                total_marks += Number($('#full_'+main_interation[i].id).val());
                if((Number($('#marks_'+main_interation[i].id).val()) < Number($('#pass_'+main_interation[i].id).val()) || ($('#pass_'+main_interation[i].id).val() == 'F'))){
                    failed_subjects.push({id : main_interation[i].id, name: main_interation[i].name});
                }
            }
            failedsubjects.empty();
            failedsubjects.append("Failed Subjects: ");
            for (let index = 0; index < failed_subjects.length; index++) {
                failedsubjects.append(' - '+failed_subjects[index].name);
            }
            $('#marks_obtained').val(marks_obtained);
            $('#total_marks').val(total_marks);
            $('#percentage').val(Number(marks_obtained)/Number(main_interation.length));
            $('#sgpa').val(Number(marks_obtained)/(Number(main_interation.length)*9.5));
            failedsubjects.change();
        };
    $(document).ready(function() {
        $('#with').hide();
        $('#exam_id').select2({
            placeholder: "Please Select Exam",
        });
        $('#student_id').select2({
            placeholder: "Please Select Student",
        });
    });
    $('#status').change(function () {
        if($('#status').val() == 'WITHHELD'){
            $('#with').show();
        }
        else{
            $('#with').hide();
        }

    });

    $('#result_form').on('submit', function(e) {
        e.preventDefault();
        var temp = 1;
        var senddata = $('#result_form').serializeArray();
        var res = null;
        var tempo = [];
        for (let i = 0; i < main_interation.length; i++) {
            res = {
                subjectname : main_interation[i].name,
                subjectid : main_interation[i].id,
                marksobt : Number($('#marks_'+main_interation[i].id).val()),
                totmarks : Number($('#full_'+main_interation[i].id).val()),
                passmark : Number($('#pass_'+main_interation[i].id).val()),
                grade : $('#grade_'+main_interation[i].id).val(),
            };
            marks_obtained += Number($('#marks_'+main_interation[i].id).val());
            total_marks += Number($('#full_'+main_interation[i].id).val());
            tempo.push({ name : 'resultsubject_'+main_interation[i].id, value : res });
        }
        senddata.push({ name : 'result', value : tempo });
        senddata.push({ name : 'failedsubject', value : failed_subjects ?? null });
        console.log(senddata);

        $.ajax({
            type: 'POST',
            url: "/admin/addResult",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'data': senddata,
            },
            success: function (data) {
                console.log(data);
                if(data.length < 1){
                    alert("No Data Found");
                }
                else{
                    if(!data.marks){
                        // alert("Error has been occurred");
                    }
                    else{
                        alert("Result Added Successfully");
                        window.location = "{{ route('result.index') }}";
                    }
                }
            }
        });
        request_count = 0;
    });

    var main_interation = null;
    $('#level_id').change(function () {
        var level = $(this).val();
        var students = $('#student_id');
        var exams = $('#exam_id');
        var subjects = $('#subjects');
        exams.empty();
        students.empty();
        subjects.empty();
        $.ajax({
            type: 'POST',
            url: "/admin/getResultData",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'level': level,
            },
            success: function (data) {
                if(data.exams.length < 1){
                    alert("No Exams for this level");
                }
                if(data.students.length < 1){
                    alert("No Students found on this level");
                }
                else{
                    students.empty();
                    exams.empty();
                    subjects.empty();
                    for (var i = 0; i < data.students.length; i++) {
                        students.append('<option value=' + data.students[i].id + '>' + data.students[i].value + '</option>');
                    }
                    for (var i = 0; i < data.exams.length; i++) {
                        exams.append('<option value=' + data.exams[i].id + '>' + data.exams[i].value + '</option>');
                    }
                    main_interation = data.subjects;
                    subjects.append('<small>Check the boxes if student is passed in particular subject</small>');
                    for (var i = 0; i < data.subjects.length; i++) {
                        subjects.append('<div class="form-inline mt-2"><label class="col-sm-2" for="marks_'+data.subjects[i].id+'">'+data.subjects[i].name+' Marks</label><input id="marks_'+data.subjects[i].id+'" type="number" placeholder="Enter '+data.subjects[i].name+' Marks " class="form-control"><input type="number" id="pass_'+data.subjects[i].id+'" placeholder="Enter '+data.subjects[i].name+' Pass Marks " class="form-control ml-4"><input type="number" id="full_'+data.subjects[i].id+'" placeholder="Enter '+data.subjects[i].name+' Full Marks " class="form-control ml-4"><select class="form-control ml-4" id="grade_'+data.subjects[i].id+'"><option value="A+">A+</option><option value="A">A</option><option value="B+">B+</option><option value="B">B</option><option value="C+">C+</option><option value="C">C</option><option value="D">D</option><option value="F">F</option></select></div>');
                    }
                    subjects.append('<button onclick="calculateData();" type="button" id="calculate" class="float-center ml-4 mt-2 btn btn-primary">Calculate</button>');
                    students.change();
                    exams.change();
                    subjects.change();
                }
            }
        });
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

                            <div class="form-group row {{ $errors->has('level_id') ? 'has-error' : '' }}">
                                {{ Form::label('level_id', 'Select Level :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('level_id', @$levels , @$result_info->level_id, ['id' => 'level_id', 'placeholder' => 'Select Level', 'required' => true, 'class' => 'form-control select2', 'style' => 'width:80%; border-color:none']) }}
                                    @error('level_id')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

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

                            <div class="form-group row mt-4 {{ $errors->has('total_marks') ? 'has-error' : '' }}">
                                {{ Form::label('total_marks', 'Total Marks :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('total_marks',  @$result_info->$total_marks, ['id' => 'total_marks', 'placeholder' => 'Total Marks', 'class' => 'form-control', 'style' => 'width:80%; border-color:none']) }}
                                    @error('total_marks')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-4 {{ $errors->has('marks_obtained') ? 'has-error' : '' }}">
                                {{ Form::label('marks_obtained', 'Marks Obtained :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('marks_obtained',  @$result_info->$marks_obtained, ['id' => 'marks_obtained', 'placeholder' => 'Marks Obtained', 'class' => 'form-control', 'style' => 'width:80%; border-color:none']) }}
                                    @error('marks_obtained')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('percentage') ? 'has-error' : '' }}">
                                {{ Form::label('percentage', 'Percentage :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('percentage',  @$result_info->$percentage, ['id' => 'percentage', 'placeholder' => '%', 'class' => 'form-control', 'style' => 'width:80%; border-color:none']) }}
                                    @error('percentage')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('sgpa') ? 'has-error' : '' }}">
                                {{ Form::label('sgpa', 'SGPA :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('sgpa',  @$result_info->$sgpa, ['id' => 'sgpa', 'placeholder' => 'SGPA', 'class' => 'form-control', 'style' => 'width:80%; border-color:none']) }}
                                    @error('sgpa')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row mt-4 {{ $errors->has('grade') ? 'has-error' : '' }}">
                                {{ Form::label('grade', 'Select Grade :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('grade', ['A+' => 'A+', 'A' => 'A','B+' => 'B+','B' => 'B','C+' => 'C+','C' => 'C','D' => 'D','F' => 'F'], @$result_info->$grade, ['id' => 'grade', 'placeholder' => 'Select grade', 'class' => 'form-control', 'style' => 'width:80%; border-color:none']) }}
                                    @error('grade')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row mt-4 {{ $errors->has('status') ? 'has-error' : '' }}">
                                {{ Form::label('status', 'Select Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('status', ['PASS' => 'PASS', 'FAIL' => 'FAIL','WITHHELD' => 'WITHHELD'], @$result_info->$status, ['id' => 'status', 'placeholder' => 'Select Status', 'class' => 'form-control', 'style' => 'width:80%; border-color:none']) }}
                                    @error('status')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div id="with">
                                <div class="form-group row {{ $errors->has('withheld_reason') ? 'has-error' : '' }}">
                                    {{ Form::label('withheld_reason', 'Withheld Reason :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::text('withheld_reason',  @$result_info->$withheld_reason, ['id' => 'withheld_reason', 'placeholder' => 'Withheld Reason', 'class' => 'form-control', 'style' => 'width:80%; border-color:none']) }}
                                        @error('withheld_reason')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
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
