<?php

namespace App\Entity;

use App\Repository\CatRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CatRepository::class)]
#[ORM\Table(name: '`cat`')]
class Cat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Cat name cannot be empty")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Cat name cannot be longer than {{ limit }} characters"
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Owner name cannot be empty")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Owner name cannot be longer than {{ limit }} characters"
    )]
    private ?string $ownerName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Owner email cannot be empty")]
    #[Assert\Email(message: "Please enter a valid email address")]
    private ?string $ownerEmail = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $pictureFilename = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getOwnerName(): ?string
    {
        return $this->ownerName;
    }

    public function setOwnerName(string $ownerName): static
    {
        $this->ownerName = $ownerName;

        return $this;
    }

    public function getOwnerEmail(): ?string
    {
        return $this->ownerEmail;
    }

    public function setOwnerEmail(string $ownerEmail): static
    {
        $this->ownerEmail = $ownerEmail;

        return $this;
    }

    public function getPictureFilename(): ?string
    {
        return $this->pictureFilename;
    }

    public function setPictureFilename(string $pictureFilename): self
    {
        $this->pictureFilename = $pictureFilename;

        return $this;
    }
}
