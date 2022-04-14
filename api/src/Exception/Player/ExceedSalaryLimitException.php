<?php


namespace App\Exception\Player;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class ExceedSalaryLimitException extends ConflictHttpException
{
    private const MESSAGE = 'The player %s exceed the salary limit';

    public static function fromName($name): self
    {
        throw new self(sprintf(self::MESSAGE, $name));
    }
}