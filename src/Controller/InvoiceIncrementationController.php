<?php

namespace App\Controller;

use App\Entity\Invoice;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InvoiceIncrementationController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param Invoice $data
     * 
     * @return Invoice
     */
    public function __invoke(Invoice $data): Invoice
    {
        $data->setChrono($data->getChrono() + 1);

        // In this version of api platform, the flush is automatically called
        $this->manager->flush();

        return $data;
    }
}