<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Privateness FAUCET</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        body {
            background: URL(/assets/img/ness-green.jpg) no-repeat center center fixed;
            background-size: cover;
            background-color: black !important;
        }

        nav,.container-fluid {
            background-color: black !important;
            color: green !important;
            font-weight: bold !important;
        }

        button, a {
            background-color: black !important;
            color: green !important;
            font-weight: bold !important;
        }
        
        .nav-link.active {
            color: lime !important;
        }

        h1 {
            color: yellowgreen;
            margin-top: 20px;
        }

        .form-control,.input-group,.input-group-text {
            background-color: black;
            color: green;
            font-weight: bold;
        }

        .form-control:focus {
            background-color: black;
            color: lime;
        }

        .paste_button {
            cursor: pointer;
            color: lime;
            text-decoration: underline;
            background-color: black;
        }

        .copy-button {
            height: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;

        }
        
        .copy-button:active {
             background-color: lightgreen;
        }

        .tip {
            background-color: #263646;
            padding: 0 14px;
            line-height: 27px;
            position: absolute;
            border-radius: 4px;
            z-index: 100;
            color: #fff;
            font-size: 12px;
            animation-name: tip;
            animation-duration: .6s;
            animation-fill-mode: both;
        }

        .tip:before {
            content: "";
            background-color: #263646;
            height: 10px;
            width: 10px;
            display: block;
            position: absolute;
            transform: rotate(45deg);
            top: -4px;
            right: 17px;
        }

        #copied_tip {
            animation-name: come_and_leave;
            animation-duration: 1s;
            animation-fill-mode: both;
            bottom: -35px;
            right: 2px;
            float: right;
        }

        #copy_button {
            cursor: pointer;
            color: lime;
            text-decoration: underline;
            background-color: black;
        }
    </style>
  </head>
  <body>



  <nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: black !important;">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">FAUCET</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link active" href="/">Time token</a>
            </li>
            <li class="nav-item">
            <a class="nav-link"  href="/token.php">Withdrawal $$$</a>
            </li>
            <li class="nav-item">
            <a class="nav-link"  href="/about.php">About</a>
            </li>
        </ul>
        </div>
    </div>
    </nav>

  <div class="container text-center">

  <div class="row">
    <div class="mb-3">
        <h1>Time token (<?=$date?>)</h1>
    </div>
    <div class="mb-3">

        <div class="input-group">
            <span class="input-group-text">Time token</span>
            <input type="text" class="form-control" value="<?=$token?>" id="token">
            <span class="input-group-text" onclick="copy('#token','#copy_button')" id="copy_button">Copy</span>
        </div>

    </div>
    <div class="mb-3">
        <a class="btn btn-primary" href="javascript:location.reload()">Reload</a>
        <a class="btn btn-success" href="/token.php">Withdraw token $$$</a>
    </div>
  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" crossorigin="anonymous">      </script>
    <script>
        function copy(id_input, target) {
            setTimeout(function() {
                $('#copied_tip').remove();
            }, 800);
            $(target).append("<div class='tip' id='copied_tip'>Copied!</div>");
            var input = $(id_input)[0];
            input.select();
            var result = document.execCommand('copy');
            return result;
        }
    </script>
  </body>
</html>