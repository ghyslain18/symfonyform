<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Order;
use App\Entity\OrderProducts;
use App\Form\OrderType;
use App\Service\Cart;
use App\Repository\ProductRepository;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function index(
        Request $request,
        SessionInterface $session,
        EntityManagerInterface $entityManager,
        ProductRepository $productRepository,
        Cart $cart,
    ): Response
    {

        /* $cart=$session->get('cart',[]);
        $cartWhitData=[];
        foreach ($cart as $id => $quantity) {
            $cartWhitData[] =[
                'product' => $productRepository->find($id),
                'quantity'=>$quantity,

            ];
        }
        $total= array_sum(array_map(function ($item)  {
                return $item['product']->getPrice() * $item['quantity'];  
            },
            $cartWhitData,
        ));
 */

        $data=$cart->getCart($session);


        $order= new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            if ($order->IsPayOnDeliVery()) {
                if (!empty($data['total'])) {
                     
                $order->setTotalPrice($data['total']);
                $order->setCreatedAt(new \DateTimeImmutable() );
                $entityManager->persist($order);
                $entityManager->flush();

                foreach ($data['cart'] as $value) {
                    $orderProduct=new OrderProducts();
                    $orderProduct->setOrder($order);
                    $orderProduct->setProduct($value['product']);
                    $orderProduct->setQte($value['quantity']);
                    $entityManager->persist($orderProduct);
                    $entityManager->flush();

                }

                } else {
                    # code...
                }
                
               
                
                //dd($order);
            } 
            else {
                # code...
            }
            $session->set('cart',[]);
            return $this->redirectToRoute('order_ok_message');
            
            //dd($data['cart']);
        }
        return $this->render('order/index.html.twig', [
            //'controller_name' => 'OrderController',
            'form' => $form->createView(),
            'total'=>$data['total']
        ]);
    }

    #[Route("/order-ok-message",name:"order_ok_message")]

    public function orderMessage():Response {
        return $this->render('order/order_message.twig',[
            
        ]);
    }

    #[Route('/editor/order', name: 'app_orders_show')]
    public function getAllOrder(OrderRepository $orderRepository, Request $request,PaginatorInterface $paginator) : Response 
    {
        $data = $orderRepository->findBy([],['id'=>'DESC']);
        $order=$paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            10
        );
        //dd($order);
        return $this->render('order/order.html.twig',[
            "orders"=>$order,
        ]);  
    }

    #[Route('/city/{id}/shipping/cost', name: 'app_city_shipping_cost')]
    public function cityShippingCoast(City $city): Response
    {
        $cityShippingPrice=$city->getShippingCost();
       // dd($city);

        return new Response(json_encode(['status'=>200,"message"=>'on','content'=>$cityShippingPrice]));


        
       
    }
}
