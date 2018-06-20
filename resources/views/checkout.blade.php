<!DOCTYPE html>
<html lang="en">
<head>
	<title>Checkout</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" type="text/css" href="/css/app.css">
	<script type="text/javascript" src="/js/app.js"></script>
	<script type="text/javascript" src="/js/jquery.mask.min.js"></script>
	<meta charset="UTF-8">
	<script type="text/javascript">
		$(document).ready(function () { 
			$('#cpf').mask('000.000.000-00', {reverse: true});
			$('#card_expiration_date').mask('00/0000', {reverse: true});

			var options =  {
				onKeyPress: function(card_number, e, field, options) {
					let mask;
					let masks = [
					'0000 0000 0000 0000', 
					'0000 000000 0000___', 
					'0000 000000 00000__'
					];

					if(card_number.length == 16){
						mask = masks[1];
					}else if(card_number.length == 17){
						mask = masks[2];
					}else{
						mask = masks[0];
					}

					console.log(card_number.length);
					console.log(mask);
					$('#card_number').mask(mask, options);
				}};

				$('#card_number').mask('0000 0000 0000 0000', options);

				$('#type').change(function() {
					let disabled;

					if($(this).val() === 'credit card'){
						disabled = false;
						$('#paymentCard').show();
					}else{
						disabled = true;
						$('#paymentCard').hide();
					}

					$('#paymentCard input').each(function(){
						$(this).attr('disabled', disabled);
					});
				});
			});
		</script>
</head>
<body>
	<div class="container">
		<form id='formulario' action="/save" method="POST" enctype="multipart/form-data">
			<h3>Dados Comprador</h3>
			<br />
			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" class="form-control" name='name' value="{{ old('name') }}" placeholder="Name" required>
			</div>
			<div class="form-group">
				<label for="email">E-mail</label>
				<input type="email" class="form-control" name='email' value="{{ old('email') }}" placeholder="E-mail" required>
			</div>
			<div class="form-group">
				<label for="cpf">CPF</label>
				<input type="text" class="form-control" id='cpf' name='cpf' value="{{ old('cpf') }}" placeholder="CPF" required>
			</div>
			<div class="form-group">
				<label for="amount">Amount</label>
				<input type="text" class="form-control" name='amount' value="150000" placeholder="amount" readonly="true" required>
			</div>
			<br />
			<h3>Forma de Pagamento</h3>
			<br />
			<div class="form-group">
				<label for="type">Type</label>
				<select class="form-control" id="type" name="type">
					<option value='' selected='true'></option>
					<option value='credit card'>Credit Card</option>
					<option value='boleto'>Boleto</option>
				</select>
			</div>

			<div id='paymentCard' style="display: none;">
				<br />
				<h2>Dados do Cartão de Credito</h2>
				<br />
				<div class="form-group">
					<label for="card_user">Card User</label>
					<input type="text" class="form-control" name='card_user' value="{{ old('card_user') }}" placeholder="Card User" disabled="true" required>
				</div>
				<div class="form-group">
					<label for="card_number">Card Number</label>
					<input type="text" class="form-control" id='card_number' name='card_number' value="{{ old('card_number') }}" placeholder="Card Number" disabled="true" required>
				</div>
				<div class="form-group">
					<label for="card_expiration_date">Card Expiration Date</label>
					<input type="text" class="form-control" id='card_expiration_date' name='card_expiration_date' value="{{ old('card_expiration_date') }}" placeholder="Card Expiration Date" disabled="true" required>
				</div>
				<div class="form-group">
					<label for="card_cvv">Card CVV</label>
					<input type="password" class="form-control" name='card_cvv' value="{{ old('card_cvv') }}" placeholder="Card CVV" disabled="true" required>
				</div>
			</div>
			@if (count($errors) > 0)
			<div class="alert alert-danger">
				@foreach ($errors->all() as $error)
				<p>{{ $error }}</p>
				@endforeach
			</div>
			@endif
			@if (!empty($fail))
			<div class="alert alert-danger">
				<p>{{ $fail }}</p>
			</div>
			@endif
			@if (!empty($success))
			<div class="alert alert-success">
				<p>{{ $success }}</p>
			</div>
			@endif
			<button type="submit" class="btn btn-primary">Submit</button>
			<input type="hidden" name="client_id" value="348298791817d5088a6de6">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
		</form>
	</div>	
</body>
</html>