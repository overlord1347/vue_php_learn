<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sender_id;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $reciever_ids = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSenderId(): ?User
    {
        return $this->sender_id;
    }

    public function setSenderId(?User $sender_id): self
    {
        $this->sender_id = $sender_id;

        return $this;
    }

    public function getRecieverIds(): ?array
    {
        return $this->reciever_ids;
    }

    public function setRecieverIds(?array $reciever_ids): self
    {
        $this->reciever_ids = $reciever_ids;

        return $this;
    }
}
