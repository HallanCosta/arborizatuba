<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once('libary/libary.php');

try{
	$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?? 1;
	$perPage = filter_input(INPUT_GET, 'per-page', FILTER_VALIDATE_INT) && filter_input(INPUT_GET, 'per-page', FILTER_VALIDATE_INT) <= 50 ? filter_input(INPUT_GET, 'per-page', FILTER_VALIDATE_INT) : 10;

	if (isset($_SESSION['usuario']) && isset($_SESSION['id']) && isset($_SESSION['cargo'])){

			//echo isset($_GET['podar']) ? $_GET['podar'] = "Árvore podada" : NULL;

		$start = (($page > 1) ? ($page * $perPage) - $perPage : 0);

		$query = "SELECT * FROM validadas INNER JOIN conf_poda ON conf_poda.estado = :estado AND conf_poda.id_validadas = validadas.id ORDER BY STR_TO_DATE(validadas.prox_poda, '%Y-%m-%d') ASC";
		$param = array(
			':estado' => '1'
		);

		$rows = DB::selectDB($query, $param, PDO::FETCH_OBJ);
		$pages = ceil(COUNT($rows)/$perPage);

		if (COUNT($rows) > 0) {
			$query = "SELECT * FROM `validadas` INNER JOIN conf_poda ON 1 = 1 AND conf_poda.estado = 1 AND conf_poda.id_validadas = validadas.id AND validadas.id_usuario = {$_SESSION['id']} ORDER BY STR_TO_DATE(validadas.prox_poda, '%Y-%m-%d') ASC LIMIT {$start}, {$perPage}";
			$param = NULL;
			$rows = DB::selectDB($query, $param, \PDO::FETCH_OBJ);
		}

			//0 - Poda NÃO agendada
			//1 - Poda agendada
			//2 - Árvore podada
		if (isset($_GET['id_arvore']) && !empty($_GET['id_arvore'])) {

				/*
				echo "ID da árvore: ".$_GET['id_arvore']."<br>";
				echo "Dia de hoje: ".$hoje = date("Y-m-d")."<br>";
				//echo "Dia de hoje: ".$hoje = "2025-09-12"."<br>";
				echo "Proxima poda: ".$prox_poda = $_GET['prox_poda']."<br>";
				echo "Proxima poda menos dois dias: ".$br_prox_poda_menos_tres_dias = date('Y-m-d', strtotime('-2 days', strtotime($_GET['prox_poda'])))."<br>";
				echo " Formato brasil: ".$br_menos_dois_dias = date('d/m/Y', strtotime('-2 days', strtotime($_GET['prox_poda'])))."<br>";
				*/

				$hoje = date("Y-m-d");
				//$prox_poda = "2019-09-19";
				$prox_poda = $_GET['prox_poda'];
				$prox_poda_BR = date("d/m/Y", strtotime($_GET['prox_poda']));
				$prox_poda_menos_tres_dias = date('Y-m-d', strtotime('-4 days', strtotime($_GET['prox_poda'])));
				$br_prox_poda_menos_tres_dias = date('d/m/Y', strtotime('-4 days', strtotime($_GET['prox_poda'])));
				//$br_prox_poda_menos_dois_dias = date('d/m/Y', strtotime('-3 days', strtotime($_GET['prox_poda'])));
				

				if ($hoje < $prox_poda_menos_tres_dias) {//se a data de hoje for menor que a proxima poda menos dois dias, ou seja, for (tres dias) imprime um error
					
					$mensagem = "<label class='mensagemImprimir' style='color: red;'>A árvore só pode ser podada dia ".$br_prox_poda_menos_tres_dias." a ".$prox_poda_BR."</label>";

				}elseif ($hoje > $prox_poda) {//atualiza o estado da prox_poda da tabela conf_poda se a poda ja venceu a validade
					

					$query = "SELECT * FROM `poda` WHERE id_validadas = :id_arvore";
					$param = array(
						':id_arvore'	=>	$_GET['id_arvore']
					);
					$rows = DB::selectDB($query, $param, PDO::FETCH_OBJ);
					$count = count($rows);

					if ($count > 0) {
						//atualiza o estado da tabela poda e da tabela poda para 0 - poda não agendada
						$query2 = "UPDATE `poda` SET estado = :estado WHERE id_validadas = :id_arvore";
						$params2 = array(
							':estado'	=>	0,
							':id_arvore'	=>	$_GET['id_arvore']
						);
						$AffectedRow3 = DB::updateDB($query2, $params2);
						

						//atualiza o estado da tabela poda e da tabela conf_poda para 0 - poda não agendada
						$query3 = "UPDATE `conf_poda` SET estado = :estado WHERE id_validadas = :id_arvore";
						$params3 = array(
							':estado'	=>	0,
							':id_arvore'	=>	$_GET['id_arvore']
						);
						$AffectedRow3 = DB::updateDB($query3, $params3);

						header("Location: podas.php?mensagem=<label class='mensagemImprimir' style='color: red;'>O tempo de poda expirou. Poda redefinida como: Poda não agendada. (CONTATE O DONO)</label>");


					}else{


						//atualiza o estado da tabela conf_poda para 0 - poda não agendada
						$query2 = "UPDATE `conf_poda` SET estado = :estado WHERE id_validadas = :id_arvore";
						$params2 = array(
							':estado'	=>	0,
							':id_arvore'	=>	$_GET['id_arvore']
						);
						$AffectedRow2 = DB::updateDB($query2, $params2);
						
						header("Location: podas.php?mensagem=<label class='mensagemImprimir' style='color: red;'>O tempo de poda expirou. Poda redefinida como: Poda não agendada.</label>");

					}

				}else{

					$query2 = "SELECT * FROM `poda` WHERE id_validadas = :id_arvore";
					$param2 = array(
						':id_arvore'	=>	$_GET['id_arvore']

					);
					$rows2 = DB::selectDB($query2, $param2, PDO::FETCH_OBJ);
					$count2 = count($rows2);


					if ($count2 > 0) {

						
						//ATUALIZANDO DADOS NA TABELA CONF_PODA
						$query2 = "UPDATE conf_poda SET estado = :estado WHERE id_validadas = :id_validadas";
						$params2 = array(
							':estado' 				=> '2',
							':id_validadas'		 	=> $_GET['id_arvore']
						);
						$AffectedRow2 = DB::updateDB($query2, $params2);



						//Atualiza o atributo ult_poda. porque a prox_poda virou ult_poda depois de podada
						$query3 = "UPDATE validadas SET ult_poda = :ult_poda WHERE id = :id";
						$params3 = array(
							':ult_poda'		=> $_GET['prox_poda'],
							':id'			=> $_GET['id_arvore']
						);
						$AffectedRow3 = DB::updateDB($query3, $params3);


						//ATUALIZANDO DADOS NA TABELA PODA
						$query4 = "UPDATE poda SET estado = :estado WHERE id_validadas = :id_validadas";
						$params4 = array(
							':estado' 				=> '2',
							':id_validadas'		 	=> $_GET['id_arvore']
						);
						$AffectedRow4 = DB::updateDB($query4, $params4);

						header("Location: podas.php?mensagem=<label class='mensagemImprimir' style='color: green;'>Árvore podada com sucesso!</label>");
						
					}else{

						//INSERINDO DADOS NA TABELA PODA
						$_GET['prox_poda'] = date("Y-m-d", strtotime($_GET['prox_poda']));
						$query = "INSERT INTO poda VALUES(NULL, :resp, :prox_poda, :estado, :id_validadas, :id_funcionario)";
						$params = array(
							':resp' 				=> $_SESSION['nome'],
							':prox_poda' 			=> $_GET['prox_poda'],
							':estado' 				=> '2',
							':id_validadas'		 	=> $_GET['id_arvore'],
							':id_funcionario'		=> $_SESSION['id']
						);
						$lastInsertId = DB::insertDB($query, $params);

						//ATUALIZANDO DADOS NA TABELA CONF_PODA
						$query2 = "UPDATE conf_poda SET estado = :estado WHERE id_validadas = :id_validadas";
						$params2 = array(
							':estado' 				=> '2',
							':id_validadas'		 	=> $_GET['id_arvore']
						);
						$AffectedRow2 = DB::updateDB($query2, $params2);



						//Atualiza o atributo ult_poda. porque a prox_poda virou ult_poda depois de podada
						$query3 = "UPDATE validadas SET ult_poda = :ult_poda WHERE id = :id";
						$params3 = array(
							':ult_poda'		=> $_GET['prox_poda'],
							':id'			=> $_GET['id_arvore']
						);
						$AffectedRow3 = DB::updateDB($query3, $params3);


						//ATUALIZANDO DADOS NA TABELA PODA
						$query4 = "UPDATE poda SET estado = :estado WHERE id_validadas = :id_validadas";
						$params4 = array(
							':estado' 				=> '2',
							':id_validadas'		 	=> $_GET['id_arvore']
						);
						$AffectedRow4 = DB::updateDB($query4, $params4);

						//$mensagem = "<label class='mensagemImprimir' style='color: green;'>Árvore podada com sucesso!</label>";
						header("Location: podas.php?mensagem=<label class='mensagemImprimir' style='color: green;'>Árvore podada com sucesso!</label>");


					}





				}



				
				//echo $_GET['id_arvore'];

				
			}




		}else{
			header("Location: menu_principal.php");
		}

	}
	catch(Exception $error){
		$mensagem = $error->getMessage();
		//header('Location: index.php');
	}



	?>
	<!DOCTYPE html>
	<html lang="pt-br">
	<head>
		<!-- Meta tags Obrigat&oacute;rias -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
		<title>AT - Podas</title>
	</head>
	<body>
		<main class="container-fluid">
			
			<div class="row bg-success">

				<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 mt-xl-1 mt-lg-1 mt-md-1 mt-sm-1 mt-0">
					
					<!-- Cabeça (Topo) do Site -->
					<ul class="navbar-nav ml-xl-auto ml-lg-auto ml-md-auto ml-sm-auto ml-auto">

						<li class="nav-item dropdown">
							
							<a class="nav-link" href="#" data-toggle="dropdown" id="navDrop">
								<img src="data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(0, 0, 0, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E" class="img-menu">
							</a>

							<div class="dropdown-menu">
								<a class="dropdown-item" href="menu_principal.php">Menu principal</a>
								<a class="dropdown-item" href="sobre.php">Sobre</a>
							</div>

						</li>

					</ul>

				</div>

				<div class="text middle col-xl-7 col-lg-7 col-md-7 col-sm-8 col-8 text-center mt-xl-2 mt-lg-1 mt-md-1 mt-sm-2 mt-3">
					<span>A</span>
					<span class="hidden">R</span>
					<span class="hidden">B</span>
					<span class="hidden">O</span>
					<span class="hidden">R</span>
					<span class="hidden">I</span>
					<span class="hidden">Z</span>
					<span class="hidden">A</span>
					<span>T</span>
					<span class="hidden">U</span>
					<span class="hidden">B</span>
					<span class="hidden">A</span>
				</div>


				<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-3 offset-xl-1 offset-lg-1 offset-md-1">
					
					<a href="logout.php" class="btn btn-danger float-right tamanho_btn_sair">Sair</a>
					
				</div>

			</div>


			<!-- Formulario -->
			<div class="row container-fluid">

				<div class="col-xl-12 text-center">

					<div class="row">

						<div class="col-xl-12">
							<label class="text-cad">Árvores para serem podadas</label>
						</div>						
						<div class="col-xl-12">
							<label> <?= $mensagem ?? NULL  ?></label>
							<label> <?= $_GET['mensagem'] ?? NULL  ?></label>
						</div>

					</div>

					<div class="row">

						<!-- <div class="col-xl-12">
							<input type="text" placeholder="Pesquise" class="form-control">
						</div> -->

					</div>
					
					<br>

					<div class="mt-3 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

						<div class="d-print-table table-responsive table-responsive-sm table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl">

							<table class="table table-hover table-bordered">

								<thead class="thead thead-dark">
									<tr>
										<th>ID</th>
										<th>CEP</th>
										<th>Tipo de Logradouro</th>
										<th>Logradouro</th>
										<th>Número</th>
										<th>Complemento</th>
										<th>Bairro</th>
										<th>Espécie</th>
										<th>Porte</th>
										<th>Quantidade</th>
										<th>Proxima poda</th>
										<th class="hidden-print" scope="col">Foto</th>
										<th></th>
									</tr>
								</thead>

								<tbody>
									<?php foreach ($rows as $row): ?>
										<tr>
											<th><?= $row->id ?></th>
											<td><?= $row->cep ?></td>
											<td><?= $row->tp_logradouro ?></td>
											<td><?= $row->logradouro ?></td>
											<td><?= $row->num ?></td>
											<td><?= $row->complemento ?></td>
											<td><?= $row->bairro ?></td>
											<td><?= $row->especie ?></td>
											<td><?= $row->porte ?></td>
											<td><?= $row->quant ?></td>
											<td>
												<?php
												$prox_poda = $row->prox_poda;
												echo $prox_poda = date("d/m/Y", strtotime($prox_poda));
												?>	
											</td>
											<td><a href="<?= $row->urlFoto; ?>" target="_blank">Link</a></td>
											<td>

												<a href="podas.php?id_arvore=<?= $row->id ?>&prox_poda=<?= $row->prox_poda ?>" class="btn btn-success">Podar</a>

											</td>

										</tr>

									<?php endforeach; ?>

								</tbody>
								
							</table>

						</div>

					</div>

					<div class="row">
						
						<div class="col-xl-12 col-xl-12 d-flex justify-content-center">

							<?php require_once 'relatorio/Template/Footer/Paginacao/paginacao.php' ?>

						</div>

					</div>

				</div>

			</div>



		</main>

		<script src="js/jquery-3.3.1.slim.min.js"></script>
		<script src="js/jquery-3.4.1.slim.min.js"></script>
		<script src="js/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/script.js"></script>

	</body>
	</html>