<?php


namespace App;


use Fpdf\Fpdf;

class Renderer extends Fpdf
{
    public function render(Invoice $invoice)
    {
        // TODO implement

        return $this->Output();
    }
}
