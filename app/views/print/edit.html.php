<h4>Edit currency</h4>
<form action="/print/save" method="post">
	<input type="submit" name="Save" class="btn btn-primary" value="Save">
	<input type="hidden" name="_id" id="_id" value="<?=$denomination['_id']?>">
<div style="height:1291px;width:2409px;background-image:url(/img/bitcoin-temp.jpg) ">
	<div style="left:10px;top:10px;position:relative ">
	BTC
	<input type="text" name="btc.x" id="btc.x" value="<?=$denomination['btc.x']?>"  style="width:25px; ">
	<input type="text" name="btc.y" id="btc.y" value="<?=$denomination['btc.y']?>"  style="width:25px; ">
	</div>
	<div  style="left:10px;top:10px;position:relative ">
	BTCWord
	<input type="text" name="btcword.x" id="btcword.x" value="<?=$denomination['btcword.x']?>"  style="width:25px; ">
	<input type="text" name="btcword.y" id="btcword.y" value="<?=$denomination['btcword.y']?>"  style="width:25px; ">
	</div>
	<div  style="left:40px;top:120px;position:relative ">
	Address
	<input type="text" name="address.x" id="address.x" value="<?=$denomination['address.x']?>"  style="width:25px; ">
	<input type="text" name="address.y" id="address.y" value="<?=$denomination['address.y']?>"  style="width:25px; ">
	<input type="text" name="address.w" id="address.w" value="<?=$denomination['address.w']?>"  style="width:25px; ">	
	<input type="text" name="address.h" id="address.h" value="<?=$denomination['address.h']?>"  style="width:25px; ">	
	</div>
	<div  style="left:610px;top:730px;position:relative ">
	AddressSTR
	<input type="text" name="addressstr.x" id="addressstr.x" value="<?=$denomination['addressstr.x']?>"  style="width:25px; ">
	<input type="text" name="addressstr.y" id="addressstr.y" value="<?=$denomination['addressstr.y']?>"  style="width:25px; ">
	</div>
	<div  style="left:1730px;top:310px;position:relative ">
	Private
	<input type="text" name="private.x" id="private.x" value="<?=$denomination['private.x']?>"  style="width:25px; ">
	<input type="text" name="private.y" id="private.y" value="<?=$denomination['private.y']?>"  style="width:25px; ">
	<input type="text" name="private.w" id="private.w" value="<?=$denomination['private.w']?>"  style="width:25px; ">	
	<input type="text" name="private.h" id="private.h" value="<?=$denomination['private.h']?>"  style="width:25px; ">	
	</div>
	<div  style="left:1610px;top:930px;position:relative ">
	PrivateSTR
	<input type="text" name="privatestr.x" id="privatestr.x" value="<?=$denomination['privatestr.x']?>"  style="width:25px; ">
	<input type="text" name="privatestr.y" id="privatestr.y" value="<?=$denomination['privatestr.y']?>"  style="width:25px; ">
	</div>
	<div  style="left:1210px;top:950px;position:relative ">
	BTC Pos
	<input type="text" name="btcpos.x" id="btcpos.x" value="<?=$denomination['btcpos.x']?>"  style="width:25px; ">
	<input type="text" name="btcpos.y" id="btcpos.y" value="<?=$denomination['btcpos.y']?>"  style="width:25px; ">
	</div>
</div>
</form>