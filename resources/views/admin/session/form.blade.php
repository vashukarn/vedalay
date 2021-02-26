@extends('layouts.admin')
@section('title', $title)
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
{{-- <script src="{{ asset('/custom/session.js') }}"></script> --}}
<script>
$(function() {
    $( "#datepicker" ).datepicker({dateFormat: 'yy'});
});
</script>​
@endpush
@push('styles')
<style>
    .datepicker {
   display: none;
}
</style>
@endpush
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ @$title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('session.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($session_info))
                        {{ Form::open(['url' => route('session.update', $session_info->id), 'files' => true, 'class' => 'form', 'name' => 'session_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('session.store'), 'files' => true, 'class' => 'form', 'name' => 'session_form']) }}
                    @endif
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">

                            <div class="form-group row {{ $errors->has('start_year') ? 'has-error' : '' }}">
                                {{ Form::label('start_year', 'Start Year :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::date('start_year', @$session_info->start_year, ['class' => 'form-control', 'id' => 'start_year','style' => 'width:80%']) }}
                                    @error('start_year')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('end_year') ? 'has-error' : '' }}">
                                {{ Form::label('end_year', 'End Year :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::date('end_year', @$session_info->end_year, ['class' => 'form-control', 'id' => 'end_year','style' => 'width:80%']) }}
                                    @error('end_year')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
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
