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
                item_id: "Item Field is Required",
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
