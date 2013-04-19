<h4>Order print paper currency</h4>
<script>
function Calculate(){
<?php
echo "var UserDefined = 0;\n";
echo "var TotalPrint = 0;\n";
echo "var TotalValue = 0;\n";
echo "var Service = 0;\n";
echo "var Deliver = 0;\n";
echo "var GrandTotal = 0;\n";

foreach($denominations as $d){
	echo "var Total".$d['_id']." = (".$d['denomination']." * $('#I".$d['_id']."').val()).toFixed(2);\n";
	echo "$('#T".$d['_id']."').html(Total".$d['_id'].");\n";
	echo "Print = parseInt($('#I".$d['_id']."').val());\n";
	echo "TotalPrint = TotalPrint + Print;\n";
	echo "TotalValue = TotalValue + parseFloat(Total".$d['_id'].");\n";
}
	echo "UserDefined = $('#UserDefined').val();\n";
	echo "if(UserDefined>0){TotalPrint = TotalPrint + 1;TotalValue = TotalValue + + parseFloat(UserDefined);}\n";
	echo "$('#UserDefinedValue').html(UserDefined);\n";
	echo "$('#TotalPrints').html(TotalPrint);\n";
	echo "$('#TotalPrintx').html(TotalPrint);\n";	
	echo "$('#Servicex').html(TotalPrint);\n";		
	echo "$('#TotalValue').html(TotalValue.toFixed(8));\n";
	echo "Service = (TotalPrint * 0.01).toFixed(2);\n";
	echo "$('#Service').html(Service);\n";
	echo "Deliver = parseFloat((TotalPrint * 0.02 + 1 ).toFixed(2)).toFixed(2);\n";	
	echo "$('#Deliver').html(Deliver);\n";	

	echo "if($('#Checked:checked').length==0){\n";
	echo "GrandTotal = parseFloat(parseFloat(TotalValue) + parseFloat(Service)  ).toFixed(8) \n";
	echo "}else{\n";
	echo "GrandTotal = parseFloat(parseFloat(TotalValue) + parseFloat(Service) + parseFloat(Deliver) ).toFixed(8) \n";
	echo "}\n";
	echo "$('#GrandTotal').html(GrandTotal);\n";	
	echo "$('#GrandTotalInput').val(GrandTotal);\n";		
?>
}
</script>
<div class="row">
	<div class="span4">
<?=$this->form->create('',array('url'=>'/print/addorder')); ?>
<input type="hidden" name="user_id" id="user_id" value="<?=$user['_id']?>">
<input type="hidden" name="username" id="username" value="<?=$user['username']?>">
<input type="hidden" name="GrandTotalInput" id="GrandTotalInput" value="">
<table class="table table-condensed table-striped table-bordered" style="background-color:white;width:100% ">
	<thead>
		<tr>
			<th>BTC</th>
			<th>#</th>
			<th><div style="width:100px;text-align:right" >Total</div></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Your own BTC Value
			<input type="text" id="UserDefined" name="UserDefined" value="" placeholder="12.1234" class="span2"  onBlur="Calculate();" maxlength="8">
			</td>
			<td>Only 1 print</td>
			<td><div style="width:100px;text-align:right" id="UserDefinedValue">0.00</div></td>
		</tr>
	<?php
		foreach($denominations as $d){
	?>
		<tr>
			<td><?=$d['denomination']?> BTC</td>
			<td><input name="I<?=$d['_id']?>" id="I<?=$d['_id']?>" value="0" class="span1" onBlur="Calculate();" maxlength="2"></td>
			<td ><div style="width:100px;text-align:right" id="T<?=$d['_id']?>">0.00</div></td>
		</tr>
	<?php }
	?>
	<tr>
		<th>Total</th>
		<th><div style="width:100px;text-align:right" id="TotalPrints">0</div></th>
		<th><div style="width:100px;text-align:right" id="TotalValue">0</div></th>
	</tr>
	<tr>
		<th>Service</th>
		<td>0.01 x <span id="Servicex">0</span></td>
		<td><div style="width:100px;text-align:right" id="Service">0.00</div></td>
	</tr>
	<tr>
		<th colspan="2">Email</th>
		<td><div style="width:100px;text-align:right" >0.00</div></td>
	</tr>
	<tr>
		<th>Print and deliver</th>
		<td>0.02 x <span id="TotalPrintx">0</span> + 1</td>
		<td><div style="width:100px;text-align:right" id="Deliver">0.00</div></td>
	</tr>
	<tr>
		<th>Grand Total </th>
		<td><input type="checkbox" value="1" checked="checked" name="Checked" id="Checked" onBlur="Calculate();"> &nbsp;Print </td>
		<th><div style="width:100px;text-align:right" id="GrandTotal">0.00</div></th>
	</tr>
	<tr>
		<th>Email:</th>
		<td colspan="2"><input type="text" name="email" id="email" value="<?=$user['email']?>" placeholder="name@domain.com"></td>
	</tr>
	<tr>
		<td colspan="3"><input type="submit" name="Submit" value="Order now!" class="btn btn-primary" onClick="Calculate();return CheckOrder();"></td>
	</tr>
	</tbody>
</table>
</form>
	</div>
	<div class="span4">
<h5>Uses:</h5>
<ol>
	<li><strong>Security</strong>: As this is an offline virtual currency, it is very safe from the hackers of the internet world.</li>
	<li><strong>Gift</strong>: You can gift these bitcoins to friends, children, grandchildren and make them aware of this new phenomena. Also make their world secure!</li>
	<li><strong>Collectibles</strong>: Use them as collectibles as you collect stamps...</li>
	<li><strong>Transact</strong>: Many newbies want bitcoins, but they do not trust it unless they see it and feel it. This is one of the best options for traders who sell BTC off cafes, meeting points. They can show them and give them to the buyer for cash!</li>	
	<li><strong>Denominations</strong>: You wallet can be broken to different denominations of safe currency. If you have 100BTC, you can divide them into:
		<ul>
			<li>1 x 50 BTC</li>
			<li>1 x 20 BTC</li>
			<li>1 x 10 BTC</li>
			<li>1 x 5 BTC</li>
			<li>1 x 2 BTC</li>
			<li>5 x 1 BTC</li>
			<li>10 x 0.1 BTC</li>
			<li>20 x 0.2 BTC</li>
			<li>10 x 0.5 BTC</li>
		</ul>
		These can be used as a normal currency when you need to spend it. You will not expose your main wallet to the world.
	</li>
</ol>
<h5>What are the charges:</h5>
<ol>
	<li>Service charge: Only 0.01 per print in PDF or email</li>
	<li>Email - <strong>FREE</strong></li>
	<li>Printing / Snail mail cost
		<ul>
			<li>Printing - 0.02 BTC per denomination</li>
			<li>Snail mail cost 1 BTC per parcel</li>
		</ul>
	</li>
</ol>
	</div>
</div>