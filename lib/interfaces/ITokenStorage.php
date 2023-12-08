<?php
namespace lib\interfaces;

interface ITokenStorage {
    public function store(int $unixtime);
    public function check(int $unixtime): bool;
    public function leftNearest(int $unixtime): int;
    public function rightNearest(int $unixtime): int;
    public function fromPeriod(int $from_time, int $to_time): array;
}