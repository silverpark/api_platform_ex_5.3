<?php

namespace App\Event;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Customer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class CustomerUserSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['customerUserLink', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function customerUserLink(ViewEvent $event): void
    {
        $customer = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$customer instanceof Customer || Request::METHOD_POST !== $method) {
            return;
        }

        $customer->setUserCustomer($this->security->getUser());
    }
}
