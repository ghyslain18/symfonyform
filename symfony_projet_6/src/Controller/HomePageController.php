<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    /* public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/HomePageController.php',
        ]);
    } */
    public function index(): Response
    {
        return new Response('<h1>hello world</h1>');
    }

#[Route('/about/', name: 'app_about_page',methods:['POST'],)]

    public function about(): Response
    {
        return new Response('<h1>About</h1>');
    }

    public function contact():Response{
        return new Response('<h1>Contact</h1>');
    }
}
