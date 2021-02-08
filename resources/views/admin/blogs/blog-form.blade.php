@extends('layouts.admin')
@section('title', $title )
@push('scripts')
<script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
<script src="{{ asset('/custom/blog.js') }}"></script>
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
        $(".select2").select2();
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
                    <a href="{{ route('blog.index') }}" type="button" class="btn btn-tool">
                        <i class="fa fa-list"></i></a>
                </div>
            </div>
            @include('admin.shared.error-messages')
            <div class="card-body">
                @if (isset($blog_info))
                {{ Form::open(['url' => route('blog.update', $blog_info->id), 'files' => true, 'class' => 'form', 'name' => 'blog_form']) }}
                @method('put')
                @else
                {{ Form::open(['url' => route('blog.store'), 'files' => true, 'class' => 'form', 'name' => 'blog_form']) }}
                @endif
                <label for="id of input"></label>
                <div class="row">
                    {{-- <input type="hidden" name="roles" value="1" placeholder="dummy"> --}}
                    <div class="col-sm-6 offset-lg-1">

                        <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                            {{ Form::label('title', 'Title :*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('title', @$blog_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Blog Title', 'required' => true, 'style' => 'width:80%']) }}
                                @error('title')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('excerpt') ? 'has-error' : '' }}">
                            {{ Form::label('excerpt', 'Short Description :*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('excerpt', @$blog_info->excerpt, ['class' => 'form-control', 'id' => 'excerpt', 'placeholder' => 'Blog Short Description', 'style' => 'width:80%']) }}
                                @error('excerpt')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                            {{ Form::label('description', 'Description :*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::textarea('description', @$blog_info->description, ['class' => 'form-control ckeditor', 'id' => 'my-editor', 'placeholder' => 'Blog Description', 'required' => true, 'style' => 'width:80%']) }}
                                @error('description')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('external_url') ? 'has-error' : '' }}">
                            {{ Form::label('external_url', 'External Url :*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('external_url', @$blog_info->external_url, ['class' => 'form-control', 'id' => 'external_url', 'placeholder' => 'Blog External Url', 'style' => 'width:80%']) }}
                                @error('description')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 offset-lg-1">
                        
                        <div class="form-group row {{ $errors->has('meta_title') ? 'has-error' : '' }}">
                            {{ Form::label('meta_title', 'Meta Title :*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('meta_title', @$content_info->meta_title, ['class' => 'form-control', 'id' => 'meta_title', 'placeholder' => 'Meta Title', 'style' => 'width:80%']) }}
                                @error('meta_title')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('meta_keyword') ? 'has-error' : '' }}">
                            {{ Form::label('meta_keyword', 'Meta Keyword :*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('meta_keyword', @$content_info->meta_keyword, ['class' => 'form-control', 'id' => 'meta_keyword', 'placeholder' => 'Meta Keyword', 'style' => 'width:80%']) }}
                                @error('meta_keyword')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('meta_description') ? 'has-error' : '' }}">
                            {{ Form::label('meta_description', 'Meta Description :*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::text('meta_description', @$content_info->meta_description, ['class' => 'form-control', 'id' => 'meta_description', 'placeholder' => 'Meta Description', 'style' => 'width:80%']) }}
                                @error('meta_description')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('tag_id') ? 'has-error' : '' }}">
                            {{ Form::label('tag_id', 'Tags :*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::select('tag_id[]',
                                @$tags,
                                @$selectedtags,
                                ['id' => 'tag_id', 'required' => false, 'class' => 'form-control select2', 'multiple' => true, 'style' => 'width:80%']) }}
                                @error('tag_id')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        

                        <div class="form-group row {{ $errors->has('category_id') ? 'has-error' : '' }}">
                            {{ Form::label('category_id', 'Categories :*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::select('category_id[]',
                                @$categories,
                                @$selectedcategories,
                                ['id' => 'category_id', 'required' => false, 'class' => 'form-control select2', 'multiple' => true, 'style' => 'width:80%']) }}
                                @error('category_id')
                                <span class="help-block error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                            {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$blog_info->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
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
                                    @if(isset($blog_info->featured_img))
                                    @if(file_exists(public_path().'/uploads/blogs/'.@$blog_info->featured_img))
                                    <img src="{{asset('/uploads/blogs/'.@$blog_info->featured_img)}}" alt="{{$blog_info->featured_img}}" class="img img-fluid img-thumbnail" style="height:80px" id=" ">
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
                                    @if(isset($blog_info->parallex_img))
                                    @if(file_exists(public_path().'/uploads/blogs/'.@$blog_info->parallex_img))
                                    <img src="{{asset('/uploads/blogs/'.@$blog_info->parallex_img)}}" alt="{{$blog_info->parallex_img}}" class="img img-fluid img-thumbnail" style="height:80px" id=" ">
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