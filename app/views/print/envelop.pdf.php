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
        $pdf->SetY(-10); 
        $pdf->SetTextColor(0, 0, 0); 
        $pdf->SetFont(PDF_FONT_NAME_MAIN,'', 8); 
        $pdf->Cell(0,8, $footertext,'T',1,'C');
    }

));

$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);
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
$image = $denomination['image'];
$address = "13y5Q8dBaMzkZQPcdHz95etjcAfv4U5i4X";
$private = "5KJS7D3FwxRD6spPzri1Fa5bfmP3Zt4UNE5xVwcNHEPeN2u2STx";

$pdf->AddPage('P');
$pdf->Image(LITHIUM_APP_PATH.'/webroot/img/bitcoin-temp-'.$image.'.jpg', 30, 10, 143, 267, '', '', '', false, 300, '', false, false, 0);

$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont($textfont,'B',20); 
$pdf->SetXY(130,8,false);
$pdf->Cell(0,13, $btc, 0,1,'L');
$pdf->SetFont($textfont, 'B', 6);
$pdf->SetXY(130,12,false);
$pdf->Cell(0,13, $btcword, 0,10,'L');

$pdf->Image(LITHIUM_APP_PATH.'/webroot/img/bitcoin-address.jpg', 90, 21, 55, 55, 'JPG', '', '', true, 300, '', false, false, 1, false, false, false);

$pdf->SetFont($textfont, 'B', 9);
$pdf->SetXY(80,88,false);
$pdf->Cell(0,0, $address, 0,10,'L');

$pdf->SetXY(90,140,false);
$pdf->SetFont($textfont,'B',20); 
$pdf->Cell(0,13, $btc, 0,1,'L');
$pdf->SetFont($textfont, 'B', 6);
$pdf->SetXY(90,144,false);
$pdf->Cell(0,13, $btcword, 0,10,'L');

$pdf->SetFont($textfont, 'B', 9);
$pdf->SetXY(48,198,false);
$pdf->Cell(0,0, $private, 0,10,'L');


$pdf->Image(LITHIUM_APP_PATH.'/webroot/img/bitcoin-private.jpg', 54, 208, 62, 62, 'JPG', '', '', true, 300, '', false, false, 1, false, false, false);


?>