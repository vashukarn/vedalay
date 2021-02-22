$(function() {
    $("form[name='salary_form']").validate({
        rules: {
                title: "required",
                monthly_salary: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                tada: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                extra_class_salary: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                incentive: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                transport_charges: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                leave_charges: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                bonus: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                advance_salary: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
               
                
            },
            messages: {
                title: "Title is required",
                monthly_salary: {
                    digits: "Monthly Salary should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                tada: {
                    digits: "Travelling Allowances & Daily Allowances Salary should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                extra_class_salary: {
                    digits: "Extra Class Bonus should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                incentive: {
                    digits: "Incentive should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                transport_charges: {
                    digits: "Transport Charges should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                leave_charges: {
                    digits: "Leave Charges should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                bonus: {
                    digits: "Bonus should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                advance_salary: {
                    digits: "Advance Salary should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                  
                  
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
