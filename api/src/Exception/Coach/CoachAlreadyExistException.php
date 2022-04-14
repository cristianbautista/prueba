<?php

namespace App\Exception\Coach;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class CoachAlreadyExistException extends ConflictHttpException
{
    private const MESSAGE = 'Coach with name %s already exist';

    public static function fromName($name): self
    {
        throw new self(sprintf(self::MESSAGE, $name));
    }
}
