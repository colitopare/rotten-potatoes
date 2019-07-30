<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PeopleRepository")
 */
class People
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le prénom est obligatoire !")  
     * @Assert\Length(min=2, minMessage="Le prénom doit faire plus de 2 caractères")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom est obligatoire !")  
     * @Assert\Length(min=2, minMessage="Le nom doit faire plus de 2 caractères")
     */
    private $lastName;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="La description est obligatoire !")  
     * @Assert\Length(min=10, minMessage="La description doit faire plus de 10 caractères")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"firstName", "lastName"})
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="La date de naissance est obligatoire !") 
     * @Assert\Date 
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="La photo est obligatoire !")  
     * @Assert\Url(message="l'URL doit être valide !")
     */
    private $picture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
}
