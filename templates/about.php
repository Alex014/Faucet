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

        p {
            color: black;
            margin-left:12px;
            font-size: medium;
            font-weight: bold;
        }

        button, a {
            background-color: black !important;
            color: green !important;
            font-weight: bold !important;
        }
        
        .nav-link.active {
            color: lime !important;
        }

        h1,h2,h3 {
            color: yellowgreen;
            margin-left:12px;
        }

        h1 {
            margin-top: 20px;
            text-align: center;
        }

        pre {
            font-size: medium;
            color: green;
            background-color: black;
            border-radius: 8px;
            padding: 12px;
            margin:12px;
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
            <a class="nav-link"  href="/token.php">Withdrawal $$$</a>
            </li>
            <li class="nav-item">
            <a class="nav-link active"  href="/about.php">About</a>
            </li>
        </ul>
        </div>
    </div>
    </nav>

    <div class="container">
        <h1>Proof of time concept</h1>

        <p>This is a first crypto-faucet representing "proof of time" concept using Privateness cryptocurrency (NESS and NCH).</p>

        <pre>
        — — — — — — — [LT] — — — — [T] — — — — — — — — [RT] — — — — NOW()
        </pre>

        <pre>
        T — token
        LT — nearest left token
        RT — nearest right
        token_dist (token distance): distance from token to NOW() moment.
        min_dist (minimum distance): distance to nearest token (LT or RT).
        progression_level: level of Arithmetic progression.
        time_price: price of one second of time.
        price: final price of token.
        </pre>

        <pre>
        progression = min_dist
        progression_level = 1

        while (progression < token_dist) {
            progression_level++
            progression += min_dist * progression_level
        }

        price = time_price * token_dist / progression_level
        </pre>

        <h2>Token</h2>

        <pre>
        token = “token_unixtime-signature”
        </pre>

        <h2>Signature</h2>
        <pre>
        sig = sign(priv-key, “H:M:S YYYY-MM-DD Privateness POT”)
        verify(pub-key, sig, “H:M:S YYYY-MM-DD Privateness POT”)
        </pre>

        <h2>Links</h2>
        <ul>
            <li> <a target=_blank href="https://github.com/Alex014/Faucet">Github</a> </li>
            <li> <a target=_blank href="https://ness-main-dev.medium.com/proof-of-time-improved-d648515afc45">Article (Medium)</a> </li>
            <li> <a target=_blank href="https://privateness.network">Privateness homepage</a> </li>
        </ul>
        
         

        <center>
            <img src="/assets/img/neoguns.jpeg"/>
        </center>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  </body>
</html>