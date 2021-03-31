<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Fee Added to your Account</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" rel="stylesheet">
    <style>
html,
body {
    margin: 0 auto !important;
    padding: 0 !important;
    height: 100% !important;
    width: 100% !important;
    background: #f1f1f1;
}

* {
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
}
div[style*="margin: 16px 0"] {
    margin: 0 !important;
}
table,
td {
    mso-table-lspace: 0pt !important;
    mso-table-rspace: 0pt !important;
}
table {
    border-spacing: 0 !important;
    border-collapse: collapse !important;
    table-layout: fixed !important;
    margin: 0 auto !important;
}
img {
    -ms-interpolation-mode:bicubic;
}
a {
    text-decoration: none;
}
*[x-apple-data-detectors],
.unstyle-auto-detected-links *,
.aBn {
    border-bottom: 0 !important;
    cursor: default !important;
    color: inherit !important;
    text-decoration: none !important;
    font-size: inherit !important;
    font-family: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
}
.a6S {
    display: none !important;
    opacity: 0.01 !important;
}
.im {
    color: inherit !important;
}
img.g-img + div {
    display: none !important;
}
@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
    u ~ div .email-container {
        min-width: 320px !important;
    }
}
@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
    u ~ div .email-container {
        min-width: 375px !important;
    }
}
@media only screen and (min-device-width: 414px) {
    u ~ div .email-container {
        min-width: 414px !important;
    }
}
</style>
<style>

	    .primary{
	background: #17bebb;
}
.bg_white{
	background: #ffffff;
}
.bg_light{
	background: #f7fafa;
}
.bg_black{
	background: #000000;
}
.bg_dark{
	background: rgba(0,0,0,.8);
}
.email-section{
	padding:2.5em;
}

/*BUTTON*/
.btn{
	padding: 10px 15px;
	display: inline-block;
}
.btn.btn-primary{
	border-radius: 5px;
	background: #808080;
	color: #ffffff;
}
.btn.btn-white{
	border-radius: 5px;
	background: #ffffff;
	color: #000000;
}
.btn.btn-white-outline{
	border-radius: 5px;
	background: transparent;
	border: 1px solid #fff;
	color: #fff;
}
.btn.btn-black-outline{
	border-radius: 0px;
	background: transparent;
	border: 2px solid #000;
	color: #000;
	font-weight: 700;
}
.btn-custom{
	color: rgba(0,0,0,.3);
	text-decoration: underline;
}

h1,h2,h3,h4,h5,h6{
	font-family: 'Poppins', sans-serif;
	color: #000000;
	margin-top: 0;
	font-weight: 400;
}

body{
	font-family: 'Poppins', sans-serif;
	font-weight: 400;
	font-size: 15px;
	line-height: 1.8;
	color: rgba(0,0,0,.4);
}

a{
	color: #17bebb;
}

table{
    border-collapse: collapse;
    width: 80%;
}

td, th {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

/*LOGO*/

.logo h1{
	margin: 0;
}
.logo h1 a{
	color: #808080;
	font-size: 24px;
	font-weight: 700;
	font-family: 'Poppins', sans-serif;
}


@media screen and (max-width: 500px) {


}


    </style>


</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;">
	<center style="width: 100%; background-color: #f1f1f1;">
    <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
      &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
    </div>
    <div style="max-width: 600px; margin: 0 auto;" class="email-container">
    	<!-- BEGIN BODY -->
      <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
      	<tr>
          <td valign="top" class="bg_white" style="padding: 1em 2.5em 0 2.5em;">
          	<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
          		<tr>
          			<td class="logo" style="text-align: center;">
			            <h1><a href="https://www.vedyalay.com/">Vedyalay</a></h1>
			          </td>
          		</tr>
          	</table>
          </td>
	      </tr><!-- end tr -->
				<tr>
          <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
            		<td style="padding: 0 2.5em; text-align: center; padding-bottom: 3em;">
            			<div class="text">
            				<h3>{{ $name }}, Fee has been added to your account.</h3>
            			</div>
            		</td>
            	</tr>

                <table>
                    <tr>
                      <th>Fee</th>
                      <th>Amount</th>
                    </tr>
                    @if(isset($fee_info->tuition_fee))
                        <tr>
                        <td>Tuition Fee</td>
                        <td>Rs. {{ $fee_info->tuition_fee }}</td>
                        </tr>
                    @endif
                    @if(isset($fee_info->exam_fee))
                        <tr>
                        <td>Exam Fee</td>
                        <td>Rs. {{ $fee_info->exam_fee }}</td>
                        </tr>
                    @endif
                    @if(isset($fee_info->transport_fee))
                        <tr>
                        <td>Transport Fee</td>
                        <td>Rs. {{ $fee_info->transport_fee }}</td>
                        </tr>
                    @endif
                    @if(isset($fee_info->stationery_fee))
                        <tr>
                        <td>Stationery Fee</td>
                        <td>Rs. {{ $fee_info->stationery_fee }}</td>
                        </tr>
                    @endif
                    @if(isset($fee_info->sports_fee))
                        <tr>
                        <td>Sports Fee</td>
                        <td>Rs. {{ $fee_info->sports_fee }}</td>
                        </tr>
                    @endif
                    @if(isset($fee_info->club_fee))
                        <tr>
                        <td>Club Fee</td>
                        <td>Rs. {{ $fee_info->club_fee }}</td>
                        </tr>
                    @endif
                    @if(isset($fee_info->hostel_fee))
                        <tr>
                        <td>Hostel Fee</td>
                        <td>Rs. {{ $fee_info->hostel_fee }}</td>
                        </tr>
                    @endif
                    @if(isset($fee_info->laundry_fee))
                        <tr>
                        <td>Laundry Fee</td>
                        <td>Rs. {{ $fee_info->laundry_fee }}</td>
                        </tr>
                    @endif
                    @if(isset($fee_info->education_tax))
                        <tr>
                        <td>Education Tax</td>
                        <td>Rs. {{ $fee_info->education_tax }}</td>
                        </tr>
                    @endif
                    @if(isset($fee_info->eca_fee))
                        <tr>
                        <td>ECA Fee</td>
                        <td>Rs. {{ $fee_info->eca_fee }}</td>
                        </tr>
                    @endif
                    @if(isset($fee_info->late_fine))
                        <tr>
                        <td>Late Fine</td>
                        <td>Rs. {{ $fee_info->late_fine }}</td>
                        </tr>
                    @endif
                    @if(isset($fee_info->extra_fee))
                        <tr>
                        <td>Extra Fee</td>
                        <td>Rs. {{ $fee_info->extra_fee }}</td>
                        </tr>
                    @endif
                    @if(isset($fee_info->total_amount))
                        <tr>
                        <td>Total Amount</td>
                        <td>Rs. {{ $fee_info->total_amount }}</td>
                        </tr>
                    @endif
                  </table>

            </table>
          </td>
	      </tr>
      </table>
    </div>
  </center>
</body>
</html>
