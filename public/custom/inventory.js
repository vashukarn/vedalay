$(function() {
    $("form[name='inventory_form']").validate({
        rules: {
            item_id: "required",
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
                item_id: "Please select product",
                quantity: {
                    required: "Quantity is required",
                    digits: " Quantity cannot be a negative value",
                    min: "Value cannot be less than one",
                },
                total_price: {
                    required: "Total Price is Required",
                    digits: "Price cannot be a negative value",
                    min: "Value cannot be less than one",
                },

                
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
