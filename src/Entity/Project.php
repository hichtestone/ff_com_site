<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $project_name = null;

    #[ORM\Column(length: 50)]
    private ?string $client_name = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    private ?User $project_manager = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $project_url = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $complete_date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectName(): ?string
    {
        return $this->project_name;
    }

    public function setProjectName(string $project_name): static
    {
        $this->project_name = $project_name;

        return $this;
    }

    public function getClientName(): ?string
    {
        return $this->client_name;
    }

    public function setClientName(string $client_name): static
    {
        $this->client_name = $client_name;

        return $this;
    }

    public function getProjectManager(): ?User
    {
        return $this->project_manager;
    }

    public function setProjectManager(?User $project_manager): static
    {
        $this->project_manager = $project_manager;

        return $this;
    }

    public function getProjectUrl(): ?string
    {
        return $this->project_url;
    }

    public function setProjectUrl(?string $project_url): static
    {
        $this->project_url = $project_url;

        return $this;
    }

    public function getCompleteDate(): ?\DateTimeInterface
    {
        return $this->complete_date;
    }

    public function setCompleteDate(?\DateTimeInterface $complete_date): static
    {
        $this->complete_date = $complete_date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
