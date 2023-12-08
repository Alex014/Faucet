<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

require_once __DIR__ . '/../lib/Container.php';
require_once __DIR__ . '/../lib/Sqlite.php';

use \lib\Container;
use \lib\Sqlite;

$cryptor = Container::Cryptor();

$token = $cryptor->show(time());
$date = date("Y-m-d H:i:s");

require __DIR__ . '/../templates/token.php';
