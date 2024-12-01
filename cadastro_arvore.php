<?php
	//error_reporting(0);
	//ini_set(“display_errors”, 0 );
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once('libary/libary.php');

	//Sera que ficaria bom criar uma função ?? para verificação de login?
if (isset($_SESSION['usuario']) && isset($_SESSION['id']) && $_SESSION['cargo'] == 0){

	if (isset($_POST['cep']) || isset($_POST['tp_logradouro']) || isset($_POST['logradouro']) || isset($_POST['numero']) || isset($_POST['complemento']) || isset($_POST['bairro']) || isset($_POST['especie']) || isset($_POST['porte']) || isset($_POST['ultima']) || isset($_POST['proxima'])) {

		try{

			if (empty($_POST['cep']) || empty($_POST['tp_logradouro']) || empty($_POST['logradouro']) || empty($_POST['numero']) || empty($_POST['bairro']) || empty($_POST['especie']) || empty($_POST['porte'])) {
				
				$mensagem = "<label class='mensagemImprimir' style='color: red;'>Preencha todos os campos!</label>";

			}

			else{

				$cadastrar = filter_input(INPUT_POST, "cadastrar", FILTER_SANITIZE_STRING);

					$cep = filter_input(INPUT_POST, "cep", FILTER_SANITIZE_STRING); //9 CHARACTERES
						$primeirosDigitos = substr($cep, 0, 5); //OBTENÇÃO DOS 5 PRIMEIROS DIGITOS DO CEP
					    $ultimosDigitos = substr($cep, -3);//OBTENÇÃO DOS 3 ultimos DIGITOS DO CEP
				    $cep = $primeirosDigitos."-".$ultimosDigitos;//ADICIONANDO - NO CEP POR EX: 16021305 / 16021-305

					$tp_logradouro = filter_input(INPUT_POST, "tp_logradouro", FILTER_SANITIZE_STRING);	//10 CHARACTERES
					$logradouro = filter_input(INPUT_POST, "logradouro", FILTER_SANITIZE_STRING);	//100 CHARACTERES
					$numero = filter_input(INPUT_POST, "numero", FILTER_VALIDATE_INT); //4 CHARACTERE
					$complemento = filter_input(INPUT_POST, "complemento", FILTER_VALIDATE_INT); //6 CHARACTERE
					empty($complemento) ? $complemento = '0' : $complemento; // se apto estiver vazio e 0
					$bairro = filter_input(INPUT_POST, "bairro", FILTER_SANITIZE_STRING); //30 CHARACTERES
					$especie = filter_input(INPUT_POST, "especie", FILTER_SANITIZE_STRING); //menor que 3 e maior que 25 CHARACTERES não entra
					$porte = filter_input(INPUT_POST, "porte", FILTER_SANITIZE_STRING);
					$quant = filter_input(INPUT_POST, "quant", FILTER_VALIDATE_INT); //4 CHARACTERE

					if (empty($_POST['ultima'])) {
						$hoje = date("Y-m-d");
						$ultimaConvert = $hoje;
					}else{	
						$ultima = $_POST['ultima'];
						$ultimaConvert = str_replace('/', '-', ($ultima));
						$ultimaConvert = date("Y-m-d", strtotime($ultimaConvert));
					}

					
					if (empty($_POST['proxima'])) {
						//$proxima = "0001-01-01";
						$proxima = date('Y-m-d');
						$proxima = strtotime($proxima);
						$proximaConvert = date("Y-m-d", $proxima);
					}else{
						
						//$hojeBD = date("Y-m-d");
						$proxima = $_POST['proxima'];
						$proxima = str_replace('/', '-', ($proxima));
						$proximaConvert = date("Y-m-d", strtotime($proxima));

						
					}

					
					if (!is_string($cep)) {
						$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite um cep valido no campo CEP!</label>";
					}else{
						
						if (strlen($cep) < 9 || strlen($cep) > 9) {
							$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite um cep valido no campo CEP!</label>";

						}else{

							if (is_numeric($bairro)) {

								$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite no campo BAIRRO no máximo 30 e no minimo 4 caracteres!</label>";
								
							}else{	

								if (strlen($bairro) < 5 || strlen($bairro) > 100) {
									
									$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite no campo BAIRRO no máximo 100 e no minimo 4 caracteres!</label>";
								}else{

									if (is_numeric($tp_logradouro)) {

										$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite no campo TIPO DE LOGRADOURO no máximo 8 e no minimo 3 caracteres!</label>";
									}else{

										if (strlen($tp_logradouro) < 3 || strlen($tp_logradouro) > 8) {

											$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite no campo TIPO DE LOGRADOURO no máximo 8 e no minimo 3 caracteres!</label>";
										}else{

											if (is_numeric($logradouro)) {

												$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite somente letras no campo LOGRADOURO!</label>";
												
											}else{

												if (strlen($logradouro) > 100 || strlen($logradouro) < 1) {
													
													$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite no campo LOGRADOURO no máximo 100 e no minimo 10 caracteres!</label>";

												}else{

													
													if (!is_numeric($numero)) {

														$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite somente números de até 4 digitos sem , ou . no campo NÚMERO</label>";
														
													}else{

														if (strlen($numero) < 1 || strlen($numero) > 4) {
															
															$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite somente números de até 4 digitos sem , ou . no campo NÚMERO</label>";

														}else{

															if (strlen($complemento) > 6) {
																$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite somente caracteres de no mínimo 1 e no máximo 6 casas no campo COMPLEMENTO</label>";
															}else{

																if (strlen($complemento) < 1 || strlen($complemento) > 6) {
																	$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite somente numeros de no mínimo 1 e no máximo 6 casas no campo COMPLEMENTO</label>";
																}else{


																	if (is_numeric($especie)) {
																		
																		$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite somente letras de no mínimo 3 e no máximo 25 caracteres no campo ÉSPECIE DA ARVORE</label>";
																	}else{

																		
																		if (strlen($especie) < 3 || strlen($especie) > 35) {
																			$mensagem = "<label class='mensagemImprimir' style='color: red;>Digite somente letras de no mínimo 3 e no máximo 25 caracteres no campo ÉSPECIE DA ARVORE</label>";
																		}else{

																			if (strlen($_POST['ultima']) > 10) {
																				$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite um ano valido no campo DATA DA ÚLTIMA PODA!</label>";
																			}else{

																				if (strlen($_POST['proxima']) > 10) {
																					$mensagem = "<label class='mensagemImprimir' style='color: red;'>Digite um ano valido no campo DATA DA PRÓXIMA PODA!</label>";
																				}else{

																					$hojeDB = date('Y-m-d');
																					
																					if ($proxima < $hojeDB) {
																						$mensagem = "<label class='mensagemImprimir' style='color: red;'>Você não pode pedir uma poda para para esse dia!</label>";
																					}else{

																						$hojeDB = date('Y-m-d', strtotime('+10 days'));
																						
																						if ($proxima < $hojeDB) {
																							$mensagem = "<label class='mensagemImprimir' style='color: red;'>Você só pode pedir uma poda contando o dia de hoje +10 dias!</label>";
																						}else{

																							//$hojeBD = date("Y-m-d");
																							//$proximaConvert = date("Y-m-d", strtotime('+10 days', strtotime($hojeDB)));
																							//$proximaConvert = $_POST['proxima'];

																							//$conexao = new Conexao();

																							//VERIFICAÇÃO DA TABELA VALIDADOS
																							$query = "SELECT cep, num, especie FROM validacao WHERE cep = :cep AND num = :num AND especie = :especie";
																							$params = array(

																								':cep'			=>		(String)$cep,
																								':num'			=>		(String)$numero,
																								':especie'		=>		(String)$especie
																							);

																							$rows = DB::selectDB($query, $params, PDO::FETCH_OBJ);
																							
																							//VERIFICAÇÃO DA TABELA VALIDADOS 
																							$query2 = "SELECT cep, num, especie FROM validadas WHERE cep = :cep AND num = :num AND especie = :especie";
																							
																							$params2 = array(

																								':cep'			=>		(String)$cep,
																								':num'			=>		(String)$numero,
																								':especie'		=>		(String)$especie
																								
																							);
																							$rows2 = DB::selectDB($query2, $params2, PDO::FETCH_OBJ);

																							$count = count($rows);
																							$count2 = count($rows2);
																							
																							if ($count > 0) {

																								$mensagem = "<label class='mensagemImprimir' style='color: red;'>Esse cadastro ja existe!</label>";
																								
																							}else{

																								if ($count2 > 0) {
																									
																									$mensagem = "<label class='mensagemImprimir' style='color: red;'>Esse cadastro ja existe!</label>";

																								}else{

																									//Verificação se o usuário clicou no botão cadastrar
																									if ($cadastrar) {
																										

									   																	//$foto = strtolower(substr($_FILES['foto']['name'], 0));
									   																	//$extensao = strtolower(substr($_FILES['foto']['name'], -4));
																										$formatos = array("png", "jpeg", "jpg");
																										$extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
																										$foto = md5(time()) . ".$extensao";
																										$diretorioBD = 'arvores/' . $_SESSION['usuario'].'/'.$foto;

																										if (in_array($extensao, $formatos)) {

																											$query = "INSERT INTO validacao VALUES(NULL, :cep, :tp_logradouro, :logradouro, :num, :complemento, :bairro, :especie, :porte, :quant, :ultimaConvert, :proximaConvert, :diretorio, :id_usuario)";
																											$params = array(

																												':cep'					=>		(String)$cep,
																												':tp_logradouro'		=>		(String)$tp_logradouro,
																												':logradouro'			=>		(String)$logradouro,
																												':num'					=>		(Integer)$numero,
																												':complemento'			=>		(String)$complemento,
																												':bairro'				=>		(String)$bairro,
																												':especie'				=>		(String)$especie,
																												':porte'				=>		(String)$porte,
																												':quant'				=>		(Integer)$quant,
																												':ultimaConvert'		=>		$ultimaConvert,
																												':proximaConvert'		=>		$proximaConvert,
																												':diretorio'			=>		$diretorioBD,
																												':id_usuario'			=>		$_SESSION['id']

																											);
																											//Retorna o ultimo id inserido como se fosse uma contagem
																											$lastInsertId = DB::insertDB($query, $params);
																											print('<script type="text/javascript">
																												window.alert("                                           !!! ATENÇÃO !!!\nSua ávore está na lista de inspeção de árvores para que seja aprovada.\nApós a validação da árvore você poderá alterar qualquer dado do cadastro da árvore desejada. \nPrazo para aprovação da árvore de 48 horas à 1 semana. Agradecemos a Compreensão")
																												</script>');
																											print('<script type="text/javascript">window.location.href="menu_principal.php"</script>');

																											

																										}else{

																											$mensagem = "<label class='mensagemImprimir' style='color:red;>Esse formato de imagem não é permitido (Somente png/jpeg/jpg)</label>";

																										}

																										
																									    //Verificar se os dados foram inseridos com sucesso
																										if (!empty($lastInsertId) && $lastInsertId > 0) {
																											
																											
																									        //Diretório onde o arquivo vai ser salvo
																											$diretorio = 'arvores/' . $_SESSION['usuario'].'/';



																									        //Criar a pasta de foto
																											if (!is_dir($diretorio)) {
																												mkdir($diretorio, 0755, TRUE); 
																											}
																											
																											

																											if(move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$foto)){
																												$mensagem = "<label class='mensagemImprimir' style='color:green;'>Cadastro realizado com sucesso</label>";
																												
																											}else{
																												$mensagem = "
																												<label class='mensagemImprimir' style='color: green;'>Dados salvo com sucesso</label>

																												<label class='mensagemImprimir' style='color:red;'> Erro ao realizar o upload da imagem</label>
																												";
																												
																											}   

																										}else {
																											$mensagem = "<label class='mensagemImprimir' style='color: red;'>Erro ao salvar a foto</label>";
																											
																										}

																									}else{
																										$mensagem = "<label class='mensagemImprimir' style='color:red;'>Erro ao salvar os dados</label>";
																										
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
			catch(PDOException $error){
				$mensagem = $error->getMessage();
			}
		}
		
	}else{
		header('Location: menu_principal.php');
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
		<title>AT - Cadastro da Árvore</title>
	</head>
	<body>
		<main class="container-fluid">

			<!-- Cabeça (Topo) do Site -->
			<div class="row bg-success">

				<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 mt-xl-1 mt-lg-1 mt-md-1 mt-sm-1 mt-1">
					
					<!-- <div class="col-xl-12">
						<a href="menu_principal.php"><<<<<<<<<</a>
					</div> -->

					<!-- Cabeça (Topo) do Site -->
					<ul class="navbar-nav ml-xl-auto ml-lg-auto ml-md-auto ml-sm-auto ml-auto">

						<li class="nav-item dropdown">
							
							<a class="nav-link" href="#" data-toggle="dropdown" id="navDrop">
								<img src="data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(0, 0, 0, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E" class="img-menu">
							</a>
							
							<div class="dropdown-menu">
								<a class="dropdown-item" href="galeria_arvores_usuario.php">Galeria árvores</a>
								<a class="dropdown-item" href="menu_principal.php">Menu principal</a>
								<a class="dropdown-item" href="alterar_arvore.php">Alterar árvore</a>
								<a class="dropdown-item" href="#">Sobre</a>
							</div>
							
						</li>
						
					</ul>
					
				</div>

				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-8 col-8 text-center mt-xl-2 mt-xl-1 mt-lg-1 mt-md-1 mt-sm-1 mt-3 text middle">
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

			<!-- Corpo Cadastro Site -->
			<form class="form-group" method="post" enctype="multipart/form-data">

				<div class="row ml-xl-5 ml-lg-5 ml-md-5 ml-sm-0 ml-0 mr-xl-5 mr-lg-5 mr-md-5 mr-sm-0 mr-0 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-2">
					
					<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 offset-xl-2 offset-lg-2 offset-md-0 offset-sm-0 bg-gray rounded-top rounded-bottom">
						
						
						<!-- Titulo -->
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center mt-xl-0 mt-lg-0 mt-md-0 mt-sm-0 mt-2">
							<label class="text-cad">Cadastre a árvore</label>
						</div>

						
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
							
							<label><?= $mensagem ?? NULL  ?></label>
							
						</div>
						
						<div class="row">
							<!-- Campo CEP -->
							<div class="col-xl-5 col-lg-6 col-md-6 col-sm-8 col-12 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-2 offset-xl-2 offset-lg-1 offset-md-1">
								<label>CEP: </label>
								<input type="text" class="form-control" placeholder="Ex: 00000-000" name="cep" id="cep">
							</div>

							<!-- Campo Tipo de Logradouro -->
							<div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-2">
								<label>*Tipo Logradouro: </label>
								<input type="text" class="form-control" placeholder="Ex: Rua/Avenida" name="tp_logradouro" id="tp_logradouro">
							</div>
							<!-- Campo Logradouro -->
							<div class="col-xl-8 col-lg-8 col-md-7 col-sm-9 col-12 offset-xl-2 offset-lg-1 offset-md-1 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-2">
								<label>*Logradouro: </label>
								<input type="text" class="form-control" placeholder="Ex: Rua jose blaya mendes" name="logradouro" id="logradouro">
							</div>

							<!-- Campo Numero -->
							<div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-12 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-2 pl-xl-3 pl-lg-3 pl-md-3 pl-sm-1 offset-xl-2 offset-lg-0">
								<label>*Número: </label>
								<input type="number" class="form-control" placeholder="Ex: 0000" name="numero" id="numero">
							</div>

							<!-- Campo Complemento -->
							<div class="col-xl-2 col-lg-3 col-md-3 col-sm-3 col-12 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-2 pl-xl-3 pl-lg-3 pl-md-3 pl-sm-3 offset-xl-0 offset-lg-1 offset-md-1">
								<label>Complemento: </label>
								<input type="text" class="form-control" placeholder="Ex: 000B" name="complemento" id="complemento">
							</div>

							<!-- Campo Bairro -->
							<div class="col-xl-4 col-lg-7 col-md-7 col-sm-9 col-12 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-2 offset-xl-0 offset-lg-0 offset-md-0">
								<label>*Bairro: </label>
								<input type="text" class="form-control" placeholder="Ex: Nova York" name="bairro" id="bairro">
							</div>

							<!-- Campo Especie da Arvore -->
							<div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-2 offset-xl-2 offset-lg-1 offset-md-1">
								<label>*Espécie da árvore: </label>
								<input type="text" class="form-control" placeholder="Ex: Alfeneiro – Ligustrum lucidum" name="especie">
							</div>

							<!-- Campo Porte da arvore -->
							<div class="col-xl-3 col-lg-4 col-md-4 col-sm-9 col-12 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-2 offset-xl-0 offset-lg-0 offset-md-0">
								<label>*Porte da árvore: </label>
								<select class="form-control" name="porte">
									<option></option>
									<option>Grande</option>
									<option>Medio</option>
									<option>Pequeno</option>
								</select>
								
							</div>


							<!-- Campo Quantidade de arvores -->
							<div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-12 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-2 pl-xl-3 pl-lg-3 pl-md-3 pl-sm-1">
								<label>*Quantidade:</label>
								<input type="number" class="form-control" placeholder="Ex:3" name="quant">
							</div>

							<!-- Campo Data da ultima poda -->
							<div class="col-xl-8 col-lg-10 col-md-10 col-sm-12 col-12 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-2 offset-xl-2 offset-lg-1 offset-md-1">
								<label>Data da última poda: </label>
								<input type="date" class="form-control" name="ultima">
							</div>

							<!-- Campos Data da proxima poda -->
							<div class="col-xl-8 col-lg-10 col-md-10 col-sm-12 col-12 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-2 mb-xl-2 mb-lg-2 mb-md-2 mb-sm-2 offset-xl-2 offset-lg-1 offset-md-1">
								<label>Data da próxima poda: <strong class="text-danger">Se você não quiser uma poda só deixar em branco o campo!</strong></label>
								<input type="date" class="form-control" name="proxima">
							</div>
						</div>

						<div class="row">

							<!-- Botão Carregar foto -->
							<div class="col-xl-3 col-lg-6 col-md-5 col-sm-5 col-12 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-3 mt-3 offset-xl-2 offset-lg-1 offset-md-1">
								<input type="file" name="foto" accept="image/*" capture="camera" value="Carregar foto" class="btn btn-danger">
							</div>

							<!-- Botão Cadastrar -->
							<div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-3 mt-3 mb-xl-3 mb-xl-3 mb-md-4 mb-sm-4 mb-3 offset-xl-3 offset-lg-2 offset-md-1 offset-sm-3 offset-0 pl-xl-4 pl-lg-2 pl-md-0 pl-sm-0 pl-4">
								<input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-success float-xl-right float-lg-right float-md-right float-sm-right">
							</div>

						</div>

					</div>

				</div>

			</form>

			


			

			
			
			
			


		</main>
		
		<footer>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
			<script src="js/jquery-3.4.1.slim.min.js"></script>
			<script src="script/script_cadastro_arvore.js"></script>
			<script src="js/popper.min.js"></script>
			<script src="js/bootstrap.min.js"></script>
		</footer>
	</body>
	</html>