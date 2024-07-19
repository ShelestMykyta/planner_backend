<?php

namespace App\Exceptions;

class BaseException extends \Exception
{
    use Render;

    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
}
