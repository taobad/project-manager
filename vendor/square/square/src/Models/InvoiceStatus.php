<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the status of an invoice.
 */
class InvoiceStatus
{
    /**
     * The invoice is a draft. You must publish a draft invoice before Square can process it.
     * A draft invoice has no `public_url`, so it is not available to customers.
     */
    public const DRAFT = 'DRAFT';

    /**
     * The invoice is published but not yet paid.
     */
    public const UNPAID = 'UNPAID';

    /**
     * The invoice is scheduled to be processed. On the scheduled date,
     * Square emails the invoice (if the `request_method` is `EMAIL`),
     * charges the customer's card (if the `request_method` is `CHARGE_CARD_ON_FILE`),
     * or takes no action (if the `request_method` is `SHARE_MANUALLY`).
     * The invoice status then changes accordingly (`UNPAID`, `PAID`, or `PARTIALLY_PAID`).
     */
    public const SCHEDULED = 'SCHEDULED';

    /**
     * A partial payment is received for the invoice.
     */
    public const PARTIALLY_PAID = 'PARTIALLY_PAID';

    /**
     * The customer paid the invoice in full.
     */
    public const PAID = 'PAID';

    /**
     * The invoice is paid (or partially paid) and some but not all the amount paid is
     * refunded.
     */
    public const PARTIALLY_REFUNDED = 'PARTIALLY_REFUNDED';

    /**
     * The full amount that the customer paid for the invoice is refunded.
     */
    public const REFUNDED = 'REFUNDED';

    /**
     * The invoice is canceled. Square no longer requests payments from the customer.
     * The `public_url` page remains and is accessible, but it displays the invoice
     * as cancelled and does not accept payment.
     */
    public const CANCELED = 'CANCELED';

    /**
     * Square canceled the invoice due to suspicious activity.
     */
    public const FAILED = 'FAILED';

    /**
     * A payment on the invoice was initiated but has not yet been processed.
     *
     * When in this state, invoices cannot be updated and other payments cannot be initiated.
     */
    public const PAYMENT_PENDING = 'PAYMENT_PENDING';
}
