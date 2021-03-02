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
        {{-- <script src="{{ asset('/custom/apphomepage.js') }}"></script> --}}
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
                        <a class="nav-link active" id="custom-tabs-three-landing-tab" data-toggle="pill"
                            href="#custom-tabs-three-landing" role="tab" aria-controls="custom-tabs-three-landing"
                            aria-selected="true">Landing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-customer-tab" data-toggle="pill"
                            href="#custom-tabs-three-customer" role="tab" aria-controls="custom-tabs-three-customer"
                            aria-selected="false">Customers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-whyus-tab" data-toggle="pill"
                            href="#custom-tabs-three-whyus" role="tab" aria-controls="custom-tabs-three-whyus"
                            aria-selected="false">Why Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-features-tab" data-toggle="pill"
                            href="#custom-tabs-three-features" role="tab" aria-controls="custom-tabs-three-features"
                            aria-selected="false">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-newsletter-tab" data-toggle="pill"
                            href="#custom-tabs-three-newsletter" role="tab" aria-controls="custom-tabs-three-newsletter"
                            aria-selected="false">Newsletter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-work-tab" data-toggle="pill"
                            href="#custom-tabs-three-work" role="tab" aria-controls="custom-tabs-three-work"
                            aria-selected="false">Work</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-priceplanteamreview-tab" data-toggle="pill"
                            href="#custom-tabs-three-priceplanteamreview" role="tab"
                            aria-controls="custom-tabs-three-priceplanteamreview" aria-selected="false">Price Plan, Team &
                            Review</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-faq-tab" data-toggle="pill" href="#custom-tabs-three-faq"
                            role="tab" aria-controls="custom-tabs-three-faq" aria-selected="false">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-parallaxblog-tab" data-toggle="pill"
                            href="#custom-tabs-three-parallaxblog" role="tab" aria-controls="custom-tabs-three-parallaxblog"
                            aria-selected="false">Parallax & Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-contact-tab" data-toggle="pill"
                            href="#custom-tabs-three-contact" role="tab" aria-controls="custom-tabs-three-contact"
                            aria-selected="false">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-mapfooter-tab" data-toggle="pill"
                            href="#custom-tabs-three-mapfooter" role="tab" aria-controls="custom-tabs-three-mapfooter"
                            aria-selected="false">Map & Footer</a>
                    </li>

                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">


                    <div class="tab-pane fade show active" id="custom-tabs-three-landing" role="tabpanel"
                        aria-labelledby="custom-tabs-three-landing-tab">

                        <div class="form-group row {{ $errors->has('landing_title1') ? 'has-error' : '' }}">
                            {{ Form::label('landing_title1', 'Landing Title (First Half) :', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('landing_title1', @$page_detail->landing_title1, ['placeholder' => 'Enter First Partial Title', 'class' => 'form-control', 'id' => 'landing_title1', 'style' => 'width:80%']) }}
                                @error('landing_title1')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('landing_title2') ? 'has-error' : '' }}">
                            {{ Form::label('landing_title2', 'Landing Title Middle Different Color :', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('landing_title2', @$page_detail->landing_title2, ['placeholder' => 'Enter Middle Different Color Title', 'class' => 'form-control', 'id' => 'landing_title2', 'style' => 'width:80%']) }}
                                @error('landing_title2')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('landing_title3') ? 'has-error' : '' }}">
                            {{ Form::label('landing_title3', 'Landing Title (Second Half) :', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('landing_title3', @$page_detail->landing_title3, ['placeholder' => 'Enter Second Partial Title', 'class' => 'form-control', 'id' => 'landing_title3', 'style' => 'width:80%']) }}
                                @error('landing_title3')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('landing_subtitle') ? 'has-error' : '' }}">
                            {{ Form::label('landing_subtitle', 'Landing Subtitle :', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('landing_subtitle', @$page_detail->landing_subtitle, ['placeholder' => 'Enter Subtitle', 'class' => 'form-control', 'id' => 'landing_subtitle', 'style' => 'width:80%']) }}
                                @error('landing_subtitle')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row {{ $errors->has('landing_image') ? 'has-error' : '' }}">
                            {{ Form::label('landing_image', 'Landing Image:*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm" data-input="landing_image" data-preview="holder"
                                            class="btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="landing_image" class="form-control" type="text" name="landing_image">
                                </div>
                                <div id="holder" style="
                                                        border: 1px solid #ddd;
                                                        border-radius: 4px;
                                                        padding: 5px;
                                                        width: 150px;
                                                        margin-top:15px;">
                                </div>

                                @if (isset($page_detail->landing_image))
                                    Old landing image: &nbsp; <img src="{{ @$page_detail->landing_image }}"
                                        alt="Image Not Available" class="img img-thumbail mt-2" style="width: 100px">
                                @endif
                                @error('landing_image')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-customer" role="tabpanel"
                        aria-labelledby="custom-tabs-three-customer-tab">


                        <div class="form-group row {{ $errors->has('customers_title1') ? 'has-error' : '' }}">
                            {{ Form::label('customers_title1', 'Customers Title (First Half) :', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('customers_title1', @$page_detail->customers_title1, ['placeholder' => 'Enter First Partial Title', 'class' => 'form-control', 'id' => 'customers_title1', 'style' => 'width:80%']) }}
                                @error('customers_title1')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('customers_title2') ? 'has-error' : '' }}">
                            {{ Form::label('customers_title2', 'Customers Title Middle Different Color :', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('customers_title2', @$page_detail->customers_title2, ['placeholder' => 'Enter Middle Different Color Title', 'class' => 'form-control', 'id' => 'customers_title2', 'style' => 'width:80%']) }}
                                @error('customers_title2')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('customers_title3') ? 'has-error' : '' }}">
                            {{ Form::label('customers_title3', 'Customers Title (Second Half) :', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('customers_title3', @$page_detail->customers_title3, ['placeholder' => 'Enter Second Partial Title', 'class' => 'form-control', 'id' => 'customers_title3', 'style' => 'width:80%']) }}
                                @error('customers_title3')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('customers_subtitle') ? 'has-error' : '' }}">
                            {{ Form::label('customers_subtitle', 'Customers Subtitle :', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('customers_subtitle', @$page_detail->customers_subtitle, ['placeholder' => 'Enter Subtitle', 'class' => 'form-control', 'id' => 'customers_subtitle', 'style' => 'width:80%']) }}
                                @error('customers_subtitle')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            {{ Form::label('customers_logo1', 'Logo 1:*', ['class' => 'col-sm-1']) }}
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm1" data-input="customers_logo1" data-preview="holder5"
                                            class="btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="customers_logo1" class="form-control" type="text" name="customers_logo1">
                                </div>
                                <div id="holder5" style="
                                                        border: 1px solid #ddd;
                                                        border-radius: 4px;
                                                        padding: 5px;
                                                        width: 150px;
                                                        margin-top:15px;">
                                </div>

                                @if (isset($page_detail->customers_logo1))
                                    Old logo: &nbsp; <img src="{{ @$page_detail->customers_logo1 }}"
                                        alt="Image Not Available" class="img img-thumbail mt-2" style="width: 100px">
                                @endif
                            </div>
                            {{ Form::label('customers_logo2', 'Logo 2:*', ['class' => 'col-sm-1']) }}
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm2" data-input="customers_logo2" data-preview="holder6"
                                            class="btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="customers_logo2" class="form-control" type="text" name="customers_logo2">
                                </div>
                                <div id="holder6" style="
                                                        border: 1px solid #ddd;
                                                        border-radius: 4px;
                                                        padding: 5px;
                                                        width: 150px;
                                                        margin-top:15px;">
                                </div>

                                @if (isset($page_detail->customers_logo2))
                                    Old logo: &nbsp; <img src="{{ @$page_detail->customers_logo2 }}"
                                        alt="Image Not Available" class="img img-thumbail mt-2" style="width: 100px">
                                @endif
                            </div>
                            {{ Form::label('customers_logo3', 'Logo 3:*', ['class' => 'col-sm-1']) }}
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm3" data-input="customers_logo3" data-preview="holder7"
                                            class="btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="customers_logo3" class="form-control" type="text" name="customers_logo3">
                                </div>
                                <div id="holder7" style="
                                                        border: 1px solid #ddd;
                                                        border-radius: 4px;
                                                        padding: 5px;
                                                        width: 150px;
                                                        margin-top:15px;">
                                </div>

                                @if (isset($page_detail->customers_logo3))
                                    Old logo: &nbsp; <img src="{{ @$page_detail->customers_logo3 }}"
                                        alt="Image Not Available" class="img img-thumbail mt-2" style="width: 100px">
                                @endif
                            </div>
                        </div>


                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-whyus" role="tabpanel"
                        aria-labelledby="custom-tabs-three-whyus-tab">

                        <div class="form-group row {{ $errors->has('whyus_title') ? 'has-error' : '' }}">
                            {{ Form::label('whyus_title', 'Why Us Title:', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('whyus_title', @$page_detail->whyus_title, ['placeholder' => 'Enter Title', 'class' => 'form-control', 'id' => 'whyus_title', 'style' => 'width:80%']) }}
                                @error('whyus_title')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('whyus_subtitle') ? 'has-error' : '' }}">
                            {{ Form::label('whyus_subtitle', 'Why Us Subtitle:', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('whyus_subtitle', @$page_detail->whyus_subtitle, ['placeholder' => 'Enter Subtitle', 'class' => 'form-control', 'id' => 'whyus_subtitle', 'style' => 'width:80%']) }}
                                @error('whyus_subtitle')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('whyus_paragraph') ? 'has-error' : '' }}">
                            {{ Form::label('whyus_paragraph', 'Why Us Paragraph:', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('whyus_paragraph', @$page_detail->whyus_paragraph, ['placeholder' => 'Enter Paragraph', 'class' => 'form-control', 'id' => 'whyus_paragraph', 'style' => 'width:80%']) }}
                                @error('whyus_paragraph')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row {{ $errors->has('whyus_image') ? 'has-error' : '' }}">
                            {{ Form::label('whyus_image', 'Why Us Side Image:*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm4" data-input="whyus_image" data-preview="holder11"
                                            class="btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="whyus_image" class="form-control" type="text" name="whyus_image">
                                </div>
                                <div id="holder11" style="
                                                        border: 1px solid #ddd;
                                                        border-radius: 4px;
                                                        padding: 5px;
                                                        width: 150px;
                                                        margin-top:15px;">
                                </div>

                                @if (isset($page_detail->whyus_image))
                                    Old why us image: &nbsp; <img src="{{ @$page_detail->whyus_image }}"
                                        alt="Image Not Available" class="img img-thumbail mt-2" style="width: 100px">
                                @endif
                                @error('whyus_image')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row {{ $errors->has('whyus_link') ? 'has-error' : '' }}">
                            {{ Form::label('whyus_link', 'Why Us Video Link:', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('whyus_link', @$page_detail->whyus_link, ['placeholder' => 'Enter Paragraph', 'class' => 'form-control', 'id' => 'whyus_link', 'style' => 'width:80%']) }}
                                @error('whyus_link')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <h5>Why Us Features :</h5> <br>


                        @for ($i = 1; $i < 4; $i++)
                            <div class="form-group row">
                                {{ Form::label('whyus_features[' . $i . '][title]', 'Features Title ' . $i . ' :', ['class' => 'col-sm-2']) }}
                                {{ Form::text('whyus_features[' . $i . '][title]', @$page_detail->whyus_features[$i]['title'], ['placeholder' => 'Enter Title ' . $i, 'class' => 'col-sm-3 form-control', 'id' => 'whyus_features[' . $i . '][title]', 'style' => 'width:80%']) }}
                                {{ Form::label('whyus_features[' . $i . '][subtitle]', 'Features Subtitle ' . $i . ' :', ['class' => 'ml-4 col-sm-2']) }}
                                {{ Form::text('whyus_features[' . $i . '][subtitle]', @$page_detail->whyus_features[$i]['subtitle'], ['placeholder' => 'Enter Subtitle ' . $i, 'class' => 'col-sm-3 form-control', 'id' => 'whyus_features[' . $i . '][subtitle]', 'style' => 'width:80%']) }}
                            </div>
                        @endfor

                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-features" role="tabpanel"
                        aria-labelledby="custom-tabs-three-features-tab">


                        <div class="form-group row {{ $errors->has('features_title') ? 'has-error' : '' }}">
                            {{ Form::label('features_title', 'Features Title :', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('features_title', @$page_detail->features_title, ['placeholder' => 'Enter Features Title', 'class' => 'form-control', 'id' => 'features_title', 'style' => 'width:80%']) }}
                                @error('features_title')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('features_subtitle') ? 'has-error' : '' }}">
                            {{ Form::label('features_subtitle', 'Features Subtitle :', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('features_subtitle', @$page_detail->features_subtitle, ['placeholder' => 'Enter Features Subtitle', 'class' => 'form-control', 'id' => 'features_subtitle', 'style' => 'width:80%']) }}
                                @error('features_subtitle')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row {{ $errors->has('features_image') ? 'has-error' : '' }}">
                            {{ Form::label('features_image', 'Features Image:*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm5" data-input="features_image" data-preview="holder16"
                                            class="btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="features_image" class="form-control" type="text" name="features_image">
                                </div>
                                <div id="holder16" style="
                                                            border: 1px solid #ddd;
                                                            border-radius: 4px;
                                                            padding: 5px;
                                                            width: 150px;
                                                            margin-top:15px;">
                                </div>

                                @if (isset($page_detail->features_image))
                                    Old feature image: &nbsp; <img src="{{ @$page_detail->features_image }}"
                                        alt="Image Not Available" class="img img-thumbail mt-2" style="width: 100px">
                                @endif
                                @error('features_image')
                                    <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-newsletter" role="tabpanel"
                        aria-labelledby="custom-tabs-three-newsletter-tab">
                        <div class="page-description-div">


                            <div class="form-group row {{ $errors->has('newsletter_title') ? 'has-error' : '' }}">
                                {{ Form::label('newsletter_title', 'Newsletter Title:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('newsletter_title', @$page_detail->newsletter_title, ['placeholder' => 'Enter Title', 'class' => 'form-control', 'id' => 'newsletter_title', 'style' => 'width:80%']) }}
                                    @error('newsletter_title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('newsletter_subtitle') ? 'has-error' : '' }}">
                                {{ Form::label('newsletter_subtitle', 'Newsletter Subtitle:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('newsletter_subtitle', @$page_detail->newsletter_subtitle, ['placeholder' => 'Enter Subtitle', 'class' => 'form-control', 'id' => 'newsletter_subtitle', 'style' => 'width:80%']) }}
                                    @error('newsletter_subtitle')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row {{ $errors->has('newsletter_image') ? 'has-error' : '' }}">
                                {{ Form::label('newsletter_image', 'Newsletter Background Image:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm6" data-input="newsletter_image" data-preview="holder21"
                                                class="btn btn-primary text-white">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                        <input id="newsletter_image" class="form-control" type="text"
                                            name="newsletter_image">
                                    </div>
                                    <div id="holder21" style="
                                                        border: 1px solid #ddd;
                                                        border-radius: 4px;
                                                        padding: 5px;
                                                        width: 150px;
                                                        margin-top:15px;">
                                    </div>

                                    @if (isset($page_detail->newsletter_image))
                                        Old Background Image: &nbsp; <img src="{{ @$page_detail->newsletter_image }}"
                                            alt="Image Not Available" class="img img-thumbail mt-2" style="width: 100px">
                                    @endif
                                    @error('newsletter_image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <h5>Counters :</h5> <br>
                            @for ($i = 1; $i < 4; $i++)
                                <div class="form-group row">
                                    {{ Form::label('newsletter_counters[' . $i . '][title]', 'Counter Title ' . $i . ' :', ['class' => 'col-sm-2']) }}
                                    {{ Form::text('newsletter_counters[' . $i . '][title]', @$page_detail->newsletter_counters[$i]['title'], ['placeholder' => 'Enter Title ' . $i, 'class' => 'col-sm-3 form-control', 'id' => 'newsletter_counters[' . $i . '][title]', 'style' => 'width:80%']) }}
                                    {{ Form::label('newsletter_counters[' . $i . '][number]', 'Counter Number ' . $i . ' :', ['class' => 'ml-4 col-sm-2']) }}
                                    {{ Form::number('newsletter_counters[' . $i . '][number]', @$page_detail->newsletter_counters[$i]['number'], ['placeholder' => 'Enter Number ' . $i, 'class' => 'col-sm-3 form-control', 'id' => 'newsletter_counters[' . $i . '][number]', 'style' => 'width:80%']) }}
                                </div>
                            @endfor

                        </div>
                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-work" role="tabpanel"
                        aria-labelledby="custom-tabs-three-work-tab">
                        <div class="page-description-div">


                            <div class="form-group row {{ $errors->has('work_title') ? 'has-error' : '' }}">
                                {{ Form::label('work_title', 'Work Title:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('work_title', @$page_detail->work_title, ['placeholder' => 'Enter Title', 'class' => 'form-control', 'id' => 'work_title', 'style' => 'width:80%']) }}
                                    @error('work_title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('work_subtitle') ? 'has-error' : '' }}">
                                {{ Form::label('work_subtitle', 'Work Subtitle:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('work_subtitle', @$page_detail->work_subtitle, ['placeholder' => 'Enter Subtitle', 'class' => 'form-control', 'id' => 'work_subtitle', 'style' => 'width:80%']) }}
                                    @error('work_subtitle')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            @for ($i = 1; $i < 4; $i++)
                                <h4>Title {{ $i }} :</h4> <br>
                                <div class="form-group row">
                                    {{ Form::label('work_detail[' . $i . '][title]', 'Title ' . $i . ' :', ['class' => 'col-sm-2']) }}
                                    {{ Form::text('work_detail[' . $i . '][title]', @$page_detail->work_detail[$i]['title'], ['placeholder' => 'Enter Title ' . $i, 'class' => 'col-sm-3 form-control', 'id' => 'work_detail[' . $i . '][title]', 'style' => 'width:80%']) }}
                                    {{ Form::label('work_detail[' . $i . '][subtitle]', 'Subtitle ' . $i . ' :', ['class' => 'ml-4 col-sm-2']) }}
                                    {{ Form::text('work_detail[' . $i . '][subtitle]', @$page_detail->work_detail[$i]['subtitle'], ['placeholder' => 'Enter Subtitle ' . $i, 'class' => 'col-sm-3 form-control', 'id' => 'work_detail[' . $i . '][subtitle]', 'style' => 'width:80%']) }}
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('work_detail[' . $i . '][description]', 'Description ' . $i . ' :', ['class' => 'col-sm-3']) }}
                                    {{ Form::textarea('work_detail[' . $i . '][description]', @$page_detail->work_detail[$i]['description'], ['placeholder' => 'Enter Description ' . $i, 'class' => 'col-sm-6 form-control', 'id' => 'work_detail[' . $i . '][description]', 'style' => 'width:80%']) }}
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('work_detail[' . $i . '][image]', 'Image:*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm{{ $i + 6 }}" data-input="work_{{ $i }}"
                                                    data-preview="holder{{ $i+25 }}"
                                                    class="btn btn-primary text-white">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="work_{{ $i }}" class="form-control" type="text"
                                                name="work_detail[{{ $i }}][image]">
                                        </div>
                                        <div id="holder{{ $i+25 }}" style="
                                                            border: 1px solid #ddd;
                                                            border-radius: 4px;
                                                            padding: 5px;
                                                            width: 150px;
                                                            margin-top:15px;">
                                        </div>

                                        @if (isset($page_detail->work_detail[$i]['image']))
                                            Old Background Image: &nbsp; <img
                                                src="{{ @$page_detail->work_detail[$i]['image'] }}"
                                                alt="Image Not Available" class="img img-thumbail mt-2"
                                                style="width: 100px">
                                        @endif
                                    </div>
                                </div>
                                @for ($j = 1; $j < 4; $j++)
                                    <div class="form-group row">
                                        {{ Form::label('work_detail[' . $i . '][bullet][' . $j . '][title]', 'Bullet Title ' . $j . ' :', ['class' => 'col-sm-2']) }}
                                        {{ Form::text('work_detail[' . $i . '][bullet][' . $j . '][title]', @$page_detail->work_detail[$i]['bullet'][$j]['title'], ['placeholder' => 'Enter Bullet Title ' . $j, 'class' => 'col-sm-3 form-control', 'id' => 'work_detail[' . $i . '][bullet][' . $j . '][title]', 'style' => 'width:80%']) }}
                                        {{ Form::label('work_detail[' . $i . '][bullet][' . $j . '][subtitle]', 'Bullet Subtitle ' . $j . ' :', ['class' => 'ml-4 col-sm-2']) }}
                                        {{ Form::text('work_detail[' . $i . '][bullet][' . $j . '][subtitle]', @$page_detail->work_detail[$i]['subtitle'], ['placeholder' => 'Enter Subtitle ' . $j, 'class' => 'col-sm-3 form-control', 'id' => 'work_detail[' . $i . '][bullet][' . $j . '][subtitle]', 'style' => 'width:80%']) }}
                                    </div>
                                @endfor
                            @endfor

                        </div>
                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-priceplanteamreview" role="tabpanel"
                        aria-labelledby="custom-tabs-three-priceplanteamreview-tab">
                        <div class="page-description-div">

                            <h4 class="mb-4">Price Plan</h4>

                            <div class="form-group row {{ $errors->has('priceplan_title') ? 'has-error' : '' }}">
                                {{ Form::label('priceplan_title', 'Price Plan Title:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('priceplan_title', @$page_detail->priceplan_title, ['placeholder' => 'Enter Price Plan Title', 'class' => 'form-control', 'id' => 'priceplan_title', 'style' => 'width:80%']) }}
                                    @error('priceplan_title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('priceplan_subtitle') ? 'has-error' : '' }}">
                                {{ Form::label('priceplan_subtitle', 'Price Plan Subtitle:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('priceplan_subtitle', @$page_detail->priceplan_subtitle, ['placeholder' => 'Enter Price Plan Subtitle', 'class' => 'form-control', 'id' => 'priceplan_subtitle', 'style' => 'width:80%']) }}
                                    @error('priceplan_subtitle')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <h4 class="mt-4 mb-4">Team</h4>

                            <div class="form-group row {{ $errors->has('team_title') ? 'has-error' : '' }}">
                                {{ Form::label('team_title', 'Team Title:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('team_title', @$page_detail->team_title, ['placeholder' => 'Enter Team Title', 'class' => 'form-control', 'id' => 'team_title', 'style' => 'width:80%']) }}
                                    @error('team_title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('team_subtitle') ? 'has-error' : '' }}">
                                {{ Form::label('team_subtitle', 'Team Subtitle:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('team_subtitle', @$page_detail->team_subtitle, ['placeholder' => 'Enter Team Subtitle', 'class' => 'form-control', 'id' => 'team_subtitle', 'style' => 'width:80%']) }}
                                    @error('team_subtitle')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <h4 class="mt-4">Review</h4>

                            <div class="form-group row {{ $errors->has('review_title') ? 'has-error' : '' }}">
                                {{ Form::label('review_title', 'Review Title:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('review_title', @$page_detail->review_title, ['placeholder' => 'Enter Review Title', 'class' => 'form-control', 'id' => 'review_title', 'style' => 'width:80%']) }}
                                    @error('review_title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('review_subtitle') ? 'has-error' : '' }}">
                                {{ Form::label('review_subtitle', 'Review Subtitle:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('review_subtitle', @$page_detail->review_subtitle, ['placeholder' => 'Enter Review Subtitle', 'class' => 'form-control', 'id' => 'review_subtitle', 'style' => 'width:80%']) }}
                                    @error('review_subtitle')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                        </div>
                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-faq" role="tabpanel"
                        aria-labelledby="custom-tabs-three-faq-tab">
                        <div class="page-description-div">

                            <div class="form-group row {{ $errors->has('faq_title') ? 'has-error' : '' }}">
                                {{ Form::label('faq_title', 'FAQ Title:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('faq_title', @$page_detail->faq_title, ['placeholder' => 'Enter FAQ Title', 'class' => 'form-control', 'id' => 'faq_title', 'style' => 'width:80%']) }}
                                    @error('faq_title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('faq_subtitle') ? 'has-error' : '' }}">
                                {{ Form::label('faq_subtitle', 'FAQ Subtitle:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('faq_subtitle', @$page_detail->faq_subtitle, ['placeholder' => 'Enter FAQ Subtitle', 'class' => 'form-control', 'id' => 'faq_subtitle', 'style' => 'width:80%']) }}
                                    @error('faq_subtitle')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('faq_image') ? 'has-error' : '' }}">
                                {{ Form::label('faq_image', 'FAQ Image:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm10" data-input="faq_image" data-preview="holder36"
                                                class="btn btn-primary text-white">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                        <input id="faq_image" class="form-control" type="text" name="faq_image">
                                    </div>
                                    <div id="holder36" style="
                                                        border: 1px solid #ddd;
                                                        border-radius: 4px;
                                                        padding: 5px;
                                                        width: 150px;
                                                        margin-top:15px;">
                                    </div>

                                    @if (isset($page_detail->faq_image))
                                        Old Background Image: &nbsp; <img src="{{ @$page_detail->faq_image }}"
                                            alt="Image Not Available" class="img img-thumbail mt-2" style="width: 100px">
                                    @endif
                                    @error('faq_image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('faq_link') ? 'has-error' : '' }}">
                                {{ Form::label('faq_link', 'FAQ Link:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('faq_link', @$page_detail->faq_link, ['placeholder' => 'Enter FAQ Link', 'class' => 'form-control', 'id' => 'faq_link', 'style' => 'width:80%']) }}
                                    @error('faq_link')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-parallaxblog" role="tabpanel"
                        aria-labelledby="custom-tabs-three-parallaxblog-tab">
                        <div class="page-description-div">

                            <h4>Blog :</h4>

                            <div class="form-group row {{ $errors->has('blog_title') ? 'has-error' : '' }}">
                                {{ Form::label('blog_title', 'Blog Title:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('blog_title', @$page_detail->blog_title, ['placeholder' => 'Enter blog Title', 'class' => 'form-control', 'id' => 'blog_title', 'style' => 'width:80%']) }}
                                    @error('blog_title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('blog_subtitle') ? 'has-error' : '' }}">
                                {{ Form::label('blog_subtitle', 'Blog Subtitle:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('blog_subtitle', @$page_detail->blog_subtitle, ['placeholder' => 'Enter blog Subtitle', 'class' => 'form-control', 'id' => 'blog_subtitle', 'style' => 'width:80%']) }}
                                    @error('blog_subtitle')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <h4>Parallax :</h4>

                            <div class="form-group row {{ $errors->has('parallax_title') ? 'has-error' : '' }}">
                                {{ Form::label('parallax_title', 'Parallax Title:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('parallax_title', @$page_detail->parallax_title, ['placeholder' => 'Enter Parallax Title', 'class' => 'form-control', 'id' => 'parallax_title', 'style' => 'width:80%']) }}
                                    @error('parallax_title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('parallax_subtitle') ? 'has-error' : '' }}">
                                {{ Form::label('parallax_subtitle', 'Parallax Subtitle:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('parallax_subtitle', @$page_detail->parallax_subtitle, ['placeholder' => 'Enter Parallax Subtitle', 'class' => 'form-control', 'id' => 'parallax_subtitle', 'style' => 'width:80%']) }}
                                    @error('parallax_subtitle')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('parallax_image') ? 'has-error' : '' }}">
                                {{ Form::label('parallax_image', 'Parallax Image:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm11" data-input="parallax_image" data-preview="holder41"
                                                class="btn btn-primary text-white">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                        <input id="parallax_image" class="form-control" type="text" name="parallax_image">
                                    </div>
                                    <div id="holder41" style="
                                                        border: 1px solid #ddd;
                                                        border-radius: 4px;
                                                        padding: 5px;
                                                        width: 150px;
                                                        margin-top:15px;">
                                    </div>

                                    @if (isset($page_detail->parallax_image))
                                        Old Background Image: &nbsp; <img src="{{ @$page_detail->parallax_image }}"
                                            alt="Image Not Available" class="img img-thumbail mt-2" style="width: 100px">
                                    @endif
                                    @error('parallax_image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-contact" role="tabpanel"
                        aria-labelledby="custom-tabs-three-contact-tab">
                        <div class="page-description-div">

                            <div class="form-group row {{ $errors->has('contact_title') ? 'has-error' : '' }}">
                                {{ Form::label('contact_title', 'Contact Title:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('contact_title', @$page_detail->contact_title, ['placeholder' => 'Enter Contact Title', 'class' => 'form-control', 'id' => 'contact_title', 'style' => 'width:80%']) }}
                                    @error('contact_title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('contact_subtitle') ? 'has-error' : '' }}">
                                {{ Form::label('contact_subtitle', 'Contact Subtitle:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('contact_subtitle', @$page_detail->contact_subtitle, ['placeholder' => 'Enter Contact Subtitle', 'class' => 'form-control', 'id' => 'contact_subtitle', 'style' => 'width:80%']) }}
                                    @error('contact_subtitle')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('contact_form_title') ? 'has-error' : '' }}">
                                {{ Form::label('contact_form_title', 'Contact Form Title:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('contact_form_title', @$page_detail->contact_form_title, ['placeholder' => 'Enter Contact Form Title', 'class' => 'form-control', 'id' => 'contact_form_title', 'style' => 'width:80%']) }}
                                    @error('contact_form_title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                        </div>
                    </div>

                    <div class="tab-pane fade" id="custom-tabs-three-mapfooter" role="tabpanel"
                        aria-labelledby="custom-tabs-three-mapfooter-tab">
                        <div class="page-description-div">

                            <div class="form-group row {{ $errors->has('map_link') ? 'has-error' : '' }}">
                                {{ Form::label('map_link', 'Map Link:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('map_link', @$page_detail->map_link, ['placeholder' => 'Ex : https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3548.8847330196522!2d77.97701311499019!3d27.191359383008393!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3974770b78b592b7%3A0x19efec852169b650!2sSoni%20Health%20Club!5e0!3m2!1sen!2sin!4v1614602138020!5m2!1sen!2sin', 'class' => 'form-control', 'id' => 'map_link', 'style' => 'width:80%']) }}
                                    @error('map_link')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div
                                class="form-group row {{ $errors->has('footer_contact_subtitle') ? 'has-error' : '' }}">
                                {{ Form::label('footer_contact_subtitle', 'Footer Contact Subtitle:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('footer_contact_subtitle', @$page_detail->footer_contact_subtitle, ['placeholder' => 'Enter Footer Contact Subtitle', 'class' => 'form-control', 'id' => 'footer_contact_subtitle', 'style' => 'width:80%']) }}
                                    @error('footer_contact_subtitle')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div
                                class="form-group row {{ $errors->has('footer_company_subtitle') ? 'has-error' : '' }}">
                                {{ Form::label('footer_company_subtitle', 'Footer Company Subtitle:', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('footer_company_subtitle', @$page_detail->footer_company_subtitle, ['placeholder' => 'Enter Contact Form Title', 'class' => 'form-control', 'id' => 'footer_company_subtitle', 'style' => 'width:80%']) }}
                                    @error('footer_company_subtitle')
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

    <div class="card-footer">
        {{ Form::button("<i class='fa fa-paper-plane'></i> Save Seting", ['class' => 'btn btn-success', 'type' => 'submit']) }}
    </div>

    {{ Form::close() }}

@endsection
