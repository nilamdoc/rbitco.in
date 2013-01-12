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