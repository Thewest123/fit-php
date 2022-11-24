<?php declare(strict_types=1);

namespace App;

use Dompdf\Dompdf;
use Latte;

class Renderer extends Dompdf
{
    public function makeInvoice(Invoice $invoice): string
    {
        $latte = new Latte\Engine;
        $params = [ "invoice" => $invoice ];        
        $html = $latte->renderToString('./src/templates/InvoiceTemplate.latte', $params);

        $dompdf = new DOMPDF();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        return $dompdf->output();
    }
}
