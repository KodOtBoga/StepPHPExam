<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Image;
use App\Entity\Product;
use App\Form\ProductType;
use App\Form\ProductEditType;
use App\Repository\ProductRepository;
use App\Service\OrderService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'products_view')]
    public function view(
        ProductRepository $pr,
    )
    {
        $products = $pr->findNewProducts();


        return $this->render('shop.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/{product}', name: 'product_view', requirements: ['product' => '\d+'])]
    public function viewProduct(Product $product, Request $request, EntityManagerInterface $em)
    {
        return $this->render('product.html.twig', [
            'product' => $product,
        ]);
    }

    #[IsGranted('ROLE_MANAGER')]
    #[Route('/product/create', name: 'product_create')]
    public function Create(Request $request, EntityManagerInterface $em)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                if ($imageId = $form->get('image')->getData()) {
                    $product->setImage($em->getRepository(Image::class)->find($imageId));
                }
                $em->persist($product);
                $em->flush();
                return $this->redirectToRoute('product_view');
            }
        }

        return $this->render('product_create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/basket/add/{product}', name: 'product_add', requirements: ['product' => '\d+'])]
    public function addProduct(Product $product, EntityManagerInterface $em, OrderService $orderService)
    {
        $order = $orderService->getOrCreateBasket($this->getUser());
        $order->getProducts()->add($product);
        $em->persist($order);
        $em->flush();
        return $this->redirectToRoute('app_view_basket');
    }

    #[Route('/user/basket/remove/{product}', name: 'product_remove', requirements: ['product' => '\d+'])]
    public function removeProduct(Product $product, EntityManagerInterface $em, OrderService $orderService){
        
        $order = $orderService->getOrCreateBasket($this->getUser());
        $order->getProducts()->removeElement($product);
        $em->persist($order);
        $em->flush();
        return $this->redirectToRoute('app_view_basket');
    }

    #[IsGranted('ROLE_MANAGER')]
    #[Route('/product/edit/{product}', name: 'product_edit', requirements: ['product' => '\d+'])]
    public function edit(Product $product, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ProductEditType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($imageId = $form->get('image')->getData()) {
                $product->setImage($em->getRepository(Image::class)->find($imageId));
            }
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