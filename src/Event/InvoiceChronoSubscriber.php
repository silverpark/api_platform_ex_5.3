<?php

namespace App\Event;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Invoice;
use App\Repository\CustomerRepository;
use App\Repository\InvoiceRepository;
use DateTime;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class InvoiceChronoSubscriber implements EventSubscriberInterface
{
    private $security;
    private $invoiceRepository;
    private $customerRepository;

    public function __construct(Security $security, InvoiceRepository $invoiceRepository, CustomerRepository $customerRepository)
    {
        $this->security = $security;
        $this->invoiceRepository = $invoiceRepository;
        $this->customerRepository = $customerRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['chrono', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function chrono(ViewEvent $event): void
    {
        $invoice = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$invoice instanceof Invoice || Request::METHOD_POST !== $method) {
            return;
        }

        $lastCustomer = $this->customerRepository->findCustomerByUser($invoice->getCustomer(), $this->security->getUser());
        if (empty($lastCustomer)) {
            throw new Exception('Please create on customer before create invoice');
        }

        $lastInvoice = $this->invoiceRepository->findLastInvoice($this->security->getUser());
        if (empty($lastInvoice)) {
            $invoice->setChrono(1);
        } else {
            $invoice->setChrono($lastInvoice->getChrono() + 1);
        }

        $invoice->setSentAt(new DateTime());
    }
}
