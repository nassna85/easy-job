<?php


namespace App\Services\Email;


use App\Entity\TokenUserRegistration;
use App\Entity\User;
use Twig\Environment;

class TokenSendler
{
    private $mailer;
    private $twig;

    /**
     * TokenSendler constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $twig
     */
    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendToken(User $user, TokenUserRegistration $token)
    {
        $message = (new \Swift_Message("EasyJob : Confirmation de votre inscription"))
            ->setFrom("contact@easy-job.be")
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render(
                    "emails/registrationConfirmation.html.twig", [
                        'token' => $token->getValue(),
                        'user' => $user
                    ]
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }
}