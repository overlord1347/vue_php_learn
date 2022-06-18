<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MainController extends AbstractController
{
    /**
     * @var MessageRepository
     */
    private $messageRepository;

    /**
     * @param MessageRepository $messageRepository
     */
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * Main page action
     *
     * @Route("/", name="main")
     */
    public function index(SerializerInterface $serializer): Response
    {
        $messagesList = $this->messageRepository->findBy([], ['date_created' => 'DESC'], 10);


        $messages = $serializer->serialize($messagesList, 'json', [
            'attributes' => ['id', 'messageText']]);

//        dd($messages);
//        return $this->json($messages);
        return $this->render('home/index.html.twig', ['messages' => $messages]);
    }
}