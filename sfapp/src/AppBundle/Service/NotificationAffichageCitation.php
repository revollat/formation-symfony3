<?php
namespace AppBundle\Service;

use AppBundle\Service\Citation;

class NotificationAffichageCitation
{
    private $citation;
    private $mailer;
    private $adminEmail;

    public function __construct(Citation $citation, \Swift_Mailer $mailer, $adminEmail)
    {
        $this->citation = $citation;
        $this->mailer = $mailer;
        $this->adminEmail = $adminEmail;
    }

    public function notification()
    {
        $message_citation = $this->citation->getCitation();

        $message = \Swift_Message::newInstance()
            ->setSubject('Notifiation !')
            ->setFrom('admin@example.com')
            ->setTo($this->adminEmail)
            ->addPart(
                "Quelqu'un a visité le site et a reçus le message :  ". $message_citation
            );
        $this->mailer->send($message);

        return $message_citation;
    }
}