<?php

	if (isset($_POST["acao"])) {
		if ($_POST["acao"]=="Adicionar") {
			adicionar_um();
		}
		else if ($_POST["acao"]=="Adicionar2") {
			adicionar_multiplos();
		}
		// else if ($_POST["acao"]=="pesquisar-cliente") {
		// 	pesquisar_clientes();
		// }
		// else if ($_POST["acao"]=="excluir-cliente") {
		// 	excluir_cliente();
		// }
		//else if ($_POST["acao"]=="Busca Avancada") {
		//	pesquisarClientesAvancado();
		//}
		//else voltarIndex();
	}

	function abrirBanco(){
		#$conexao = new mysqli("localhost","root","","financas");
		$conexao = mysqli_connect("localhost","root","","financas");
		if(false === mysqli_set_charset($conexao, "utf8")){
			echo "<script> alert('bug no charset');</script>";
    	}
		return $conexao;
	}

	function selecionarDia($dia){
		$banco = abrirBanco();
		$sql = "SELECT * FROM transacoes WHERE data LIKE '%$dia%'";
		$resultado = $banco->query($sql);
		$banco->close();
		while ($row = mysqli_fetch_array($resultado)) {
			$grupo[] = $row;
		}
		return $grupo;
	}

	function selecionarMes($mes,$ano){
		$banco = abrirBanco();
		$sql = "SELECT * FROM transacoes WHERE data LIKE '%$ano-$mes-%'";
		$resultado = $banco->query($sql);
		$banco->close();
		while ($row = mysqli_fetch_array($resultado)) {
			$grupo[] = $row;
		}
		return $grupo;
	}

	function totalGastosMes($am, $tipo){
		$banco = abrirBanco();
		//$sql = "SELECT SUM(valor) FROM transacoes WHERE data LIKE '%$am%' AND pgto='$tipo'";
		//if ( strcasecmp($tipo,"dinheiro"))
		if ( $tipo=="dinheiro" || $tipo=="DINHEIRO" )
			$sql = "SELECT SUM(valor) FROM transacoes WHERE data LIKE '%$am%' AND pgto='$tipo' AND valor < 0";
		else
			$sql = "SELECT SUM(valor) FROM transacoes WHERE data LIKE '%$am%' AND pgto='$tipo'";
		$resultado = $banco->query($sql);
		$banco->close();
		while ($row = mysqli_fetch_array($resultado)) {
			$grupo[] = $row;
		}
		return $grupo;
	}

	function totalGanhosMes($am){
		$banco = abrirBanco();
		$sql = "SELECT SUM(valor) FROM transacoes WHERE data LIKE '%$am%' AND pgto='dinheiro' AND valor > 0";
		$resultado = $banco->query($sql);
		$banco->close();
		while ($row = mysqli_fetch_array($resultado)) {
			$grupo[] = $row;
		}
		return $grupo;
	}

	function adicionar_um(){
	 	$banco = abrirBanco();
	 	$sql = "INSERT INTO transacoes (oque, onde, valor, pgto, data) values ('{$_POST["oque"]}','{$_POST["onde"]}','{$_POST["valor"]}','{$_POST["pgto"]}','{$_POST["data"]}')";
	 	$banco->query($sql);
	 	$banco->close();
	 	voltar();
	}

	function adicionar_multiplos(){
		
		$linhas = explode(";",$_POST["varios"]);
		$banco = abrirBanco();
		for ($i=0; $i < count($linhas); $i++) { 
			$c = explode(",",$linhas[$i]);

			$oque = $c[0];
			$onde = $c[1];
			$valor = $c[2];
			$pgto = $c[3];
			$data = $c[4];

			var_dump($oque);
			var_dump($onde);
			var_dump($valor);
			var_dump($pgto);
			var_dump($data);

			$sql = "INSERT INTO transacoes (oque, onde, valor, pgto, data) values ('"
				.$oque ."','".$onde."','".$valor."','".$pgto."','".$data."')" ;
			$banco->query($sql);
		}
		//print_r($linhas);
		//print_r(count($linhas));
	 	$banco->close();
	 	voltar();
	}

	function voltar(){
		header("location: index.php");
	}

	//SELECT SUM(valor) FROM transacoes WHERE data LIKE "%2019-08-%" AND pgto='visa';
	//SELECT SUM(valor) FROM transacoes WHERE data LIKE "%2019-08-%" AND pgto='dinheiro' AND valor < 0;
	//SELECT SUM(valor) FROM transacoes WHERE data LIKE "%2019-08-%" AND pgto='hipercard';
	//SELECT SUM(valor) FROM transacoes WHERE data LIKE "%2019-08-%" AND pgto='dinheiro' AND valor > 0;
?>
