$(document).ready(function () {
    $("#level_id").val("");
    $("#feedetail").hide();
    $("#feepayment").hide();
    $("#bank_details").hide();
    $("#forupi").hide();
    $("#forcard").hide();
    $("#phone_det").hide();
    $("#student_id").select2({
        placeholder: "Please Select Student",
    });
});
$("#level_id").change(function () {
    tuition = 0;
    exam = 0;
    transport = 0;
    stationery = 0;
    sports = 0;
    club = 0;
    hostel = 0;
    laundry = 0;
    education = 0;
    eca = 0;
    extra = 0;
    late = 0;
    total = 0;
    $("#feedetail").hide();
    $("#feepayment").hide();
    $("#tablebody").empty();
    var id = $(this).val();
    var students = $("#student_id");
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

var tuition = 0;
var exam = 0;
var transport = 0;
var stationery = 0;
var sports = 0;
var club = 0;
var hostel = 0;
var laundry = 0;
var education = 0;
var eca = 0;
var extra = 0;
var late = 0;
var total = 0;
$("#student_id").change(function () {
    tuition = 0;
    exam = 0;
    transport = 0;
    stationery = 0;
    sports = 0;
    club = 0;
    hostel = 0;
    laundry = 0;
    education = 0;
    eca = 0;
    extra = 0;
    late = 0;
    total = 0;
    $("#feedetail").hide();
    $("#feepayment").hide();
    var tablebody = $("#tablebody");
    tablebody.empty();
    var id = $(this).val();
    $.ajax({
        type: "POST",
        url: $('meta[name="getFeeDetails"]').attr("content"),
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: id,
        },
        success: function (data) {
            if (data.length < 1) {
                alert("No Fee Data Found");
            } else {
                $("#feedetail").show();
                $("#feepayment").show();
                tablebody.empty();
                for (var i = 0; i < data.length; i++) {
                    total += Number(data[i].total_amount);
                    late += Number(data[i].late_fine);
                    extra += Number(data[i].extra_fee);
                    eca += Number(data[i].eca_fee);
                    education += Number(data[i].education_tax);
                    laundry += Number(data[i].laundry_fee);
                    hostel += Number(data[i].hostel_fee);
                    club += Number(data[i].club_fee);
                    sports += Number(data[i].sports_fee);
                    stationery += Number(data[i].stationery_fee);
                    transport += Number(data[i].transport_fee);
                    exam += Number(data[i].exam_fee);
                    tuition += Number(data[i].tuition_fee);
                    tablebody.append("<tr>");
                    tablebody.append(
                        "<td>" + data[i].created_at.split("T")[0] + "</td>"
                    );
                    tablebody.append("<td>" + data[i].tuition_fee + "</td>");
                    tablebody.append("<td>" + data[i].exam_fee + "</td>");
                    tablebody.append("<td>" + data[i].transport_fee + "</td>");
                    tablebody.append("<td>" + data[i].stationery_fee + "</td>");
                    tablebody.append("<td>" + data[i].sports_fee + "</td>");
                    tablebody.append("<td>" + data[i].club_fee + "</td>");
                    tablebody.append("<td>" + data[i].hostel_fee + "</td>");
                    tablebody.append("<td>" + data[i].laundry_fee + "</td>");
                    tablebody.append("<td>" + data[i].education_tax + "</td>");
                    tablebody.append("<td>" + data[i].eca_fee + "</td>");
                    tablebody.append("<td>" + data[i].late_fine + "</td>");
                    tablebody.append("<td>" + data[i].extra_fee + "</td>");
                    tablebody.append("<td>" + data[i].total_amount + "</td>");
                    tablebody.append("</tr>");
                }

                tablebody.append("<tr>");
                tablebody.append("<td>Grand Total</td>");
                tablebody.append("<td>" + tuition + "</td>");
                tablebody.append("<td>" + exam + "</td>");
                tablebody.append("<td>" + transport + "</td>");
                tablebody.append("<td>" + stationery + "</td>");
                tablebody.append("<td>" + sports + "</td>");
                tablebody.append("<td>" + club + "</td>");
                tablebody.append("<td>" + hostel + "</td>");
                tablebody.append("<td>" + laundry + "</td>");
                tablebody.append("<td>" + education + "</td>");
                tablebody.append("<td>" + eca + "</td>");
                tablebody.append("<td>" + late + "</td>");
                tablebody.append("<td>" + extra + "</td>");
                tablebody.append("<td>" + total + "</td>");
                tablebody.append("</tr>");
            }
        },
    });
});

$("#payment_method").change(function () {
    var val = $(this).val();
    if (val == "Bank Transfer") {
        $("#bank_details").show();
        $("#forupi").hide();
        $("#phone_det").hide();
        $("#forcard").hide();
    } else if (val == "UPI") {
        $("#bank_details").hide();
        $("#forcard").hide();
        $("#forupi").show();
        $("#phone_det").show();
    } else if (val == "Paytm") {
        $("#bank_details").hide();
        $("#forupi").hide();
        $("#forcard").hide();
        $("#phone_det").show();
    } else if (val == "Card") {
        $("#bank_details").hide();
        $("#forupi").hide();
        $("#phone_det").hide();
        $("#forcard").show();
    } else {
        $("#bank_details").hide();
        $("#forupi").hide();
        $("#phone_det").hide();
        $("#forcard").hide();
    }
});

$("#calculate").click(function () {
    var calculatetotal =
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
    $("#total_amount").val(calculatetotal);
    $("#advancewarn").empty();
    var advancefee = Number(calculatetotal) - Number(total);
    console.log(calculatetotal);
    console.log(total);
    if (calculatetotal > total) {
        $("#advancewarn").append(
            "You will be paying advance fee amount : " +
                advancefee +
                ". It can be deducted on next fee payment."
        );
    }
});

$("#autofill").click(function () {
    $("#tuition_fee").val(Number(tuition));
    $("#exam_fee").val(Number(exam));
    $("#transport_fee").val(Number(transport));
    $("#stationery_fee").val(Number(stationery));
    $("#sports_fee").val(Number(sports));
    $("#club_fee").val(Number(club));
    $("#hostel_fee").val(Number(hostel));
    $("#laundry_fee").val(Number(laundry));
    $("#education_tax").val(Number(education));
    $("#eca_fee").val(Number(eca));
    $("#late_fine").val(Number(late));
    $("#extra_fee").val(Number(extra));
    $("#total_amount").val(Number(total));
});

$(function () {
    $("form[name='feepayment_form']").validate({
        rules: {
            title: "required",
            level_id: "required",
            student_id: "required",
            payment_method: "required",
            bank_ifsc: "required",
            bank_accountno: {
                required: true,
                digits: true,
            },
            card_type: "required",
            transfer_phone: {
                required: true,
                digits: true,
                maxlength: 10,
                minlength: 10,
                min: 0,
            },
            upi_type: "required",
            transfer_date: {
                required: true,
                date: true,
            },
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
            level_id: "Please select level",
            student_id: "Please select student",
            payment_method: "Please select mode of payment",
            bank_ifsc: "Enter bank IFSC number",
            bank_accountno: {
                required: "Bank account number is required",
                digits: "Bank number should be in digits",
            },
            card_type: "Please select card type",
            transfer_phone: {
                required: "Please enter phone number from which amount is transferred",
                digits: "Phone number should be digits",
                maxlength: "Phone number should be of 10 digits only",
                minlength: "Phone number should be of 10 digits",
                min: "Phone number cannot be less than zero",
            },
            upi_type: "Please select the UPI type",
            transfer_date: {
                required: "Please add transfer date (if not enter today's date)",
                date: "The input should be date",
            },
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
