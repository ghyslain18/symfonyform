<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/admin/user', name: 'app_user')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' =>$userRepository->findAll(),
        ]);
    }

    #[Route('/admin/user/{id}/to/editor', name: 'app_user_to_editor')]
    public function chanegeRole(EntityManagerInterface $entityManager, User $user ):Response
    {
        $user->setRoles(["ROLE_EDITOR","ROLE_USER"]);
        $entityManager->flush();
        $this->addFlash(
           'success',
           'le role éditeur a été ajouté  à votre utilisateur'
        );
        return $this->redirectToRoute('app_user');
    }
}
