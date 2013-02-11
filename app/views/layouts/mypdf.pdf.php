<?php
header("Content-type: application/pdf");
echo $this->Pdf->Output('rBitcoin-currency.pdf', 'D');
?>