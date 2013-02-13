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
/*     'footer'=>function() use($pdf){
        $footertext = sprintf('Copyright © %d http://rBitco.in. All rights reserved.', date('Y')); 
        $pdf->SetY(-10); 
        $pdf->SetTextColor(0, 0, 0); 
        $pdf->SetFont(PDF_FONT_NAME_MAIN,'', 8); 
        $pdf->Cell(0,8, $footertext,'T',1,'C');
    }
*/
));
$pdf->setMargins(2,20,2);
$pdf->SetAuthor('https://rBitco.in');
$pdf->SetCreator('admin@rBitco.in');
$pdf->SetSubject('Real Bitcoin currency');

$pdf->SetAutoPageBreak(true);

$btc = $denomination['denomination']." BTC";
$btcword = ucwords($function->number_to_words($denomination['denomination']))." BTC";
$pdf->SetKeywords('Real Bitcoin currency:'.$btcword);
$pdf->SetTitle('Real Bitcoin currency:'.$btcword);

$height = $denomination['height'];
$width = $denomination['width'];

$btcx = $denomination['btc.x'];
$btcy = $denomination['btc.y'];

$btcwordx = $denomination['btcword.x'];
$btcwordy = $denomination['btcword.y'];

$addressx = $denomination['address.x'];
$addressy = $denomination['address.y'];
$addressw = $denomination['address.w'];
$addressh = $denomination['address.h'];

$addressstrx = $denomination['addressstr.x'];
$addressstry = $denomination['addressstr.y'];

$privatex = $denomination['private.x'];
$privatey = $denomination['private.y'];
$privatew = $denomination['private.w'];
$privateh = $denomination['private.h'];

$privatestrx = $denomination['privatestr.x'];
$privatestry = $denomination['privatestr.y'];

$btcposx = $denomination['btcpos.x'];
$btcposy = $denomination['btcpos.y'];

$address = "13y5Q8dBaMzkZQPcdHz95etjcAfv4U5i4X";
$private = "5KJS7D3FwxRD6spPzri1Fa5bfmP3Zt4UNE5xVwcNHEPeN2u2STx";

$pdf->AddPage('L');
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont($textfont,'B',20); 
$pdf->Image(LITHIUM_APP_PATH.'/webroot/img/bitcoin-temp.jpg', 10, 30, $width, $height, 'JPG', '', '', true, 300, '', false, false, 1, false, false, false);
$pdf->Image(LITHIUM_APP_PATH.'/webroot/img/bitcoin-address.jpg', $addressx, $addressy, $addressw, $addressh, 'JPG', '', '', true, 300, '', false, false, 1, false, false, false);
$pdf->Image(LITHIUM_APP_PATH.'/webroot/img/bitcoin-private.jpg', $privatex, $privatey, $privatew, $privateh, 'JPG', '', '', true, 300, '', false, false, 1, false, false, false);
$pdf->SetXY($btcx,$btcy,false);
$pdf->Cell(0,13, $btc, 0,1,'L');
$pdf->SetFont($textfont, 'B', 6);
$pdf->SetXY($btcwordx,$btcwordy,false);
$pdf->Cell(0,0, $btcword, 0,10,'L');
$pdf->SetFont($textfont, 'B', 10);
$pdf->SetXY($btcposx,$btcposy,false);
$pdf->Cell(0,100, $btc, 0,10,'L');
$pdf->SetFont($textfont, 'B', 5);
$pdf->Rotate(90);
$pdf->SetXY($addressstrx,$addressstry,false);
$pdf->Cell(0,0, $address, 0,10,'L');
$pdf->SetXY($privatestrx,$privatestry,false);
$pdf->Cell(0,0, $private, 0,10,'L');
$pdf->Rotate(270);
$pdf->SetXY(70,160,false);
$pdf->SetFont($textfont, 'B', 20);
$pdf->Rotate(45);
$pdf->Cell(0,0, "SPECIMEN SAMPLE", 0,10,'L');
$pdf->Rotate(-45);
$pdf->SetFont($textfont, 'B', 11);
?>