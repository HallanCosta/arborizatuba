<?php
$cep = '16021-305';
require_once('../../class_static/conexao.php');
	//69903-695 ac
	//71900-500 df
	//16021-305 sp
	//16021-010 sp
	$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
	//Imprimi o cep só com os cincos primeiros digitos
	$primeirosDigitos = substr(str_replace("-", "", $cep), 0, 5);
	//limite menor de cep em são paulo
	$cep1 = 01000; 
	//limite maior de cep em são paulo
	$cep2 = 19999; 
	//verificando se o cep que o usuario digitou é maior que o cep1 e menor que o cep2 
	if(!empty($cep) && $primeirosDigitos >= $cep1 && $primeirosDigitos <= $cep2){
		$query = "SELECT nome FROM uf WHERE cep1 = '01000' AND cep2 = '19999'";
		$param = NULL;
	    $rows = DB::selectDB($query, $param, PDO::FETCH_OBJ);
	
		if ($rows > 0) {
			# code...
			foreach ($rows as $row) {
		    	$row->nome;           
		    	echo json_encode($row);
				
			}

		}else{
			foreach ($rows as $row) {
				
				$row->nome = "Estado não encontrado!";
				echo json_encode($row);
			}
		}
		

	}
?>