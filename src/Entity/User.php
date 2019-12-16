<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email", message="Cet email existe déjà. Veuillez en choisir un autre et rééssayer !")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Veuillez indiquer votre email !")
     * @Assert\Email(message="Veuillez indiquer un email valide !")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Veuillez indiquer un mot de passe !", groups={"registration"})
     * @Assert\Length(
     *     min="6",
     *     minMessage="Votre mot de passe doit contenir au minimum 6 caractères !",
     *     max="12",
     *     maxMessage="Votre mot de passe doit contenir au maximum 12 caractères !",
     *     groups={"registration"}
     * )
     */
    private $password;

    /**
     * @var string
     * @Assert\EqualTo(
     *     propertyPath="password",
     *     message="Vos deux mots de passe ne correspondent pas !"
     * )
     */
    private $passwordConfirm;

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
     * @Assert\NotBlank(message="Veuillez indiquer un prénom !")
     * @Assert\Length(min="2", minMessage="Votre nom doit contenir au minimum 2 caractères !", max="30", maxMessage="Votre nom doit contenir au maximum 30 caractères !")
     * @Assert\Regex(
     *     pattern="/^[a-zéèçàâäêëîï]+\-?[a-zéèçàâäêëîï]+$/i",
     *     message="Votre prénom ne doit contenir que des lettres !"
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez choisir un type !")
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Job", mappedBy="author", orphanRemoval=true)
     */
    private $jobs;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\TokenUserRegistration", mappedBy="user", cascade={"persist", "remove"})
     */
    private $tokenUserRegistration;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Apply", mappedBy="user", orphanRemoval=true)
     */
    private $applies;

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
        $this->active = false;
        $this->applies = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist()
     */
    public function initializeCreatedAt()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return string
     */
    public function fullName()
    {
        return $this->firstName . " " . $this->lastName;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getPasswordConfirm()
    {
        return $this->passwordConfirm;
    }

    public function setPasswordConfirm($passwordConfirm)
    {
        $this->passwordConfirm = $passwordConfirm;
    }

    /**
     * @return Collection|Job[]
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Job $job): self
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs[] = $job;
            $job->setAuthor($this);
        }

        return $this;
    }

    public function removeJob(Job $job): self
    {
        if ($this->jobs->contains($job)) {
            $this->jobs->removeElement($job);
            // set the owning side to null (unless already changed)
            if ($job->getAuthor() === $this) {
                $job->setAuthor(null);
            }
        }

        return $this;
    }

    public function getTokenUserRegistration(): ?TokenUserRegistration
    {
        return $this->tokenUserRegistration;
    }

    public function setTokenUserRegistration(TokenUserRegistration $tokenUserRegistration): self
    {
        $this->tokenUserRegistration = $tokenUserRegistration;

        // set the owning side of the relation if necessary
        if ($tokenUserRegistration->getUser() !== $this) {
            $tokenUserRegistration->setUser($this);
        }

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection|Apply[]
     */
    public function getApplies(): Collection
    {
        return $this->applies;
    }

    public function addApply(Apply $apply): self
    {
        if (!$this->applies->contains($apply)) {
            $this->applies[] = $apply;
            $apply->setUser($this);
        }

        return $this;
    }

    public function removeApply(Apply $apply): self
    {
        if ($this->applies->contains($apply)) {
            $this->applies->removeElement($apply);
            // set the owning side to null (unless already changed)
            if ($apply->getUser() === $this) {
                $apply->setUser(null);
            }
        }

        return $this;
    }
}
