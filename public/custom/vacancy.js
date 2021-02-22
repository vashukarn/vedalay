$(function() {
    $("form[name='vacancy_form']").validate({
        rules: {
                job_role: "required",
                required_no: {
                    digits: true,
                },
                salary: {
                    digits: true,
                },
                
                
            },
            messages: {
                job_role: "Designation is required",
                tuition_fee: {
                    digits: "Requirement Number should be positive",
                },
                salary: {
                    digits: "Requirement Number should be positive",
                },
                
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
