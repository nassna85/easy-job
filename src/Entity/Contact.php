<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer un prénom !")
     * @Assert\Length(min="2", minMessage="Votre prénom doit contenir au minimum 2 caractères !", max="30", maxMessage="Votre prénom doit contenir au maximum 30 caractères !")
     * @Assert\Regex(
     *     pattern="/^[a-zéèçàâäêëîï]+\-?[a-zéèçàâäêëîï]+$/i",
     *     message="Votre prénom ne doit contenir que des lettres !"
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer un nom !")
     * @Assert\Length(min="2", minMessage="Votre nom doit contenir au minimum 2 caractères !", max="30", maxMessage="Votre nom doit contenir au maximum 30 caractères !")
     * @Assert\Regex(
     *     pattern="/^[a-zéèçàâäêëîï]+\-?[a-zéèçàâäêëîï]+$/i",
     *     message="Votre nom ne doit contenir que des lettres !"
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer votre email !")
     * @Assert\Email(message="Veuillez indiquer un email valide !")
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Veuillez indiquer votre message !")
     * @Assert\Length(
     *     min="20",
     *     minMessage="Votre message doit contenir au minimum 20 caractères !"
     * )
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern="/^[0-9]{3,4}[\/][0-9]{2}[\/][0-9]{2}[\/][0-9]{2}$/",
     *     message="Le format est incorrect : (0489/89/89/89) !"
     * )
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $resolved;

    public function __construct()
    {
        $this->resolved = false;
    }

    /**
     * @ORM\PrePersist()
     */
    public function initializeCreatedAt()
    {
        $this->createdAt = new \DateTime();
    }

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getResolved(): ?bool
    {
        return $this->resolved;
    }

    public function setResolved(?bool $resolved): self
    {
        $this->resolved = $resolved;

        return $this;
    }
}
