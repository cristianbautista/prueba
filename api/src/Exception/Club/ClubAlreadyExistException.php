<?php

namespace App\Exception\Club;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class ClubAlreadyExistException extends ConflictHttpException
{
    private const MESSAGE = 'Club with name %s already exist';
    private const MESSAGE_NOT_PRESUPPOSITION = 'Club with name %s is not presupposition';
    private const MESSAGE_NOT_EXIST_CLUB = 'Club with name %s is not exist';

    public static function fromName($name): self
    {
        throw new self(sprintf(self::MESSAGE, $name));
    }

    public static function fromPresupposition($name): self
    {
        throw new self(sprintf(self::MESSAGE_NOT_PRESUPPOSITION, $name));
    }

    public static function notExistClub($name): self
    {
        throw new self(sprintf(self::MESSAGE_NOT_EXIST_CLUB, $name));
    }
}
