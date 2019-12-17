<?php


namespace App\Services\Email;


use App\Entity\Job;
use Twig\Environment;

class JobSendler
{

    private $mailer;

    private $twig;

    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {

        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function confirmationNewJobCreatedForEmployee(Job $job)
    {
        $message = (new \Swift_Message("EasyJob : Confirmation de la mise en ligne de votre nouvel emploi"))
            ->setFrom("contact@easy-job.be")
            ->setTo($job->getAuthor()->getEmail())
            ->setBody(
                $this->twig->render(
                    "emails/confirmationNewJobCreatedForEmployee.html.twig", [
                        'job' => $job
                    ]
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }

    public function confirmationNewJobCreated(Job $job)
    {
        $message = (new \Swift_Message("EasyJob : Un nouvel emploi a été mis en ligne"))
            ->setFrom("contact@easy-job.be")
            ->setTo("nassna85@hotmail.fr")
            ->setBody(
                $this->twig->render(
                    "emails/confirmationNewJobCreated.html.twig", [
                        'job' => $job
                    ]
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }
}