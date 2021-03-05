<?php
/**
 * Contains the BaseClassTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     GPL
 * @since       2017-12-15
 *
 */

namespace Workice\PdfInvoice\Tests;

use PHPUnit\Framework\TestCase;
use Workice\PdfInvoice\InvoicePrinter;

class BaseClassTest extends TestCase
{
    /**
     * @test
     */
    public function can_be_instantiated()
    {
        $invoicr = new InvoicePrinter();

        $this->assertInstanceOf(InvoicePrinter::class, $invoicr);
    }
}
