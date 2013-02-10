<?php

namespace Acme\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\SecurityContext;
use Stripe;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $request = $this->container->get('request');
        $message = '';
        if($request->get('test'))
        {
            Stripe::setApiKey('pk_test_ur0ebwOGBrsNzQrpdCNENIu4');

            $token = $request->get('stripeToken');

            $customer = Stripe_Customer::create(array(
                  'email' => 'customer@example.com',
                  'card'  => $token
            ));

            $charge = Stripe_Charge::create(array(
                  'customer' => $customer->id,
                  'amount'   => 5000,
                  'currency' => 'usd'
            ));

            $message = '<h1>Successfully charged $50.00!</h1>';
        }

        return $this->render('AcmeTestBundle:Default:index.html.twig', array('message' => $message));
    }
}
