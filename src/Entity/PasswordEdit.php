<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class PasswordEdit
{
    private $oldPassword;

    /**
     * @Assert\NotBlank(message="Veuillez indiquer un nouveau mot de passe !")
     * @Assert\Length(
     *     min="6",
     *     minMessage="Votre nouveau mot de passe doit contenir au minimum 6 caractères !",
     *     max="12",
     *     maxMessage="Votre nouveau mot de passe doit contenir au maximum 12 caractères !",
     *     groups={"registration"}
     * )
     */
    private $newPassword;

    /**
     * @Assert\EqualTo(propertyPath="newPassword", message="Vous n'avez pas correctement confirmé votre nouveau mot de passe !")
     */
    private $confirmPassword;

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
