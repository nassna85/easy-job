<?php


namespace App\Services\Email;


use App\Entity\Apply;
use App\Entity\Job;
use App\Entity\User;
use Twig\Environment;

class ApplySendler
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

    public function applySendForConfirmation(User $user, Job $job)
    {
        $message = (new \Swift_Message("EasyJob : Confirmation de votre candidature"))
            ->setFrom("contact@easy-job.be")
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render(
                    "emails/applyConfirmation.html.twig", [
                        'user' => $user,
                        'job' => $job
                    ]
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }

    public function applySendToEmployee(Apply $apply)
    {
        $message = (new \Swift_Message("EasyJob : Une nouvelle candidature a été envoyée (référence du poste : {$apply->getJob()->getId()})"))
            ->setFrom("contact@easy-job.be")
            ->setTo($apply->getJob()->getEmailContact())
            ->setBody(
                $this->twig->render(
                    "emails/applySendToEmployee.html.twig", [
                        'apply' => $apply
                    ]
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }
}