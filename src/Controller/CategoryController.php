<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
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
                return $this->redirectToRoute('category_create');
            }
        }
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/chat/edit/{category}', name: 'category_edit', requirements: ['category' => '\d+'])]
    public function edit(Category $category, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('category_create');
        }

        return $this->render('category_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/category/delete/{category}', name: 'category_delete', requirements: ['category' => '\d+'])]
    public function Delete(Request $request, EntityManagerInterface $em, Category $category)
    {
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute('category_create');
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