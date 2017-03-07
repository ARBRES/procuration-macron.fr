<?php

namespace AppBundle\Repository;

use AppBundle\Entity\VoterInvitation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

class VoterInvitationRepository extends EntityRepository
{
    /**
     * @return VoterInvitation[]|ArrayCollection
     */
    public function findAllByLastName()
    {
        return $this->createQueryBuilder('v')
            ->orderBy('v.lastName', 'ASC')
            ->addOrderBy('v.firstName', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
