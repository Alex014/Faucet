<?php
namespace lib\interfaces;

interface ICryptor {
    public function show(int $unixtime): string;
    public function check(string $token): bool;
    public function store(string $token);
    public function verify(string $token): bool;
    public function getTime(string $token): int;
    public function getLength(string $token): int;
    public function getSig(string $token): string;
}
