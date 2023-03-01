<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\OrderState;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Order::class);
    }

    public function findUsersBasket(User $user)
    {
        $qb = $this->createQueryBuilder('o');
        $qb
            ->innerJoin('o.orderState', 'os')
            ->andWhere('o.user = :user')
            ->andWhere('os.state = :basket')
            ->setParameter('basket', OrderState::STATE_BASKET)
            ->setParameter('user', $user)
            ->setMaxResults(1)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }
}