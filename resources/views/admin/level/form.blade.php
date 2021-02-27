@extends('layouts.admin')
@section('title', $title)
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
{{-- <script src="{{ asset('/custom/level.js') }}"></script> --}}
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ @$title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('level.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($level_info))
                        {{ Form::open(['url' => route('level.update', $level_info->id), 'files' => true, 'class' => 'form', 'name' => 'level_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('level.store'), 'files' => true, 'class' => 'form', 'name' => 'level_form']) }}
                    @endif
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">

                            <div class="form-group row {{ $errors->has('standard') ? 'has-error' : '' }}">
                                {{ Form::label('standard', 'Standard :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('standard', @$level_info->standard, ['placeholder'=> 'Enter Level Name / Standard Here','class' => 'form-control', 'id' => 'standard','style' => 'width:80%']) }}
                                    @error('standard')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('section') ? 'has-error' : '' }}">
                                {{ Form::label('section', 'Section :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('section', @$level_info->section, ['placeholder'=> 'Enter Level Section Here','class' => 'form-control', 'id' => 'section','style' => 'width:80%']) }}
                                    @error('section')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                    <small>Leave blank if you do not want to add section</small>
                                </div>
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
