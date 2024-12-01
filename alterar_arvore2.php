<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once('libary/libary.php');

try{

	if (isset($_SESSION['usuario']) && isset($_SESSION['id']) && $_SESSION['cargo'] == 0 && isset($_GET['id_arvore'])){

		$id_arvore = filter_input(INPUT_GET, 'id_arvore', FILTER_VALIDATE_INT);
		$msg = NULL;
		
		$query = "SELECT * FROM validadas WHERE id = :id";
		$param = array(
			':id'	=>	(Integer)$id_arvore
		);
		$rows = DB::selectDB($query, $param, PDO::FETCH_OBJ);	
		$row =& $rows;

	}else{
		header("Location: menu_principal.php");
	}

	if (isset($_POST['agendar'])) {

		//Fazendo a atualização da árvore
		$sql = "UPDATE `validadas`
		SET prox_poda = :proxima_poda
		WHERE 1 = 1 AND id = :id_arvore";
		$params = array(
			':id_arvore'	=> (Integer)$id_arvore,
			':proxima_poda' => date("Y-m-d", strtotime("+10 days"))
		);
		$affectedRow = DB::updateDB($sql, $params);
		
		if ($affectedRow > 0) {
			$sql = "UPDATE `conf_poda`
			SET estado = :estado
			WHERE 1 = 1 AND id_validadas = :id_arvore";
			$params = array(
				'id_arvore'	=>	(Integer)$id_arvore,
				'estado'	=>	1
			);

			$affectedRow = DB::updateDB($sql, $params);

			$mensagem = ("
			<script>
			window.alert('.:: A poda da árvore foi redefinida para dia ".date("d/m/Y", strtotime("+10 days"))." (Somente a data poda!) ::.')
			window.location.href = 'alterar_arvore.php?page=1'
			</script>
			");

		} else {
			$mensagem = 
			('<div class="alert alert-warning">
				<h4>Atenção</h4>
				A poda já foi redefinida para dia '.date("d/m/Y", strtotime("+10 days")).' .<br>
				(Caso queira aumentar a data da poda altere o campo *Proxima Poda para a data desejada e clique no botão <strong>Atualizar dados</strong> no fim do formulario)
			</div>');
		}

		

	}

	if(isset($_REQUEST['atualizar_dados']) && COUNT($row) > 0){
		if (strlen(filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING)) === 9 && strpos(filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING), '-')) {
			$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
			if (strlen(filter_input(INPUT_POST, 'tp_logradouro', FILTER_SANITIZE_STRING)) <= 8) {
				$tp_logradouro = filter_input(INPUT_POST, 'tp_logradouro', FILTER_SANITIZE_STRING);
				if (strlen(filter_input(INPUT_POST, 'logradouro', FILTER_SANITIZE_STRING)) <= 100) {
					$logradouro = filter_input(INPUT_POST, 'logradouro', FILTER_SANITIZE_STRING);
					if (strlen(filter_input(INPUT_POST, 'num', FILTER_SANITIZE_STRING)) <= 4) {
						$numero = filter_input(INPUT_POST, 'num', FILTER_SANITIZE_NUMBER_INT);
						if (strlen(filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING)) <= 6) {
							$complemento = filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING);
							if (strlen(filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING)) <= 30) {
								$bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
								if (strlen(filter_input(INPUT_POST, 'especie', FILTER_SANITIZE_STRING)) <= 35) {
									$especie = filter_input(INPUT_POST, 'especie', FILTER_SANITIZE_STRING);
									switch (filter_input(INPUT_POST, 'porte', FILTER_VALIDATE_INT)) {
										case 1:
										$porte = "Pequeno";
										break;
										case 2:
										$porte = "Medio";
										break;
										case 3:
										$porte = "Grande";
										break;
										default:
										$porte = NULL;
										break;
									}
									if (strlen(filter_input(INPUT_POST, 'quant', FILTER_SANITIZE_NUMBER_INT)) <= 11) {
										$quantidade = filter_input(INPUT_POST, 'quant', FILTER_SANITIZE_NUMBER_INT);
										if (strlen(filter_input(INPUT_POST, 'ultima_poda', FILTER_SANITIZE_STRING)) <= 10) {
											$ultima_poda = filter_input(INPUT_POST, 'ultima_poda', FILTER_SANITIZE_NUMBER_INT);
											if (strlen(filter_input(INPUT_POST, 'proxima_poda', FILTER_SANITIZE_STRING)) <= 10) {


														$hojeDB = date('Y-m-d');
														$hoje_mais_dez_dias = date("Y-m-d", strtotime("+10 days"));

														if (empty(filter_input(INPUT_POST, 'proxima_poda', FILTER_SANITIZE_STRING))) {
															$proxima_poda = date('Y-m-d');
															$proxima_poda = strtotime($proxima_poda);
															$proxima_poda = date("Y-m-d", $proxima_poda);
														} else {
															$proxima_poda = filter_input(INPUT_POST, 'proxima_poda', FILTER_SANITIZE_STRING);
															$proxima_poda = str_replace('/', '-', ($proxima_poda));
															$proxima_poda = date("Y-m-d", strtotime($proxima_poda));										
														}

														

														if ($proxima_poda == $hojeDB) {//if deixará acontecer a condição

															$msg = 1;

														} elseif ($proxima_poda >= $hoje_mais_dez_dias) {

															$msg = 1;

														} else {//Else ira dar o erro

															$msg = -10;//Data Inválida
														}

													} else {
															$msg = -10;//Proxima Poda invalido
														}
													} else {
														$msg = -9;//Ultima Poda invalido
													}
												} else {
													$msg = -8;//Quantidade invalido
												}
											} else {
												$msg = -7;//Especie invalido
											}							
										} else {
											$msg = -6;//Bairro invalido
										}
									} else {
										$msg = -5;//Número do Complemento invalido
									}
								} else {
									$msg = -4;//Número da Rua invalido
								}
							} else {
								$msg = -3;//Logradouro invalido
							}
						} else {
							$msg = -2;//Tipo de Logradouro invalido
						}
					} else {
						$msg = -1;	//CEP Invalido
					}
				}

				switch ($msg) {
					case 1:
					
					$sql = "SELECT * FROM `poda` WHERE id_validadas = :id_arvore";
					$params = array(
						':id_arvore'	=>	(Integer)$id_arvore
					);
					$rows = DB::selectDB($sql, $params, PDO::FETCH_OBJ);
					$count = count($rows);

					
					//Se a proxima poda não for igual a proxima poda
					if ($count < 1) {

						//Fazendo a atualização da árvore
						$sql = "UPDATE `validadas`
						SET cep = :cep,
						tp_logradouro = :tp_logradouro,
						logradouro = :logradouro,
						num = :numero,
						complemento = :complemento,
						bairro = :bairro,
						especie = :especie,
						porte = :porte,
						quant = :quantidade,
						ult_poda = :ultima_poda,
						prox_poda = :proxima_poda 
						WHERE 1 = 1 AND id = :id_arvore";
						$params = array(
							':id_arvore' => (Integer)$id_arvore,
							':cep' => (String)$cep,
							':tp_logradouro' => (String)$tp_logradouro,
							':logradouro' => (String)$logradouro,
							':bairro' => (String)$bairro,
							':numero' => (Integer)$numero,
							':complemento' => (String)$complemento,
							':especie' => (String)$especie,
							':porte' => (String)$porte,
							':quantidade' => (Integer)$quantidade,
							':ultima_poda' => (String)$ultima_poda,
							':proxima_poda' => (String)$proxima_poda
						);
						$affectedRow = DB::updateDB($sql, $params);

						if ($proxima_poda == $hojeDB) {
							//atualizando estado e a proxima poda da tabela conf_poda
							$sql3 = "UPDATE `conf_poda`
							SET estado = :estado,
							prox_poda = :prox_poda
							WHERE 1 = 1 AND id_validadas = :id_arvore";
							$params3 = array(
								':estado' => 0,
								':prox_poda' => (String)$proxima_poda,
								':id_arvore' => (Integer)$id_arvore
							);
							$affectedRow3 = DB::updateDB($sql3, $params3);
							
						} else {
							//atualizando estado e a proxima poda da tabela conf_poda
							$sql3 = "UPDATE `conf_poda`
							SET estado = :estado,
							prox_poda = :prox_poda
							WHERE 1 = 1 AND id_validadas = :id_arvore";
							$params3 = array(
								':estado' => 1,
								':prox_poda' => (String)$proxima_poda,
								':id_arvore' => (Integer)$id_arvore
							);
							$affectedRow3 = DB::updateDB($sql3, $params3);
						}


						//Se houver uma atualização apareça isso
						if ($affectedRow > 0) {
							$mensagem = ("
								<script>
								window.alert('Dados atualizados e poda redefinida com sucesso')
								window.location.href = 'alterar_arvore.php?page=1'
								</script>
								");
						}else{

							$mensagem = ('<div class="alert alert-warning">
								<h4>Atenção</h4>
								É necessario que alterar algum campo para fazer a atualização dos dados da Arvore.<br>
								(Caso queira voltar para a pagina de Tabela de Arvores clique no botão <strong>voltar</strong> no fim do formulario)
								</div>
								');

						}
						


					} else {//Senão existir uma poda

						//Fazendo a atualização da árvore
						$sql = "UPDATE `validadas`
						SET cep = :cep,
						tp_logradouro = :tp_logradouro,
						logradouro = :logradouro,
						num = :numero,
						complemento = :complemento,
						bairro = :bairro,
						especie = :especie,
						porte = :porte,
						quant = :quantidade,
						ult_poda = :ultima_poda,
						prox_poda = :proxima_poda 
						WHERE 1 = 1 AND id = :id_arvore";
						$params = array(
							':id_arvore' => (Integer)$id_arvore,
							':cep' => (String)$cep,
							':tp_logradouro' => (String)$tp_logradouro,
							':logradouro' => (String)$logradouro,
							':bairro' => (String)$bairro,
							':numero' => (Integer)$numero,
							':complemento' => (String)$complemento,
							':especie' => (String)$especie,
							':porte' => (String)$porte,
							':quantidade' => (Integer)$quantidade,
							':ultima_poda' => (String)$ultima_poda,
							':proxima_poda' => (String)$proxima_poda
						);
						$affectedRow = DB::updateDB($sql, $params);


						if ($proxima_poda == $hojeDB) {
							//atualizando estado e a proxima poda da tabela poda
							$sql2 = "UPDATE `poda`
							SET estado = :estado,
							prox_poda = :prox_poda
							WHERE 1 = 1 AND id_validadas = :id_arvore";
							$params2 = array(
								':estado' => 0,
								':prox_poda' => (String)$proxima_poda,
								':id_arvore' => (Integer)$id_arvore
							);
							$affectedRow2 = DB::updateDB($sql2, $params2);
							//atualizando estado e a proxima poda da tabela conf_poda
							$sql3 = "UPDATE `conf_poda`
							SET estado = :estado,
							prox_poda = :prox_poda
							WHERE 1 = 1 AND id_validadas = :id_arvore";
							$params3 = array(
								':estado' => 0,
								':prox_poda' => (String)$proxima_poda,
								':id_arvore' => (Integer)$id_arvore
							);
							$affectedRow3 = DB::updateDB($sql3, $params3);


						}else{

							$sql2 = "UPDATE `poda`
							SET estado = :estado,
							prox_poda = :prox_poda
							WHERE 1 = 1 AND id_validadas = :id_arvore";
							$params2 = array(
								':estado' => 1,
								':prox_poda' => (String)$proxima_poda,
								':id_arvore' => (Integer)$id_arvore
							);
							$affectedRow2 = DB::updateDB($sql2, $params2);
							//atualizando estado e a proxima poda da tabela conf_poda
							$sql3 = "UPDATE `conf_poda`
							SET estado = :estado,
							prox_poda = :prox_poda
							WHERE 1 = 1 AND id_validadas = :id_arvore";
							$params3 = array(
								':estado' => 1,
								':prox_poda' => (String)$proxima_poda,
								':id_arvore' => (Integer)$id_arvore
							);
							$affectedRow3 = DB::updateDB($sql3, $params3);

						}


						//Se a atualização da árvore for sucesso tiver campos diferentes
						if ($affectedRow > 0) {

							$mensagem = ("
								<script>
								window.alert('Dados atualizados e poda redefinida com sucesso')
								window.location.href = 'alterar_arvore.php?page=1'
								</script>
								");


						}else{

							$mensagem = ("
								<script>
								window.alert('!!! NENHUM DADO FOI MODIFICADO !!!')
								window.location.href = 'alterar_arvore2.php?id_arvore=".$id_arvore."'
								</script>
							");

							/*$mensagem = ('<div class="alert alert-warning">
								<h4>Atenção</h4>
								É necessario que alterar algum campo para fazer a atualização dos dados da Arvore.<br>
								(Caso queira voltar para a pagina de Tabela de Arvores clique no botão <strong>voltar</strong> no fim do formulario)
								</div>
								');*/

						}



					}
					break;
					case -1:
					$mensagem = ('<div class="alert alert-warning">
						<h4>Atenção</h4>
						CEP Invalido!
						</div>
						');
					break;
					case -2:
					$mensagem = ('<div class="alert alert-warning">
						<h4>Atenção</h4>
						Tipo de Logradouro Invalido, o Complemento deve conter no maximo 8 caracteres
						</div>
						');
					break;
					case -3:
					$mensagem = ('<div class="alert alert-warning">
						<h4>Atenção</h4>
						Logradouro Invalido, o Logradouro deve conter no maximo 100 caracteres
						</div>
						');
					break;
					case -4:
					$mensagem = ('<div class="alert alert-warning">
						<h4>Atenção</h4>
						Número da Rua Invalido, o Número da Rua deve conter no maximo 4 caracteres.
						</div>
						');
					break;
					case -5:
					$mensagem = ('<div class="alert alert-warning">
						<h4>Atenção</h4>
						Complemento Invalido, o Complemento deve conter no maximo 6 caracteres.
						</div>
						');
					break;
					case -6:
					$mensagem = ('<div class="alert alert-warning">
						<h4>Atenção</h4>
						Bairro Invalido, o Bairro deve conter no maximo 30 caracteres
						</div>
						');
					break;
					case -7:
					$mensagem = ('<div class="alert alert-warning">
						<h4>Atenção</h4>
						Especie Invalida, o Especie deve conter no maximo 35 caracteres
						</div>
						');
					break;
					case -8:
					$mensagem = ('<div class="alert alert-warning">
						<h4>Atenção</h4>
						Quantidade Invalida, o Complemento deve conter no maximo 7 caracteres
						</div>
						');
					break;
					case -9:
					$mensagem = ('<div class="alert alert-warning">
						<h4>Atenção</h4>
						Data Invalido! (Ultima Poda)
						</div>
						');
					break;
					case -10:
					$mensagem = ('<div class="alert alert-warning">
						<h4>Atenção</h4>
						Data Invalido! (Proxima Poda)
						</div>
						');
					break;
					default:
					$msg = NULL;
					break;
				}





				


				

			}catch(Exception $error){
				$mensagem = $error->getMessage();
				// header('Location: menu_principal.php');
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
				<title>AT - Atualizar árvore</title>
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
										<a class="dropdown-item" href="galeria_arvores_usuario.php">Galeria árvores</a>
										<a class="dropdown-item" href="cadastro_arvore.php">Cadastrar árvore</a>
										<a class="dropdown-item" href="#">Sobre</a>
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

						<div class="col-xl-12">

							<div class="row">

								<div class="col-xl-12 text-center">
									<label class="text-cad">Atualizar dados da árvore</label>
								</div>		

								<div class="col-xl-12 text-center">
									<label><?= $mensagem ?? NULL ?></label>
								</div>				

							</div>
							
							<br>

							<div class="row">

								<div class="col-xl-12">
									
									<?php foreach ($rows as $row): ?>
										
										<form method="POST">
											
											
											<div class="form-group">
												<label for=""><strong>*CEP:</strong> </label>
												<input type="text" required name="cep" id="cep" value="<?= $rows->cep ?>" class="form-control" maxlength="9">
											</div>
											<!-- <div class="form-group">
												<label for=""><strong>*CEP:</strong> </label>
												<input type="text" required name="cep" id="cep" value="<?= $row->cep ?>" class="form-control" maxlength="9">
											</div> -->
											<div class="form-group">
												<label for=""><strong>*Tipo de Logradouro:</strong> </label>
												<input type="text" required name="tp_logradouro" id="tp_logradouro" value="<?= $row->tp_logradouro ?>" class="form-control" maxlength="8">
											</div>
											<div class="form-group">
												<label for=""><strong>*Logradouro:</strong> </label>
												<input type="text" required name="logradouro" id="logradouro" value="<?= $row->logradouro ?>" class="form-control" maxlength="100">
											</div>
											<div class="form-group">
												<label for=""><strong>*Número da Rua:</strong> </label>
												<input type="text" required name="num" id="numero" value="<?= $row->num ?>" class="form-control" maxlength="4">
											</div>
											<div class="form-group">
												<label for=""><strong>*Complemento:</strong> </label>
												<input type="text" required name="complemento" value="<?= $row->complemento ?>" class="form-control" maxlenght="6">
											</div>
											<div class="form-group">
												<label for=""><strong>*Bairro:</strong> </label>
												<input type="text" required name="bairro" id="bairro" value="<?= $row->bairro ?>" class="form-control" maxlength="30">
											</div>
											<div class="form-group">
												<label for=""><strong>*Especie:</strong> </label>
												<input type="text" required name="especie" value="<?= $row->especie ?>" class="form-control" maxlength="35">
											</div>
											<div class="form-group">
												<label for=""><strong>*Porte:</strong> </label>
												<select name="porte" class="form-control">
													<optgroup label="Selecione o Porte da Arvore"></optgroup>
													<option value="1">Pequeno</option>
													<option value="2">Medio</option>
													<option value="3">Grande</option>
												</select>
											</div>
											<div class="form-group">
												<label for=""><strong>*Quantidade:</strong> </label>
												<input type="text" required name="quant" value="<?= $row->quant ?>" class="form-control" maxlength="11">
											</div>
											<div class="form-group">
												<label for=""><strong>*Ultima Poda:</strong> </label>
												<input type="date" name="ultima_poda" value="<?= $row->ult_poda ?>" class="form-control" maxlength="10">
											</div>
											<div class="form-group">
												<label for=""><strong>*Proxima Poda:</strong> <strong class="text-danger">se você não quiser uma poda coloque a data de hoje (<?= $hojeBR = date("d-m-Y") ?>).</strong> <strong class="text-success"> se você quiser uma poda coloque a data de hoje + 10 Ex: (<?= $hojeBR = date("d-m-Y", strtotime("+10 days")) ?>) ou clique em "Agendar" -></strong></label>
												&nbsp;<input type="submit" name="agendar" value="Agendar" class="btn btn-warning font-weight-bold">
												<input type="date" name="proxima_poda" value="<?= $row->prox_poda ?>" class="form-control">
											</div>
											<a href="alterar_arvore.php?page=1" class="btn btn-warning font-weight-bold">Voltar</a>
											<input type="submit" name="atualizar_dados" value="Atualizar Dados" class="btn btn-success">&nbsp;

										</form>

									<?php endforeach; ?>

									
									
								</div>

							</div>
						</div>

					</div>
					

					
				</main>

				<footer>
					<script src="js/jquery-3.3.1.slim.min.js"></script>
					<script src="js/jquery-3.4.1.slim.min.js"></script>
					<script src="script/script_alterar_arvore2.js"></script>
					<script src="js/popper.min.js"></script>
					<script src="js/bootstrap.min.js"></script>
				</footer>

			</body>
			</html>