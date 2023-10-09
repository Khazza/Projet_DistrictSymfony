<?php 
namespace App\EventSubscriber;

use App\Event\OrderConfirmedEvent;
use App\Service\MailService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OrderPlacedSubscriber implements EventSubscriberInterface
{
    private $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public static function getSubscribedEvents()
    {
        return [
            OrderConfirmedEvent::NAME => 'onOrderPlaced',
        ];
    }

    public function onOrderPlaced(OrderConfirmedEvent $event) // Changez ceci
    {
        $userData = $event->getUserData();
        $orderData = $event->getOrderData(); 

        // Envoyez le mail
        $this->mailService->sendOrderConfirmationMail($userData, $orderData);
        }
}
