@extends('layouts.front')
@section('page_title', 'Contact Us')
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')


        <!-- header -->
        <header class="page-title page-bg" style="background-image: url({{ asset('/uploads/contents/'.@$pagedata->parallex_img) }});">
            <div class="container">
                <div class="page-title-inner">
                    <div class="section-title">
                        <h1>Contact Us</h1>
                        <ul class="page-breadcrumbs">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li>Contact us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!-- .end header -->
        <!-- contact-address-section -->
        <section class="contact-address-section pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="box-card fluid-height">
                            <div class="box-card-inner full-height">
                                <div class="box-card-icon mb-25">
                                    <img src="assets/images/map.png" alt="icon"> <!-- you can use icon instead of img. For using icon you should use span tag like: <span><i class="font-name"></i></span> -->
                                </div>
                                <div class="box-card-details">
                                    <h3 class="box-card-title mb-20">Address</h3>
                                    <p class="box-card-para">{{ @$result['setting']->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="box-card fluid-height">
                            <div class="box-card-inner full-height">
                                <div class="box-card-icon mb-25">
                                    <img src="assets/images/envelop.png" alt="icon"> <!-- you can use icon instead of img. For using icon you should use span tag like: <span><i class="font-name"></i></span> -->
                                </div>
                                <div class="box-card-details">
                                    <h3 class="box-card-title mb-20">Email</h3>
                                    <p class="box-card-para"><a class="link-us" href="mailto:{{ @$result['setting']->email }}">{{ @$result['setting']->email }}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="box-card fluid-height">
                            <div class="box-card-inner full-height">
                                <div class="box-card-icon mb-25">
                                    <img src="assets/images/phone.png" alt="icon"> <!-- you can use icon instead of img. For using icon you should use span tag like: <span><i class="font-name"></i></span> -->
                                </div>
                                <div class="box-card-details">
                                    <h3 class="box-card-title mb-20">Phone</h3>
                                    <p class="box-card-para"><a class="link-us" href="tel:{{ @$result['setting']->contact_no[0]['phone_number'] }}">{{ @$result['setting']->contact_no[0]['phone_number'] }}</a></p>
                                    <p class="box-card-para"><a class="link-us" href="tel:{{ @$result['setting']->contact_no[1]['phone_number'] }}">{{ @$result['setting']->contact_no[1]['phone_number'] }}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--end contact-address-section-->
        <!-- contact-comment-section -->
        <section class="contact-comment-section bg-off-white pt-100 pb-70">
            <div class="container">
                <div class="home-facility-content">
                    <div class="row align-items-end">
                        <div class="col-sm-12 col-md-12 col-lg-5">
                            <div class="home-facility-image pl-20">
                                <div class="home-facility-item faq-block-image pb-30">
                                    <img src="assets/images/contact-comment.png" alt="comment">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-7">
                            <div class="home-facility-item pb-30">
                                <div class="blog-comment-leave-area contact-comment-leave-area">
                                    <h3 class="sub-section-title">Leave a message</h3>
                                    <div class="blog-comment-input-area mt-40">
                                    <div id="success-alert" class="alert alert-success" role="alert">
                                        Form Submitted Successfully!
                                    </div>
                                        <form id="formSubmit">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="form-group mb-30">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="flaticon-user"></i></span>
                                                            </div>
                                                            <input type="text" name="name" id="name" class="form-control" required data-error="Please enter your name" placeholder="Name*" />
                                                        </div>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="form-group mb-30">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="flaticon-user"></i></span>
                                                            </div>
                                                            <input type="email" name="email" id="email" class="form-control" required data-error="Please enter your email" placeholder="Email*" />
                                                        </div>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="form-group mb-30">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="flaticon-phone-call"></i></span>
                                                            </div>
                                                            <input type="text" name="phone" id="phone" required data-error="Please enter your phone number" class="form-control" placeholder="Phone*" />
                                                        </div>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="form-group mb-30">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="flaticon-book"></i></span>
                                                            </div>
                                                            <input type="text" name="subject" id="subject" class="form-control" required data-error="Please enter your subject" placeholder="Subject*" />
                                                        </div>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group mb-30">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="flaticon-email"></i></span>
                                                            </div>
                                                            <textarea name="message" class="form-control" id="message" rows="5" required data-error="Write your message" placeholder="Your Message*"></textarea>
                                                        </div>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <button class="btn1 orange-gradient btn-with-image" type="submit">
                                                        <i class="flaticon-login"></i>
                                                        <i class="flaticon-login"></i>
                                                        Send A Message
                                                    </button>
                                                    <div id="msgSubmit"></div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--end contact-comment-section-->
{{-- Contact Form Submission --}}

<script type="text/javascript">
    document.getElementById("success-alert").style.visibility = "hidden";
        $("#formSubmit").on("submit", function (event) {
        event.preventDefault();
        let name = $("#name").val();
        let email = $("#email").val();
        let phone = $("#phone").val();
        let subject = $("#subject").val();
        let message = $("#message").val();
        let data = {
            _token: "{{ csrf_token() }}",
            name: name,
            email: email,
            phone: phone,
            subject: subject,
            message: message,
            };
        $.ajax({
            url: "/contact-form",
            type: "POST",
            data: data,
            success: function (response) {
                if(response.error == null){
                    console.log(response);
                    document.getElementById("success-alert").style.visibility = "";
                    document.getElementById("formSubmit").reset();
                }
                else{
                    console.log(response.error);
                }
            },
        });
        });

    </script>
    
@endsection
@push('scripts')
{{-- scripts here --}}
@endpush