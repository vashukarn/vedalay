$(function() {
    $("form[name='inventoryitem_form']").validate({
        rules: {
                title: "required",
                
            },
            messages: {
                title: "This Title is Required",

                
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
