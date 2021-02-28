$(function() {
    $("form[name='result_form']").validate({
        rules: {
                level_id : 'required',
                exam_id : 'required',
                student_id : 'required',
                total_marks :{
                    digits: true,
                    min: 0,
                    
                },
                marks_obtained :{
                    digits: true,
                },
                percentage :{
                    digits: true,
                    minlength: 0,
                    max: 100,
                },
                sgpa :{
                    digits: true,
                    min: 0,
                    max: 10,
                },
               
                status : 'required',

            },
            messages: {
                level_id : "Select level is required",
                exam_id : "Select exam is required",
                student_id : "Select Student is required",
                total_marks :{
                    digits: "Total marks should be digits only",
                    min:"Total marks should be positive",
                },
                marks_obtained :{
                    digits: "Marks obtained should be digits only",
                },
                percentage :{
                    digits: "Percentage should be digits only",
                    min: "This field is required",
                    max: "Pecentage should not more than 100",
                },
                sgpa :{
                    digits: "SGPA should be digits only",
                    min: "This field is required",
                    max: "SGPA should not be more than 10",
                },
                status : "This field is required",
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
