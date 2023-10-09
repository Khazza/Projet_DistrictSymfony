<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'objet ne peut pas être vide.")]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: "L'objet doit comporter au moins {{ limit }} caractères.",
        maxMessage: "L'objet ne peut pas comporter plus de {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^[A-Za-z0-9 ]+$/",
        message: "L'objet ne peut contenir que des lettres et des chiffres."
    )]
    private ?string $objet = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'adresse e-mail ne peut pas être vide.")]
    #[Assert\Email(message: "Veuillez saisir une adresse e-mail valide.")]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Le message ne peut pas être vide.")]
    #[Assert\Length(
        min: 10,
        max: 500,
        minMessage: "Votre message doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Votre message ne peut pas comporter plus de {{ limit }} caractères."
    )]
    private ?string $message = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): static
    {
        $this->objet = $objet;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }
}
