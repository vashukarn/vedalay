@extends('layouts.admin')
@section('title', 'Update Profile')
@section('content')
    @push('scripts')
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
        <script>
            function pop(e) {
                var id = e.getAttribute("data-message");
                $.ajax({
                    type: 'POST',
                    url: "{{ route('changeTaskStatus') }}",
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'id': id,
                    },
                    // success: function(data) {
                    //     if (data.length < 1) {
                    //         alert("No Subjects found on this level");
                    //     } else {
                    //         subjects = data;
                    //         datecounter = 0;
                    //         dates = [];
                    //         subjects = null;
                    //         subjectselect = '';
                    //         diffcounter = 0;
                    //         for (let index = 0; index < data.length; index++) {
                    //             subjectselect += '<option value="' + data[index]['id'] + '">' + data[index][
                    //                 'title'
                    //             ] + '</option>';
                    //         }
                    //         console.log(subjectselect)
                    //     }
                    // }
                });
            }
            var today = new Date().toISOString().split('T')[0];
            document.getElementsByName("deadline")[0].setAttribute('min', today);

        </script>
    @endpush
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <section class="content-header mt-0 pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="img-fluid img-circle"
                                    src="@isset($student_info->image) {{ $student_info->image }} @else {{ asset('img/AdminLTELogo.png') }} @endisset"
                                    style="width:80px" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>

                            <p class="text-muted text-center">{{ request()->user()->roles->first()->name }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{ @$user_info->email }}</a>
                                </li>
                                @hasrole('Super Admin')
                                <li class="list-group-item">
                                    <b>Session Id:</b> <a class="float-right">#{{ GETAPPSETTING()['session'] }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Marks Scheme:</b> <a class="float-right">{{ GETAPPSETTING()['marks_scheme'] }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Razorpay Status:</b> <a
                                        class="float-right">{{ GETAPPSETTING()['razorpay_payment'] }}</a>
                                </li>
                                @endhasrole
                                @hasrole('Student')
                                <li class="list-group-item">
                                    <b>Level/Class</b> <a class="float-right">{{ @$levels[$student_info->level_id] }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Date of Birth</b> <a
                                        class="float-right">{{ ReadableDate(@$student_info->dob, 'ymd') }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Gender</b> <a class="float-right">{{ @$student_info->gender }}</a>
                                </li>
                                @endhasrole
                                @hasrole('Teacher')
                                <li class="list-group-item">
                                    <b>Short Name</b> <a class="float-right">{{ @$teacher_info->short_name }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Joining Date</b> <a
                                        class="float-right">{{ ReadableDate(@$teacher_info->joining_date, 'ymd') }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Gender</b> <a class="float-right">{{ @$teacher_info->gender }}</a>
                                </li>
                                @endhasrole
                            </ul>
                            {{-- <a href="#" class="btn btn-primary btn-block"><b>View More</b></a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ion ion-clipboard mr-1"></i>
                                To Do List
                            </h3>

                            <div class="card-tools">
                                <div class="row">
                                    <div class="col-md-8">
                                        <span class="pagination-sm m-0 float-right">{{ $tasks->links() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <ul class="todo-list" data-widget="todo-list">
                                @foreach ($tasks as $item)
                                    <li>
                                        <!-- checkbox -->
                                        <?php
                                        $now = time(); // or your date as well
                                        $your_date = strtotime($item->deadline);
                                        $datediff = $now - $your_date;
                                        $rem = round($datediff / (60 * 60 * 24)) + 1;
                                        ?>
                                        <div class="icheck-primary d-inline ml-2">
                                            <input type="checkbox" data-message="{{ $item->id }}" onclick="pop(this)"
                                                id="todocheck_{{ $item->id }}"
                                                {{ $item->completion == 'INCOMPLETE' ? '' : 'checked' }}>
                                            <label for="todocheck_{{ $item->id }}"></label>
                                        </div>
                                        <!-- todo text -->
                                        <span class="text">{{ $item->description }}</span>
                                        <!-- Emphasis label -->
                                        <small class="badge @if ($rem < 2) badge-danger @elseif($rem < 5) badge-warning @elseif($rem < 10) badge-primary @else badge-success @endif">
                                            <i class="far fa-clock"></i> &nbsp;
                                            @if ($rem > 365) {{ $rem / 365 }} year
                                            @else {{ $rem }} days @endif
                                        </small>
                                        <!-- General tools such as edit or delete-->
                                        <div class="tools">
                                            {{-- <i class="fas fa-edit"></i> --}}
                                            {{ Form::open(['method' => 'DELETE', 'route' => ['task.destroy', $item->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete this task?")']) }}
                                            {{ Form::button('<i class="fas fa-trash-alt"></i>', ['class' => 'btn btn-danger btn-sm btn-flat', 'type' => 'submit', 'title' => 'Delete Task ']) }}
                                            {{ Form::close() }}
                                            {{-- <i class="fas fa-trash"></i> --}}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <button type="button" class="btn btn-info float-right" data-toggle="modal"
                                data-target="#todolist"><i class="fas fa-plus"></i> Add item</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        </div>
        </div>
    </section>


    {{-- To Do List Modal --}}
    <div class="modal fade" id="todolist" tabindex="-1" role="dialog" aria-labelledby="todolistLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="todolistLabel">Add New Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{ Form::open(['url' => route('task.store'), 'class' => 'form', 'name' => 'task_form']) }}
                <div class="modal-body">
                    <div class="form-group">
                        {{ Form::label('description', 'Description') }}
                        {{ Form::text('description', null, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('deadline', 'Deadline Date') }}
                        {{ Form::date('deadline', null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{ Form::button("<i class='fa fa-paper-plane'></i> Submit", ['class' => 'btn btn-success btn-flat', 'type' => 'submit']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
