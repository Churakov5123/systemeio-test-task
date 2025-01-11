<?php

declare(strict_types=1);

namespace App\ApiBundle\Dto;

use App\ApiBundle\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseDto
{
    /**
     * @param Request $request
     * @return void
     *
     * @throws BadRequestException
     */
    public function fillFromRequest(Request $request): void
    {
        $data = $this->getDataFromRequest($request);

        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * @param Request $request
     * @return array
     *
     * @throws BadRequestException
     */
    private function getDataFromRequest(Request $request): array
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            throw new BadRequestException();
        }

        return $data;
    }
}
