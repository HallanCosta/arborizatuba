<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once('libary/libary.php');
require_once('class_static/crypt.php');
try{

		if (isset($_SESSION['usuario']) && isset($_SESSION['id'])){//&& $_SESSION['cargo'] == 2 || $_SESSION['cargo'] == 3


		if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['usuario']) && isset($_POST['senha']) && isset($_POST['confSenha']) && isset($_POST['datadenasc']) && isset($_POST['cpf']) && isset($_POST['rg']) && isset($_POST['telefone']) && isset($_POST['cep']) && isset($_POST['tp_logradouro']) && isset($_POST['logradouro']) && isset($_POST['num']) && isset($_POST['complemento']) && isset($_POST['bairro']) && isset($_POST['cidade']) && isset($_POST['uf']) && isset($_POST['cargo'])) {

			if (empty($_POST['nome'])) {
					//resto da verificação se esta vazio todos os campos
					//&& empty($_POST['email']) && empty($_POST['usuario']) && empty($_POST['senha']) && empty($_POST['confSenha']) && empty($_POST['datadenasc']) && empty($_POST['cpf']) && empty($_POST['rg']) && empty($_POST['telefone']) && empty($_POST['cep']) && empty($_POST['tp_logradouro']) && empty($_POST['logradouro']) && empty($_POST['num']) && empty($_POST['complemento']) && empty($_POST['bairro']) && empty($_POST['cidade']) && empty($_POST['uf']) && empty($_POST['cargo'])
				$mensagem = "<label class='mensagemImprimir' style='color: red;'>Preencha todos os campos!</label>";
			}else{

				$nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRING);
				$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
				$usuario = filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_STRING);
				$senha =  filter_input(INPUT_POST, "senha", FILTER_SANITIZE_STRING);
				$confSenha = filter_input(INPUT_POST, "confSenha", FILTER_SANITIZE_STRING);

				$datadenasc = $_POST['datadenasc'];
				$datadenasc = str_replace('/', '-', ($datadenasc));
					//$datadenasc = date("Y-m-d", strtotime($datadenasc));

				$pattern_cpf = "/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}-[0-9]{2}$/";
				$cpf = filter_input(INPUT_POST, "cpf", FILTER_SANITIZE_STRING);
					//$cpf = str_replace('.', '', ($cpf));
					//$cpf = str_replace('-', '', ($cpf));

				$pattern_rg = "/^[0-9]{2}\.[0-9]{3}\.[0-9]{3}-[a-zA-Z0-9]{1}$/";
				$rg = filter_input(INPUT_POST, "rg", FILTER_SANITIZE_STRING);
					//$rg = str_replace('.', '', ($rg));
					//$rg = str_replace('-', '', ($rg));

				$telefone = filter_input(INPUT_POST, "telefone", FILTER_SANITIZE_STRING);
				$telefone = str_replace('(', '', ($telefone));
				$telefone = str_replace(')', '', ($telefone));
				$telefone = str_replace('-', '', ($telefone));

				$cep = filter_input(INPUT_POST, "cep", FILTER_SANITIZE_STRING);
						//$primeirosDigitos = substr($cep, 0, 5); //OBTENÇÃO DOS 5 PRIMEIROS DIGITOS DO CEP
						//$ultimosDigitos = substr($cep, -3);//OBTENÇÃO DOS 3 ultimos DIGITOS DO CEP
				    //$cep = $primeirosDigitos."-".$ultimosDigitos;//ADICIONANDO - NO CEP POR EX: 16021305 / 16021-305

				$tp_logradouro = filter_input(INPUT_POST, "tp_logradouro", FILTER_SANITIZE_STRING);
				$logradouro = filter_input(INPUT_POST, "logradouro", FILTER_SANITIZE_STRING);
					//numero
				$num = filter_input(INPUT_POST, "num", FILTER_VALIDATE_INT);
					//apartamento
				$complemento = filter_input(INPUT_POST, "complemento", FILTER_SANITIZE_STRING);
					empty($complemento) ? $complemento = '0' : $complemento; // se complemento estiver vazio e 0
					$bairro = filter_input(INPUT_POST, "bairro", FILTER_SANITIZE_STRING);
					$cidade = filter_input(INPUT_POST, "cidade", FILTER_SANITIZE_STRING);
					$uf = filter_input(INPUT_POST, "uf", FILTER_SANITIZE_STRING);
					$cargo = filter_input(INPUT_POST, "cargo", FILTER_SANITIZE_STRING);//1-Funcionario, 2-Gerente, 3-Administrador

					if (is_numeric($nome)) {
						$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite somente letras no campo NOME de no máximo 100 e no minimo 4 caracteres!</label>";

					}else{

						if (strlen($nome) < 4 || strlen($nome) > 100) {
							$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite somente letras no campo NOME de no máximo 100 e no minimo 4 caracteres!</label>";

						}else{

							if (!is_string($email)) {	
								$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite um EMAIL valido!</label>";

							}else{

								if (strlen($usuario) < 4 || strlen($usuario) > 30) {
									$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite um USUARIO de no máximo 30 e no minimo 4 caracteres!</label>";

								}else{

									if (strlen($senha) < 5 || strlen($senha) > 30) {
										$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite um SENHA de no máximo 30 e no minimo 4 caracteres!</label>";

									}else{

										if ($senha !== $confSenha) {
											$mensagem = "<label class='mensagemImprimir' style='color: red;'>Confirmação da senha inválida!</label>";

										}else{

											if (strlen($datadenasc) > 10) {
												$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite um ano valido no campo DATA DE NASCIMENTO!</label>";
											}else{

												if (!preg_match($pattern_cpf, $cpf)) {
													$mensagem = "<la bel class='mensagemImprimir' style='color: red;'>Digite um Cpf Válido no campo CPF!</label>";
												}else{

													if (strlen($cpf) < 14 || strlen($cpf) > 14) {
														$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite um CPF VÁLIDO no campo CPF!</label>";
													}else{

														if (!is_string($telefone)) {
															$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite somente numeros no campo TELEFONE!</label>";
														}else{

															if (strlen($telefone) > 13) {
																$mensagem = "<label class='mensagemImprimir' style='color: red;'>Não esqueça de digitar o DD de sua cidade (00) 0000-0000 no campo TELEFONE!</label>";
															}else{
																if (!strlen($cep) == 9) {
																	$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite um cep valido no campo CEP!</label>";
																}else{

																	if (!strlen($cep) == 9) {
																		$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite um cep valido no campo CEP!</label>";
																	}else{

																		if (!preg_match($pattern_rg, $rg)) {
																			$mensagem = "<la bel class='mensagemImprimir' style='color: red;'>Digite um Rg Válido no campo RG!</label>";
																		}else{

																			if (strlen($rg) < 12 || strlen($rg) > 12) {
																				$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite um Rg Válido no campo RG!</label>";
																			}else{

																				if (is_numeric($tp_logradouro)) {
																					$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite somente letras no campo TIPO DE LOGRADOURO!</label>";
																				}else{

																					if (strlen($tp_logradouro) < 3 || strval($tp_logradouro) > 9) {
																						$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite no campo TIPO DE LOGRADOURO no máximo 8 e no minimo 3 caracteres!</label>";
																					}else{

																						if (is_numeric($logradouro)) {
																							$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite somente letras no campo LOGRADOURO!</label>";
																						}else{

																							if (strlen($logradouro) < 4 || strlen($logradouro) > 100) {
																								$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite no campo LOGRADOURO no máximo 100 e no minimo 4 caracteres!</label>";
																							}else{

																								if (!isset($num)) {
																									$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite somente números de até 4 digitos sem , ou . no campo NÚMERO</label>";
																								}else{

																									if (strlen($num) < 1 || strlen($num) > 4) {echo $num;
																										$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite somente números de até 4 digitos sem , ou . no campo NÚMERO</label>";
																									}else{

																										if (strlen($complemento) < 1 || strlen($complemento) > 6) {
																											$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite no mínimo 1 e no máximo 6 caracteres no campo COMPLEMENTO</label>";
																										}else{

																											if (is_numeric($bairro)) {
																												$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite somente letras no campo BAIRRO!</label>";
																											}else{

																												if (strlen($bairro) < 5 || strlen($bairro) > 30) {
																													$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite no máximo 30 e no minimo 5 caracteres no campo BAIRRO!</label>";
																												}else{

																													if (is_numeric($cidade)) {
																														$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite somente letras no campo CIDADE!</label>";
																													}else{

																														if (strlen($cidade) < 5 || strlen($cidade) > 30) {
																															$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite no máximo 30 e no minimo 5 caracteres no campo CIDADE!</label>";
																														}else{

																															if ($_SESSION['cargo'] == 2) {

																																if ($cargo == 1) {
																																	



																																	//VERIFICAÇÃO DA TABELA USUARIO 
																																	$query = "SELECT usuario, email FROM usuario WHERE usuario = :usuario OR email = :email";
																																	$params = array(

																																		':usuario'		=>		(String)$usuario,
																																		':email'		=>		(String)$email

																																	);
																																	
																																	$rows = DB::selectDB($query, $params, PDO::FETCH_OBJ);
																																	$count = count($rows);


																																	if ($count > 0) {

																																		$mensagem = "<label class='mensagemImprimir' style='color: red;'>Email ou Usuario ja foram cadastrado!</label>";

																																	}else{
																																		//VERIFICAÇÃO DA TABELA FUNCIONARIO 
																																		$query = "SELECT usuario, email, cpf FROM funcionario WHERE usuario = :usuario OR email = :email OR cpf = :cpf";
																																		$params = array(

																																			':usuario'		=>		(String)$usuario,
																																			':email'		=>		(String)$email,
																																			':cpf'			=>		(String)$cpf


																																		);
																																		$rows = DB::selectDB($query, $params, PDO::FETCH_OBJ);
																																		$count2 = count($rows);
																																		if ($count2 > 0) {

																																			$mensagem = "<label class='mensagemImprimir' style='color: red;'>Email, Usuario ou Cpf ja foram cadastrado!</label>";

																																		}else{
																																			$datadenasc = DateTime::createFromFormat('d-m-Y', $datadenasc)->format('Y-m-d');
																																			$codificacao = md5($senha);

																																			$query = "INSERT INTO funcionario(id, nome, email, usuario, senha, datadenasc, cpf, rg, telefone, cep, tp_logradouro, logradouro, num, complemento, bairro, cidade, uf, cargo) VALUES (NULL, :nome, :email, :usuario, :senha, :datadenasc, :cpf, :rg, :telefone, :cep, :tp_logradouro, :logradouro, :num, :complemento, :bairro, :cidade, :uf, :cargo)";
																																			$params = array(
																																				
																																				':nome'				=>		(String)$nome,
																																				':email'			=>		(String)$email,
																																				':usuario'			=>		(String)$usuario,
																																				':senha'			=>		(String)$codificacao,
																																				':datadenasc'		=>		$datadenasc,
																																				':cpf'				=>		(String)$cpf,
																																				':rg'				=>		(String)$rg,
																																				':telefone'			=>		(String)$telefone,
																																				':cep'				=>		(String)$cep,
																																				':tp_logradouro'	=>		(String)$tp_logradouro,
																																				':logradouro'		=>		(String)$logradouro,
																																				':num'				=>		(Integer)$num,
																																				':complemento'		=>		(String)$complemento,
																																				':bairro'			=>		(String)$bairro,
																																				':cidade'			=>		(String)$cidade,
																																				':uf'				=>		(String)$uf,
																																				':cargo'			=>		(String)$cargo
																																				
																																			);
																																			$rows = DB::insertDB($query, $params);
																																			$mensagem = "<label class='mensagemImprimir' style='color: green;'>Cadastrado com Sucesso</label>";
																																		}

																																	}

																																}else{//Verifica se o cargo selecionado é 1 - Funcionario
																																	
																																	$mensagem = "<label class='mensagemImprimir' style='color: red;'>Não é possivel cadastrar um Gerente ou Administrador nessa conta. (CONTATAR: Administrador)!</label>";
																																}

																															}elseif ($_SESSION['cargo'] == 3) {
																																
																																if ($cargo == 1 || $cargo == 2 || $cargo == 3) {
																																	
																																	//VERIFICAÇÃO DA TABELA USUARIO 
																																	$query = "SELECT usuario, email FROM usuario WHERE usuario = :usuario OR email = :email";
																																	$params = array(

																																		':usuario'		=>		(String)$usuario,
																																		':email'		=>		(String)$email

																																	);
																																	
																																	$rows = DB::selectDB($query, $params, PDO::FETCH_OBJ);
																																	$count = count($rows);


																																	if ($count > 0) {

																																		$mensagem = "<label class='mensagemImprimir' style='color: red;'>Email ou Usuario ja foram cadastrado!</label>";

																																	}else{
																																		//VERIFICAÇÃO DA TABELA FUNCIONARIO 
																																		$query = "SELECT usuario, email, cpf FROM funcionario WHERE usuario = :usuario OR email = :email OR cpf = :cpf";
																																		$params = array(

																																			':usuario'		=>		(String)$usuario,
																																			':email'		=>		(String)$email,
																																			':cpf'			=>		(String)$cpf


																																		);
																																		$rows = DB::selectDB($query, $params, PDO::FETCH_OBJ);
																																		$count2 = count($rows);
																																		if ($count2 > 0) {

																																			$mensagem = "<label class='mensagemImprimir' style='color: red;'>Email, Usuario ou Cpf ja foram cadastrado!</label>";

																																		}else{
																																			$query = "SELECT usuario, email, cpf FROM funcionario WHERE usuario = :usuario OR email = :email OR cpf = :cpf";
																																			$params = array(

																																				':usuario'		=>		(String)$usuario,
																																				':email'		=>		(String)$email,
																																				':cpf'			=>		(String)$cpf


																																			);
																																			$rows = DB::selectDB($query, $params, PDO::FETCH_OBJ);
																																			$count3 = count($rows);
																																			if ($count3 > 0) {
																																				$mensagem = "<label class='mensagemImprimir' style='color: red;'>Email, Usuario ou Cpf ja foram cadastrado!</label>";
																																			} else {
																																					$codificacao = md5($senha);

																																					$query = "INSERT INTO funcionario(id, nome, email, usuario, senha, datadenasc, cpf, rg, telefone, cep, tp_logradouro, logradouro, num, complemento, bairro, cidade, uf, cargo) VALUES (NULL, :nome, :email, :usuario, :senha, :datadenasc, :cpf, :rg, :telefone, :cep, :tp_logradouro, :logradouro, :num, :complemento, :bairro, :cidade, :uf, :cargo)";
																																					$params = array(

																																						':nome'				=>		(String)$nome,
																																						':email'			=>		(String)$email,
																																						':usuario'			=>		(String)$usuario,
																																						':senha'			=>		(String)$codificacao,
																																						':datadenasc'		=>		$datadenasc,
																																						':cpf'				=>		(String)$cpf,
																																						':rg'				=>		(String)$rg,
																																						':telefone'			=>		(String)$telefone,
																																						':cep'				=>		(String)$cep,
																																						':tp_logradouro'	=>		(String)$tp_logradouro,
																																						':logradouro'		=>		(String)$logradouro,
																																						':num'				=>		(Integer)$num,
																																						':complemento'		=>		(String)$complemento,
																																						':bairro'			=>		(String)$bairro,
																																						':cidade'			=>		(String)$cidade,
																																						':uf'				=>		(String)$uf,
																																						':cargo'			=>		(String)$cargo

																																					);
																																					$rows = DB::insertDB($query, $params);
																																					$mensagem = "<label class='mensagemImprimir' style='color: green;'>Cadastrado com Sucesso</label>";

																																			}
																																		}

																																	}

																																}else{//Verifica se o cargo selecionado é 1 - Funcionario, 2 - Gerente ou 3 - Administrador
																																	
																																	$mensagem = "<label class='mensagemImprimir' style='color: red;'>Não é possivel cadastrar um Gerente ou Administrador nessa conta. (CONTATAR: Administrador)!</label>";
																																}




																															}else{

																																$mensagem = "<label class='mensagemImprimir' style='color: red;'>Não é possivel cadastrar um Funcionario, Gerente ou Administrador nessa conta. (CONTATAR: Administrador)!</label>";
																															}
																														}
																													}
																												}
																											}
																										}
																									}
																								}
																							}
																						}
																					}
																				}
																			}
																		}
																	}
																}
															}
														}

													}
												}
											}

										}
									}
								}	
							}
						}
					}
				}

			}


		}else{
			header("Location: menu_principal.php");
		}



	}

	catch(PDOException $error){
		$mensagem = $error->getMessage();
	}	
	?>
	<!DOCTYPE html>
	<html lang="pt-br">
	<head>
		<!-- Meta tags Obrigat&oacute;rias -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.ripples/0.5.3/jquery.ripples.min.js"></script>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
		<title>AT - Registro do Funcionario</title>
	</head>	
	<body>

		<main class="container-fluid" id="background_funcionario">
			<!-- Cabeça (Topo) do Site -->
			<div class="row bg-success">

				<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 mt-xl-1 mt-lg-1 mt-md-1 mt-sm-1 mt-1">

					<ul class="navbar-nav ml-xl-auto ml-lg-auto ml-md-auto ml-sm-auto ml-auto">

						<li class="nav-item dropdown">
							
							<a class="nav-link" href="#" data-toggle="dropdown" id="navDrop">
								<img src="data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(0, 0, 0, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E" class="img-menu">
							</a>

							<div class="dropdown-menu">
								<a class="dropdown-item" href="menu_principal.php">Menu principal</a>
								<a class="dropdown-item" href="#">Sobre</a>
							</div>

						</li>

					</ul>

				</div>

				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-7 text-center mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-3 text middle" style="transform: translateX(10%);"> 
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
				

				<!-- Contagem de arvores -->
				<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-3 offset-xl-1 offset-lg-1 offset-sm-1 offset-md-1 offset-1">
					
					<a href="logout.php" class="btn btn-danger float-right tamanho_btn_sair">Sair</a>
					
				</div>

			</div>

			<!-- Formulario  cad_usuario_full_screen-->		
			<div  class="row">

				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-xl-4 mt-lg-4 mt-md-4 mt-sm-4 mt-4">

					<div class="row">

						<div class="col-xl-4 col-lg-5 col-md-6 col-sm-7 col-10 offset-xl-4 offset-lg-3 offset-md-3 offset-sm-2 offset-1 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-2">

							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 border bg-white rounded">

								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center mt-xl-4 mt-lg-4 mt-md-4 mt-sm-3 mt-3">
									<label class="cad_usuario_title_form">Registrar</label>
								</div>

								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">

									<label><?=  $mensagem ?? NULL ?></label>

								</div>

								<form method="POST" class="form-group">

									<label class="font-weight-bold">*Nome</label>
									<input type="text" name="nome" placeholder="Ex: Johnny" class="form-control">

									<label class="font-weight-bold">*Email</label>
									<input type="text" name="email" placeholder="Ex: name@example.com" class="form-control">

									<label class="font-weight-bold">*Usuario</label>
									<input type="text" name="usuario" placeholder="Ex: john" class="form-control">

									<label class="font-weight-bold">*Senha</label>
									<input type="password" name="senha" placeholder="Ex: john123" class="form-control">

									<label class="font-weight-bold">*Confirmar Senha</label>
									<input type="password" name="confSenha" placeholder="john123" class="form-control">

									<label class="font-weight-bold">*Data de Nascimento</label>
									<input type="text" name="datadenasc" id="datadenasc" placeholder="Ex: 00-00-0000" class="form-control">

									<label class="font-weight-bold">*CPF</label>
									<input type="text" name="cpf" id="cpf" placeholder="Ex: 000.000.000-00" class="form-control">

									<label class="font-weight-bold">*RG</label>
									<input type="text" name="rg" id="rg" placeholder="Ex: XX.XXX.XXX-X" class="form-control">

									<label class="font-weight-bold">*Telefone</label>
									<input type="text" name="telefone" id="telefone" placeholder="Ex: (00) 00000-0000" class="form-control">
									
									<label class="font-weight-bold">*CEP</label>
									<input type="text" name="cep" id="cep" placeholder="Ex: 00000-000" class="form-control">			

									<label class="font-weight-bold">*Tipo de Logradouro</label>
									<input type="text" name="tp_logradouro" id="tp_logradouro" placeholder="Ex: Rua/Avenida" class="form-control">

									<label class="font-weight-bold">*Logradouro</label>
									<input type="text" name="logradouro" id="logradouro" placeholder="Ex: Nova Iorque" class="form-control">

									<label class="font-weight-bold">*Numero</label>
									<input type="number" name="num" id="num" placeholder="Ex: 0000" class="form-control">

									<label class="font-weight-bold">Complemento</label>
									<input type="text" name="complemento" placeholder="Ex: 000B/Casa" class="form-control">

									<label class="font-weight-bold">*Bairro</label>
									<input type="text" name="bairro" id="bairro" placeholder="Ex: Nova York" class="form-control">

									<label class="font-weight-bold">*Cidade</label>
									<input type="text" name="cidade" id="cidade" placeholder="Ex: Araçatuba" class="form-control">

									<label class="font-weight-bold">*Estado</label>
									<select name="uf" id="uf" class="custom-select">
										<optgroup label="Selecione o estado"></optgroup>
										<option value="" selected>-- Selecione --</option>
										<?php 
										$sql = "SELECT nome FROM `uf` WHERE 1";
										$rows = DB::selectDB($sql, NULL, \PDO::FETCH_OBJ);
										?>
										<?php foreach ($rows as $row): ?>
											<option value="<?=$row->nome;?>"><?=$row->nome;?></option>
										<?php endforeach; ?>
									</select>
									<!-- <input type="text" name="uf" id="uf" placeholder="Ex: São Paulo" class="form-control"> -->

									<label class="font-weight-bold">*Cargo</label>
									<select name="cargo" class="form-control">
										<optgroup label="Selecione o cargo"></optgroup>
										<option value="" selected>-- Selecione --</option>
										<option value="1">Funcionario</option>
										<?php if ($_SESSION['cargo'] == 3): ?>
											<option value="2">Gerente</option>
										<?php endif; ?>
										<!-- <option value="3">Administrador</option> -->
									</select>
									<input type="submit" value="Cadastrar" class="btn btn-primary mt-xl-3 mt-lg-3 mt-md-3 mt-sm-3 mt-3">

								</form>

							</div>

						</div>

					</div>

				</div>






			</div>

		</main>

		<footer>

			<script src="js/jquery-3.3.1.slim.min.js"></script>
			<script src="js/jquery-3.4.1.slim.min.js"></script>
			<script src="script/script_cadastro_funcionario.js"></script>
			<script src="js/popper.min.js"></script>
			<script src="js/bootstrap.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
			<script src="script/script_mask.js"></script>
		</footer>

	</body>
	</html>