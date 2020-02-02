<?php
session_start();
require_once('libary/libary.php');
require_once('class_static/crypt.php');

try{

	//$conexao = new Conexao();
	$query = "SELECT SUM(quant) AS quantTotal FROM validadas";
	$rows = DB::selectDB($query, NULL, PDO::FETCH_OBJ);
	foreach ($rows as $row) {
		$_SESSION['quantTotal'] = $row->quantTotal;
	}


	if (isset($_POST['usuario']) || isset($_POST['senha'])){
		$email = filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_STRING);
		$usuario = filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_STRING);
		$senha = filter_input(INPUT_POST, "senha", FILTER_SANITIZE_STRING);

		if (empty($_POST['usuario']) || empty($_POST['senha'])){

			$mensagem = "Preencha todos os campos!";
				//$mensagem = "<label style='color: red;'>Preencha todos os campos!</label>";
			
		}else{
				//$crypt = new Crypt();
			$codificacao = md5($senha);

				//VERIFICAÇÃO TABELA USUARIO
			$query = "SELECT * FROM `usuario` WHERE (email = :email AND senha = :senha) OR (usuario = :usuario AND senha = :senha)";
			$params = array(
				':email' => (String)$email,
				':usuario' => (String)$usuario,
				':senha' => (String)$codificacao
			);
			$rows = DB::selectDB($query, $params, \PDO::FETCH_OBJ); 
			$count = count($rows);

			//VERIFICAÇÃO TABELA FUNCIONARIO
			$query2 = "SELECT * FROM `funcionario` WHERE (email = :email AND senha = :senha) OR (usuario = :usuario AND senha = :senha)";
			$params2 = array(
				':email' => (String)$email,
				':usuario' => (String)$usuario,
				':senha' => (String)$codificacao
			);
			$rows2 = DB::selectDB($query2, $params2, \PDO::FETCH_OBJ); 
			$count2 = count($rows2);

			//VERIFICAÇÃO TABELA FUNCIONARIO
			$query3 = "SELECT * FROM `admin` WHERE (email = :email AND senha = :senha) OR (usuario = :usuario AND senha = :senha)";
			$params3 = array(
				':email' => (String)$email,
				':usuario' => (String)$usuario,
				':senha' => (String)$codificacao
			);
			$rows3 = DB::selectDB($query3, $params3, \PDO::FETCH_OBJ); 
			$count3 = count($rows3);

			if ($count > 0){
				if (isset($_SESSION)) {
					$quantTotal = $_SESSION['quantTotal'];
					session_unset();
					$_SESSION['quantTotal'] = $quantTotal;
				}
				foreach ($rows as $row) {
					if (($row->usuario === $usuario || $row->email == $usuario) && $row->senha === $codificacao) {
						$_SESSION['id'] = $row->id;
						$_SESSION['nome'] = $row->nome;	
						$_SESSION['usuario'] = $row->usuario;
						$_SESSION['cargo'] = 0;
						header('Location: menu_principal.php');
					} else {
						$mensagem = "Usuário ou Senha inválido!";
					}
				}
			}elseif($count2 > 0){
				if (isset($_SESSION)) {
					$quantTotal = $_SESSION['quantTotal'];
					session_unset();
					$_SESSION['quantTotal'] = $quantTotal;
				}
				foreach ($rows2 as $row2) {
					if (($row2->usuario === $usuario || $row2->email == $usuario) && $row2->senha === $codificacao) {
						$_SESSION['id'] = $row2->id;
						$_SESSION['nome'] = $row2->nome;	
						$_SESSION['usuario'] = $row2->usuario;
						$_SESSION['cargo'] = $row2->cargo;
						header('Location: menu_principal.php');
					} else {
						$mensagem = "Usuário ou Senha inválido!";
					}
				}
			}elseif($count3 > 0){
				if (isset($_SESSION)) {
					$quantTotal = $_SESSION['quantTotal'];
					session_unset();
					$_SESSION['quantTotal'] = $quantTotal;
				}
				foreach ($rows3 as $row3) {
					if (($row3->usuario === $usuario || $row3->email == $usuario) && $row3->senha === $codificacao) {
						$_SESSION['id'] = $row3->id;
						$_SESSION['nome'] = $row3->nome;	
						$_SESSION['usuario'] = $row3->usuario;
						$_SESSION['cargo'] = $row3->cargo;
						header('Location: menu_principal.php');
					} else {
						$mensagem = "Usuário ou Senha inválido!";
					}
				}
			}else{
				$mensagem = "Usuário ou Senha está inválido!";
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
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
	<title>AT - Login</title>
</head>
<body>

	<main class="container-fluid img-fluid" id="ripples_background">

		<!-- Cabeça (Topo) do Site -->
		<div class="row bg-success">

			<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 mt-md-1 mt-md-1 mt-sm-1 mt-1">

				<ul class="navbar-nav ml-xl-auto ml-lg-auto ml-md-auto ml-sm-auto ml-auto">

					<li class="nav-item dropdown">

						<a class="nav-link" href="#" data-toggle="dropdown" id="navDrop">
							<img src="data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(0, 0, 0, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E" class="img-menu">
						</a>

						<div class="dropdown-menu">
							<a class="dropdown-item" href="index.html">Home</a>
							<a class="dropdown-item" href="cadastro_usuario.php">Cadastrar-se</a>
							<a class="dropdown-item" href="inicio/contact">Contato</a>
						</div>

					</li>

				</ul>

			</div>

			<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-7 offset-sm-2 text-center mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-3 text middle-index"> 
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
			<div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-3 mt-xl-4 mt-lg-4 mt-md-4 mt-sm-4 mt-3 offset-xl-1 offset-lg-1">

				<label class="text-white font-weight-bold arvores_aracatuba">Total de Árvores: <label class="text-danger"><?= $_SESSION['quantTotal'] ?></label></label>

			</div>
			
		</div>



		<!-- Formulario -->
		<form method="post">


			<div class="row">
				
				<!-- Leaves Effects -->
				<section id="leaves-section">

					<div class="set">
						<div class="div-leaves"><img src="img/leaves/leaves1.png" id="leaves-size1"></div>
						<div class="div-leaves"><img src="img/leaves/leaves2.png" id="leaves-size2"></div>
						<div class="div-leaves"><img src="img/leaves/leaves3.png" id="leaves-size3"></div>
						<div class="div-leaves"><img src="img/leaves/leaves4.png" id="leaves-size4"></div>
						<div class="div-leaves"><img src="img/leaves/leaves1.png" id="leaves-size1"></div>
						<div class="div-leaves"><img src="img/leaves/leaves2.png" id="leaves-size2"></div>
						<div class="div-leaves"><img src="img/leaves/leaves3.png" id="leaves-size3"></div>
						<div class="div-leaves"><img src="img/leaves/leaves4.png" id="leaves-size4"></div>
					</div>
					<div class="set set2">
						<div class="div-leaves"><img src="img/leaves/leaves1.png" id="leaves-size1"></div>
						<div class="div-leaves"><img src="img/leaves/leaves2.png" id="leaves-size2"></div>
						<div class="div-leaves"><img src="img/leaves/leaves3.png" id="leaves-size3"></div>
						<div class="div-leaves"><img src="img/leaves/leaves4.png" id="leaves-size4"></div>
						<div class="div-leaves"><img src="img/leaves/leaves1.png" id="leaves-size1"></div>
						<div class="div-leaves"><img src="img/leaves/leaves2.png" id="leaves-size2"></div>
						<div class="div-leaves"><img src="img/leaves/leaves3.png" id="leaves-size3"></div>
						<div class="div-leaves"><img src="img/leaves/leaves4.png" id="leaves-size4"></div>
					</div>
					<div class="set set3">
						<div class="div-leaves"><img src="img/leaves/leaves1.png" id="leaves-size1"></div>
						<div class="div-leaves"><img src="img/leaves/leaves2.png" id="leaves-size2"></div>
						<div class="div-leaves"><img src="img/leaves/leaves3.png" id="leaves-size3"></div>
						<div class="div-leaves"><img src="img/leaves/leaves4.png" id="leaves-size4"></div>
						<div class="div-leaves"><img src="img/leaves/leaves1.png" id="leaves-size1"></div>
						<div class="div-leaves"><img src="img/leaves/leaves2.png" id="leaves-size2"></div>
						<div class="div-leaves"><img src="img/leaves/leaves3.png" id="leaves-size3"></div>
						<div class="div-leaves"><img src="img/leaves/leaves4.png" id="leaves-size4"></div>
					</div>
				</section>

				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

					<div class="row">
						<!-- Imagem Logo -->
						<div class="col-xl-12 col-lg-12 col-md-12 col-12 mt-xl-5 mt-lg-5 mt-md-5 mt-sm-5 mt-5 mb-xl-2 mb-lg-2 mb-md-2 mb-sm-2 mb-2 text-center">
							<figure class="figure">
								<img src="img/Logo.jpg" class="figure-img img-fluid rounded" alt="Logo Arborizatuba">
								<figcaption class="figure-caption text-center">
									<?php if (isset($mensagem)): ?>
										<h5 class="alert alert-danger m-0"><?= $mensagem ?? NULL; ?></h5>
									<?php endif; ?>
								</figcaption>
							</figure>

						</div>

						<!-- Caixa de Texto Login -->
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

							<div class="form-group">				

								<div class="offset-xl-5 offset-lg-5 offset-md-4 offset-sm-4 offset-3 col-xl-2 col-lg-2 col-md-4 col-sm-4 col-6">
									<input type="text" name="usuario" class="form-control" placeholder="Usuario">
								</div>

							</div>

						</div>

						<!-- Caixa de Texto Senha -->

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

							<div class="form-group">

								<div class="offset-xl-5 offset-lg-5 offset-md-4 offset-sm-4 offset-3 col-xl-2 col-lg-2 col-md-4 col-sm-4 col-6">
									<input type="password" name="senha" class="form-control" placeholder="Senha">
								</div>

							</div>

						</div>

						<!-- Botão Entrar -->
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
							<input type="submit" value="Entrar" class="btn btn-primary">
						</div>		

					</div>

				</div>

			</div>

		</form>

		<!-- HOSTING -->

			<!-- <div class="row mt-md-5 mt-5">
			
				<div class="col-md-12 mt-md-4 mt-0 col-12"> 
					
					ADICIOAR ALGO COMO "HOSTEDADO:"
			
					<div class="col-md-12 col-12 text-center">
			
						<figure>
							<a href="https://infinityfree.net">
								<img src="img/hospeded.png" alt="Infinity Free">
							</a>
							<figcaption class="infinityfree mt-md-2 mt-0">© 2019 InfinityFree. All rights reserved.</figcaption>
						</figure>
			
					</div>
			
				</div> 
			
			</div> -->

		</main>

		<footer>
			<script src="js/jquery-3.4.1.slim.min.js"></script>
			<script src="js/popper.min.js"></script>
			<script src="js/bootstrap.min.js"></script>
		</footer>

	</body>
	</html>