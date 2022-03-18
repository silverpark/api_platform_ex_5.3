<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  collectionOperations={"GET"={"path":"/customers"},"POST"},
 *  itemOperations={"GET"={"path":"/customers/{id}"},"PUT","DELETE"},
 *  subresourceOperations={
 *      "invoices_get_subresource"={"path":"/customers/{id}/facts"}
 *  },
 *  attributes={"pagination_items_per_page":90},
 *  normalizationContext={
 *      "groups"={"customers_read"}
 *  }
 * )
 * @ApiFilter(SearchFilter::class, properties={"firstName":"partial","lastName":"partial","company"})
 * @ApiFilter(OrderFilter::class, properties={"firstName", "lastName"})
 * @ORM\Entity
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"customers_read","invoices_read","users_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customers_read","invoices_read","users_read","invoices_subresource"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customers_read","invoices_read","users_read","invoices_subresource"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customers_read","invoices_read","users_read","invoices_subresource"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"customers_read","invoices_read","users_read","invoices_subresource"})
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity=Invoice::class, mappedBy="customer")
     * @Groups({"customers_read","users_read"})
     * @ApiSubresource()
     */
    private $invoices;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="customers")
     * @Groups({"customers_read","invoices_read"})
     */
    private $userCustomer;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
    }

    /**
     * @Groups({"customers_read","invoices_read","users_read"})
     * @return float
     */
    public function getTotalAmount(): float
    {
        /** @var Invoice $invoice */
        return array_reduce($this->invoices->toArray(), function ($total, $invoice) {
            return $total + $invoice->getAmount();
        }, 0);
    }

    /**
     * @Groups({"customers_read","invoices_read","users_read"})
     * @return float
     */
    public function getUnpaidAmount(): float
    {
        /** @var Invoice $invoice */
        return array_reduce($this->invoices->toArray(), function ($total, $invoice) {
            return $total + ($invoice->getStatus() === "PAID" || $invoice->getStatus() === "CANCELLED" ? 0 : $invoice->getAmount());
        }, 0);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, Invoice>
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices[] = $invoice;
            $invoice->setCustomer($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getCustomer() === $this) {
                $invoice->setCustomer(null);
            }
        }

        return $this;
    }

    public function getUserCustomer(): ?User
    {
        return $this->userCustomer;
    }

    public function setUserCustomer(?User $userCustomer): self
    {
        $this->userCustomer = $userCustomer;

        return $this;
    }
}
