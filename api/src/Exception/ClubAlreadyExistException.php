<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class ClubAlreadyExistException extends ConflictHttpException
{
    private const MESSAGE = 'Club with name %s already exist';

    public static function fromName($name): self
    {
        throw new self(sprintf(self::MESSAGE, $name));
    }
}
