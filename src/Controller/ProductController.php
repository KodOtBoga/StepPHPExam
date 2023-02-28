<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/{product}', name: 'product_view', requirements: ['product' => '\d+'], methods: ['GET'])]
    public function view(
        Product $product, 
        ProductRepository $userRepository,
    )
    {
        

    }

    #[IsGranted('ROLE_MANAGER')]
    #[Route('/product/create', name: 'product_create')]
    public function Create(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($product);
                $em->flush();
                return $this->redirectToRoute('product_create');
            }
        }
    }

    #[IsGranted('ROLE_MANAGER')]
    #[Route('/chat/edit/{product}', name: 'product_edit', requirements: ['product' => '\d+'])]
    public function edit(Product $product, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('product_create');
        }

        return $this->render('product_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[IsGranted('ROLE_MANAGER')]
    #[Route('/product/delete/{product}', name: 'product_delete', requirements: ['product' => '\d+'])]
    public function Delete(Request $request, EntityManagerInterface $em, Product $product)
    {
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('product_create');
    }



    //#[Route('/user/edit', name: 'app_edit_user')]
    // public function editUser(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher)
    // {
    //     $user = $this->getUser();
    //     $form = $this->createForm(EditType::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         if ($user->getPlainPassword()) {
    //             $user->setPassword($hasher->hashPassword($user, $user->getPlainPassword()));
    //         }
    //         $em->persist($user);
    //         $em->flush();
    //         return $this->redirectToRoute('app_edit_user');
    //     }

    //     return $this->render('profile.html.twig', [
    //         'form' => $form->createView(),
    //         'user' => $user,
    //     ]);
    // }
}