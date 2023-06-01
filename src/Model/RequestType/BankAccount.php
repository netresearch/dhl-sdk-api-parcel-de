<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\RequestType;

class BankAccount implements \JsonSerializable
{
    private ?string $bankName;

    private ?string $bic;

    public function __construct(private readonly string $accountHolder, private readonly string $iban)
    {
    }

    public function setBankName(?string $bankName): void
    {
        $this->bankName = $bankName;
    }

    public function setBic(?string $bic): void
    {
        $this->bic = $bic;
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
