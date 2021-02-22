$(function() {
    $("form[name='staff_form']").validate({
        rules: {
            name: "required",
            phone: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10,
            },
            position: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 5
            },
            password_confirm: {
                required: true,
                minlength: 5,
                equalTo: "#confirm_password"
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
                date: true
            },  
            joining_date: {
                required: true,
            },  
            salary: {
                required: true,
            },  
             
            },
            messages: {
            name: "Please enter name",
            phone: {
                required: "Phone number is required",
                digits: "Phone number should be digits only",
                minlength: "Phone number should be of 10 digits",
                maxlength: "Phone number should be of 10 digits only",
            },
            position: {
                required: "You need to add a designation to the staff",
            },
            email: {
                required: "Email is required",
                email: "This is not a valid email",
            },
            password: {
                required: "This field is required" ,
                minlength: "Minimum 6 digit required ",
            },  
            password_confirm: {
                required: "This Field s required",
                equalTo: "password",
            },
            aadhar_number: {
                required: "Aadhar number is required",
                digits: "Minimum 12 digit's required",
                minlength: "Aadhar number sholud be 12 digit",
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
                date: "Date format is required",
            },   
            joining_date: {
                required: "This field is required",
            },  
            salary: {
                required: "This field is required",
            },  
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
