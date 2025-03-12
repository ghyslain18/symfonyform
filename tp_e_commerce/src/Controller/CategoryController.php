<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories=$categoryRepository->findAll();
        // dd($categories);
        return $this->render('category/index.html.twig', [
            'categories'=>$categories
        ]);
    }
    #[Route('/category/new', name: 'app_category_new')]
    public function addCategory(EntityManagerInterface $entityManager,Request $request):Response{
        $category=new Category();

        $form=$this->createForm(CategoryFormType::class, $category);
        $form ->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->redirectToRoute('app_category',);
        }
        return $this->render('category/new.html.twig',['form' => $form->createView()]);
        
    }

    #[Route('/category/{id}/update', name: 'app_category_update')]
    public function update(Category $category, EntityManagerInterface $entitymanager,Request $request):Response
    {
        $form=$this->createForm(CategoryFormType::class, $category);
        $form ->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()) {
            $entitymanager->flush();
            return $this->redirectToRoute('app_category',);
        }
        
        return $this->render('category/update.html.twig',['form' => $form->createView(),
            
        ]);
    }

    #[Route('/category/{id}/delete', name: 'app_category_delete')]
    public function delete(Category $category, EntityManagerInterface $entitymanager):Response
    {
       $entitymanager->remove($category);
       $entitymanager->flush();
        
        return $this->redirectToRoute('app_category',
            
        );
    }
}
