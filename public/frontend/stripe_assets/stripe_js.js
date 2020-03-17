// Create a Stripe client.
var stripe = Stripe('pk_test_NLgUesdX4gq4fhma2Ed8JwXA');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    lineHeight: '18px',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();

  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
 /////////////////////////////////////sweta/////////////////////
  
    var guest_name = document.getElementById('guest_name').value.trim();   
		var guest_mobile = document.getElementById('guest_mobile').value.trim();   
		var guest_email = document.getElementById('guest_email').value.trim();   
		var guest_address = document.getElementById('guest_address').value.trim();   
		var guest_city = document.getElementById('guest_city').value.trim();   
		var guest_country = document.getElementById('guest_country').value.trim();   
		var guest_postcode = document.getElementById('guest_postcode').value.trim(); 
    var user_type = $('input[name=user_type]:checked').val();
		var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
	
	
		var recipient_name = document.getElementById('recipient_name').value.trim();   
		var recipient_mobile = document.getElementById('recipient_mobile').value.trim();   
		var recipient_email = document.getElementById('recipient_email').value.trim();   
		var recipient_address = document.getElementById('recipient_address').value.trim();   
		var recipient_city = document.getElementById('recipient_city').value.trim();   
		var recipient_country = document.getElementById('recipient_country').value.trim();   
		var recipient_postcode = document.getElementById('recipient_postcode').value.trim(); 
	
		var total_price = document.getElementById('total_price').value.trim(); 


		var strUserEml=guest_email.toLowerCase();
		var recipient_email1=recipient_email.toLowerCase();

	if(user_type=='GUEST'){
		if(guest_name == "")
	{
		document.getElementById('guest_name').style.border='1px solid #ff0000';
		document.getElementById("guest_name").focus();
		$('#guest_name').val('');
		$('#guest_name').attr("placeholder", "Please enter your full name");
		$("#guest_name").addClass( "errors" );
		return false;
	}
	else{
		document.getElementById('guest_name').style.border=' ';
	}
	
	if(guest_mobile == "")
	{
		document.getElementById('guest_mobile').style.border='1px solid #ff0000';
		document.getElementById("guest_mobile").focus();
		$('#guest_mobile').val('');
		$('#guest_mobile').attr("placeholder", "Please enter your mobile");
		$("#guest_mobile").addClass( "errors" );
		return false;
	}
	else if(guest_mobile.length <=9 || guest_mobile.length >=16)
	{
			document.getElementById('guest_mobile').style.border='1px solid #ff0000';
		document.getElementById("guest_mobile").focus();
		$("#guest_mobile").val('');
		$('#guest_mobile').attr("placeholder", "Phone no should be 10-16 digits");
		$("#guest_mobile").addClass( "errors" );

			return false;
	}
	else{
		document.getElementById('guest_mobile').style.border=' ';
	} 
	
	if(guest_email == "")
	{
		document.getElementById('guest_email').style.border='1px solid #ff0000';
		document.getElementById("guest_email").focus();
		$('#guest_email').val('');
		$('#guest_email').attr("placeholder", "Please enter your email");
		$("#guest_email").addClass( "errors" );
		return false;
	} else if(!filter.test(strUserEml)) 
	{

		document.getElementById('guest_email').style.border='1px solid #ff0000';
		document.getElementById("guest_email").focus();
		$('#guest_email').val('');
		$('#guest_email').attr("placeholder", "Invalid E-mail Id");
		$("#guest_email").addClass( "errors" );

			return false;
	}
	else{
		document.getElementById('guest_email').style.border=' ';
	} 
	
	if(guest_address == "")
	{
		document.getElementById('guest_address').style.border='1px solid #ff0000';
		document.getElementById("guest_address").focus();
		$('#guest_address').val('');
		$('#guest_address').attr("placeholder", "Please enter your address");
		$("#guest_address").addClass( "errors" );
		return false;
	}
	else{
		document.getElementById('guest_address').style.border=' ';
	}
	
	if(guest_city == "")
	{
		document.getElementById('guest_city').style.border='1px solid #ff0000';
		document.getElementById("guest_city").focus();
		$('#guest_city').val('');
		$('#guest_city').attr("placeholder", "Please enter your city");
		$("#guest_city").addClass( "errors" );
		return false;
	}
	else{
		document.getElementById('guest_city').style.border=' ';
	} 
	
	if(guest_country == "")
	{
		document.getElementById('guest_country').style.border='1px solid #ff0000';
		document.getElementById("guest_country").focus();
		$('#guest_country').val('');
		$('#guest_country').attr("placeholder", "Please enter your country");
		$("#guest_country").addClass( "errors" );
		return false;
	}
	else{
		document.getElementById('guest_country').style.border=' ';
	} 
	
	if(guest_postcode == "")
	{
		document.getElementById('guest_postcode').style.border='1px solid #ff0000';
		document.getElementById("guest_postcode").focus();
		$('#guest_postcode').val('');
		$('#guest_postcode').attr("placeholder", "Please enter your postcode");
		$("#guest_postcode").addClass( "errors" );
		return false;
	}
	else{
		document.getElementById('guest_postcode').style.border=' ';
	} 	
	}
		

			
			if(recipient_name == "")
		{
			document.getElementById('recipient_name').style.border='1px solid #ff0000';
			document.getElementById("recipient_name").focus();
			$('#recipient_name').val('');
			$('#recipient_name').attr("placeholder", "Please enter your full name");
			$("#recipient_name").addClass( "errors" );
			return false;
		}
		else{
			document.getElementById('recipient_name').style.border=' ';
		}
		
		if(recipient_mobile == "")
		{
			document.getElementById('recipient_mobile').style.border='1px solid #ff0000';
			document.getElementById("recipient_mobile").focus();
			$('#recipient_mobile').val('');
			$('#recipient_mobile').attr("placeholder", "Please enter your mobile");
			$("#recipient_mobile").addClass( "errors" );
			return false;
		}
		else if(recipient_mobile.length <=9 || recipient_mobile.length >=16)
		{
				document.getElementById('recipient_mobile').style.border='1px solid #ff0000';
			document.getElementById("recipient_mobile").focus();
			$("#recipient_mobile").val('');
			$('#recipient_mobile').attr("placeholder", "Phone no should be 10-15 digits");
			$("#recipient_mobile").addClass( "errors" );

				return false;
		}
		else{
			document.getElementById('recipient_mobile').style.border=' ';
		} 
		
		if(recipient_email1 == "")
		{
			document.getElementById('recipient_email').style.border='1px solid #ff0000';
			document.getElementById("recipient_email").focus();
			$('#recipient_email').val('');
			$('#recipient_email').attr("placeholder", "Please enter your email");
			$("#recipient_email").addClass( "errors" );
			return false;
		}else if(!filter.test(recipient_email1)) 
		{

			document.getElementById('recipient_email').style.border='1px solid #ff0000';
			document.getElementById("recipient_email").focus();
			$('#recipient_email').val('');
			$('#recipient_email').attr("placeholder", "Invalid E-mail Id");
			$("#recipient_email").addClass( "errors" );

				return false;
		}
		else{
			document.getElementById('recipient_email').style.border=' ';
		} 
		
		if(recipient_address == "")
		{
			document.getElementById('recipient_address').style.border='1px solid #ff0000';
			document.getElementById("recipient_address").focus();
			$('#recipient_address').val('');
			$('#recipient_address').attr("placeholder", "Please enter your address");
			$("#recipient_address").addClass( "errors" );
			return false;
		}
		else{
			document.getElementById('recipient_address').style.border=' ';
		}
		
		if(recipient_city == "")
		{
			document.getElementById('recipient_city').style.border='1px solid #ff0000';
			document.getElementById("recipient_city").focus();
			$('#recipient_city').val('');
			$('#recipient_city').attr("placeholder", "Please enter your city");
			$("#recipient_city").addClass( "errors" );
			return false;
		}
		else{
			document.getElementById('recipient_city').style.border=' ';
		} 
		
		if(recipient_country == "")
		{
			document.getElementById('recipient_country').style.border='1px solid #ff0000';
			document.getElementById("recipient_country").focus();
			$('#recipient_country').val('');
			$('#recipient_country').attr("placeholder", "Please enter your country");
			$("#recipient_country").addClass( "errors" );
			return false;
		}
		else{
			document.getElementById('recipient_country').style.border=' ';
		} 
		
		if(recipient_postcode == "")
		{
			document.getElementById('recipient_postcode').style.border='1px solid #ff0000';
			document.getElementById("recipient_postcode").focus();
			$('#recipient_postcode').val('');
			$('#recipient_postcode').attr("placeholder", "Please enter your postcode");
			$("#recipient_postcode").addClass( "errors" );
			return false;
		}
		else{
			document.getElementById('recipient_postcode').style.border=' ';
    }  

    document.getElementById("formdata_guest_name").value=guest_name;
    document.getElementById("formdata_guest_mobile").value=guest_mobile;
    document.getElementById("formdata_guest_email").value=guest_email;
    document.getElementById("formdata_guest_address").value=guest_address;
    document.getElementById("formdata_guest_city").value=guest_city;
    document.getElementById("formdata_guest_country").value=guest_country;
    document.getElementById("formdata_guest_postcode").value=guest_postcode;
    document.getElementById("formdata_recipient_name").value=recipient_name; 
    document.getElementById("formdata_recipient_mobile").value=recipient_mobile;
    document.getElementById("formdata_recipient_email").value=recipient_email1;
    document.getElementById("formdata_recipient_address").value=recipient_address;
    document.getElementById("formdata_recipient_city").value=recipient_city;
    document.getElementById("formdata_recipient_country").value=recipient_country;
    document.getElementById("formdata_recipient_postcode").value=recipient_postcode;
    document.getElementById("formdata_total_price").value=total_price;
    document.getElementById("formdata_user_type").value=user_type;

    
    /////////////////////////////////sweta////////////////////////////////////
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}

