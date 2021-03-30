$(document).ready(function () {
    $("#level").select2({
        placeholder: "Choose Level",
    });
    $("#student").select2({
        placeholder: "Choose Students",
    });
    $("#level").val('');
});

$("#level").change(function () {
    var id = $(this).val();
    var students = $("#student");
    students.empty();
    $.ajax({
        type: "POST",
        url: $('meta[name="getstudentroute"]').attr("content"),
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: id,
        },
        success: function (data) {
            if (data == "No Data Found") {
                students.empty();
                alert(data);
            } else {
                students.empty();
                for (var i = 0; i < data.length; i++) {
                    students.append(
                        "<option value=" +
                            data[i].id +
                            ">" +
                            data[i].value +
                            "</option>"
                    );
                }
                students.change();
            }
        },
    });
});

$("#calculate").click(function () {
    var total =
        Number($("#tuition_fee").val()) +
        Number($("#exam_fee").val()) +
        Number($("#transport_fee").val()) +
        Number($("#stationery_fee").val()) +
        Number($("#sports_fee").val()) +
        Number($("#club_fee").val()) +
        Number($("#hostel_fee").val()) +
        Number($("#laundry_fee").val()) +
        Number($("#education_tax").val()) +
        Number($("#eca_fee").val()) +
        Number($("#late_fine").val()) +
        Number($("#extra_fee").val());
    $("#total_amount").val(total);
});

$(function () {
    $("form[name='fee_form']").validate({
        rules: {
            title: "required",
            level: "required",
            student: "required",
            total_amount: "required",
            tuition_fee: {
                digits: true,
                maxlength: 8,
                min: 0,
            },
            exam_fee: {
                digits: true,
                maxlength: 8,
                min: 0,
            },
            transport_fee: {
                digits: true,
                maxlength: 8,
                min: 0,
            },
            sports_fee: {
                digits: true,
                maxlength: 8,
                min: 0,
            },
            stationery_fee: {
                digits: true,
                maxlength: 8,
                min: 0,
            },
            club_fee: {
                digits: true,
                maxlength: 8,
                min: 0,
            },
            hostel_fee: {
                digits: true,
                maxlength: 8,
                min: 0,
            },
            laundry_fee: {
                digits: true,
                maxlength: 8,
                min: 0,
            },
            eduaction_tax: {
                digits: true,
                maxlength: 8,
                min: 0,
            },
            eca_fee: {
                digits: true,
                maxlength: 8,
                min: 0,
            },
            late_fine: {
                digits: true,
                maxlength: 8,
                min: 0,
            },
            extra_fee: {
                digits: true,
                maxlength: 8,
                min: 0,
            },
        },
        messages: {
            title: "Title is required",
            level: "Level selection is required",
            student: "Please select at least one student",
            total_amount: "Please Click Claculator Button",
            tuition_fee: {
                digits: "Tuition Fee should be positive",
                maxlength: "Please enter a valid amount",
                min: "Please enter a positive amount",
            },
            exam_fee: {
                digits: "Exam Fee should be positive",
                maxlength: "Please enter a valid amount",
                min: "Please enter a positive amount",
            },
            transport_fee: {
                digits: "Transport Fee should be positive",
                maxlength: "Please enter a valid amount",
                min: "Please enter a positive amount",
            },
            sports_fee: {
                digits: "Sports  Fee should be in positive",
                maxlength: "Please enter a valid amount",
                min: "Please enter a positive amount",
            },
            stationery_fee: {
                digits: "Stationery Fee should be positive",
                maxlength: "Please enter a valid amount",
                min: "Please enter a positive amount",
            },
            club_fee: {
                digits: "Club Fee should be positive",
                maxlength: "Please enter a valid amount",
                min: "Please enter a positive amount",
            },
            hostel_fee: {
                digits: "Hostel Fee should be positive",
                maxlength: "Please enter a valid amount",
                min: "Please enter a positive amount",
            },
            laundry_fee: {
                digits: "Laundry Fee should be positive",
                maxlength: "Please enter a valid amount",
                min: "Please enter a positive amount",
            },
            eduaction_tax: {
                digits: "Education Fee should be positive",
                maxlength: "Please enter a valid amount",
                min: "Please enter a positive amount",
            },
            eca_fee: {
                digits: "ECA Fee should be positive",
                maxlength: "Please enter a valid amount",
                min: "Please enter a positive amount",
            },
            late_fine: {
                digits: "Late fine Fee should be positive",
                maxlength: "Please enter a valid amount",
                min: "Please enter a positive amount",
            },
            extra_fee: {
                digits: "Extra fee Fee should be positive",
                maxlength: "Please enter a valid amount",
                min: "Please enter a positive amount",
            },
        },
        submitHandler: function (form) {
            form.submit();
        },
    });
});
