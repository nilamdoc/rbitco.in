<h4>Get short URL fro your bit address:</h4>
<h3>bitcoin address shortener</h3>
<?php if(isset($shorten)){?>
<h3>Your bitcoin address: <?=$address?><br>

Short URL  <a href="https://<?=$_SERVER['HTTP_HOST'];?>/s/<?=$shorten?>" target="_blank"><strong style="color:#FF0000 ">https://<?=$_SERVER['HTTP_HOST'];?>/s/<?=$shorten?></strong></a><br>
Short URL  QRCode <a href="https://<?=$_SERVER['HTTP_HOST'];?>/s/<?=$shorten?>/qr" target="_blank"><strong style="color:#FF0000 ">http://<?=$_SERVER['HTTP_HOST'];?>/s/<?=$shorten?>/qr</strong></a></h3>
<?php }?>

<?=$this->form->create(); ?>
<?=$this->form->field('address', array('label'=>'Bitcoin address','placeholder'=>'enter full or short bitcoin address','class'=>'span3','value'=>$address )); ?>
<?=$this->form->submit('go' ,array('class'=>'btn btn-primary','onclick'=>'if(document.getElementById("Address").value==""){alert("Enter bitcoin address!");return false;}')); ?>
<?=$this->form->end(); ?>
<h5>What is short address?</h5>
<p>Bitcoin addresses are long and easy to forget. 
They are also difficult to input on a mobile device. 
A bitcoin address shortener solves these and many other issues common with bitcoin addresses.</p>
<h5>Why to use?</h5>
<p>Simply enter a bitcoin address to receive or create a shortened https://<?=$_SERVER['HTTP_HOST'];?>/s/ address. If you have a shortened btc.to address, enter it to receive the original bitcoin address. </p>

<p>https://<?=$_SERVER['HTTP_HOST'];?>/s/ is completly safe. Our entire shortened database will be continuously available for public view and download shortly. <?=$_SERVER['HTTP_HOST'];?> is the official bitcoin address shortener of rBitco.in</p>
<h5>Examples:</h5>
<p>https://<?=$_SERVER['HTTP_HOST'];?>/s/1NiLAMn67Q2k6v5KGwLRmrimJ11YQJyixa</p>
<pre>a2ew</pre>
<p>https://<?=$_SERVER['HTTP_HOST'];?>/s/a2ew</p>
<pre>1NiLAMn67Q2k6v5KGwLRmrimJ11YQJyixa</pre>
<p>Adding qr at the end of the address will show QRcode</p>
<p>https://<?=$_SERVER['HTTP_HOST'];?>/s/1NiLAMn67Q2k6v5KGwLRmrimJ11YQJyixa/<strong>qr</strong></p>
<p>https://<?=$_SERVER['HTTP_HOST'];?>/s/a2ew/<strong>qr</strong></p>
<img src="/qrcode/out/1BitCoinpjWQKnrR3GXH1awtRjJDpCGU15.png">
<h5>Developers</h5>
<p>Include bitcoin shortener support in your app with our simple API.</p>
<pre>GET https://<?=$_SERVER['HTTP_HOST'];?>/s/&lt;full bitcoin address&gt;
  returns short address
GET https://<?=$_SERVER['HTTP_HOST'];?>/s/&lt;short address&gt;
  returns full bitcoin address
</pre>

<h5>Blockexplorer</h5>
<p>Use https://<?=$_SERVER['HTTP_HOST'];?>/s/ to easily check block explorer.<br>
<pre>https://<?=$_SERVER['HTTP_HOST'];?>/s/&lt;short or full address&gt;/be</pre>
  Automatically redirects to Block Explorer page 
</p>