@extends('layouts.admin')
@section('title', 'Home Page Data')
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
        <script src="{{ asset('/custom/apphomepage.js') }}"></script>
        <script>
            $('#lfm').filemanager('image');
            $('#lfm1').filemanager('image');
            $('#lfm2').filemanager('image');
            $('#lfm3').filemanager('image');
            $('#lfm4').filemanager('image');
            $('#lfm5').filemanager('image');
            $('#lfm6').filemanager('image');
            $('#lfm7').filemanager('image');
            $('#lfm8').filemanager('image');
            $('#lfm9').filemanager('image');
            $('#lfm10').filemanager('image');
            $('#lfm11').filemanager('image');
            $('#lfm12').filemanager('image');
            $('#lfm13').filemanager('image');
            $('#lfm14').filemanager('image');
        </script>
    @endpush
@section('content')


    @if (@$page_detail)
        {{ Form::open(['url' => route('homepage.update', @$page_detail->id), 'files' => true, 'class' => 'form-horizontal', 'name' => 'homepage_form']) }}
        @method('put')
    @else
        {{ Form::open(['url' => route('homepage.store'), 'files' => true, 'class' => 'form-horizontal', 'name' => 'homepage_form']) }}
    @endif
    <div class="card-body">
        @csrf
        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-topics-tab" data-toggle="pill"
                            href="#custom-tabs-three-topics" role="tab" aria-controls="custom-tabs-three-topics"
                            aria-selected="true">Top Topics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-jumbotron-tab" data-toggle="pill"
                            href="#custom-tabs-three-jumbotron" role="tab" aria-controls="custom-tabs-three-jumbotron"
                            aria-selected="false">Apply Admission</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-about-tab" data-toggle="pill"
                            href="#custom-tabs-three-about" role="tab" aria-controls="custom-tabs-three-about"
                            aria-selected="false">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-features-tab" data-toggle="pill"
                            href="#custom-tabs-three-features" role="tab" aria-controls="custom-tabs-three-features"
                            aria-selected="false">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-logo-tab" data-toggle="pill"
                            href="#custom-tabs-three-logo" role="tab" aria-controls="custom-tabs-three-logo"
                            aria-selected="false">Logos</a>
                    </li>
                  
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-three-topics" role="tabpanel"
                        aria-labelledby="custom-tabs-three-topics-tab">

                        <div class="form-group row">
                            {{ Form::label('topTopics[title][0]', ' Title:', ['class' => 'col-sm-1 col-form-label']) }}
                            {{ Form::text('topTopics[title][0]', @$page_detail->topTopics['title'][0], ['class' => 'col-sm-2 form-control', 'id' => 'topTopics[title][0]']) }}

                            {{ Form::label('topTopics[sub_title][0]', 'Sub Title:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                            {{ Form::text('topTopics[sub_title][0]', @$page_detail->topTopics['sub_title'][0], ['class' => 'col-sm-2 form-control', 'id' => 'topTopics[sub_title][0]']) }}

                            {{ Form::label('topTopics[logo][0]', 'Icon:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                            <div class="col-sm-3">
                                <div class="input-group input-group-btn">
                                    <a id="lfm" data-input="image" data-preview="holder" class="btn btn-primary text-white">Choose</a>
                                    <input id="image" class="form-control" type="text" name="topTopics[logo][0]">
                                </div>
                                <div id="holder" style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px; margin-top:15px;">
                                </div>
                                @if (isset($page_detail->topTopics['logo'][0]))
                                Old Logo: &nbsp; <img src="{{ @$page_detail->topTopics['logo'][0] }}" alt="Couldn't load logo" 
                                class="img img-thumbail mt-2" style="width: 100px">
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('topTopics[title][1]', ' Title:', ['class' => 'col-sm-1 col-form-label']) }}
                            {{ Form::text('topTopics[title][1]', @$page_detail->topTopics['title'][1], ['class' => 'col-sm-2 form-control', 'id' => 'topTopics[title][1]']) }}

                            {{ Form::label('topTopics[sub_title][1]', 'Sub Title:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                            {{ Form::text('topTopics[sub_title][1]', @$page_detail->topTopics['sub_title'][1], ['class' => 'col-sm-2 form-control', 'id' => 'topTopics[sub_title][1]']) }}

                            {{ Form::label('topTopics[logo][1]', 'Icon:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                            <div class="col-sm-3">
                                <div class="input-group input-group-btn">
                                    <a id="lfm1" data-input="image1" data-preview="holder1" class="btn btn-primary text-white">Choose</a>
                                    <input id="image1" class="form-control" type="text" name="topTopics[logo][1]">
                                </div>
                                <div id="holder1" style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px; margin-top:15px;">
                                </div>
                                @if (isset($page_detail->topTopics['logo'][1]))
                                Old Logo: &nbsp; <img src="{{ @$page_detail->topTopics['logo'][1] }}" alt="Couldn't load logo" 
                                class="img img-thumbail mt-2" style="width: 100px">
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('topTopics[title][2]', ' Title:', ['class' => 'col-sm-1 col-form-label']) }}
                            {{ Form::text('topTopics[title][2]', @$page_detail->topTopics['title'][2], ['class' => 'col-sm-2 form-control', 'id' => 'topTopics[title][2]']) }}

                            {{ Form::label('topTopics[sub_title][2]', 'Sub Title:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                            {{ Form::text('topTopics[sub_title][2]', @$page_detail->topTopics['sub_title'][2], ['class' => 'col-sm-2 form-control', 'id' => 'topTopics[sub_title][2]']) }}

                            {{ Form::label('topTopics[logo][2]', 'Icon:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                            <div class="col-sm-3">
                                <div class="input-group input-group-btn">
                                    <a id="lfm2" data-input="image2" data-preview="holder2" class="btn btn-primary text-white">Choose</a>
                                    <input id="image2" class="form-control" type="text" name="topTopics[logo][2]">
                                </div>
                                <div id="holder2" style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px; margin-top:15px;">
                                </div>
                                @if (isset($page_detail->topTopics['logo'][2]))
                                Old Logo: &nbsp; <img src="{{ @$page_detail->topTopics['logo'][2] }}" alt="Couldn't load logo" 
                                class="img img-thumbail mt-2" style="width: 100px">
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('topTopics[title][3]', ' Title:', ['class' => 'col-sm-1 col-form-label']) }}
                            {{ Form::text('topTopics[title][3]', @$page_detail->topTopics['title'][3], ['class' => 'col-sm-2 form-control', 'id' => 'topTopics[title][3]']) }}

                            {{ Form::label('topTopics[sub_title][3]', 'Sub Title:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                            {{ Form::text('topTopics[sub_title][3]', @$page_detail->topTopics['sub_title'][3], ['class' => 'col-sm-2 form-control', 'id' => 'topTopics[sub_title][3]']) }}

                            {{ Form::label('topTopics[logo][3]', 'Icon:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                            <div class="col-sm-3">
                                <div class="input-group input-group-btn">
                                    <a id="lfm3" data-input="image3" data-preview="holder3" class="btn btn-primary text-white">Choose</a>
                                    <input id="image3" class="form-control" type="text" name="topTopics[logo][3]">
                                </div>
                                <div id="holder3" style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px; margin-top:15px;">
                                </div>
                                @if (isset($page_detail->topTopics['logo'][3]))
                                Old Logo: &nbsp; <img src="{{ @$page_detail->topTopics['logo'][3] }}" alt="Couldn't load logo" 
                                class="img img-thumbail mt-2" style="width: 100px">
                                @endif
                            </div>
                        </div>


                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-jumbotron" role="tabpanel"
                        aria-labelledby="custom-tabs-three-jumbotron-tab">
                         
                        
                        <div class="form-group row">
                            {{ Form::label('firstjumbotron[title]', 'Admission Part Title:', ['class' => 'col-sm-2 col-form-label']) }}
                            {{ Form::text('firstjumbotron[title]', @$page_detail->firstjumbotron['title'], ['class' => 'col-sm-3 form-control', 'id' => 'firstjumbotron[title]']) }}

                            {{ Form::label('firstjumbotron[sub_title]', 'Admission Part Sub Title:', ['class' => 'ml-2 col-sm-2 col-form-label']) }}
                            {{ Form::text('firstjumbotron[sub_title]', @$page_detail->firstjumbotron['sub_title'], ['class' => 'col-sm-3 form-control', 'id' => 'firstjumbotron[sub_title]']) }}
                        </div>
                        
                        <div class="form-group row">
                        {{ Form::label('firstjumbotron[description]', 'Admission Part Description:', ['class' => 'col-sm-2 col-form-label']) }}
                        {{ Form::textarea('firstjumbotron[description]', @$page_detail->firstjumbotron['description'], ['class' => 'col-sm-9 form-control', 'id' => 'firstjumbotron[description]']) }}
                        </div>

                        <div class="form-group row">
                            {{ Form::label('firstjumbotron[left_image]', 'Left Image:', ['class' => 'col-sm-2 col-form-label']) }}
                            <div class="col-sm-3">
                                <div class="input-group input-group-btn">
                                    <a id="lfm4" data-input="image4" data-preview="holder4" class="btn btn-primary text-white">Choose</a>
                                    <input id="image4" class="form-control" type="text" name="firstjumbotron[left_image]">
                                </div>
                                <div id="holder4" style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px; margin-top:15px;">
                                </div>
                                @if (isset($page_detail->firstjumbotron['left_image']))
                                Old Image: &nbsp; <img src="{{ @$page_detail->firstjumbotron['left_image'] }}" alt="Couldn't load Image" 
                                class="img img-thumbail mt-2" style="width: 100px">
                                @endif
                            </div>
                            {{ Form::label('firstjumbotron[right_image]', 'Right Image:', ['class' => 'ml-2 col-sm-2 col-form-label']) }}
                            <div class="col-sm-3">
                                <div class="input-group input-group-btn">
                                    <a id="lfm5" data-input="image4" data-preview="holder5" class="btn btn-primary text-white">Choose</a>
                                    <input id="image4" class="form-control" type="text" name="firstjumbotron[right_image]">
                                </div>
                                <div id="holder5" style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px; margin-top:15px;">
                                </div>
                                @if (isset($page_detail->firstjumbotron['right_image']))
                                Old Image: &nbsp; <img src="{{ @$page_detail->firstjumbotron['right_image'] }}" alt="Couldn't load Image" 
                                class="img img-thumbail mt-2" style="width: 100px">
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-about" role="tabpanel"
                        aria-labelledby="custom-tabs-three-about-tab">


                        <div class="page-description-div">
                            <div class="form-group row">
                                {{ Form::label('aboutinfo[0]', 'First Description', ['class' => 'col-sm-4 col-form-label']) }}
                                <div class="col-sm-6">
                                    {{ Form::textarea('aboutinfo[0]', @$page_detail->aboutinfo[0], ['class' => 'form-control', 'id' => 'aboutinfo[0]', 'placeholder' => 'First Description']) }}
                                </div>
                                {{ Form::label('aboutinfo[1]', 'Second Description', ['class' => 'mt-2 col-sm-4 col-form-label']) }}
                                <div class="col-sm-6">
                                    {{ Form::textarea('aboutinfo[1]', @$page_detail->aboutinfo[1], ['class' => 'mt-2 form-control', 'id' => 'aboutinfo[1]', 'placeholder' => 'Second Description']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="tab-pane fade" id="custom-tabs-three-features" role="tabpanel"
                            aria-labelledby="custom-tabs-three-features-tab">
                            <div class="page-description-div">
                                
                            <div class="form-group row">
                                {{ Form::label('features[title][0]', ' Title:', ['class' => 'col-sm-1 col-form-label']) }}
                                {{ Form::text('features[title][0]', @$page_detail->features['title'][0], ['class' => 'col-sm-2 form-control', 'id' => 'features[title][0]']) }}

                                {{ Form::label('features[sub_title][0]', 'Sub Title:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                                {{ Form::text('features[sub_title][0]', @$page_detail->features['sub_title'][0], ['class' => 'col-sm-2 form-control', 'id' => 'features[sub_title][0]']) }}

                                {{ Form::label('features[logo][0]', 'Icon:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                                <div class="col-sm-3">
                                    <div class="input-group input-group-btn">
                                        <a id="lfm6" data-input="image6" data-preview="holder6" class="btn btn-primary text-white">Choose</a>
                                        <input id="image6" class="form-control" type="text" name="features[logo][0]">
                                    </div>
                                    <div id="holder6" style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px; margin-top:15px;">
                                    </div>
                                    @if (isset($page_detail->features['logo'][0]))
                                    Old Feature Logo: &nbsp; <img src="{{ @$page_detail->features['logo'][0] }}" alt="Couldn't load logo" 
                                    class="img img-thumbail mt-2" style="width: 100px">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('features[title][1]', ' Title:', ['class' => 'col-sm-1 col-form-label']) }}
                                {{ Form::text('features[title][1]', @$page_detail->features['title'][1], ['class' => 'col-sm-2 form-control', 'id' => 'features[title][1]']) }}

                                {{ Form::label('features[sub_title][1]', 'Sub Title:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                                {{ Form::text('features[sub_title][1]', @$page_detail->features['sub_title'][1], ['class' => 'col-sm-2 form-control', 'id' => 'features[sub_title][1]']) }}

                                {{ Form::label('features[logo][1]', 'Icon:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                                <div class="col-sm-3">
                                    <div class="input-group input-group-btn">
                                        <a id="lfm7" data-input="image7" data-preview="holder7" class="btn btn-primary text-white">Choose</a>
                                        <input id="image7" class="form-control" type="text" name="features[logo][1]">
                                    </div>
                                    <div id="holder7" style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px; margin-top:15px;">
                                    </div>
                                    @if (isset($page_detail->features['logo'][1]))
                                    Old Feature Logo: &nbsp; <img src="{{ @$page_detail->features['logo'][1] }}" alt="Couldn't load logo" 
                                    class="img img-thumbail mt-2" style="width: 100px">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('features[title][2]', ' Title:', ['class' => 'col-sm-1 col-form-label']) }}
                                {{ Form::text('features[title][2]', @$page_detail->features['title'][2], ['class' => 'col-sm-2 form-control', 'id' => 'features[title][2]']) }}

                                {{ Form::label('features[sub_title][2]', 'Sub Title:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                                {{ Form::text('features[sub_title][2]', @$page_detail->features['sub_title'][2], ['class' => 'col-sm-2 form-control', 'id' => 'features[sub_title][2]']) }}

                                {{ Form::label('features[logo][2]', 'Icon:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                                <div class="col-sm-3">
                                    <div class="input-group input-group-btn">
                                        <a id="lfm8" data-input="image8" data-preview="holder8" class="btn btn-primary text-white">Choose</a>
                                        <input id="image8" class="form-control" type="text" name="features[logo][2]">
                                    </div>
                                    <div id="holder8" style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px; margin-top:15px;">
                                    </div>
                                    @if (isset($page_detail->features['logo'][2]))
                                    Old Feature Logo: &nbsp; <img src="{{ @$page_detail->features['logo'][2] }}" alt="Couldn't load logo" 
                                    class="img img-thumbail mt-2" style="width: 100px">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('features[title][3]', ' Title:', ['class' => 'col-sm-1 col-form-label']) }}
                                {{ Form::text('features[title][3]', @$page_detail->features['title'][3], ['class' => 'col-sm-2 form-control', 'id' => 'features[title][3]']) }}

                                {{ Form::label('features[sub_title][3]', 'Sub Title:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                                {{ Form::text('features[sub_title][3]', @$page_detail->features['sub_title'][3], ['class' => 'col-sm-2 form-control', 'id' => 'features[sub_title][3]']) }}

                                {{ Form::label('features[logo][3]', 'Icon:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                                <div class="col-sm-3">
                                    <div class="input-group input-group-btn">
                                        <a id="lfm9" data-input="image9" data-preview="holder9" class="btn btn-primary text-white">Choose</a>
                                        <input id="image9" class="form-control" type="text" name="features[logo][3]">
                                    </div>
                                    <div id="holder9" style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px; margin-top:15px;">
                                    </div>
                                    @if (isset($page_detail->features['logo'][3]))
                                    Old Feature Logo: &nbsp; <img src="{{ @$page_detail->features['logo'][3] }}" alt="Couldn't load logo" 
                                    class="img img-thumbail mt-2" style="width: 100px">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('threefeatures[title][0]', ' Title:', ['class' => 'col-sm-1 col-form-label']) }}
                                {{ Form::text('threefeatures[title][0]', @$page_detail->threefeatures['title'][0], ['class' => 'col-sm-2 form-control', 'id' => 'threefeatures[title][0]']) }}

                                {{ Form::label('threefeatures[sub_title][0]', 'Sub Title:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                                {{ Form::text('threefeatures[sub_title][0]', @$page_detail->threefeatures['sub_title'][0], ['class' => 'col-sm-2 form-control', 'id' => 'threefeatures[sub_title][0]']) }}
                            </div>
                            <div class="form-group row">
                                {{ Form::label('threefeatures[title][1]', ' Title:', ['class' => 'col-sm-1 col-form-label']) }}
                                {{ Form::text('threefeatures[title][1]', @$page_detail->threefeatures['title'][1], ['class' => 'col-sm-2 form-control', 'id' => 'threefeatures[title][1]']) }}

                                {{ Form::label('threefeatures[sub_title][1]', 'Sub Title:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                                {{ Form::text('threefeatures[sub_title][1]', @$page_detail->threefeatures['sub_title'][1], ['class' => 'col-sm-2 form-control', 'id' => 'threefeatures[sub_title][1]']) }}
                            </div>
                            <div class="form-group row">
                                {{ Form::label('threefeatures[title][2]', ' Title:', ['class' => 'col-sm-1 col-form-label']) }}
                                {{ Form::text('threefeatures[title][2]', @$page_detail->threefeatures['title'][2], ['class' => 'col-sm-2 form-control', 'id' => 'threefeatures[title][2]']) }}

                                {{ Form::label('threefeatures[sub_title][2]', 'Sub Title:', ['class' => 'ml-2 col-sm-1 col-form-label']) }}
                                {{ Form::text('threefeatures[sub_title][2]', @$page_detail->threefeatures['sub_title'][2], ['class' => 'col-sm-2 form-control', 'id' => 'threefeatures[sub_title][2]']) }}
                            </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="custom-tabs-three-logo" role="tabpanel"
                            aria-labelledby="custom-tabs-three-logo-tab">
                            <div class="page-description-div">
                                <div class="form-group row">
                                    {{ Form::label('logo[0]', 'Logo:', ['class' => 'ml-2 col-sm-2 col-form-label']) }}
                                    <div class="col-sm-6">
                                        <div class="input-group input-group-btn">
                                            <a id="lfm10" data-input="image10" data-preview="holder10" class="btn btn-primary text-white">Choose</a>
                                            <input id="image10" class="form-control" type="text" name="logo[0]">
                                        </div>
                                        <div id="holder10" style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px; margin-top:15px;">
                                        </div>
                                        @if (isset($page_detail->logo[0]))
                                        Old logo: &nbsp; <img src="{{ @$page_detail->logo[0] }}" alt="Couldn't load logo" 
                                        class="img img-thumbail mt-2" style="width: 100px">
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('logo[1]', 'Logo:', ['class' => 'ml-2 col-sm-2 col-form-label']) }}
                                    <div class="col-sm-6">
                                        <div class="input-group input-group-btn">
                                            <a id="lfm11" data-input="image11" data-preview="holder11" class="btn btn-primary text-white">Choose</a>
                                            <input id="image11" class="form-control" type="text" name="logo[1]">
                                        </div>
                                        <div id="holder11" style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px; margin-top:15px;">
                                        </div>
                                        @if (isset($page_detail->logo[1]))
                                        Old logo: &nbsp; <img src="{{ @$page_detail->logo[1] }}" alt="Couldn't load logo" 
                                        class="img img-thumbail mt-2" style="width: 100px">
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('logo[2]', 'Logo:', ['class' => 'ml-2 col-sm-2 col-form-label']) }}
                                    <div class="col-sm-6">
                                        <div class="input-group input-group-btn">
                                            <a id="lfm12" data-input="image12" data-preview="holder12" class="btn btn-primary text-white">Choose</a>
                                            <input id="image12" class="form-control" type="text" name="logo[2]">
                                        </div>
                                        <div id="holder12" style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px; margin-top:15px;">
                                        </div>
                                        @if (isset($page_detail->logo[2]))
                                        Old logo: &nbsp; <img src="{{ @$page_detail->logo[2] }}" alt="Couldn't load logo" 
                                        class="img img-thumbail mt-2" style="width: 100px">
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('logo[3]', 'Logo:', ['class' => 'ml-2 col-sm-2 col-form-label']) }}
                                    <div class="col-sm-6">
                                        <div class="input-group input-group-btn">
                                            <a id="lfm13" data-input="image13" data-preview="holder13" class="btn btn-primary text-white">Choose</a>
                                            <input id="image13" class="form-control" type="text" name="logo[3]">
                                        </div>
                                        <div id="holder13" style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px; margin-top:15px;">
                                        </div>
                                        @if (isset($page_detail->logo[3]))
                                        Old logo: &nbsp; <img src="{{ @$page_detail->logo[3] }}" alt="Couldn't load logo" 
                                        class="img img-thumbail mt-2" style="width: 100px">
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('logo[4]', 'Logo:', ['class' => 'ml-2 col-sm-2 col-form-label']) }}
                                    <div class="col-sm-6">
                                        <div class="input-group input-group-btn">
                                            <a id="lfm14" data-input="image14" data-preview="holder14" class="btn btn-primary text-white">Choose</a>
                                            <input id="image14" class="form-control" type="text" name="logo[4]">
                                        </div>
                                        <div id="holder14" style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px; margin-top:15px;">
                                        </div>
                                        @if (isset($page_detail->logo[4]))
                                        Old logo: &nbsp; <img src="{{ @$page_detail->logo[4] }}" alt="Couldn't load logo" 
                                        class="img img-thumbail mt-2" style="width: 100px">
                                        @endif
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
    </div>

    {{ Form::close() }}

@endsection
