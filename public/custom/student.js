$(function () {
    $("form[name='student_form']").validate({
        rules: {
            name: "required",
            phone: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10,
            },
            email: {
                required: true,
                email: true,
            },
            fathername: {
                required: true,
                minlength: 3,
            },
            mothername: {
                required: true,
                minlength: 3,
            },
            guardian_name: {
                required: true,
                minlength: 3,
            },
            guardian_phone: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10,
            },
            password: {
                required: true,
                minlength: 5,
            },
            password_confirm: {
                required: true,
                minlength: 5,
                equalTo: "#confirm_password",
            },
            aadhar_number: {
                required: true,
                digits: true,
                minlength: 12,
                maxlength: 12,
            },
            current_address: {
                required: true,
            },
            permanent_address: {
                required: true,
            },
            dob: {
                required: true,
            },
        },
        messages: {
            name: "Please enter name",
            phone: {
                required: "Phone number is required",
                digits: "Phone number should be digits only",
                minlength: "Phone number should be of 10 digits",
                maxlength: "Phone number hould be of 10 digits only",
            },
            email: {
                required: "Email is required",
                email: "This is not a valid email",
            },
            fathername: {
                required: "Father name is required",
                minlength: "Please enter correct father's name",
            },
            mothername: {
                required: "Mother name is required",
                minlength: "Please enter correct mother's name",
            },
            guardian_name: {
                required: "Local guardian name required",
                minlength: "Please enter correct guardian name",
            },
            guardian_phone: {
                required: "Phone number is required",
                digits: "Phone number should be digits only",
                minlength: "Phone number should be of 10 digits",
                maxlength: "Phone number should be of 10 digits only",
            },
            password: {
                required: "This field is required",
                minlength: "Minimum 6 digit required ",
            },
            password_confirm: {
                required: "This Field s required",
                equalTo: "password",
            },
            aadhar_number: {
                required: "Aadhar number is required",
                digits: "Minimum 12 digit's required",
                minlength: "Aadhar number should be 12 digit",
                maxlength: "Aadhar number should be 12 digit only",
            },
            current_address: {
                required: "This field is required",
            },
            permanent_address: {
                required: "This field is required",
            },
            dob: {
                required: "DOB is required",
            },
        },
        submitHandler: function (form) {
            form.submit();
        },
    });
});
