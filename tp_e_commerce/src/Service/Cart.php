<?php

namespace App\Service;
use App\Repository\ProductRepository;



class Cart 
{
    public function __construct(private  ProductRepository $productRepository){}

    public    function getCart($session):array {
        $cart=$session->get('cart',[]);
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
        return [
            'cart'=>$cartWhitData,
            'total'=>$total
        ];
    }
}
