<?php
namespace lib;

require_once __DIR__ . '/interfaces/ITokenStorage.php';
require_once __DIR__ . '/interfaces/ICryptor.php';
require_once __DIR__ . '/TimeCryptor.php';
require_once __DIR__ . '/Ness.php';
require_once __DIR__ . '/Sqlite.php';

use lib\interfaces\ICrypto;
use \lib\interfaces\ICryptor;
use \lib\interfaces\ITokenStorage;
use \lib\TimeCryptor;
use \lib\Sqlite;
use \lib\Ness;

Container::$config = require_once(__DIR__ . '/../config/config.php');

class Container {
    public static $config = [];

    public static function Cryptor():  ICryptor
    {
        $keyfile = self::$config['keyfile'];
        $keydata = file_get_contents($keyfile);
        $keydata = json_decode($keydata, true);
        $private = $keydata['keys']['private'];
        $verify = $keydata['keys']['verify'];

        $db = new Sqlite(__DIR__ . '/../data/tokens.db');

        return new TimeCryptor($db, base64_decode($private), base64_decode($verify));
    }

    public static function Crypto():  ICrypto
    {
        return new Ness(
            self::$config['ness']['host'],
            self::$config['ness']['port'],
            self::$config['ness']['wallet'],
            self::$config['ness']['password'],
            self::$config['ness']['prefix'],
            self::$config['ness']['price'][0],
            self::$config['ness']['price'][1]
        );
    }
}
