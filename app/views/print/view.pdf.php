<?php
use app\extensions\action\Functions;
$function = new Functions();

ini_set('memory_limit', '-1');

$pdf =& $this->Pdf;
$this->Pdf->setCustomLayout(array(
    'header'=>function() use($pdf){
        list($r, $g, $b) = array(200,200,200);
        $pdf->SetFillColor($r, $g, $b); 
        $pdf->SetTextColor(0 , 0, 0);
        $pdf->Cell(0,15, 'Bitcoin paper currency', 0,1,'C', 1);
        $pdf->Ln();
    },
    'footer'=>function() use($pdf){
        $footertext = sprintf('Copyright © %d http://rBitco.in. All rights reserved.', date('Y')); 
        $pdf->SetY(-20); 
        $pdf->SetTextColor(0, 0, 0); 
        $pdf->SetFont(PDF_FONT_NAME_MAIN,'', 8); 
        $pdf->Cell(0,8, $footertext,'T',1,'C');
    }
));
$pdf->setMargins(10,30,10);
$pdf->SetAuthor('https://rBitco.in');
$pdf->SetAutoPageBreak(true);

$pdf->AddPage();
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont($textfont,'B',20); 

$btc = $denomination['denomination']." BTC";
$btcword = ucwords($function->number_to_words($denomination['denomination']))." BTC";
$height = $denomination['height'];
$width = $denomination['width'];
$address = "13y5Q8dBaMzkZQPcdHz95etjcAfv4U5i4X";
$private = "5KJS7D3FwxRD6spPzri1Fa5bfmP3Zt4UNE5xVwcNHEPeN2u2STx";
$pdf->Image(LITHIUM_APP_PATH.'/webroot/img/bitcoin-temp.jpg', 10, 30, 124, 68, 'JPG', '', '', true, 300, '', false, false, 1, false, false, false);
$pdf->Image(LITHIUM_APP_PATH.'/webroot/img/bitcoin-address.jpg', 15, 42, 28, 28, 'JPG', '', '', true, 300, '', false, false, 1, false, false, false);
$pdf->Image(LITHIUM_APP_PATH.'/webroot/img/bitcoin-private.jpg', 101, 57, 30, 30, 'JPG', '', '', true, 300, '', false, false, 1, false, false, false);
$pdf->SetXY(10,28,false);
$pdf->Cell(0,13, $btc, 0,1,'L');
$pdf->SetFont($textfont, 'B', 6);
$pdf->SetXY(10,38,false);
$pdf->Cell(0,0, $btcword, 0,10,'L');
$pdf->SetFont($textfont, 'B', 10);
$pdf->SetXY(70,44,false);
$this->Pdf->Cell(0,100, $btc, 0,10,'L');
$pdf->SetFont($textfont, 'B', 5);
$pdf->Rotate(90);
$pdf->SetXY(139,120,false);
$this->Pdf->Cell(0,0, $address, 0,10,'L');
$pdf->SetXY(123,171,false);
$this->Pdf->Cell(0,0, $private, 0,10,'L');
$pdf->Rotate(270);
$pdf->SetXY(70,160,false);
$pdf->SetFont($textfont, 'B', 20);
$pdf->Rotate(45);
$pdf->Cell(0,0, "SPECIMEN SAMPLE", 0,10,'L');
$pdf->Rotate(-45);
$pdf->SetFont($textfont, 'B', 11);
?>