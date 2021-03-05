@extends('layouts.admin')
@section('title', $title)
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
{{-- <script src="{{ asset('/custom/assignment.js') }}"></script> --}}
<script>
    var counter = 0;
    function addReferences() {
        counter++;
        $('#reference').append('<div class="input-group input-group-sm mb-3"><input type="text" placeholder="Reference Link '+counter+' (Ex: https://www.youtube.com/watch?v=jMWrsRNveSI)" name="references['+counter+']" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm"></div>');
    }
</script>
@endpush
@section('content')
@include('admin.section.ckeditor')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($assignment_info))
                    {{ Form::open(['url' => route('assignment.update', $assignment_info->id), 'files' => true, 'class' => 'form', 'name' => 'assignment_form']) }}
                    @method('put')
                    @else
                    {{ Form::open(['url' => route('assignment.store'), 'files' => true, 'class' => 'form', 'name' => 'assignment_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">

                            {{ Form::hidden('subject_id', @$subject_info->id) }}

                            <div class="form-group row">
                                {{ Form::label('deadline', 'Deadline', ['class' => 'col-sm-2']) }}
                                <div class="col-sm-4">
                                {{ Form::date('deadline', @$subject_info->deadline, ['class' => 'form-control', 'id' => 'deadline','style' => 'width:80%']) }}
                                    @error('deadline')
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

                            

                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Assignment Title:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$noticeboard_info->title, ['class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                                {{ Form::label('description', 'Assignment Description:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::textarea('description', @$noticeboard_info->description, ['class' => 'form-control ckeditor', 'id' => 'my-editor', 'style' => 'width:80%']) }}
                                    @error('description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('references') ? 'has-error' : '' }}">
                                {{ Form::label('references', 'References :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::button("<i class='fa fa-plus-square'></i> Add Reference", ['onclick' => 'addReferences();','class' => 'btn btn-success btn-flat', 'id'=>'addreference']) }}
                                </div>
                            </div>

                            <div id="reference">

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
