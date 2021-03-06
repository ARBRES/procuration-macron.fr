<?php

namespace AppBundle\Message;

use AppBundle\Entity\Procuration;
use EnMarche\Bundle\MailjetBundle\Message\MailjetMessage;
use Ramsey\Uuid\Uuid;

class ProcurationAssignationMessage extends MailjetMessage
{
    /**
     * @param Procuration $procuration
     *
     * @return ProcurationAssignationMessage
     */
    public static function createFromModel(Procuration $procuration): self
    {
        $requester = $procuration->getRequester();
        $recipient = $procuration->getVotingAvailability()->getVoter();

        $message = new self(
            Uuid::uuid4(),
            '', // TODO Mailjet template ID
            $requester->getEmail(),
            (string) $requester,
            sprintf('Votant pour votre procuration du %s', $procuration->getElectionRound()->getPerformanceDate()->format('d/m/Y'))
        );

        $message->addRecipient($recipient->getEmail(), (string) $recipient);

        return $message;
    }
}
