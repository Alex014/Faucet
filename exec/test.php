<?php
require_once __DIR__ . '/../lib/Sqlite.php';
require_once __DIR__ . '/../lib/TimeCryptor.php';

use \lib\Sqlite;
use \lib\TimeCryptor;

ini_set('display_errors', true);
error_reporting(E_ALL);

if (file_exists(__DIR__ . '/../config/config.php')) {
    echo "config.php - OK";
} else {
    echo "config.php - FAILED";
}

echo "\n";

$db = new Sqlite(__DIR__ . '/../data/tokens.db');

echo "Sqlite DB - OK";

echo "\n";

$config = require_once(__DIR__ . '/../config/config.php');

$keyfile = $config['keyfile'];
$keydata = file_get_contents($keyfile);
$keydata = json_decode($keydata, true);
$private = $keydata['keys']['private'];
$verify = $keydata['keys']['verify'];

$db = new Sqlite(__DIR__ . '/../data/tokens.db');

$tc = new TimeCryptor($db, base64_decode($private), base64_decode($verify));
$token = $tc->show(time());

echo "Token [$token] - OK";


echo "\n";