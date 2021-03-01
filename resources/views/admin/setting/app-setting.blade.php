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
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
        <script src="{{ asset('/custom/appsetting.js') }}"></script>
        <script>
            UpdateMeta("{{ @$site_detail->is_meta == 1 ? 'YES' : 'NO' }}");
            UpdateFavOg("{{ @$site_detail->is_favicon == 1 ? 'YES' : 'NO' }}");
            $('#lfm').filemanager('image');
            $('#lfm1').filemanager('image');
            $('#lfm2').filemanager('image');
            $('#lfm3').filemanager('image');
        </script>
    @endpush
@section('content')


    @if (@$site_detail)
        {{ Form::open(['url' => route('setting.update', @$site_detail->id), 'files' => true, 'class' => 'form-horizontal', 'name' => 'appsetting_form']) }}
        @method('put')
    @else
        {{ Form::open(['url' => route('setting.store'), 'files' => true, 'class' => 'form-horizontal', 'name' => 'appsetting_form']) }}
    @endif
    <div class="card-body">
        @csrf
        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill"
                            href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home"
                            aria-selected="true">Institution</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill"
                            href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile"
                            aria-selected="false">URLs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-meta-tab" data-toggle="pill"
                            href="#custom-tabs-three-meta" role="tab" aria-controls="custom-tabs-three-messages"
                            aria-selected="false">Meta</a>
                    </li>
                  
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel"
                        aria-labelledby="custom-tabs-three-home-tab">
                        <div class="form-group row">
                            {{ Form::label('name', 'Institution Name*', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::text('name', @$site_detail->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'University/College/School Name', 'required' => true]) }}
                                @error('name')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('address[0]', 'Primary Address*', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::text('address[0]', @$site_detail->address[0], ['class' => 'form-control', 'id' => 'address[0]', 'placeholder' => 'Primary Address', 'required' => true]) }}
                                @error('address[0]')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('address[1]', 'Secondary Address*', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::text('address[1]', @$site_detail->address[1], ['class' => 'form-control', 'id' => 'address[1]', 'placeholder' => 'Secondary Address', 'required' => true]) }}
                                @error('address[1]')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('email[0]', 'Contact Email*', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::text('email[0]', @$site_detail->email[0], ['class' => 'form-control', 'id' => 'email[0]', 'placeholder' => 'Contact Email', 'required' => true]) }}
                                @error('email[0]')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('email[1]', 'Email for Admissions*', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::text('email[1]', @$site_detail->email[1], ['class' => 'form-control', 'id' => 'email[1]', 'placeholder' => 'Email for Admissions', 'required' => true]) }}
                                @error('email[1]')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('phone_number', 'Primary Phone Number*', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-lg-6">
                                        {{ Form::number('contact_no[0][phone_number]', @$site_detail->phone[0]['phone_number'], ['class' => 'form-control', 'maxlength' => 10, 'id' => 'phone', 'placeholder' => 'Primary Phone Number ', 'required' => true]) }}
                                        @error('phone')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-lg-6">
                                        {!! Form::text('contact_no[0][contact_city]', @$site_detail->phone[0]['contact_city'], ['class' => 'form-control', 'placeholder' => 'Contact City Name ']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('phone_number_one', 'Alternative Phone Number (Optional)', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-lg-6">
                                        {{ Form::number('contact_no[1][phone_number]', @$site_detail->phone[1]['phone_number'], ['class' => 'form-control', 'maxlength' => 10, 'id' => 'phone', 'placeholder' => 'Alternative Phone Number']) }}
                                        @error('phone')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        {!! Form::text('contact_no[1][contact_city]', @$site_detail->phone[1]['contact_city'], ['class' => 'form-control', 'placeholder' => 'Contact City Name ']) !!}
                                        
                                    </div>
                                </div>
                               
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('logo') ? 'has-error' : '' }}">
                            {{ Form::label('logo', 'Institution Logo:*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                      <a id="lfm" data-input="logo" data-preview="holder" class="btn btn-primary text-white">
                                        <i class="fa fa-picture-o"></i> Choose
                                      </a>
                                    </span>
                                    <input id="logo" class="form-control" type="text" name="logo">
                                </div>
                                <div id="holder" style="
                                    border: 1px solid #ddd;
                                    border-radius: 4px;
                                    padding: 5px;
                                    width: 150px;
                                    margin-top:15px;">
                                </div>
                                @if (isset($site_detail->logo))
                                Old Logo: &nbsp; <img src="{{ @$site_detail->logo }}" alt="Couldn't load logo" 
                                class="img img-thumbail mt-2" style="width: 100px">
                                @endif
                                @error('logo')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('logo_light') ? 'has-error' : '' }}">
                            {{ Form::label('logo_light', 'Institution Light Logo:*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                      <a id="lfm3" data-input="logo_light" data-preview="holder" class="btn btn-primary text-white">
                                        <i class="fa fa-picture-o"></i> Choose
                                      </a>
                                    </span>
                                    <input id="logo_light" class="form-control" type="text" name="logo_light">
                                </div>
                                <div id="holder" style="
                                    border: 1px solid #ddd;
                                    border-radius: 4px;
                                    padding: 5px;
                                    width: 150px;
                                    margin-top:15px;">
                                </div>
                                @if (isset($site_detail->logo_light))
                                Old Logo_light: &nbsp; <img src="{{ @$site_detail->logo_light }}" alt="Couldn't load logo_light" 
                                class="img img-thumbail mt-2" style="width: 100px">
                                @endif
                                @error('logo_light')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-md-4">Favicon / OG Image</label>
                            <div class="btn-group btn-group-toggle col-md-3" data-toggle="buttons">
                                <label class="btn btn-default active">
                                    <input type="radio" name="is_favicon" autocomplete="off" value="YES"
                                        {{ @$site_detail->is_favicon == 1 ? 'checked' : '' }}> Yes
                                </label>
                                <label class="btn btn-default">
                                    <input type="radio" name="is_favicon" autocomplete="off" value="NO"
                                        {{ @$site_detail->is_favicon == 0 ? 'checked' : '' }}>No
                                </label>
                            </div>
                        </div>

                        <div id="fav_icon-details">
                        <div class="form-group row {{ $errors->has('favicon') ? 'has-error' : '' }}">    
                            {{ Form::label('favicon', 'Institution favicon:*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                      <a id="lfm1" data-input="favicon" data-preview="holder" class="btn btn-primary text-white">
                                        <i class="fa fa-picture-o"></i> Choose
                                      </a>
                                    </span>
                                    <input id="favicon" class="form-control" type="text" name="favicon">
                                </div>
                                <div id="holder" style="
                                    border: 1px solid #ddd;
                                    border-radius: 4px;
                                    padding: 5px;
                                    width: 150px;
                                    margin-top:15px;">
                                </div>
                                @if (isset($site_detail->favicon))
                                Old favicon: &nbsp; <img src="{{ @$site_detail->favicon }}" alt="Couldn't load favicon" 
                                class="img img-thumbail mt-2" style="width: 100px">
                                @endif
                                @error('favicon')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('og_image') ? 'has-error' : '' }}">    
                            {{ Form::label('og_image', 'Meta OG Image:*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                      <a id="lfm2" data-input="og_image" data-preview="holder" class="btn btn-primary text-white">
                                        <i class="fa fa-picture-o"></i> Choose
                                      </a>
                                    </span>
                                    <input id="og_image" class="form-control" type="text" name="og_image">
                                </div>
                                <div id="holder" style="
                                    border: 1px solid #ddd;
                                    border-radius: 4px;
                                    padding: 5px;
                                    width: 150px;
                                    margin-top:15px;">
                                </div>
                                @if (isset($site_detail->og_image))
                                Old Meta OG Image: &nbsp; <img src="{{ @$site_detail->og_image }}" alt="Couldn't load Old OG Image" 
                                class="img img-thumbail mt-2" style="width: 100px">
                                @endif
                                @error('og_image')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        </div>


                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel"
                        aria-labelledby="custom-tabs-three-profile-tab">
                         
                        <div class="form-group row">
                            {{ Form::label('facebook', 'Official Facebook', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::url('facebook', @$site_detail->facebook, ['class' => 'form-control', 'id' => 'facebook', 'placeholder' => 'Official Facebook Page URL', 'required' => true]) }}
                                @error('facebook')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('instagram', 'Official Instagram', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::url('instagram', @$site_detail->instagram, ['class' => 'form-control', 'id' => 'instagram', 'placeholder' => 'Official Instagram Page URL', 'required' => true]) }}
                                @error('instagram')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('youtube', 'Official Youtube', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::url('youtube', @$site_detail->youtube, ['class' => 'form-control', 'id' => 'youtube', 'placeholder' => 'Official Youtube Channel URL', 'required' => true]) }}
                                @error('youtube')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('linkedin', 'Official Linkedin', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::url('linkedin', @$site_detail->linkedin, ['class' => 'form-control', 'id' => 'linkedin', 'placeholder' => 'Official LinkedIn Profile URL', 'required' => true]) }}
                                @error('linkedin')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('skype', 'Official Skype', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::url('skype', @$site_detail->skype, ['class' => 'form-control', 'id' => 'skype', 'placeholder' => 'Official Skype URL', 'required' => true]) }}
                                @error('skype')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('twitter', 'Official Twitter', ['class' => 'col-sm-4 col-form-label']) }}
                            <div class="col-sm-6">
                                {{ Form::url('twitter', @$site_detail->twitter, ['class' => 'form-control', 'id' => 'twitter', 'placeholder' => 'Official Twitter URL', 'required' => true]) }}
                                @error('twitter')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-meta" role="tabpanel"
                        aria-labelledby="custom-tabs-three-meta-tab">


                        <div class="page-description-div">

                            
                        <div class="form-group row">
                            <label class="col-md-4">Use Meta Tag</label>
                            <div class="btn-group btn-group-toggle col-md-3" data-toggle="buttons">
                                <label class="btn btn-default active">
                                    <input type="radio" name="is_meta" autocomplete="off" value="YES"
                                        {{ @$site_detail->is_meta == 1 ? 'checked' : '' }}> Yes
                                </label>
                                <label class="btn btn-default">
                                    <input type="radio" name="is_meta" autocomplete="off" value="NO"
                                        {{ @$site_detail->is_meta == 0 ? 'checked' : '' }}> No
                                </label>
                            </div>
                        </div>

                        <div id="metatag-details">
                            <div class="form-group row">
                                {{ Form::label('meta[title]', 'Meta Title', ['class' => 'col-sm-4 col-form-label']) }}
                                <div class="col-sm-6">
                                    {{ Form::textarea('meta[title]', @$site_detail->meta['title'], ['class' => 'form-control', 'id' => 'meta[title]', 'placeholder' => 'Meta Title', 'required' => false, 'rows' => 1]) }}
                                    @error('meta[title]')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                {{ Form::label('meta[key]', 'Meta Keywords', ['class' => 'col-sm-4 col-form-label']) }}
                                <div class="col-sm-6">
                                    {{ Form::textarea('meta[key]', @$site_detail->meta['key'], ['class' => 'form-control', 'id' => 'meta[key]', 'placeholder' => 'Meta Keywords', 'required' => false, 'rows' => 2]) }}
                                    @error('meta[key]')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                {{ Form::label('meta[description]', 'Meta Description', ['class' => 'col-sm-4 col-form-label']) }}
                                <div class="col-sm-6">
                                    {{ Form::textarea('meta[description]', @$site_detail->meta['description'], ['class' => 'form-control', 'id' => '', 'placeholder' => 'Meta Description', 'required' => false, 'rows' => 5, 'style' => 'font-size:14px; text-align:justify']) }}
                                    @error('meta[description]')
                                        <span class="help-block error">{{ $message }}</span>
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
