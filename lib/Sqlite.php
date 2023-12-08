<?php
namespace lib;

require_once __DIR__ . '/interfaces/ITokenStorage.php';

use \lib\interfaces\ITokenStorage;

class Sqlite implements ITokenStorage {
    private $connection;

    public function __construct($db_filename)
    {
        if (! file_exists($db_filename)) {
            touch($db_filename);
        }

        $this->connection = new \PDO("sqlite:" . $db_filename);

        $sql = <<<SQL
            CREATE TABLE IF NOT EXISTS `tokens` (
            `time` UNSIGNED BIG INT PRIMARY KEY
            )
        SQL;

        $st = $this->connection->prepare($sql);

        return $st->execute();
    }


    public function store(int $unixtime)
    {
        $st = $this->connection->prepare(
            "INSERT INTO tokens (`time`) VALUES(?)");
        return $st->execute([$unixtime]);
    }

    public function check(int $unixtime): bool
    {
        $st = $this->connection->prepare("SELECT * FROM tokens WHERE `time` = ?");
        $st->execute([$unixtime]);
        $row = $st->fetch();

        return !empty( $row );
    }

    public function leftNearest(int $unixtime): int
    {
        $st = $this->connection->prepare("SELECT * FROM tokens WHERE `time` < ? ORDER BY `time` DESC");
        $st->execute([$unixtime]);
        
        $row = $st->fetch();

        if (! empty($row)) {
            return $row['time'];
        } else {
            return 0;
        }
    }

    public function rightNearest(int $unixtime): int
    {
        $st = $this->connection->prepare("SELECT * FROM tokens WHERE `time` > ? ORDER BY `time` ASC");
        $st->execute([$unixtime]);
        
        $row = $st->fetch();

        if (! empty($row)) {
            return $row['time'];
        } else {
            return 0;
        }
    }
    
    public function fromPeriod(int $from_time, int $to_time): array
    {
        $st = $this->connection->prepare(
            "SELECT * FROM tokens WHERE `time` > ? AND `time` < ?");
        $st->execute([$from_time, $to_time]);
        
        $rows = $st->fetchAll();

        if (! empty($rows)) {
            return array_map(function ($row) {
                return $row['time'];
            }, $rows);
        } else {
            return [];
        }
    }
    
}