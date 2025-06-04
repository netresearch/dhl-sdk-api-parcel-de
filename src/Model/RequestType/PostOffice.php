<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\RequestType;

class PostOffice implements ConsigneeInterface, \JsonSerializable
{
    /**
     * Postnummer.
     *
     * The official account number a private DHL Customer gets upon registration.
     * To address a post office or retail outlet directly, either the post number
     * or e-mail address of the consignee is needed.
     */
    private ?string $postNumber = null;

    private ?string $email = null;

    /**
     * @param string $name Consignee Name
     * @param int $retailID Filialnummer: Three-digit number identifying the facility
     * @param string $postalCode The postal code of the facility location
     * @param string $city City where the facility is located
     * @param string $country A valid country code consisting of three characters according to ISO 3166-1 alpha-3
     */
    public function __construct(
        private readonly string $name,
        private readonly int $retailID,
        private readonly string $postalCode,
        private readonly string $city,
        private readonly string $country
    ) {
    }

    public function setPostNumber(?string $postNumber): void
    {
        $this->postNumber = $postNumber;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
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
