<?php
namespace lib;

require_once __DIR__ . '/interfaces/ITokenStorage.php';
require_once __DIR__ . '/interfaces/ICryptor.php';
require_once __DIR__ . '/err/EWrongTokenFormat.php';

use Exception;
use \lib\interfaces\ICryptor;
use \lib\interfaces\ITokenStorage;
use \lib\err\EWrongTokenFormat;

class TimeCryptor implements ICryptor {
    private string $private;
    private string $verify;
    private ITokenStorage $db;
    
    public function __construct(ITokenStorage $db, string $private, string $verify)
    {
        $this->db = $db;
        $this->private = $private;
        $this->verify = $verify;
    }

    public function check(string $token): bool
    {
        $time = $this->getTime($token);
        return $this->db->check($time);
    }

    public function store(string $token)
    {
        $time = $this->getTime($token);
        $this->db->store($time);
    }

    public function show(int $unixtime): string
    {
        // https://ness-main-dev.medium.com/proof-of-time-another-variant-e423b58de9c0
        // sig = sign(priv-key, “S:M:H YYYY-MM-DD Privateness POT”)
        $string = date("s:i:H Y-m-d", $unixtime)." Privateness POT";
        $keypair = sodium_crypto_box_keypair_from_secretkey_and_publickey($this->private, $this->verify);
        $sig = sodium_crypto_sign_detached($string, $keypair);

        return $unixtime . '_' . base64_encode($sig);
    }

    public function verify(string $token): bool
    {
        if (empty($token)) {
            throw new \Exception("Token is empty");
        }

        $token = explode('_', $token);

        if (2 !== count($token)) {
            throw new EWrongTokenFormat("must be UNIXTIME_SIGNATURE", 1);
        }

        $unixtime = $token[0];
        $string = date("s:i:H Y-m-d", $unixtime)." Privateness POT";

        if (false === $string) {
            throw new EWrongTokenFormat("error decoding UNIXTIME", 1);
        }

        $sig = base64_decode($token[1]);

        return sodium_crypto_sign_verify_detached($sig, $string, $this->verify);
    }
    
    public function getTime(string $token): int
    {
        $token = explode('_', $token);
        return (int) $token[0];
    }
    
    public function getSig(string $token): string
    {
        $token = explode('_', $token);
        return $token[1];
    }
    
    public function getTokenDist(string $token): int
    {
        $time = $this->getTime($token);
        $token_dist = time() - $time;
        $left = $this->db->leftNearest($time);
        $right = $this->db->rightNearest($time);

        if (empty($left) && empty($right)) {
            return $token_dist;
        }

        if (empty($left)) {
            $min_dist = $right - $time;
        } elseif (empty($right)) {
            $min_dist = $time - $left;
        } else {
            $left_dist = $time - $left;
            $right_dist = $right - $time;
            
            if ($right_dist < $left_dist) {
                $min_dist = $right_dist;
            } else {
                $min_dist = $left_dist;
            }
        }

        return $min_dist;
    }
    
    public function getLength(string $token): int
    {
        // https://ness-main-dev.medium.com/proof-of-time-improved-d648515afc45
        $time = $this->getTime($token);
        $token_dist = time() - $time;

        $min_dist = $this->getTokenDist($token);

        if($token_dist < $min_dist) {
            return $token_dist;
        }

        $progression = $min_dist;
        $progression_level = 1;
        
        while ($progression < $token_dist) {
          $progression_level ++;
          $progression += $min_dist * $progression_level;
        }
        
        $length = round($token_dist / $progression_level);

        if ($length < $min_dist) {
            $length = $min_dist;
        }

        return $length;
    }
    
}