<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Describes a `DeleteInvoice` request.
 */
class DeleteInvoiceRequest implements \JsonSerializable
{
    /**
     * @var int|null
     */
    private $version;

    /**
     * Returns Version.
     *
     * The version of the [invoice](#type-invoice) to delete.
     * If you do not know the version, you can call [GetInvoice](#endpoint-Invoices-GetInvoice) or
     * [ListInvoices](#endpoint-Invoices-ListInvoices).
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     *
     * The version of the [invoice](#type-invoice) to delete.
     * If you do not know the version, you can call [GetInvoice](#endpoint-Invoices-GetInvoice) or
     * [ListInvoices](#endpoint-Invoices-ListInvoices).
     *
     * @maps version
     */
    public function setVersion(?int $version): void
    {
        $this->version = $version;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['version'] = $this->version;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
