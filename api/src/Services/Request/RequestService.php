<?php

namespace App\Services\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestService
{
    /**
     * @param Request $request
     * @param string $fieldName
     * @param bool $isRequired
     * @param bool $isArray
     * @return mixed|null
     */
    public static function getField(
        Request $request,
        string $fieldName,
        bool $isRequired = true,
        bool $isArray = false
    ) {
        $requestData = \json_decode($request->getContent(), true);
        if ($isArray) {
            $arrayData = self::arrayFlatter($requestData);
            foreach ($arrayData as $key => $value) {
                if ($fieldName === $key) {
                    return $value;
                }
            }
            if ($isRequired) {
                throw new BadRequestHttpException(\sprintf('Missing field %s', $fieldName));
            }
            return null;
        }
        if (array_key_exists($fieldName, $requestData)) {
            return $requestData[$fieldName];
        }

        if ($isRequired) {
            throw new BadRequestHttpException(\sprintf('Missing field %s', $fieldName));
        }
    }

    public static function arrayFlatter(array $array): array
    {
        $return = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $return  = array_merge($return, self::arrayFlatter($value));
            } else {
                $return[$key] = $value;
            }
        }
        return $return;
    }
}
