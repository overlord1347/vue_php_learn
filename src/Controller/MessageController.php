<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/message", name="message_")
 */
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
     * @var MessageRepository
     */
    private $messageRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param HubInterface $publisher
     * @param MessageRepository $messageRepository
     */
    public function __construct(EntityManagerInterface $entityManager, HubInterface $publisher, MessageRepository $messageRepository)
    {
        $this->entityManager = $entityManager;
        $this->publisher = $publisher;
        $this->messageRepository = $messageRepository;
    }

    /**
     * @Route("/send", name="send", methods={"POST"})
     */
    public function send(Request $request, SerializerInterface $serializer): Response
    {
        $user = $this->getUser();

        $message = new Message();
        $message->setSenderId($user)
            ->setMessageText($request->request->get('messageText'));

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
//            dd($exception->getMessage(), $update);
        }

        return new Response('ok');
    }

    /**
     * @Route("/get/all")
     *
     * @return void
     */
    public function getAllMessages(Request $request, SerializerInterface $serializer): Response
    {
        $limit = 10;

        $messagesList = $this->messageRepository->getMessagesWithUserInfo($limit, 1);

        $messages = $serializer->serialize($messagesList, 'json', [
            'attributes' => ['id', 'messageText', 'name']]);

        return new Response($messages);
    }

    /**
     * @Route("/get")
     *
     * @param Request $request
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function getMessages(Request $request, SerializerInterface $serializer)
    {
        $page = $request->query->getInt('page');
        $limit = 10;

        $messagesList = $this->messageRepository->getMessagesWithUserInfo($limit, $page);

        $messages = $serializer->serialize($messagesList, 'json', [
            'attributes' => ['id', 'messageText', 'name']]);

        return new Response($messages);
    }
}
