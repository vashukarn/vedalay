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
            emailone: {
                email: true,
            },
            emailtwo: {
                email: true,
            },
            phoneone: {
                digits: true,
                minlength: 10,
                maxlength: 10,
            },
            phonetwo: {
                digits: true,
                minlength: 10,
                maxlength: 10,
            },
        },
        // Specify validation error messages
        messages: {
            emailone: {
                email: "Value entered should be an email",
            },
            emailtwo: {
                email: "Value entered should be an email",
            },
            phoneone: {
                digits: "Phone number should be digits only",
                minlength: "Phone number should be of 10 digits",
                maxlength: "Phone number should be of 10 digits only",
            },
            phonetwo: {
                digits: "Phone number should be digits only",
                minlength: "Phone number should be of 10 digits",
                maxlength: "Phone number should be of 10 digits only",
            },

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});