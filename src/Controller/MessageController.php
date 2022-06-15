<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/message/send", name="app_message", methods={"POST"})
     */
    public function send(Request $request): Response
    {
        dd($this->getUser());

        return new Response('');
    }
}
