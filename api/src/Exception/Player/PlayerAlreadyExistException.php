<?php

namespace App\Exception\Player;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class PlayerAlreadyExistException extends ConflictHttpException
{
    private const MESSAGE = 'Player with name %s already exist';
    public static function fromName($name): self
    {
        throw new self(sprintf(self::MESSAGE, $name));
    }
}
