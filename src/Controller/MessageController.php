<?php

namespace App\Controller;

use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MessageController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var HubInterface
     */
    private $publisher;

    /**
     * @param EntityManagerInterface $entityManager
     * @param HubInterface $publisher
     */
    public function __construct(EntityManagerInterface $entityManager, HubInterface $publisher)
    {
        $this->entityManager = $entityManager;
        $this->publisher = $publisher;
    }

    /**
     * @Route("/message/send", name="app_message", methods={"POST"})
     */
    public function send(Request $request, SerializerInterface $serializer): Response
    {

        if (!$this->getUser()) {
            return new JsonResponse('error', Response::HTTP_FORBIDDEN);
        }

        $user = $this->getUser();

        $message = new Message();
        $message->setSenderId($user)
            ->setMessageText($request->request->get('messageText'))
            ->setRecieverIds(['*']);

        try {
            $this->entityManager->persist($message);
            $this->entityManager->flush();

        } catch (\Throwable $exception) {
            return new Response($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $messageData = $serializer->serialize($message, 'json', [
            'attributes' => ['id', 'messageText']]);

        $update = new Update(
            sprintf('/conversations/%d', 1),
            $messageData,
        );

        try {
            $this->publisher->publish($update);
        } catch (\Throwable $exception) {
            dd($exception->getMessage(), $update);
        }

        return new Response('ok');
    }
}
