@extends('layouts.front')
@section('page_title', 'Register')
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')
        <!-- authentication-section -->
        <div class="authentication-section">
            <div class="authentication-grid">
                <div class="authentication-item authentication-img-bg" style="background-image: url({{ asset('/uploads/contents/'.@$pagedata->parallex_img) }}");></div>
                <div class="authentication-item bg-white pl-15 pr-15">
                    <div class="authentication-user-panel">
                        <div class="authentication-user-header">
                            {{-- <a href="{{ url('/') }}"><img src="{{ asset('/uploads/contents/'.@$pagedata->featured_img) }}" alt="logo"></a> --}}
                            {{-- <h1>Rider Registeration</h1> --}}
                        </div>
                        <div class="authentication-user-body">
                            <div class="authentication-tab">
                                    <div class="authentication-tab-item authentication-tab-active">
                                        <img src="assets/images/register.png" alt="icon">
                                        Rider Registration
                                    </div>
                            </div>
                            <div class="authentication-tab-details">
                                <div class="authentication-tab-details-item authentication-tab-details-active">
                                    <div class="authentication-form">
                                    {{-- <div id="success-alert" class="alert" role="alert">
                                    </div> --}}
                                        <form action="{{ route('registeruser') }}" method="POST" id="riderform" name="rider_form">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group mb-15">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="flaticon-user"></i></span>
                                                            </div>
                                                            <input  id="name" name="name" type="text" class="form-control" placeholder="Name*" />
                                                            @error('name')
                                                                <span class="help-block error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group mb-15">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="flaticon-phone-call"></i></span>
                                                            </div>
                                                            <input name="mobile" id="mobile" type="number" class="form-control" placeholder="Phone Number * (10 digits)" pattern="[0-9]{10}" required />
                                                            @error('mobile')
                                                                <span class="help-block error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="form-group mb-15">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="flaticon-preview"></i></span>
                                                            </div>
                                                            <select class="form-control"name="vehicle_type" id="vehicle_type">
                                                                <option value="">Vehicle Type</option>
                                                                @foreach ($vehicle_type as $vehicle)
                                                                <option value="{{ $vehicle->id }}">{{ $vehicle->type }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('vehicle_type')
                                                                <span class="help-block error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="form-group mb-15">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="flaticon-book"></i></span>
                                                            </div>
                                                            <input id="registration_number" name="registration_number" type="text" class="form-control" placeholder="Vehicle Number *" required />
                                                            @error('registration_number')
                                                                <span class="help-block error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <div class="form-group mb-15">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="flaticon-agenda"></i></span>
                                                            </div>
                                                            <input id="license_number" name="license_number" type="text" class="form-control" placeholder="License Number *" required />
                                                            @error('license_number')
                                                                <span class="help-block error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="form-group mb-15">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="flaticon-hide"></i></span>
                                                            </div>
                                                            <input id="password" name="password" type="password" class="form-control" placeholder="Password *" required />
                                                            @error('password')
                                                                <span class="help-block error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="form-group mb-15">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="flaticon-hide"></i></span>
                                                            </div>
                                                            <input id="confirmpassword" name="confirmpassword" type="password" class="form-control" placeholder="Confirm Password *" required />
                                                            @error('confirmpassword')
                                                                <span class="help-block error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <button name="submit" type="submit" id="submit" class="btn1 orange-gradient full-width">Submit</button>
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
        </div>
        <!-- .end authentication-section -->

@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
<script src="{{ asset('/custom/register.js') }}"></script>
{{-- <script>
    $(document).ready(function () {
        $('#riderform').on('submit',function(e){
            e.preventDefault();
            let data = {
                _token: "{{ csrf_token() }}",
                name: $('#name').val(),
                mobile: $('#mobile').val(),
                vehicle_type: $('#vehicletype').val(),
                registration_number: $('#vehicleno').val(),
                license_number: $('#licenseno').val(),
                password: $('#password').val(),
                confirmpassword: $('#confirmpassword').val(),
             }
             $.ajax({
                    url: "{{ route('registeruser') }}",
                    type: 'post',
                    dataType:'json',    
                    data: data,
                    success: function(response)
                    {
                        if(response.error == null){
                            console.log(response);
                            document.getElementById("success-alert").html('Form Submitted Successfully!');
                            document.getElementById("riderform").reset();
                        }
                        else{
                            console.log(response.error);
                            document.getElementById("success-alert").html('Cannot Submit Form!' + response.error );
                        }
                    }
                });
        })
    });
    </script> --}}
@endpush
