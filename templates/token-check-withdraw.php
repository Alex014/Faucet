<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Privateness FAUCET</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


    <style>
        body {
            background: URL(/assets/img/faucet.jpg) no-repeat center center fixed;
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
            <a class="nav-link" href="/">Time token</a>
            </li>
            <li class="nav-item">
            <a class="nav-link active"  href="/token.php">Withdrawal $$$</a>
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
    <form method="POST">
        <div class="mb-3">
            <h1>Time token input</h1>
        </div>
        <div class="mb-3">

            <div class="input-group">
                <span class="input-group-text">Time token</span>
                <input name="token" type="text" class="form-control" id="token" value="<?=$token?>">
                <span class="input-group-text paste_button" data-id="token">Paste</span>
            </div>
            <br/>
            <?php if (isset($withdraw) || (isset($check) && isset($err) && (true === $err))): ?>
                <div class="input-group">
                    <span class="input-group-text">Address</span>
                    <input name="address" type="text" class="form-control" id="address" value="<?=$address?>">
                    <span class="input-group-text paste_button" data-id="address">Paste</span>
                </div>
            <?php endif; ?>

        </div>
        <div class="mb-3">
            <?php if ((isset($withdraw) && isset($err) && is_string($err)) || (isset($check) && isset($err) && (true === $err))): ?>
                <button class="btn btn-success" name="withdraw">Withdraw</button>
            <?php elseif (! isset($withdraw)): ?>
                <button class="btn btn-primary" name="check">Check token</button>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <?php if (isset($err) && is_string($err)): ?>
            <div class="alert alert-danger" role="alert">
            <?=$err?>
            </div>
            <?php elseif (isset($err) && (true === $err) && isset($check)): ?>
            <div class="alert alert-success" role="alert">
                <h3>Token is correct:</h3>
                Date: <?=$date?> <br/>
                Length in seconds: <?=$time?> <br/>
                Distance to nearest token: <?=$min_dist?> <br/>
                Calculated length: <?=$length?> <br/>
                Price: <?=$price_coins?> NESS coins and <?=$price_hours?> NESS Hours
            </div>
            <?php elseif (isset($err) && (true === $err) && isset($withdraw)): ?>
            <div class="alert alert-success" role="alert">
                <h3>Token has been withdrawn:</h3>
                Date: <?=$date?> <br/>
                Calculated length: <?=$length?> <br/>
                Price: <?=$price_coins?> NESS coins and <?=$price_hours?> NESS Hours
                To address: <?=$address?>
                <center>
                    <a class="btn btn-success" name="withdraw" href="/token.php">Go back</a>
                </center>
            </div>
            <?php endif; ?>
        </div>
    </form>
  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" crossorigin="anonymous">      </script>
    <script src="https://diriectordoc.github.io/jQlipboard/src/w0.3/jQlipboard.min.js"></script>
    <script>
        $(".paste_button").click(function (e) {
            $('#' + $(this).data('id')).focus();
            $('#' + $($this).data('id')).paste();
        })
    </script>
  </body>
</html>
