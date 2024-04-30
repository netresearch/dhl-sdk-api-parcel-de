<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\RequestType;

class CashOnDelivery implements \JsonSerializable
{
    private \JsonSerializable|BankAccount|null $bankAccount = null;

    private ?string $accountReference = null;

    private ?string $transferNote1 = null;

    private ?string $transferNote2 = null;

    public function __construct(private readonly \JsonSerializable|MonetaryValue $amount)
    {
    }

    public function setBankAccount(\JsonSerializable|BankAccount|null $bankAccount): void
    {
        $this->bankAccount = $bankAccount;
    }

    public function setAccountReference(?string $accountReference): void
    {
        $this->accountReference = $accountReference;
    }

    public function setTransferNote1(?string $transferNote1): void
    {
        $this->transferNote1 = $transferNote1;
    }

    public function setTransferNote2(?string $transferNote2): void
    {
        $this->transferNote2 = $transferNote2;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @return mixed[] Serializable object properties
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
