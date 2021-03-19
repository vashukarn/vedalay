$(function() {
    $("form[name='inventory_form']").validate({
        rules: {
                title: "required",
                quantity: {
                    required: true,
                    digits: true,
                    min: 1,
                },
                total_price: {
                    required: true,
                    digits: true,
                    min: 1,
                },
            },
            messages: {
                title: "This Title is Required",
                quantity: {
                    required: "Quantity is Required",
                    digits: " Quantity Should Cannot be Negative",
                    min: "Minimum 1 digit requireds",
                },
                total_price: {
                    required: "Total Price is Required",
                    digits: "Total price Should Cannot be Negative",
                    min: "Minimum 1 digit required",
                },

                
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
