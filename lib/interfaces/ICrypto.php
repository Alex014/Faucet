<?php
namespace lib\interfaces;

interface ICrypto {
    public function pay(int $seconds, string $to_addr) ;
}