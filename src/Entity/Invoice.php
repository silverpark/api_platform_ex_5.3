<?php

namespace App\Entity;

use App\Controller\InvoiceIncrementationController;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *  subresourceOperations={
 *      "api_customers_invoices_get_subresource"={
 *          "normalization_context"={"groups"={"invoices_subresource"}}
 *      }
 *  },
 *  itemOperations={"GET","PUT","DELETE","increment"={
 *      "method"="post",
 *      "path"="/invoices/{id}/increment",
 *      "controller"=InvoiceIncrementationController::class,
 *      "openapi_context"={
 *          "summary"="Increment the chrono",
 *          "description"="Increment the chrono of a specific fact"
 *      }
 *  }},
 *  normalizationContext={"groups"={"invoices_read"}},
 *  denormalizationContext={"disable_type_enforcement"=true}
 * )
 * @ORM\Entity(repositoryClass=InvoiceRepository::class)
 */
class Invoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"invoices_read","customers_read","users_read","invoices_subresource"})
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"invoices_read","customers_read","users_read","invoices_subresource"})
     * @Assert\NotBlank()
     * @Assert\Type("numeric")
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"invoices_read","customers_read","users_read","invoices_subresource"})
     * @Assert\NotBlank(allowNull=true)
     * @Assert\Type(type="\DateTimeInterface", message="The format must be YYYY-mm-dd H:i:s")
     */
    private $sentAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"invoices_read","customers_read","users_read","invoices_subresource"})
     * @Assert\NotBlank()
     * @Assert\Choice(choices={"SENT","PAID","CANCELLED"},message="Your choices must be SENT, PAID or CANCELLED")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="invoices")
     * @Groups({"invoices_read","invoices_subresource"})
     * @Assert\NotBlank()
     */
    private $customer;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"invoices_read","customers_read","users_read","invoices_subresource"})
     * @Assert\NotBlank(allowNull=true)
     * @Assert\Type("integer")
     */
    private $chrono;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    // here we disable type hinting because we manage type with assert
    // and we disable "disable_type_enforcement" for this
    public function setAmount($amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getSentAt(): ?\DateTimeInterface
    {
        return $this->sentAt;
    }

    public function setSentAt($sentAt): self
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getChrono(): ?int
    {
        return $this->chrono;
    }

    // here we disable type hinting because we manage type with assert
    // and we disable "disable_type_enforcement" for this
    public function setChrono($chrono): self
    {
        $this->chrono = $chrono;

        return $this;
    }
}
