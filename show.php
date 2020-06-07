<!DOCTYPE html>
<?php
	//ini_set('display_errors', '1');
	include ("conectar.php");
	$data = $_POST['novodia'];
	$grupo = selecionarDia($data);
?>
<head>
	<meta charset="utf-8">
	<title>Finanças Pessoais</title>
	<link rel="stylesheet" type="text/css" href="index.css">
</head>

<header>
	<?php
		$data = $_POST['novodia'];
		$grupo = selecionarDia($data);
		$diasemana = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');
		$diasemana_numero = date('w', strtotime($data));
		?><h1><b><?=formatoData($data)?> - <?=$diasemana[$diasemana_numero]?></b></h1><?php
    ?>
</header>

<body>
	<div class="navbar">
		<a href="index.php">Hoje</a>
		<a href="#cat">Categorias</a>
		<div class="dropdown">
			<button class="dropbtn">Meses 
			<i class="fa fa-caret-down"></i>
			</button>
			<div class="dropdown-content">
				<a href="#">Agosto/19</a>
			</div>
		</div>
		<div class="box" style="float: right;">
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
			<form name="ver" action="show.php" method="POST" id="formNovoDia" >
				<input name="novodia" type="date" min="2019-07-17" value="" id="newday" />
			</form>
		</div>
	</div>
  
  	<?php
		if( empty($grupo) ) {
			?>
			<table class="responstable">
				<tr style="background: white; color: #024457;" >
					<td style="width: 100%; font-size: 18px; text-align: center;" colspan="4"><h4>Não há transação nesse dia.</h4></td>
				</tr><?php
		} else {
			?><table class="responstable">
				<tr>
					<th width="160">Categoria (o quê)</th>
					<th width="160">Onde / Quem</th>
					<th width="80">Pagamento</th>
					<th width="30">Valor (R$)</th>
					<!-- <th width="80">Data</th> -->
				</tr>
			<?php
			foreach ($grupo as $transacoes) { ?>
				<tr>
					<td><?=$transacoes["oque"]?></td>
					<td><?=$transacoes["onde"]?></td>
					<td><?=$transacoes["pgto"]?></td>
					<td><?=number_format($transacoes["valor"], 2, ',', '');?></td>
					<!--<td><?=formatoData($transacoes["data"])?></td>-->
					<!--<td>
						<form name="alterar-cliente" action="conectar.php" method="POST">
							<input type="hidden" name="transacao_id" value="<?=$transacoes["transacao_id"]?>" />
							<input type="image" width="20" src="imgs/i-editar.png">
						</form>
			  		</td>
					<td>
						<form name="excluir-cliente" action="conectar.php" method="POST">
							<input type="hidden" name="transacao_id" value="<?=$transacoes["transacao_id"]?>" />
							<input type="hidden" name="acao" value="excluir-cliente" />
							<input type="image" width="20" src="imgs/i-excluir.png">
						</form>
					</td>-->
				</tr>
		<?php 
			}
		} ?>
			</table>
    
	<?php
	function formatoData($data) {
		$array = explode("-", $data);
		$novaData = $array[2]."/".$array[1]."/".$array[0];
		return $novaData;
	}
	?>
	
</body>
</html>

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
