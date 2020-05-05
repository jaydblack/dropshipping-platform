<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;

interface ProductInterface extends ResourceInterface
{
    public function getColor(): ?string;

    public function setColor(string $color): void;

    public function getSuppliers(): Collection;

    public function addSupplier(SupplierInterface $supplier): void;

    public function removeSupplier(SupplierInterface $supplier): void;

    public function getExternalId(): string;

    public function setExternalId(string $externalId): void;
}
