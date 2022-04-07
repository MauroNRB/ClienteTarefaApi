<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Mauro Ribeiro
 * @since 2022-04-05
 *
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $expirationAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $conclusionAt;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getExpirationAt(): ?\DateTimeImmutable
    {
        return $this->expirationAt;
    }

    public function setExpirationAt(?\DateTimeImmutable $expirationAt): self
    {
        $this->expirationAt = $expirationAt;

        return $this;
    }

    public function getConclusionAt(): ?\DateTimeImmutable
    {
        return $this->conclusionAt;
    }

    public function setConclusionAt(?\DateTimeImmutable $conclusionAt): self
    {
        $this->conclusionAt = $conclusionAt;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
