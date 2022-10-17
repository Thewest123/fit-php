<?php declare(strict_types=1);

namespace App;

use Dompdf\Dompdf;

class Renderer extends Dompdf
{
    public function makeInvoice(Invoice $invoice): string
    {
        // TODO implement
    }
}
