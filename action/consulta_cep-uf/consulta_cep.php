<?php
$cep = "16021-305";
//Conexao com banco de dados
require_once('../../class_static/conexao.php');
	//Filtrando o valor do cep
	$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);

	//Convertendo o cep adicionando 0 16021305 - anted de tres numeros ficando: 16021-305
	$primeirosDigitos = substr($cep, 0, 5);
    $ultimosDigitos = substr($cep, -3);
    $cep = $primeirosDigitos."-".$ultimosDigitos;

    //$conexao = new Conexao();
	$query = "SELECT * FROM sp WHERE cep = :cep LIMIT 1";
    $params = array(
            //Tipagem do cep verificando se é uma string
            ':cep' => (String)$cep
        );
    $rows = DB::selectDB($query, $params, PDO::FETCH_OBJ);

  	//$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    //$stmt->bindParam(':cep', $cep, PDO::PARAM_STR);


    //Contando linha
    //$count = $rows->rowCount();
    
            
    //Contando a linha para tranformar em objeto e converter em json
    if($rows > 0){
        foreach ($rows as $row) {    
	        $row->tp_logradouro;        
	        $row->logradouro;        
	        $row->bairro;        
	        $row->cidade;  
			echo json_encode($row);
   		}
      //Se não encontrar a linha ele tranforma em objeto e manda mensagem de erros e converte em json    
    }else{ 
	    foreach ($rows as $row) {
	        $row->cep = 'CEP não encontrado';        
	        $row->tp_logradouro = '';        
	        $row->logradouro = 'Endereço não encontrado';        
	        $row->bairro = 'Bairro não encontrado';        
	        $row->cidade = 'Cidade não encontrada';        
			echo json_encode($row);
	    }      
    }
    
?>