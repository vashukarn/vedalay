
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

<script>
    if($("#np_short_description")){
        ckeditor('np_short_description', 200);
    }
    // CKEDITOR.replace('my-editor', {
    //     filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
    //     filebrowserUploadMethod: 'form'
    // });

    // CKEDITOR.replace('my-editor1', {
    //     filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
    //     filebrowserUploadMethod: 'form'
    // });

</script>
<style>
    .cke_browser_webkit {
        width: 80%;
    }
</style>
