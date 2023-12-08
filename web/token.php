<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

require_once __DIR__ . '/../lib/Container.php';

use \lib\Container;

$crypto = Container::Crypto();
$cryptor = Container::Cryptor();

// $ness->health();
// var_dump($ness->listAddresses());

// 1701081726_F1JvojG3jR9quZmjspQO9C/vnk2GVWbJvIb9XtWN5BAtZ5KUax2o7p74WXOcJ7oGnUH71XZzvWX3qBcCeLG5AA==
// 1702027648_ocdzHuRNWi2xMZZ6Ow7+My1BpDatOJJDc9YljAt8lHX1XaQGtMo/NyLo9rZnbknXNCYkfSGxObEjVkq+uN/HCQ==

$token = '';
if (isset ($_POST['check']) && isset($_POST['token'])) {
    $token = $_POST['token'];
    $check = true;
    $err = true;

    try {
        if ($cryptor->check($token)) {
            throw new \Exception("Token is already payed");
        }

        if (! $cryptor->verify($token)) {
            throw new \Exception("Error verifying token");
        }

        $time = $cryptor->getTime($token);
        $date = date('s:i:h d.m.Y', $time);
        $time = time() - $time;
        $min_dist = $cryptor->getTokenDist($token);
        $length = $cryptor->getLength($token);
        $price_coins = $crypto->priceCoins($length);
        $price_hours = $crypto->priceHours($length);
        $address = '';
    } catch (\Throwable $th) {
        $err = $th->getMessage();
    }
} elseif (isset ($_POST['withdraw']) && isset($_POST['token']) && isset($_POST['address'])) {
    $token = $_POST['token'];
    $address = $_POST['address'];
    $withdraw = true;
    $err = true;

    try {
        if ($cryptor->check($token)) {
            throw new \Exception("Token isalready payed");
        }

        if (! $cryptor->verify($token)) {
            throw new \Exception("Error verifying token");
        }

        $time = $cryptor->getTime($token);
        $date = date('s:i:h d.m.Y', $time);
        $time = time() - $time;
        $min_dist = $cryptor->getTokenDist($token);
        $length = $cryptor->getLength($token);
        $price_coins = $crypto->priceCoins($length);
        $price_hours = $crypto->priceHours($length);

        $crypto->pay($length, $address);
        $cryptor->store($token);
    } catch (\Throwable $th) {
        $err = $th->getMessage();
    }
}

require __DIR__ . '/../templates/token-check-withdraw.php';
