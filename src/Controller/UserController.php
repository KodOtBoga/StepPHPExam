<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditType;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use App\Service\OrderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route('/users', name: 'users_view')]
    public function users_view(
        UserRepository $ur,
    )
    {
        $users = $ur->findAllExcept($this->getUser());

        return $this->render('users.html.twig', [
            'users' => $users,
        ]);
    }


    #[Route('/register', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $user->setPassword($hasher->hashPassword($user, $user->getPassword()));
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('products_view');
            }
        }

        return $this->render('register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(AuthenticationUtils $authenticationUtils)
    {
        
    }

    #[Route('/user/basket', name: 'app_view_basket')]
    public function viewBasket(Request $request, OrderService $br)
    {
        $user = $this->getUser();
        $order = $br->getOrCreateBasket($user);
        $products = $order->getProducts();
 

        return $this->render('basket.html.twig', [
            'products' => $products,
        ]);
    }


    #[Route('/user/edit/{user}', name: 'app_edit_user', requirements: ['product' => '\d+'])]
    public function editUser(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher, User $user)
    {
        $form = $this->createForm(EditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getPlainPassword()) {
                $user->setPassword($hasher->hashPassword($user, $user->getPlainPassword()));
            }
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('users_view');
        }

        return $this->render('profile.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/user/delete/{user}', name: 'app_delete_user', requirements: ['product' => '\d+'])]
    public function deleteUser(Request $request, EntityManagerInterface $em, User $user)
    {
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('users_view');
    }

}