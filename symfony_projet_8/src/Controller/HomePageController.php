<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page',methods:['GET'])]
    
    public function index(): Response
    {
        $name='vincent';
        $nb=12;
        $date= new \DateTime() ;
        $posts=[];
        $posts[]=['title'=>'lorem iptuim 1',"content"=>"Some quick example text to build on the card title and make up the bulk of the card's content."];
        $posts[]=['title'=>'lorem iptuim 2',"content"=>"Some quick example text to build on the card title and make up the bulk of the card's content."];
        $posts[]=['title'=>'lorem iptuim 3',"content"=>"Some quick example text to build on the card title and make up the bulk of the card's content."];
        $posts[]=['title'=>'lorem iptuim 4',"content"=>"Some quick example text to build on the card title and make up the bulk of the card's content."];
        // dd($posts);
        return $this->render('homePage/index.html.twig',
        [
            "name"=>$name,
            "nb"=>$nb,
            "posts"=>$posts,
            "myDate"=>$date,
        ]
    );

        
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
