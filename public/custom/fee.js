$(function() {
    $("form[name='fee_form']").validate({
        rules: {
                title: "required",
                tuition_fee: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                exam_fee: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                tuition_fee: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                transport_fee: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                sports_fee: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                stationery_fee: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                club_fee: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                hostel_fee: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                laundry_fee: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                eduaction_tax: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                eca_fee: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                late_fine: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                extra_fee: {
                    digits: true,
                    maxlength: 8,
                    min:1,
                },
                
            },
            messages: {
                title: "Title is required",
                tuition_fee: {
                    digits: "Tuition Fee should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                exam_fee: {
                    digits: "exam Fee should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                transport_fee: {
                    digits: "Transport Fee should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                sports_fee: {
                    digits: "sports  Fee should be in positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                stationery_fee: {
                    digits: "Stationery Fee should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                club_fee: {
                    digits: "Club Fee should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                hostel_fee: {
                    digits: "hostel Fee should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                laundry_fee: {
                    digits: "Laundry Fee should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                eduaction_tax: {
                    digits: "education Fee should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                eca_fee: {
                    digits: "ECA Fee should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                late_fine: {
                    digits: "Late fine Fee should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                extra_fee: {
                    digits: "Extra fee Fee should be positive",
                    maxlength: "Please enter a valid amount",
                    min:"Please enter a positive amount",
                },
                  
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
