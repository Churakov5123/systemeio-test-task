<?php
declare(strict_types=1);

namespace App\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{
    /**
     * @param array|string $data
     * @param int $status
     * @param array $headers
     * @param bool $isJson
     *
     * @return JsonResponse
     */
    public function sendJsonResponse($data = null, $status = Response::HTTP_OK, $headers = [], $isJson = false): JsonResponse
    {
        $response = new JsonResponse($data, $status, $headers, $isJson);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return $response;
    }
}