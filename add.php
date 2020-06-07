<!DOCTYPE html>

<head>
	<meta charset="utf-8">
	<title>Finanças Pessoais</title>
	<link rel="stylesheet" type="text/css" href="index.css">
</head>

<style type="text/css">
	textarea {
		width:99%;
	}
	.textwrapper {
		border:1px solid #999999;
		margin:5px 0;
		padding:3px;
	}
</style>

<header>
    <h1><b>Nova Transação</b></h1>
</header>

<body>
	<div class="box" style="background-color: white; display: block; padding: 15px;">
		<form name="dados" action="conectar.php" method="POST" style="margin-left: auto; margin-right: auto;">
			<input type="text" name="oque" placeholder="Categoria (o quê)" value="" required />
			<input type="text" name="onde" placeholder="Onde/Quem" value="" />
			<input type="text" name="valor" placeholder="Valor" value="" required />
			<input type="text" name="pgto" placeholder="Forma de Pagamento" value="" required />
			<input type="date" name="data" placeholder="Data" value="" required />
			<input type="submit" name="acao" value="Adicionar" />
		</form>
		<br>
		<form name="dados2" action="conectar.php" method="POST" style="margin-left: auto; margin-right: auto;">
			<div class="textwrapper">
				<textarea name="varios" cols="2" rows="10" id="rules" placeholder="Adicionar múltiplas transações;&#10;&#10;Exemplo:&#10;Mercado,Bompreço,-37.40,visa,2019-7-20;&#10;Cabeleleiro,Bom Corte,-30,dinheiro,2019-7-22;&#10;Padaria,Paneville,-5.64,hipercard,2019-7-23;&#10;"></textarea> 
			</div>
			<input type="submit" name="acao" value="Adicionar2" />
       </form>
       <br>
       <form action="index.php">
			<input type="submit" value="Cancelar" />
		</form>
	</div>
</body>
</html>

<?php
function formatoData($data) {
	$array = explode("-", $data);
	$novaData = $array[2]."/".$array[1]."/".$array[0];
	return $novaData;
}
?>

<script type="text/javascript">

	$('#newday').change(function(){
		console.log('Submiting form');                
		$('#formNovoDia').submit();
	});

	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
	if(dd<10){
		dd='0'+dd
	} 
	if(mm<10){
		mm='0'+mm
	} 

	today = yyyy+'-'+mm+'-'+dd;
	document.getElementById("newday").setAttribute("max", today);

</script>