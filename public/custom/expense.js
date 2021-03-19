$(function() {
    $("form[name='expense_form']").validate({
        rules: {
                title: "required",
                paid_to: "required",
                amount: {
                    required: true,
                    digits: true,
                    min:1,
                    
                },
            },
            messages: {
                title: "Title is required",
                paid_to:"This field is required",
                amount: {
                    required: "This field is required" ,
                    digits: "Spent Amount Should Be Digit Only ",
                    min: "Minimum 1 digit required ",
                },  
                  
                  
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
