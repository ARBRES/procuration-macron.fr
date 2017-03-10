<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function queryBuilderAllByName()
    {
        return $this->createQueryBuilder('u')
            ->where('COUNT(u.officesInCharge) > 0')
            ->orWhere('u.sup')
            ->orderBy('u.lastName', 'ASC')
            ->addOrderBy('u.firstName', 'ASC')
            ->setParameters([
                'role_admin' => '%ROLE_ADMIN%',
                'role_super_admin' => '%ROLE_SUPER_ADMIN%',
            ]);
    }

    /**
     * @return User[]|ArrayCollection
     */
    public function findAllWithRelationshipsByName()
    {
        return $this->createQueryBuilder('u')
            ->select('u', 'o')
            ->leftJoin('u.officesInCharge', 'o')
            ->orderBy('u.lastName', 'ASC')
            ->addOrderBy('u.firstName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param User $user
     *
     * @return User[]|ArrayCollection
     */
    public function findAllForReferent(User $user)
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.officesInCharge', 'o')
            ->innerJoin('o.referents', 'r')
            ->where('r = :user')
            ->setParameter('user', $user)
            ->orderBy('u.lastName', 'ASC')
            ->addOrderBy('u.firstName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $id
     *
     * @return User|null
     */
    public function findOneWithRelations($id): ?User
    {
        return $this->createQueryBuilder('u')
            ->select('u', 'o')
            ->leftJoin('u.officesInCharge', 'o')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
