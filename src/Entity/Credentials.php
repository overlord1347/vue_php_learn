<?php

namespace App\Entity;

use App\Repository\CredentialsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CredentialsRepository::class)
 */
class Credentials
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $date_created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_last_modified;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $data = [];

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateLastModified(): ?\DateTimeInterface
    {
        return $this->date_last_modified;
    }

    public function setDateLastModified(?\DateTimeInterface $date_last_modified): self
    {
        $this->date_last_modified = $date_last_modified;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(?array $data): self
    {
        $this->data = $data;

        return $this;
    }
}
