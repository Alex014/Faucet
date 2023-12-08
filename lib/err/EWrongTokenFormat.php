<?php
namespace lib\err;

use \Throwable;

class EWrongTokenFormat extends \Exception {
    public function __construct(string $message, int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            "Wrong token format: $message", 
            $code, 
            $previous
        );
    }
}
