<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<script type="text/javascript" src="button.js"></script>
<style>
	#mpesa{
		padding: 10px 30px;
		background-color: green;
		width: 20%;
		border-radius: 20px;
	}
	#mpesa a{
		color:white;

	}
</style>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	        <div class="row">
	        	<div class="col-sm-9">
	        		<h1 class="page-header">YOUR CART</h1>
	        		<div class="box box-solid">
	        			<div class="box-body">
		        		<table class="table table-bordered">
		        			<thead>
		        				<th></th>
		        				<th>Photo</th>
		        				<th>Name</th>
		        				<th>Price</th>
		        				<th width="20%">Quantity</th>
		        				<th>Subtotal</th>
		        			</thead>
		        			<tbody id="tbody">
		        			</tbody>
		        		</table>
	        			</div>
	        		</div>
	        		<?php
	        			if(isset($_SESSION['user'])){
	        				echo "
							<div id='mpesa'><a href='mpesa.php'>Mpesa</> </div> 
							<br>
	        					<div id='paypal-button'></div>
	        				";
	        			}
	        			else{
	        				echo "
	        					<h4>You need to <a href='login.php'>Login</a> to checkout.</h4>
	        				";
	        			}
	        		?>
	        	</div>
	        	<div class="col-sm-3">
	        		<?php include 'includes/sidebar.php'; ?>
	        	</div>
	        </div>
	      </section>
	     
	    </div>
	  </div>
  	<?php $pdo->close(); ?>
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
<script>
var total = 0;
$(function(){
	$(document).on('click', '.cart_delete', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		$.ajax({
			type: 'POST',
			url: 'cart_delete.php',
			data: {id:id},
			dataType: 'json',
			success: function(response){
				if(!response.error){
					getDetails();
					getCart();
					getTotal();
				}
			}
		});
	});

	$(document).on('click', '.minus', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var qty = $('#qty_'+id).val();
		if(qty>1){
			qty--;
		}
		$('#qty_'+id).val(qty);
		$.ajax({
			type: 'POST',
			url: 'cart_update.php',
			data: {
				id: id,
				qty: qty,
			},
			dataType: 'json',
			success: function(response){
				if(!response.error){
					getDetails();
					getCart();
					getTotal();
				}
			}
		});
	});

	$(document).on('click', '.add', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var qty = $('#qty_'+id).val();
		qty++;
		$('#qty_'+id).val(qty);
		$.ajax({
			type: 'POST',
			url: 'cart_update.php',
			data: {
				id: id,
				qty: qty,
			},
			dataType: 'json',
			success: function(response){
				if(!response.error){
					getDetails();
					getCart();
					getTotal();
				}
			}
		});
	});

	getDetails();
	getTotal();

});

function getDetails(){
	$.ajax({
		type: 'POST',
		url: 'cart_details.php',
		dataType: 'json',
		success: function(response){
			$('#tbody').html(response);
			getCart();
		}
	});
}

function getTotal(){
	$.ajax({
		type: 'POST',
		url: 'cart_total.php',
		dataType: 'json',
		success:function(response){
			total = response;
		}
	});
}

</script>
<!-- Paypal Express -->
<script>
paypal.Button.render({
    env: 'sandbox', // change for production if app is live,

	client: {
        sandbox:    'ASE-pQNNFWKt2rvt5ZrIE_LkNKzCKQw4kja8JMaOA0hVEe5-ICpl80kKxbk2yUz5w43JolWQmmO1Tx3R',
        //production: 'AaBHKJFEej4V6yaArjzSx9cuf-UYesQYKqynQVCdBlKuZKawDDzFyuQdidPOBSGEhWaNQnnvfzuFB9SM'
    },

    commit: true, // Show a 'Pay Now' button

    style: {
    	color: 'gold',
    	size: 'small'
    },

    payment: function(data, actions) {
        return actions.payment.create({
            payment: {
                transactions: [
                    {
                    	//total purchase
                        amount: { 
                        	total: total, 
                        	currency: 'USD' 
                        }
                    }
                ]
            }
        });
    },

    onAuthorize: function(data, actions) {
        return actions.payment.execute().then(function(payment) {
			window.location = 'sales.php?pay='+payment.id;
        });
    },

}, '#paypal-button');
</script>
<script>
	var button = document.getElementById("mpesaButton");

if (button !== null) {
    document.head.insertAdjacentHTML('beforeend', '<link rel=stylesheet href="https://cdn.jsdelivr.net/gh/muaad/mpesa_button@master/styles/style.css">');
    img = '<img style="width: 35px; display: inline; margin: -8px;" src= "https://cdn.jsdelivr.net/gh/muaad/mpesa_button@master/images/mpesa.png">'
    btnMarkup = '<a href="" id="mpesaBtn" class="mpesaButton">' + img + '<span style="margin-left: 15px;">Pay with Mpesa</span></a>'
    phoneInstruction = '<strong><em>We will send an Mpesa payment request to this phone number</em></stron>'
    form = '<form>\
        <label for="amount" class="mpesaLabel">Amount</label><input class="mpesaInput" type="text" placeholder="2000" name="phone" id="mpesaAmount"></input><br>\
        <label for="phone" class="mpesaLabel">Phone Number</label><input class="mpesaInput" type="text" placeholder="254722123456" name="phone" id="mpesaPhoneNumber"></input><br>' + phoneInstruction + '<br><br><button href="" id="mpesaSend" class="mpesaButton" style="width: 100%;">' + img + '<span style="margin-left: 15px;">Pay</span></button></form>'
    formMarkup = '<div id="mpesaForm"><h3 class="mpesaHeader">Pay With Mpesa</h3>' + form + '</div>'
    button.innerHTML = btnMarkup

    success = '<div style="text-align: center;" class="animate-bottom">\
      <h2>√ Success</h2>\
      <p>An Mpesa payment request will be sent to your phone shortly</p>\
    </div>'

    button.addEventListener('click', function (e) {
        e.preventDefault();
        formDiv = document.createElement('div')
        button.parentNode.insertBefore(formDiv, button.nextSibling);
        formDiv.innerHTML = formMarkup
        amountInput = document.getElementById("mpesaAmount")
        phoneInput = document.getElementById("mpesaPhoneNumber")
        phone = button.getAttribute('data-phone')
        amount = button.getAttribute('data-amount')
        url = button.getAttribute('data-url')
        amountInput.value = total
        phoneInput.value = phone
        button.style.display = 'none';

        payButton = document.getElementById("mpesaSend")
        loaderDiv = document.createElement('div')
        loaderDiv.setAttribute("id", "loader");
        payButton.parentNode.insertBefore(loaderDiv, payButton.nextSibling);
        loader = document.getElementById("loader")
        loader.style.display = "none";
        loader.style.margin = '-75px 0 0 -110px';

        payButton.addEventListener('click', function (evt) {
            evt.preventDefault();
            payButton.disabled = true;
            document.getElementById('mpesaPhoneNumber').disabled = true;
            formDiv = document.getElementById('mpesaForm')
            if (url !== undefined) {
                var xhttp = new XMLHttpRequest();
                xhttp.open("POST", url, true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send('phone=' + phoneInput.value + '&amount=' + amountInput.value);
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        formDiv.innerHTML = success
                    }
                    else {
                        formDiv.innerHTML = 'Something went wrong. Contact website developer. Error: "We could not POST to the URL specified!"'
                    }
                };
            } else {
                setTimeout(function () {
                    formDiv.innerHTML = 'Something went wrong. Contact website developer. Error: "No URL specified!"'
                }, 3000); 
            }
            loader.style.display = "";
        })
    })
}

</script>

</body>
</html>
