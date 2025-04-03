<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
//use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CartController extends AbstractController
{
    public function __construct(private  ProductRepository $productRepository){}


    #[Route('/cart', name: 'app_cart', methods: ['GET'])]
    public function index(SessionInterface $session,Cart $cart): Response
    {
        /* $cart=$session->get('cart',[]);
        $cartWhitData=[];
        foreach ($cart as $id => $quantity) {
            $cartWhitData[] =[
                'product' => $this->productRepository->find($id),
                'quantity'=>$quantity,

            ];
        }
        $total= array_sum(array_map(function ($item)  {
                return $item['product']->getPrice() * $item['quantity'];  
            },
            $cartWhitData,
        ));
        //dd($total); */

        $data=$cart->getCart($session);
        $cartProducts=$data['cart'];
        $products=[];
        foreach ($cartProducts as $value) {
            # code...
        }
        return $this->render('cart/index.html.twig', [
            'items' =>$data['cart'], //$cartWhitData,
            'total'=>$data['total'], //$total
        ]);
    }
    #[Route('/cart/add/{id}/ ', name: 'app_cart_new', methods: ['GET'])]
    public function addToCart(int $id, SessionInterface $session):Response
    {
        $cart = $session->get('cart',[]);

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id]=1;
        }
        $session->set('cart',$cart);
        //dd($cartWhitData);

        return $this->redirectToRoute('app_cart');

       
    }

    #[Route('/cart/remove/{id}/ ', name: 'app_cart_product_remove', methods: ['GET'])]
    public function removeToCart($id, SessionInterface $session):Response
    {
        $cart = $session->get('cart',[]);

        if (!empty($cart[$id])) {
            unset($cart[$id]);
           // $cart[$id]++;
        } /* else {
            $session->sett('cart',$cart);
            //$cart[$id]=1;
        } */
        $session->set('cart',$cart);
        //dd($cartWhitData);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/ ', name: 'app_cart_remove', methods: ['GET'])]
    public function remove( SessionInterface $session):Response
    {
         $session->set('cart',[]);
/* 
        if (!empty($cart[$id])) {
            unset($cart[$id]);
           // $cart[$id]++;
        } /* else {
            $session->sett('cart',$cart);
            //$cart[$id]=1;
        } */
       // $session->set('cart',$cart);
        //dd($cartWhitData); */

        return $this->redirectToRoute('app_cart');
    }
}
