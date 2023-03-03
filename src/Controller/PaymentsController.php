<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Service\OrderService;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PaymentsController extends AbstractController
{
    #[Route('/user/payments', name: 'payments_view')]
    public function view(
        EntityManagerInterface $em,
    )
    {
        $payments = $em->getRepository(Payment::class)->findAll();


        return $this->render('payments.html.twig', [
            'payments' => $payments,
        ]);
    }

    #[Route('/user/order/{order}', name: 'order_view')]
    public function view_order(Order $order, EntityManagerInterface $em)
    {
        $products = $order->getProducts();


        return $this->render('order.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/user/payment/create', name: 'payment_create')]
    public function create(
        OrderService $or,
        EntityManagerInterface $em,
    )
    {
        $order = $or->getOrCreateBasket($this->getUser())->setStatus("payed");

        $payment = new Payment();
        $payment
            ->setOrder($order)
            ->setUser($this->getUser())
        ;
        $em->persist($payment);
        $em->flush();

        return $this->redirectToRoute('payments_view');
    }
}