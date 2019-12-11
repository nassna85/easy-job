<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Job
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer un titre à votre offre d'emploi !", groups={"job"})
     * @Assert\Length(
     *     min="5",
     *     minMessage="Le titre doit contenir au minimum 5 caractères !",
     *     max="255",
     *     maxMessage="Le titre doit contenir au maximum 255 caractères !",
     *     groups={"job"}
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     *  @Assert\NotBlank(message="Veuillez indiquer une description à votre offre d'emploi !", groups={"job"})
     * @Assert\Length(
     *     min="20",
     *     minMessage="La description doit contenir au minimum 20 caractères !",
     *     groups={"job"}
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="Veuillez indiquer le nom de l'entreprise !", groups={"job"})
     *  @Assert\Length(
     *     min="5",
     *     minMessage="Le nom de l'entreprise doit contenir au minimum 5 caractères !",
     *     max="255",
     *     maxMessage="Le nom de l'entreprise doit contenir au maximum 255 caractères !",
     *     groups={"job"}
     * )
     */
    private $enterprise;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer le pays où l'offre d'emploi est vacant !")
     *  @Assert\Length(
     *     min="5",
     *     minMessage="Le nom du pays doit contenir au minimum 5 caractères !",
     *     max="255",
     *     maxMessage="Le nom du pays doit contenir au maximum 255 caractères !"
     * )
     */
    private $place;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez choisir une expérience pour l'offre d'emploi !", groups={"job"})
     */
    private $experience;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez choisir le contrat de l'offre d'emploi !", groups={"job"})
     */
    private $contract;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer une personne de contact !", groups={"job"})
     * @Assert\Length(min="5", minMessage="La personne de contact doit contenir au minimum 5 caractères !", groups={"job"})
     */
    private $contactPerson;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer l'email de la personne de contact !", groups={"job"})
     * @Assert\Email(message="Veuillez indiquer un email correct !", groups={"job"})
     */
    private $emailContact;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="jobs")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Veuillez choisir une catégorie pour votre offre d'emploi", groups={"job"})
     */
    private $categories;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="jobs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\PrePersist()
     */
    public function initialiseCreatedAt()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @return string
     */
    public function toSlug()
    {
        $slugify = new Slugify();
        $this->slug = $slugify->slugify($this->title);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getEnterprise(): ?string
    {
        return $this->enterprise;
    }

    public function setEnterprise(string $enterprise): self
    {
        $this->enterprise = $enterprise;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(string $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getContract(): ?string
    {
        return $this->contract;
    }

    public function setContract(string $contract): self
    {
        $this->contract = $contract;

        return $this;
    }

    public function getContactPerson(): ?string
    {
        return $this->contactPerson;
    }

    public function setContactPerson(string $contactPerson): self
    {
        $this->contactPerson = $contactPerson;

        return $this;
    }

    public function getEmailContact(): ?string
    {
        return $this->emailContact;
    }

    public function setEmailContact(string $emailContact): self
    {
        $this->emailContact = $emailContact;

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

    public function getCategories(): ?Category
    {
        return $this->categories;
    }

    public function setCategories(?Category $categories): self
    {
        $this->categories = $categories;

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

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
