<?php

namespace App\Exceptions\Task;

use App\Exceptions\BaseException;

class TaskTimeException extends BaseException
{
    public function __construct(string $message = 'Wrong time', int $code = 400)
    {
        parent::__construct($message, $code);
    }

    public static function wrongStartTime(): self
    {
        return new self('Wrong start time');
    }

    public static function wrongEndTime(): self
    {
        return new self('Finish time must be after start time');
    }

    public static function wrongTimeNoEndTime(): self
    {
        return new self('Wrong time input. No end time.');
    }
}
