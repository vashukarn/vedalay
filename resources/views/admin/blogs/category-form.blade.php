@extends('layouts.admin')
@section('title', $title )
@push('scripts')
<script>
    $(document).ready(function() {
        $('#featured_img').change(function() {
            // alert('hello');
            var input = this;
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#featured_image_view').attr('src', e.target.result).fadeIn(1000);
                    $('#featured_image_view').removeClass('d-none');
                    // $('#img_edit').addClass('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        })

        $('#parallex_img').change(function() {
            // alert('hello');
            var input = this;
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#parallex_image_view').attr('src', e.target.result).fadeIn(1000);
                    $('#parallex_image_view').removeClass('d-none');
                    // $('#img_edit').addClass('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        })
    })
</script>
@include('admin.section.ckeditor')

@endpush
@section('content')
<section class="content-header pt-0"></section>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ @$title }}</h3>
                <div class="card-tools">
                    <a href="{{ route('category.index') }}" type="button" class="btn btn-tool">
                        <i class="fa fa-list"></i></a>
                </div>
            </div>
            @include('admin.shared.error-messages')
            <div class="card-body">
                @if (isset($category_info))
                {{ Form::open(['url' => route('category.update', $category_info->id), 'files' => true, 'class' => 'form']) }}
                @method('put')
                @else
                {{ Form::open(['url' => route('category.store'), 'files' => true, 'class' => 'form']) }}
                @endif
                <label for="id of input"></label>
                <div class="row">
                    {{-- <input type="hidden" name="roles" value="1" placeholder="dummy"> --}}
                    <div class="col-sm-6 offset-lg-1">

                        <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                            {{ Form::label('title', 'Category Title :*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('title', @$category_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Category Title', 'required' => true, 'style' => 'width:80%']) }}
                                @error('title')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                            {{ Form::label('description', 'Category Description :*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::textarea('description', @$category_info->description, ['class' => 'form-control ckeditor', 'id' => 'my-editor', 'placeholder' => 'Category Description', 'required' => true, 'style' => 'width:80%']) }}
                                @error('description')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('position') ? 'has-error' : '' }}">
                            {{ Form::label('position', 'Category Position :*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::number('position', @$category_info->position, ['class' => 'form-control', 'id' => 'position', 'placeholder' => 'Category External Url', 'required' => true, 'style' => 'width:80%']) }}
                                @error('description')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-4 offset-lg-1">

                        <div class="form-group row {{ $errors->has('show_on_menu') ? 'has-error' : '' }}">
                            {{ Form::label('show_on_menu', 'Show on:*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::select('show_on_menu', ['H' => 'Header', 'F' => 'Footer', 'B' => 'Both' , 'N' => 'None'], @$category_info->show_on_menu, ['id' => 'show_on_menu', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                @error('show_on_menu')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('show_on') ? 'has-error' : '' }}">
                            {{ Form::label('show_on', 'Show on Mobile/Web:*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::select('show_on', ['web' => 'Web', 'mobile' => 'Mobile', 'both' => 'Both'], @$category_info->show_on, ['id' => 'show_on', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                @error('show_on')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                            {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$category_info->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                @error('publish_status')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row {{ $errors->has('featured_img') ? 'has-error' : '' }}">
                            {{ Form::label('featured_img', 'Featured Image:*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::file('featured_img',  ['id' => 'featured_img',   'class' => '', 'style' => 'width:80%', 'accept' => 'image/*']) }}
                                @error('icon')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                                <div class="col-sm-4">
                                    <img id="featured_image_view" src="#" alt="image" class="d-none img-fluid img-thumbnail" style="height: 80px" />
                                    {{--dd($documents_detail)--}}
                                    @if(isset($category_info->featured_img))
                                    @if(file_exists(public_path().'/uploads/categories/'.@$category_info->featured_img))
                                    <img src="{{asset('/uploads/categories/'.@$category_info->featured_img)}}" alt="{{$category_info->featured_img}}" class="img img-fluid img-thumbnail" style="height:80px" id=" ">
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('parallex_img') ? 'has-error' : '' }}">
                            {{ Form::label('parallex_img', 'Parallex Image:*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::file('parallex_img',  ['id' => 'parallex_img',   'class' => '', 'style' => 'width:80%', 'accept' => 'image/*']) }}
                                @error('icon')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                                <div class="col-sm-4">
                                    <img id="parallex_image_view" src="#" alt="image" class="d-none img-fluid img-thumbnail" style="height: 80px" />
                                    {{--dd($documents_detail)--}}
                                    @if(isset($category_info->parallex_img))
                                    @if(file_exists(public_path().'/uploads/categories/'.@$category_info->parallex_img))
                                    <img src="{{asset('/uploads/categories/'.@$category_info->parallex_img)}}" alt="{{$category_info->parallex_img}}" class="img img-fluid img-thumbnail" style="height:80px" id=" ">
                                    @endif
                                    @endif
                                </div>
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