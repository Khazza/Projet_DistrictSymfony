<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierTotalListener
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $panier = $this->session->get('panier', []);
        $panierTotal = array_sum($panier);

        $event->getRequest()->attributes->set('panierTotal', $panierTotal);
    }
}
