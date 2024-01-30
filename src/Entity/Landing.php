<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Sluggable\Util\Urlizer;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LandingRepository::class)]
class Landing extends Workflow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true, nullable: true)]
	#[Serializer\Groups("detail")]
    private $titleTab;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
	#[Assert\NotBlank()]
	#[Serializer\Groups(["detail"])]
    private $titlePage;

    #[ORM\Column(type: 'text')]
	#[Assert\NotBlank()]
	#[Serializer\Groups(["detail"])]
    private $content;

    #[ORM\Column(type: 'string', length: 80)]
	#[Assert\NotBlank()]
	#[Serializer\Groups(["detail"])]
    private $keyword;

    #[ORM\Column(type: 'string', length: 200)]
	#[Assert\NotBlank()]
	#[Serializer\Groups(["detail"])]
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="landings")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleTab(): ?string
    {
        return $this->titleTab;
    }

    public function setTitleTab(string $titleTab): self
    {
        $this->titleTab = $titleTab;

        return $this;
    }

    public function getTitlePage(): ?string
    {
        return $this->titlePage;
    }

    public function setTitlePage(string $titlePage): self
    {
        $this->titlePage = $titlePage;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getKeyword(): ?string
    {
        return $this->keyword;
    }

    public function setKeyword(string $keyword): self
    {
        $this->keyword = $keyword;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
