$("input[name=is_meta]").change(function(e) {
    var is_meta = $(this).val();
    UpdateMeta(is_meta);
});

function UpdateMeta(is_meta) {
    if (is_meta == "NO") {
        $("div#metatag-details").hide();
    }
    if (is_meta == "YES") {
        $("div#metatag-details").show();
    }
}


$("input[name=is_favicon]").change(function(e) {
    var is_favicon = $(this).val();
    UpdateFavOg(is_favicon);
});

function UpdateFavOg(is_favicon) {
    if (is_favicon == "NO") {
        $("div#fav_icon-details").hide();
    }
    if (is_favicon == "YES") {
        $("div#fav_icon-details").show();
    }
}

$(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='appsetting_form']").validate({
        // Specify validation rules
        rules: {
           
            email: {
                email: true,
            },
            phone: {
                digits: true,
                minlength: 10,
                maxlength: 10,
            },
          
           

        },
        // Specify validation error messages
        messages: {
            name: "Please enter company name",
            address: "Please enter address",
            email: {
                required: "Please enter email address",
                email: "Value entered should be email",
            },
            phone: {
                required: "Phone number is required",
                digits: "Phone number should be digits only",
                minlength: "Phone number should be of 10 digits",
                maxlength: "Phone number should be of 10 digits only",
            },
            commission: {
                required: "Commission is required",
                digits: "Commission should be in numbers only",
            },
            vat: {
                number: "The value should be numeric",
            },
            front_feature_description: "Please enter front feature description",
            front_counter_description: "Please enter front counter description",
            front_testimonial_description: "Please enter front testimonial description",
            otp_expire: {
                required: "OTP expire time is required",
                digits: "Please enter the value in minutes",
            },

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});