<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="img/logo.png" type="image/png" />
    <title>SHRIVAHAN</title>
    <style>
        body, html {
          height: 100%;
          margin: 0;
        }

        a{color:#fff; text-decoration:none;}

        .bgimg {
          background-image: url({{ asset('img/forestbridge.jpg') }});
          height: 100%;
          background-position: center;
          background-size: cover;
          position: relative;
          color: white;
          font-family: "Courier New", Courier, monospace;
          font-size: 25px;
        }

        .topleft {
          position: absolute;
          top: 0;
          left: 16px;
         font-size:14px;
        }

        .bottomleft {
          position: absolute;
          bottom: 0;
          left: 16px;
        }

        .middle {
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          text-align: center;
        }

        hr {
          margin: auto;
          width: 40%;
        }
        </style>
</head>
<body>
    <div class="bgimg">
        <div class="topleft">
         <p></p>
        </div>
        <div class="middle">
           <a href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}"></a>
          <h1>SHRIVAHAN</h1>
          <h3>COMING SOON</h3>
          <p><a href="{{ url('/') }}">www.shrivahan.com</a><br>
              <span style="font-size:16px;">info@shrivahan.com</span>
          </p>
        </div>
        <div class="bottomleft">
      {{-- <p>Some text</p> --}}
        </div>
      </div>
</body>
</html>
