$(function() {
    $("form[name='noticeboard_form']").validate({
        rules: {
                title: "required",
                date:"required",
               
            },
            messages: {
                title: "Title is required",
                date:"Date is required",
                
                  
                  
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
