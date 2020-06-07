<!DOCTYPE html>
<?php
	ini_set('display_errors', '1');
	include ("conectar.php");
	date_default_timezone_set('America/Sao_Paulo');
	$hoje = date('Y-m-d');
	$grupo = selecionarDia($hoje);
?>

<head>
	<meta charset="utf-8">
	<title>Finanças Pessoais</title>
	<link rel="stylesheet" type="text/css" href="index.css">
</head>

<header>
    
	<?php
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('Y-m-d');
		$diasemana = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');
		$diasemana_numero = date('w', strtotime($data));
    ?>
    <h1><b>[HOJE] <?=formatoData($data)?> - <?=$diasemana[$diasemana_numero]?></b></h1>

</header>

<body>
	<div class="navbar">
		<a href="index.php">Hoje</a>
		<a href="add.php">Adicionar Transação</a>
		<a href="add.php">Contas Bancárias</a>
		<!-- <a href="#cat">Categorias</a> -->

		<!-- <div class="dropdown">
			<button class="dropbtn">Meses 
			<i class="fa fa-caret-down"></i>
			</button>
			<div class="dropdown-content">
				<a href="#">Agosto/19</a>
			</div>
		</div>-->
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
					<th width="135">Categoria (o quê)</th>
					<th width="145">Onde / Quem</th>
					<th width="110">Pagamento</th>
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
			<br>
			<?php
				date_default_timezone_set('America/Sao_Paulo');
				$data = date('Y-m-d');
				$meses=array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
				$mes = (int)substr($data, 5, 2);
				$ano = (int)substr($data, 0, 4);

				if($mes < 10)	$am = $ano."-0".$mes;
				else			$am = $ano."-".$mes;

				// $visa = totalGastosMes($am,"visa");
				// $hipercard = totalGastosMes($am,"hipercard");
				$gastos = totalGastosMes($am,"dinheiro");
				$ganhos = totalGanhosMes($am);

				if ( empty($visa[0]["SUM(valor)"]) )
					$visa[0]["SUM(valor)"] = 0;
				if ( empty($hipercard[0]["SUM(valor)"]) )
					$hipercard[0]["SUM(valor)"] = 0;
				if ( empty($gastos[0]["SUM(valor)"]) )
					$gastos[0]["SUM(valor)"] = 0;

				$saldo = strval($ganhos[0]["SUM(valor)"]) + strval($gastos[0]["SUM(valor)"]);
				$gastosTotais = strval($visa[0]["SUM(valor)"]) + strval($gastos[0]["SUM(valor)"]) + strval($hipercard[0]["SUM(valor)"]);
		    ?>

			<table style="background-color: white; width: 45%;float: left;">
				<tr>
					<td style="text-align: center;" colspan="2"><b>Somatório dos Gastos de <?=$meses[$mes-1]?> de <?=$ano?></b></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr>
					<td style="text-align:left;font-family:'Times New Roman',Times,serif;padding-left:18px">VISA:</td>
					<td style="text-align:right;font-family:'Times New Roman',Times,serif;padding-right:25px"><?=number_format($visa[0]["SUM(valor)"], 2, ',', '');?></td>
				</tr>
				<tr>
					<td style="text-align:left;font-family:'Times New Roman',Times,serif;padding-left:18px">HIPERCARD:</td>
					<td style="text-align:right;font-family:'Times New Roman',Times,serif;padding-right:25px"><?=number_format($hipercard[0]["SUM(valor)"], 2, ',', '');?></td>
				</tr>
				<tr>
					<td style="text-align:left;font-family:'Times New Roman',Times,serif;padding-left:18px">Dinheiro:</td>
					<td style="text-align:right;font-family:'Times New Roman',Times,serif;padding-right:25px"><?=number_format($gastos[0]["SUM(valor)"], 2, ',', '');?></td>
				</tr>
				<tr>
					<td style="text-align:left;font-family:'Times New Roman',Times,serif;padding-left:18px"><b>Gastos Totais:</b></td>
					<td style="text-align:right;font-family:'Times New Roman',Times,serif;padding-right:25px"><b><?=number_format($gastosTotais, 2, ',', '');?></b></td>
				</tr>
			</table>

			<table style="background-color: white; width: 45%; float:right;">
				<tr>
					<td style="text-align: center;" colspan="2"><b>Receita de <?=$meses[$mes-1]?> de <?=$ano?></b></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr>
					<td style="text-align:left;font-family:'Times New Roman',Times,serif;padding-left:18px">Ganhos (dinheiro):</td>
					<td style="text-align:right;font-family:'Times New Roman',Times,serif;padding-right:25px"><?=number_format($ganhos[0]["SUM(valor)"], 2, ',', '');?></td>
				</tr>
				<tr>
					<td style="text-align:left;font-family:'Times New Roman',Times,serif;padding-left:18px">Gastos (dinheiro):</td>
					<td style="text-align:right;font-family:'Times New Roman',Times,serif;padding-right:25px"><?=number_format($gastos[0]["SUM(valor)"], 2, ',', '');?></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr>
					<td style="text-align:left;font-family:'Times New Roman',Times,serif;padding-left:18px"><b>Saldo:</b></td>
					<td style="text-align:right;font-family:'Times New Roman',Times,serif;padding-right:25px"><b><?=number_format($saldo, 2, ',', '');?></b></td>
				</tr>
			</table>
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