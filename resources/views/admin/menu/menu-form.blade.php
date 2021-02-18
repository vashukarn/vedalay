@extends('layouts.admin')
@section('title', @$title)
@push('scripts')
<script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
<script src="{{ asset('/custom/menu.js') }}">
</script>
@endpush
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ @$title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('menu.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
              <div class="card-body">
                  @if(isset($data))
                  {{Form::open(['url'=>route('menu.update',$data->id),'files'=>true,'class'=>'form', 'name' => 'menu_form'])}}
                  @method('put')
                  @else
                      {{Form::open(['url'=>route('menu.store'),'files'=>true,'class'=>'form'])}}
                  @endif
                  <div class="form-group row {{ $errors->has('slug') ? 'has-error' : '' }}">
                    {{ Form::label('slug', 'Content Type :*', ['class' => 'col-sm-3']) }}
                    <div class="col-sm-9">
                        {{ Form::select('slug', CONTENT_TYPE,  @$data->slug, ['id' => 'slug', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                        @error('slug')
                        <span class="help-block error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                  <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' :'' }}">
                      {{Form::label('publish_status','Menu Publish Status:*',['class'=>'col-sm-3'])}}
                      <div class="col-sm-9">
                          {{Form::select('publish_status',['0'=>'In-Active','1'=>'Active'],@$data->publish_status,['id'=>'publish_status','required'=>true,'class'=>'form-control','style'=>'width:80%'])}}
                          @error('publish_status')
                          <span class="help-block error">{{$message}}</span>
                          @enderror
                      </div>
                  </div>


                  <div class="form-group row">
                      {{Form::label('','',['class'=>'col-sm-3'])}}
                      <div class="col-sm-9">
                          {{Form::button("<i class='fa fa-paper-plane'></i> Submit",['class'=>'btn btn-success btn-flat','type'=>'submit'])}}
                          {{Form::button("<i class='fas fa-sync-alt'></i> Reset",['class'=>'btn btn-danger btn-flat','type'=>'reset'])}}
                      </div>
                  </div>
                  {{Form::close()}}
              </div>
            </div>
        </div>
    </section>
@endsection