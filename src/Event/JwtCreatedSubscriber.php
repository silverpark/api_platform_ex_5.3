<?php

namespace App\Event;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JwtCreatedSubscriber
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function updateJwtData(JWTCreatedEvent $event)
    {
        // $request = $this->requestStack->getCurrentRequest();
        
        /** @var User $user */
        $user = $event->getUser();
        $payload = $event->getData();
        $payload['lastName'] = $user->getLastName();

        $event->setData($payload);
    }
}
