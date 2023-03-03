<?php

namespace App\Service;
use App\Entity\Order;
use App\Entity\OrderState;
use App\Entity\User;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderService
{

    public function __construct(
        private EntityManagerInterface $em,
        private OrderRepository $orderRepository,
    )
    {

    }
    public function getOrCreateBasket(User $user): Order
    {
        $order = $this->orderRepository->findUsersBasket($user);

        if (!$order) {
            $order = new Order();
            $order->setUser($user)->setStatus(Order::STATUS_BASKET);
            $this->em->persist($order);
            $this->em->flush();
        }

        return $order;
    }

}