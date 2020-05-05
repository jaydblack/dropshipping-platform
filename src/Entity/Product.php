<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\Product as BaseProduct;

class Product extends BaseProduct implements ProductInterface
{
    protected $color;

    /** @var SupplierInterface[] */
    protected $suppliers;

    /** @var string $externalId */
    protected $externalId;

    public function __construct()
    {
        parent::__construct();
        $this->suppliers = new ArrayCollection();
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function getSuppliers(): Collection
    {
        return $this->suppliers;
    }

    public function addSupplier(SupplierInterface $supplier): void
    {
        if (!$this->hasSupplier($supplier)) {
            $this->suppliers->add($supplier);
            $supplier->setProduct($this);
        }
    }

    public function removeSupplier(SupplierInterface $Supplier): void
    {
        if ($this->hasSupplier($Supplier)) {
            $this->suppliers->removeElement($Supplier);
        }
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): void
    {
        $this->externalId = $externalId;
    }
}
