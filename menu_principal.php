<?php
session_start();
require_once('libary/libary.php');
if (!isset($_SESSION['cargo'])) {
	$message = '<script>';
	$message .= 'window.alert("É necessário fazer o login para acessar está pagína");';
	$message .= 'window.location.href="tela_login.php";';
	$message .= '</script>';
	print($message);
}

try{

	if (isset($_SESSION['usuario']) && isset($_SESSION['id'])){
		//Quantidade de arvore que o usuario tem
		$query = "SELECT SUM(quant) AS quantU FROM validadas, usuario WHERE usuario.id = validadas.id_usuario AND usuario.id = :id";
		$params = array(
			':id' => $_SESSION['id']
		);
		$rows = DB::selectDB($query, $params, \PDO::FETCH_OBJ);	
		$row =& $rows[0];
		$quantU = $row->quantU;

		$cargo = NULL;
		if (isset($_SESSION['cargo'])) {
			if ($_SESSION['cargo'] == 3) {
				$cargo = 3;//Administrador
			} elseif ($_SESSION['cargo'] == 2) {
				$cargo = 2;//Gerente
			} elseif ($_SESSION['cargo'] == 1) {
				$cargo = 1;//Funcionário
			} else{
				$cargo = 0;//Usuário
			}
		} else {
			print('<script>window.alert("É necessario fazer o login para acessar está pagina");window.location.href="tela_login.php";</script>');
		}
	}
}
catch(Exception $error){
	print('Error: ' . $error->getMessage());
}



?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
<head>
	<!-- Meta tags Obrigat&oacute;rias -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<title>AT - Tela principal</title>
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

							<!-- 0 - USUARIO, 1 - FUNCIONARIO, 2 - GERENTE, 3-ADMINISTRADOR -->
							<?php if ($_SESSION['cargo'] == 0): ?>
								<a class="dropdown-item" href="galeria_arvores_usuario.php">Galeria árvores</a>
								<a class="dropdown-item" href="cadastro_arvore.php">Cadastrar árvore</a>
								<a class="dropdown-item" href="alterar_arvore.php">Alterar cadastro</a>
							<?php endif; ?>

							<?php if (isset($_SESSION['cargo'])): ?>
								<?php if ($_SESSION['cargo'] == 1): ?>
									<a class="dropdown-item" href="podas.php">Podas</a>
								<?php endif; ?>
								<?php if ($_SESSION['cargo'] == 2 || $_SESSION['cargo'] == 3): ?>
									<a class="dropdown-item" href="cadastro_funcionario.php">Cadastro do Funcionário</a>
									<a class="dropdown-item" href="tabelas/lista_de_aprovacao_de_arvores/" target="_blank">Tabela de Validação das Árvores</a>
									<a class="dropdown-item" href="tabelas/lista_de_arvores_validadas/" target="_blank">Tabela de Árvores Validadas</a>
									<a class="dropdown-item" href="tabelas/lista_de_arvores_descartadas/" target="_blank">Tabela de Árvores Descartadas</a>
								<?php endif; ?>
							<?php endif; ?>
							<a class="dropdown-item" href="inicio/contato.html">Sobre</a>
						</div>
					</li>

				</ul>

			</div>

			<div class="text middle col-xl-7 col-lg-7 col-md-7 col-sm-8 col-8 text-center mt-xl-1 mt-lg-1 mt-md-1 mt-sm-2 mt-3">
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

		<!-- Navigation Menu -->
		<div class="row bg-black">


			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-9">

				<div class="row">

					<!-- Nome do usuario -->
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<label id="nomeU" class="float-left">Olá, <?= $_SESSION['nome']; ?></label>

					</div>

					<!-- Quantidade de arvores cadastradas pelo usuario -->
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<?php if ($_SESSION['cargo'] == 0): ?>
							<?php foreach ($rows as $row): ?>	
								<label id="nomeU" class="float-xl-right float-lg-right float-md-right float-sm-right float-left">Minhas árvores: <label class="text-danger"><?= $quantU ?></label></label>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>

				</div>


			</div>

		</div>


		<!-- Formulario -->
		<div class="row">

			<!-- Cadastrar -->
			<?php if ($cargo === 0): ?>
				<div class="d-xl-flex d-lg-flex d-md-flex d-sm-flex col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12 text-center mt-xl-3 mt-lg-3 mt-md-3 mt-sm-3 mt-3">			

					<!-- Cadastro -->
					<div class="mt-5 form-group">
						<a href='cadastro_arvore.php'>
							<img src='img/arvore.png' class='bg-white image-size border-3 border-success rounded-top rounded-bottom'>
						</a>
						<label class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_principal">Cadastrar árvore</label>
					</div>

					<!-- Alterar Cadastro -->
					<div class="mt-5 form-group">
						<a href="alterar_arvore.php">
							<img src="img/arvore.png" class="bg-white image-size border-3 border-success rounded-top rounded-bottom">
						</a>
						<label class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_principal">Alterar cadastro</label>
					</div>

					<!-- Sobre -->
					<div class="mt-5 form-group">
						<a href="inicio/contato.html">
							<img src="img/logo.jpg" class="image-size border-3 border-success rounded">
						</a>
						<label class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 text_principal">Sobre</label>	
					</div>
				</div>
			<?php endif; ?>

			<?php if ($cargo === 1): ?>
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 text-center mt-xl-3 mt-lg-3 mt-md-3 mt-sm-3 mt-3 offset-xl-4 offset-lg-4 offset-md-4">	
					<div class="mt-5 form-group">
						<a href='podas.php'>
							<img src='img/arvore.png' class='image-size border-3 border-success rounded-top rounded-bottom'>
						</a>
						<label class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_principal">Poda</label>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($cargo === 2): ?>
				<div class="d-xl-flex d-lg-flex d-md-flex d-sm-flex col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12 text-center mt-xl-3 mt-lg-3 mt-md-3 mt-sm-3 mt-3">			

					<!-- Cadastro -->
					<div class="mt-5 form-group">
						<a href="tabelas/lista_de_aprovacao_de_arvores/" target="_blank">
							<img src='img/arvore.png' class='bg-white image-size border-3 border-success rounded-top rounded-bottom'>
						</a>
						<label class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_principal">Validação de Árvores</label>
					</div>

					<!-- Alterar Cadastro -->
					<div class="mt-5 form-group">
						<a href="tabelas/lista_de_arvores_validadas/" target="_blank">
							<img src="img/arvore.png" class="bg-white image-size border-3 border-success rounded-top rounded-bottom">
						</a>
						<label class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_principal">Árvores Validadas</label>
					</div>

					<!-- Sobre -->
					<div class="mt-5 form-group">
						<a href="tabelas/lista_de_arvores_descartadas/" target="_blank">
							<img src="img/arvore.png" class="image-size border-3 border-success rounded">
						</a>
						<label class="col-xl-12 col-lg-4 col-md-12 col-sm-12 col-12 text_principal">Árvores Descartadas</label>	
					</div>
				</div>
			<?php endif; ?>
			<?php if ($cargo == 3): ?>
				<div class="d-xl-flex d-lg-flex d-md-flex d-sm-flex col-xl-12 col-lg-4 col-md-4 col-sm-12 col-12 text-center mt-xl-3 mt-lg-3 mt-md-3 mt-sm-3 mt-3">			

					<!-- Tabela de Validação de Árvores -->
					<div class="mt-5 form-group">
						<a href="tabelas/lista_de_aprovacao_de_arvores/" target="_blank">
							<img src='img/arvore.png' class='bg-white image-size border-3 border-success rounded-top rounded-bottom'>
						</a>
						<label class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_principal">Validação de Árvores</label>
					</div>

					<!-- Tabela de Valirdar Árvores -->
					<div class="mt-5 form-group">
						<a href="tabelas/lista_de_arvores_validadas/" target="_blank">
							<img src="img/arvore.png" class="bg-white image-size border-3 border-success rounded-top rounded-bottom">
						</a>
						<label class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_principal">Árvores Validadas</label>
					</div>

					<!-- Tabela de Descartar Árvores -->
					<div class="mt-5 form-group">
						<a href="tabelas/lista_de_arvores_descartadas/" target="_blank">
							<img src="img/arvore.png" class="image-size border-3 border-success rounded">
						</a>
						<label class="col-xl-12 col-lg-4 col-md-12 col-sm-12 col-12 text_principal">Árvores Descartadas</label>	
					</div>
				</div>
			<?php endif; ?>

		</div>



	</main>

	<script src="js/jquery-3.3.1.slim.min.js"></script>
	<script src="js/jquery-3.4.1.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</body>
</html>