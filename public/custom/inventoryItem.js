$(function() {
    $("form[name='inventoryitem_form']").validate({
        rules: {
                title: "required",
                
            },
            messages: {
                title: "Title is Required",

                
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
