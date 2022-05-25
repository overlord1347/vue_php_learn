<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends AbstractController
{

    /*
     * @Route
     */
    public function register(): JsonResponse {
        $a = 0;

        return $this->json($a);
    }
}