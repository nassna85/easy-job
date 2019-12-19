<?php


namespace App\Services\Email;


use App\Entity\Contact;
use Twig\Environment;

class ContactSendler
{
    private $mailer;

    private $twig;

    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {

        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function notifyContact(Contact $contact)
    {
        $message = (new \Swift_Message("EasyJob : Demande de contact de {$contact->getFirstName()}"))
            ->setFrom($contact->getEmail())
            ->setTo('contact@easy-job.be')
            ->setBody(
                $this->twig->render(
                    'emails/contact.html.twig', [
                        'contact' => $contact
                    ]
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }
}