<?php
namespace lib;

require_once __DIR__ . '/interfaces/ICrypto.php';

use \lib\interfaces\ICrypto;


class Ness implements ICrypto {  
    private $host = '';
    private $port = 6460;
    private $wallet_id = '';
    private $password = '';
    private $prefix = '';
    private $price_coins = 0.000001;
    private $price_hours = 1;
    
    public function __construct(string $host, int $port, string $wallet_id, string $password = '', $prefix = 'http://', $price_coins = 0.000001, $price_hours = 1)
    {
      $this->prefix = $prefix;
      $this->host = $host;
      $this->port = $port;
      $this->wallet_id = $wallet_id;
      $this->password = $password;
      $this->price_coins = $price_coins;
      $this->price_hours = $price_hours;
    }
  
    public function health()
    {
      $responce = file_get_contents($this->prefix . $this->host . ":" . $this->port . "/api/v1/health");
      if (false !== $responce) {
        return json_decode($responce, true);
      } else {
        return false;
      }
    }

    public function listAddresses() 
    {
      $responce = file_get_contents($this->prefix . $this->host . ":" . $this->port . "/api/v1/wallet/balance?id=" . $this->wallet_id);
      $responce = json_decode($responce, true);
      
      return $responce['addresses'];
    }

    private function _pay(array $from_addr, string $to_addr, float $coins, int $hours) 
    {
      $responce = file_get_contents($this->prefix . $this->host . ":" . $this->port . "/api/v1/csrf");
  
      $responce = json_decode($responce, true);
      $token = $responce["csrf_token"];

      $from_addr = array_map(function($addr) {
        return "\"$addr\"";
      }, $from_addr);

      $from_addr = implode(',', $from_addr);
  
      $body = <<<BODY
      {
          "hours_selection": {
              "type": "manual"
          },
          "wallet_id": "$this->wallet_id",
          "password": "$this->password",
          "addresses": [$from_addr],
          "to": [{
              "address": "$to_addr",  
              "coins": "$coins",
              "hours": "$hours"
          }]
      }
BODY;
  
      $ch = curl_init($this->prefix . $this->host . ":" . $this->port . "/api/v1/wallet/transaction");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'X-CSRF-Token: '.$token));
      curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
  
      $output = curl_exec($ch);
      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  
      if (200 !== $httpcode) {
        $msg = explode(' - ', $output, 2);
  
        if(2 === count($msg)) {
          $msg = $msg[1];
        } else {
          $msg = $msg[0];
        }
  
        throw new \Exception($msg);
      }
  
      $json_output = json_decode($output, true);
      $encoded_transaction = $json_output['encoded_transaction'];
  
      $body = '{"rawtx": "' . $encoded_transaction . '"}';
  
      // var_dump($output); 
      // die();
  
      $ch = curl_init($this->prefix . $this->host . ":" . $this->port . "/api/v1/injectTransaction");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'X-CSRF-Token: '.$token));
      curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
      $output = curl_exec($ch);
  
  
      return true;
    }

    public function priceCoins(int $seconds): float
    {
      return $this->price_coins * $seconds;
    }

    public function priceHours(int $seconds): float
    {
      return $this->price_hours * $seconds;
    }

    public function pay(int $seconds, string $to_addr) 
    {
      if (empty($to_addr)) {
          throw new \Exception("Address is empty");
      }

      $addresses = $this->listAddresses();
      $addrs = [];

      foreach ($addresses as $addr => $record) {
        $addrs[] = $addr;
      }
      
      $this->_pay($addrs, $to_addr, $this->priceCoins($seconds), $this->priceHours($seconds));
    }
}