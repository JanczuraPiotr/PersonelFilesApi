<?php

namespace App\Core\Exception;

abstract class Exception extends \Exception
{

    public function __construct(string $message)
    {
        parent::__construct($message);
    }

}

