<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/create', name: 'category_create')]
    public function Create(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($category);
                $em->flush();
                return $this->redirectToRoute('app_homepage');
            }
        }

        return $this->render('login.html.twig', [
            'form' => $form->createView(),
        ]);
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