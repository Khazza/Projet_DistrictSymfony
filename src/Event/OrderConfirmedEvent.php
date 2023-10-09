<?php 
namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class OrderConfirmedEvent extends Event
{
    public const NAME = 'order.confirmed';

    private array $userData;
    private array $orderData;

    public function __construct(array $userData, array $orderData)
    {
        $this->userData = $userData;
        $this->orderData = $orderData;
    }

    public function getUserData(): array
    {
        return $this->userData;
    }

    public function getOrderData(): array
    {
        return $this->orderData;
    }
}
