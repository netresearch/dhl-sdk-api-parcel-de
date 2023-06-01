<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Sdk\ParcelDe\Shipping\Model\RequestType;

abstract class Address implements \JsonSerializable
{
    /**
     * An optional, additional line of name information.
     *
     * @var string|null
     */
    protected ?string $name2;

    /**
     * An optional, additional line of name information.
     *
     * @var string|null
     */
    protected ?string $name3;

    /**
     * State, province or territory.
     *
     * For the USA please use the official regional ISO-Codes, e.g. US-AL.
     *
     * @var string|null
     */
    protected ?string $state;

    /**
     * House number, can alternatively be added to street name.
     *
     * @var string|null
     */
    protected ?string $addressHouse;

    /**
     * Additional information that is positioned either behind or below addressStreet on the label.
     *
     * If it is printed and where exactly depends on the country.
     *
     * @var string|null
     */
    protected ?string $additionalAddressInformation1;

    /**
     * Additional information that is positioned either behind or below addressStreet on the label.
     *
     * If it is printed and where exactly depends on the country.
     *
     * @var string|null
     */
    protected ?string $additionalAddressInformation2;

    /**
     * Optional contact name.
     *
     * @var string|null
     */
    protected ?string $contactName;

    /**
     * @var string|null
     */
    protected ?string $phone;

    /**
     * @var string|null
     */
    protected ?string $email;

    /**
     * An optional, additional line of address.
     *
     * It's only usable for a few countries, e.g. Belgium.
     * It is positioned below name3 on the label.
     *
     * @var string|null
     */
    private ?string $dispatchingInformation;

    /**
     * @param string $name1 Line 1 of name information
     * @param string $addressStreet Line 1 of the street address, street name (can also include house number)
     * @param string $postalCode Mandatory for all countries but Ireland that use a postal code system
     * @param string $city City
     * @param string $country A valid country code consisting of three characters according to ISO 3166-1 alpha-3.
     */
    public function __construct(
        protected readonly string $name1,
        protected readonly string $addressStreet,
        protected readonly string $postalCode,
        protected readonly string $city,
        protected readonly string $country
    ) {
    }

    public function setName2(?string $name2): void
    {
        $this->name2 = $name2;
    }

    public function setName3(?string $name3): void
    {
        $this->name3 = $name3;
    }

    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    public function setAddressHouse(?string $addressHouse): void
    {
        $this->addressHouse = $addressHouse;
    }

    public function setAdditionalAddressInformation1(?string $additionalAddressInformation1): void
    {
        $this->additionalAddressInformation1 = $additionalAddressInformation1;
    }

    public function setAdditionalAddressInformation2(?string $additionalAddressInformation2): void
    {
        $this->additionalAddressInformation2 = $additionalAddressInformation2;
    }

    public function setContactName(?string $contactName): void
    {
        $this->contactName = $contactName;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function setDispatchingInformation(?string $dispatchingInformation): void
    {
        $this->dispatchingInformation = $dispatchingInformation;
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
