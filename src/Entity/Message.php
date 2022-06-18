<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\Column(type="datetime_immutable")
     */
    private $date_last_modified;

    /**
     * @ORM\Column(type="text")
     */
    private $message_text;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $date_created;

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

    public function getDateLastModified(): ?\DateTimeImmutable
    {
        return $this->date_last_modified;
    }

    public function setDateLastModified(\DateTimeImmutable $date_last_modified): self
    {
        $this->date_last_modified = $date_last_modified;

        return $this;
    }

    public function getMessageText(): ?string
    {
        return $this->message_text;
    }

    public function setMessageText(string $message_text): self
    {
        $this->message_text = $message_text;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeImmutable
    {
        return $this->date_created;
    }

    public function setDateCreated(\DateTimeImmutable $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function updateCreatedDatetime()
    {
        // update the modified time
        $this->setDateCreated(new \DateTimeImmutable());
        $this->setDateLastModified(new \DateTimeImmutable());
    }

    /**
     * @ORM\PreUpdate()
     */
    public function updateModifiedDatetime()
    {
        // update the modified time
        $this->setDateLastModified(new \DateTimeImmutable());
    }
}
