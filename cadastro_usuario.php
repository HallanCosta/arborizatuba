<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once('libary/libary.php');
require_once('class_static/crypt.php');

try{
		//$conexao = new Conexao();
	$query = "SELECT SUM(quant) AS quantUsuario FROM validadas";
	$rows = DB::selectDB($query, NULL, PDO::FETCH_OBJ);
	foreach ($rows as $row) {
				# code...
		$_SESSION['quantUsuario'] = $row->quantUsuario;
	}	

	if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['usuario']) && isset($_POST['senha']) && isset($_POST['confSenha'])) {
		
		
		if (empty($_POST['nome']) && empty($_POST['email']) && empty($_POST['usuario']) && empty($_POST['senha']) && empty($_POST['confSenha'])) {
			
			$mensagem = "<label style='color: red; font-size: 20px;'>Preencha todos os campos!</label>";
		}else{

			$nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRING);
			$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
			$usuario = filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_STRING);
			$senha =  filter_input(INPUT_POST, "senha", FILTER_SANITIZE_STRING);
			$confSenha = filter_input(INPUT_POST, "confSenha", FILTER_SANITIZE_STRING);

			if (is_numeric($nome)) {
				$mensagem = "<label style='color: red; font-size: 20px;'>Digite somente letras no campo NOME de no máximo 100 e no minimo 4 caracteres!</label>";
				
			}else{

				if (strlen($nome) < 4 || strlen($nome) > 100) {
					$mensagem = "<label style='color: red; font-size: 20px;'>Digite somente letras no campo NOME de no máximo 100 e no minimo 4 caracteres!</label>";
					
				}else{

					if (!is_string($email)) {	
						$mensagem = "<label style='color: red; font-size: 20px;'>Digite um EMAIL valido!</label>";
						
					}else{

						if (strlen($usuario) < 6 || strlen($usuario) > 30) {
							$mensagem = "<label style='color: red; font-size: 20px;'>Digite um USUARIO de no máximo 30 e no minimo 6 caracteres!</label>";
							
						}else{

							if (strlen($senha) < 7 || strlen($senha) > 30) {
								$mensagem = "<label style='color: red; font-size: 20px;'>Digite uma SENHA de no máximo 30 e no minimo 7 caracteres!</label>";
								
							}else{

								if ($senha !== $confSenha) {
									$mensagem = "<label style='color: red; font-size: 20px;'>Confirmação da senha inválida!</label>";
									
								}else{

										//VERIFICAÇÃO DA TABELA USUARIO 
									$query = "SELECT usuario, email FROM `admin` WHERE usuario = :usuario OR email = :email";
									$query2 = "SELECT usuario, email FROM `funcionario` WHERE usuario = :usuario OR email = :email";
									$query3 = "SELECT usuario, email FROM `usuario` WHERE usuario = :usuario OR email = :email";
									$params = array(
										':usuario'		=>		(String)$usuario,
										':email'		=>		(String)$email
									);
									

									$rows = DB::selectDB($query, $params, PDO::FETCH_OBJ);
									$rows2 = DB::selectDB($query2, $params, PDO::FETCH_OBJ);
									$rows3 = DB::selectDB($query3, $params, PDO::FETCH_OBJ);
									$count = count($rows);
									$count2 = count($rows2);
									$count3 = count($rows3);
									
									if ($count > 0) {
										$mensagem = "<label style='color: red; font-size: 20px;'>Este email ou usuário já está em uso</label>";
									} elseif ($count2 > 0) {
										$mensagem = "<label style='color: red; font-size: 20px;'>Este email ou usuário já está em uso</label>";
									} elseif ($count3 > 0) {
										$mensagem = "<label style='color: red; font-size: 20px;'>Este email ou usuário já está em uso</label>";
									} else{
											//$s = senha
											//$crypt = new Crypt();
										$codificacao = md5($senha);

										$query = "INSERT INTO usuario(id, nome, email, usuario, senha) VALUES(NULL, :nome, :email, :usuario, :senha)";
										$params = array(
											
											':nome'		=>		(String)$nome,
											':email'	=>		(String)$email,
											':usuario'	=>		(String)$usuario,
											':senha'	=>		(String)$codificacao
											
										);
										$rows3 = DB::insertDB($query, $params) or die('Não foi possive Cadastrar no banco de dados! tente novamente em outra hora');

										print('<script type="text/javascript">
											window.alert("Cadastro de usuário realizado com sucesso.")
											</script>');
										print('<script type="text/javascript">
											window.alert("Faça o login na plataforma para acessar sua conta.")
											window.location.href="tela_login.php";
											</script>');
										$mensagem = "<label style='color: green; font-size: 20px;'>Cadastrado com Sucesso</label>";



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
	<title>AT - Cadastro do Usuario</title>
</head>	
<body>

	<main class="container-fluid" id="bg-gray">
		<!-- Cabeça (Topo) do Site -->
		<div class="row bg-success">

			<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 mt-xl-1 mt-lg-1 mt-md-1 mt-sm-1 mt-1">
				
				<ul class="navbar-nav ml-xl-auto ml-lg-auto ml-md-auto ml-sm-auto ml-auto">
					
					<li class="nav-item dropdown">
						
						<a class="nav-link" href="#" data-toggle="dropdown" id="navDrop">
							<img src="data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(0, 0, 0, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E" class="img-menu">
						</a>
						
						<div class="dropdown-menu">
							<a class="dropdown-item" href="index.html">Home</a>
							<a class="dropdown-item" href="tela_login.php">Tela de login</a>
							<a class="dropdown-item" href="inicio/contato.html">Contato</a>
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
			<div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-2 mt-xl-4 mt-lg-4 mt-md-4 mt-sm-4 mt-3 offset-xl-1 offset-lg-1">
				<label class="text-white font-weight-bold arvores_aracatuba">Árvores: <?php echo "<label class='text-danger'>" .$_SESSION['quantUsuario']. "</label>";?></label>

			</div>
			
		</div>

		<!-- Formulario  cad_usuario_full_screen-->		
		<div  class="row">

			<div class="col-xl-6 col-lg-7 col-md-6 col-sm-12 col-12 mt-xl-4 mt-lg-4 mt-md-4 mt-sm-4 mt-4">
				
				<div class="row">
					
					<div class="col-xl-8 col-lg-9 col-md-10 col-sm-10 col-12 offset-xl-2 offset-lg-1 offset-md-1 offset-sm-1 offset-0 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-2">

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 border bg-white rounded">

							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center mt-xl-4 mt-lg-4 mt-md-4 mt-sm-3 mt-3">
								<label class="cad_usuario_title_form">Cadastre-se</label>
							</div>
							
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">

								<label><?=  isset($mensagem) ? $mensagem : $mensagem = '' ?></label>
								<?php 
										/*if (isset($mensagem)){

											echo "" .$mensagem. "";
											
										}*/
										?>
									</div>

									<form method="post" class="form-group">
										
										<label class="font-weight-bold">Nome</label>
										<input type="text" name="nome" placeholder="Ex: Joaquim dos Santos Alves" class="form-control">

										<label class="font-weight-bold">Email</label>
										<input type="text" name="email" placeholder="Ex: joaquim.alves@hotmail.com" class="form-control">

										<label class="font-weight-bold">Usuario</label>
										<input type="text" name="usuario" placeholder="Ex: joaquimSA" class="form-control">

										<label class="font-weight-bold">Senha</label>
										<input type="password" name="senha" placeholder="Ex: joaquimSA123" class="form-control">
										
										<label class="font-weight-bold">Confirmar Senha</label>
										<input type="password" name="confSenha" placeholder="joaquimSA123" class="form-control">

										<input type="submit" value="Cadastrar" class="btn btn-primary mt-xl-3 mt-lg-3 mt-md-3 mt-sm-3 mt-3">

									</form>

								</div>
								
							</div>
							
						</div>
						
					</div>


					<div class="col-xl-6 col-lg-5 col-md-6 col-sm-12 col-12 mt-xl-2 mt-lg-2 mt-md-0 mt-sm-0 mt-2">
						
						<div class="row mr-xl-1 mr-lg-1 mr-md-1 mr-sm-1 mt-xl-4 mt-lg-4 mt-md-4 mt-sm-0 mt-2">
							
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-xl-2 mt-lg-2 mt-md-0 mt-sm-0 mt-4 texto_center">
								<h3>1. Como cadastrar-se</h3>
							</div>
							
							<div class="col-xl-12 col-lg-12 col-md-12 col-10 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-1 offset-1 border bg-white rounded">
								
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<ul class="font-weight-bold mt-xl-2 mt-lg-2 mt-md-2 mt-sm-3 mt-3" style="list-style-type: none;">
										<li>1.1 Preencha com seu nome completo.</li>
										<li>1.2 Digite um email valido para enviar-mos notificações.</li>
										<li>1.3 Digite seu nome de usuario que você usara para entrar no sistema.</li>
										<li>1.4 Crie uma senha forte sem caracteres especias como @!#$%& e não compartilhe-a com ninguém.</li>
										<li>1.5 Repita sua senha e não esqueça de anota-la para não esquecer.</li>
									</ul>
								</div>

							</div>
							
						</div>

						<div class="row mr-xl-1 mr-lx-1 mr-md-1 mr-sm-1 mr-1 mt-xl-4 mt-lx-4 mt-md-4 mt-sm-4 mt-4 mb-xl-2 mb-lg-2 mb-md-2 mb-sm-4 mb-4">
							
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 texto_center">
								<h3>2. Como cadastrar árvore</h3>
							</div>
							
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-10 col-10 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-1 offset-1 border bg-white rounded">

								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<ul class="font-weight-bold mt-xl-2 mt-lg-2 mt-md-2 mt-sm-3 mt-3" style="list-style-type: none;">
										<li>2.1 Faça login no sistema.</li>
										<li>2.2 Clique em Cadastrar Arvore.</li>
										<li>2.3 Coloque o Bairro que você mora.</li>
										<li>2.4 Digite o Endereço de sua casa e em seguida o Número.</li>
										<li>2.5 Digite o Porte de sua Árvore (Grande, Medio ou Pequeno).</li>
										<li>2.6 Se não souber a Espécie da árvore disponibilizamos logo abaixo algumas espécie escolha uma que é semelhante a sua.</li>
										<li>2.7 Coloque a última vez que podaram sua árvore.</li>
										<li>2.8 Coloque qual sera a data da proxima poda daqui 6 meses.</li>
									</ul>
								</div>
								
							</div>	
							
						</div>

					</div>
					


					
					
					

				</main>

				<footer>

					<script src="js/jquery-3.3.1.slim.min.js"></script>
					<script src="js/jquery-3.4.1.slim.min.js"></script>
					<script src="js/popper.min.js"></script>
					<script src="js/bootstrap.min.js"></script>
				</footer>

			</body>
			</html>