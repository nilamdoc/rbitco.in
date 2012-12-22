function SetCurrency(currency){
	$.getJSON('/Utils/currency/'+currency,
				function(){
					window.location = "/";
					}
			  );
	}