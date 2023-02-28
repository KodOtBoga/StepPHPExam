<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Product::class);
    }

    public function findNewProducts(int $limit = 10, int $offset = 0)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->setMaxResults($limit)
            ->setFirstResult($offset)

            ->orderBy('p.id', 'DESC')
        ;    

        return $qb->getQuery()->getResult();
    }
}