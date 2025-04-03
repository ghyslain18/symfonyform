<?php

namespace App\Controller;

use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StripeController extends AbstractController
{
    #[Route('pay/success', name: 'app_stripe_success')]
    public function success(): Response
    {
        return $this->render('stripe/index.html.twig', [
            'controller_name' => 'StripeController',
        ]);
    }

    #[Route('pay/cancele', name: 'app_stripe_cancel')]
    public function cancel(): Response
    {
        return $this->render('stripe/index.html.twig', [
            'controller_name' => 'StripeController',
        ]);
    }

    #[Route('/strype/notify', name: 'app_stripe_notify')]
    public function strypeNotify(Request $request): Response
    {
        Stripe::setApiKey($_SERVER['STRIPE_SECRET']);
        $endpoint_secret='whsec_dcaee1dc08dcf0a34b0e98d33d3d1b4d771466251b263e646d319a7320977359';
        $payload=$request->getContent();
        $sig_header=$request->headers->get('stripe-signature');
        $event=null;
        try {
            $event= \Stripe\Webhook::constructEvent(
                $payload,$sig_header,$endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            return new Response('payload invalide',400);
        }
        catch(\Stripe\Exception\SignatureVerificationException $e){
            return new Response('Signature invalide');
        }
        switch ($event->type) {
            case 'payment_intent.successed':
                $paymentIntent=$event->data->object;
                $fileName='stripe-details-'.uniqid().'txt';
                file_put_contents($fileName,$paymentIntent);
            break;
            case 'payment_method.attached':
                $paymentMethod=$event->data->object;
            break;
            
            default:
                # code...
                break;
        }
       /*  return $this->render('stripe/index.html.twig', [
            'controller_name' => 'StripeController',
        ]); */

        return new Response('evenement reçu',200);
    }
}
