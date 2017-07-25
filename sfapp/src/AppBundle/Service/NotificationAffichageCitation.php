<?php
namespace AppBundle\Service;

use AppBundle\Service\Citation;

class NotificationAffichageCitation
{
    private $citation;
    private $mailer;

    public function __construct(Citation $citation, \Swift_Mailer $mailer)
    {
        $this->citation = $citation;
        $this->mailer = $mailer;
    }

    public function notification()
    {
        $message_citation = $this->citation->getCitation();

        $message = \Swift_Message::newInstance()
            ->setSubject('Notifiation !')
            ->setFrom('admin@example.com')
            ->setTo('manager@example.com')
            ->addPart(
                "Quelqu'un a visité le site et a reçus le message :  ". $message_citation
            );
        $this->mailer->send($message);

        return $message_citation;
    }
}