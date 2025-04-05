<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\All;

final class SearchEngineController extends AbstractController
{
    #[Route('/search/engine', name: 'app_search_engine',methods:['GET'])]
    public function index(Request $request,ProductRepository $productRepository): Response
    {
        if ($request->isMethod('GET')) {
            $data=$request->query->all();
            $word=$data['word'];
            $results=$productRepository->searchEngin($word);
            //dd($data);
        }
        return $this->render('search_engine/index.html.twig', [
            'products' => $results,
            'word' =>$word,
        ]);
    }
}
