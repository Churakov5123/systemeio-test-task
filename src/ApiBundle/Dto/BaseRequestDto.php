<?php

declare(strict_types=1);

namespace App\ApiBundle\Dto;

use Symfony\Component\HttpFoundation\Request;

abstract class BaseRequestDto
{
    /**
     * @throws \Exception
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
     * @throws \Exception
     */
    private function getDataFromRequest(Request $request): array
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            throw new \Exception('Decode request problem');
        }

        return $data;
    }
}
