function SetCurrency(currency){
	$.getJSON('/Utils/currency/'+currency,
				function(){
					window.location = "/";
					}
			  );
	}
function addBank(){
	if(document.getElementById('Bankname').value==""){
		alert("Bank name is required");
		return false;
	}
	if(document.getElementById('Accountnumber').value==""){
		alert("Account number is required");
		return false;
	}
	if(document.getElementById('Branchname').value==""){
		alert("Branch name is required");
		return false;
	}
	if(document.getElementById('Micrnumber').value==""){
		alert("MICR number is required");
		return false;
	}
	if(document.getElementById('Accountname').value==""){
		alert("Account name is required");
		return false;
	}
	return;
}
function ConfirmVainty(Patternlength){
	if(document.getElementById('Email').value==""){
		alert("Email is required");
		return false;
	}
	if(document.getElementById('VanityPaymentFrom').value==""){
		alert("Vanity payment from is required");
		return false;
	}
	if(document.getElementById('VanityPattern').value==""){
		alert("Vanity pattern is required");
		return false;
	}
	if((document.getElementById('VanityPattern').value).length!=Patternlength){
		alert("Vanity pattern length does not match");
		return false;
	}

	return;
}
function CompareAmount(){
	var maxAmount = $("#MaxAmount").val();
	var Amount = $("#Amount").val();	
	var address = $("#Address").val();	
	var verifyaddress = $("#VerifyAddress").val();		
	if(Amount==""){
		alert("Please enter an amount");
		return false;
	}
	
	if(Amount>=maxAmount){
		alert("Transfer amount should be less than "+maxAmount);
		return false;
	}
	if(address==""){
		alert("Please enter an address");
		return false;
	}
	if(verifyaddress!=address){
		alert("Both address does not match");
		return false;
	}
	
}
function placeBid(currency){
	if(currency=="USD"){
		if($("#bidusdAmount").val()==""){
			alert("I want to buy cannot be null");
			return false;
		}
		if($("#bidusdAmount").val()<="0.01"){
			alert("I want to buy cannot be less than 0.01");
			return false;
		}

		if($("#btcusdAmount").val()==""){
			alert("Bid price cannot be null");
			return false;
		}
	}
	if(currency=="INR"){
		if($("#btcinrAmount").val()==""){
			alert("I want to buy cannot be null");
			return false;
		}
		if($("#btcinrAmount").val()<="0.01"){
			alert("I want to buy cannot be less than 0.01");
			return false;
		}
		if($("#bidinrAmount").val()==""){
			alert("Bid price cannot be null");
			return false;
		}
	}
}

function respondBid(user_id,username,deal_id,btc_amount,bid_amount,type,currency){
	var TotalAmount = Math.round(bid_amount*btc_amount,2);
	
	$("#Username").html(username);
	$("#user_id").val(user_id);	
	$("#deal_id").val(deal_id);		
	$("#BTC_Amount").html(btc_amount);		
	$("#Bid_Amount").html(bid_amount);		
	$("#TotalAmount").html(TotalAmount);
	$("#Currency").html(currency);		
	$("#CurrencyOut").html(currency);			
	$("#Type").html(type);	
	if(type=="Buy"){
		$("#Response").html("Sell");	
	}else{
		$("#Response").html("Buy");	
	}
}