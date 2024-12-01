<?php
session_start();
require_once('libary/libary.php');

try{
	$page = $_GET['page'] ?? 1;
	$perPage = isset($_GET['per-page']) && $_GET['per-page'] <= 50 ? $_GET['per-page'] : 5;

	if (isset($_SESSION['usuario']) && isset($_SESSION['id'])){
		$start = $page > 1 ? $page * $perPage - $perPage : 0; 

		$query = "SELECT urlFoto, especie FROM validadas WHERE 1 = 1 AND id_usuario = :id_usuario";
		$param = array(
			':id_usuario'	=>	$_SESSION['id']
		);
		$rows = DB::selectDB($query, $param, PDO::FETCH_OBJ);
		$pages = ceil(COUNT($rows)/$perPage);
		if (COUNT($rows) > 0) {
			$query = "SELECT * FROM `validadas` WHERE 1 = 1 AND id_usuario = :id_usuario LIMIT {$start}, {$perPage}";
			$param = array(
				':id_usuario'	=>	$_SESSION['id']
			);
			$rows = DB::selectDB($query, $param, \PDO::FETCH_OBJ);
		}
		

	}else{
		header("Location: tela_login.php");
	}



}
catch(Exception $error){
	$mensagem = $error->getMessage();
		//header('Location: index.html');
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
	<title>AT - Minhas árvores</title>
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
								<a class="dropdown-item" href="menu_principal.php">Menu principal</a>
							<?php endif ?>

							<?php if ($_SESSION['cargo'] == 0): ?>
								<a class="dropdown-item" href="cadastro_arvore.php">Cadastrar árvore</a>
							<?php endif ?>
							
							<?php if (isset($_SESSION['cargo'])): ?>
								<?php if ($_SESSION['cargo'] == 2 || $_SESSION['cargo'] == 3): ?>
									<a class="dropdown-item" href="cadastro_funcionario.php">Cadastro funcionario</a>
								<?php endif ?>
							<?php endif ?>

							<?php if (isset($_SESSION['cargo'])): ?>
								<?php if ($_SESSION['cargo'] == 1): ?>
									<a class="dropdown-item" href="podas.php">Podas</a>
								<?php endif ?>
							<?php endif ?>

							<?php if ($_SESSION['cargo'] == 0): ?>	
								<a class="dropdown-item" href="alterar_arvore.php">Alterar cadastro</a>
							<?php endif ?>
							<a class="dropdown-item" href="sobre.php">Sobre</a>
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
		<div class="container">
			<div class="row">
				<?php foreach ($rows as $row): ?>
					<div class="col-xl-4 mt-3 text-center">
						<h4 class=""><?= $row->especie ?></h4>
						<a href="<?=  $row->urlFoto; ?>" target="_blank"><img style="widht: 358px; height: 201.25px;" class="rounded w-100" src="<?=  $row->urlFoto; ?>" alt="Imagem: <?= $row->especie ?>"/></a>	
					</div>
				<?php endforeach; ?><!-- 
				<div class="col-xl-4 mt-3 form-inline">
					<h4><?= $row->especie ?></h4>
					<a href="http://localhost/Arborizatuba(com%20botoes%20validadas)/arvores/hallex/fotos_validadas/8e4c5e7ca85e618f2afd2dd409a87f3d.png"><img class="img-fluid img-thumbnail rounded" src="<?=  $row->urlFoto; ?>"/></a>		
				</div>
				<div class="col-xl-4 mt-3 form-inline">
					<h4><?= $row->especie ?></h4>
					<a href="http://localhost/Arborizatuba(com%20botoes%20validadas)/arvores/hallex/fotos_validadas/8e4c5e7ca85e618f2afd2dd409a87f3d.png"><img class="img-fluid img-thumbnail rounded" src="<?=  $row->urlFoto; ?>"/></a>		
				</div> -->
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-5">
				<?php require_once 'tabelas/Template/Footer/Paginacao/paginacao.php'; ?>
			</div>
		</div>
	</main>

	<script src="js/jquery-3.3.1.slim.min.js"></script>
	<script src="js/jquery-3.4.1.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</body>
</html>