@extends('layouts.admin')
@section('title', 'Basic Site Settings')
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
         
    @endpush
@section('content')

    {{ Form::open(['url' => route('updateWebsiteContent'), 'class' => 'form-horizontal', 'name' => 'appsetting_form']) }}

    <div class="card-body">
        @csrf
        <div class="card card-primary card-outline card-tabs">
            
            <div class="card-body">
                {{-- dd(\Session::get('website_content_item')) --}}
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel"
                        aria-labelledby="custom-tabs-three-home-tab">
                        <div class="form-group row">
                            <label class="col-md-12">Select required Item for the website</label>
                            <div class="col-lg-12">
                                <div class="form-group row {{ $errors->has('permission') ? 'has-error' :'' }}">
                                    {{Form::label('content','Web Content:',['class'=>'col-sm-3'])}}
                                    <div class="col-sm-9">
                                       
                                        <div>
                                            {{Form::checkbox('select_all','',false,['id'=>'select_all'])}}
                                            <label for="">Select All</label>
                                        </div>
                                        <div class="row">
                                            @foreach(website_content_item as $key=>$value)
                                   
                                                <div class="col-md-3">
                                                    <div>
                                            
                                                        <strong class="d-inline-block m-b-5">Manage {{ucfirst($value['value'])}}:</strong>
                                              
                                                        
                                                    </div>
                                                  <div>
                                                    <label>{{Form::checkbox('content[]', $value['value'], @in_array($value['value'], @$website_content_item) ? true : false, ['class' => 'name']) }} {{ucfirst($value['value'])}}</label>
                                                  </div>
                                              </div>
                                            @endforeach
                                        </div>
                                        @error('permission')
                                        <span class="help-block error">{{$message}}</span>
                                        @enderror
                                     
                                    </div>
                                </div>
                               
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        {{ Form::button("<i class='fa fa-paper-plane'></i> Save Seting", ['class' => 'btn btn-success', 'type' => 'submit']) }}
        <a href="{{ route('dashboard.index') }}" class="btn btn-primary float-right"><i class="fa fa-list"></i>
            Dashboard</a>
    </div>
    {{ Form::close() }}

@endsection
