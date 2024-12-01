<?php
	session_start();
	require_once('libary/libary.php');

	try{

		if (isset($_SESSION['usuario']) && isset($_SESSION['id'])){
			# Continue o codigo!
			
		}else{
			header("Location: index.php");
		}

	}
	catch(Exception $error){
		$mensagem = $error->getMessage();
		header('Location: index.php');
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
		<title>AT - Sobre</title>
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
								<?php if ($_SESSION['cargo'] == 0): ?>
									<a class="dropdown-item" href="cadastro_arvore.php">Cadastrar árvore</a>
									<a class="dropdown-item" href="alterar_arvore.php">Alterar cadastro</a>
									<a class="dropdown-item" href="sobre.php">Sobre</a>
								<?php endif; ?>
							</div>
		
						</li>
		
					</ul>
		
				</div>
	
				<div class="text middle col-xl-7 col-lg-7 col-md-7 col-sm-8 col-8 text-center mt-xl-1 mt-lg-1 mt-md-1 mt-sm-2 mt-2">
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

		
				<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 mt-xl-2 mt-lg-2 mt-md-2 mt-sm-2 mt-2 offset-xl-1 offset-lg-1 offset-md-1">
					
					<a href="logout.php" class="btn btn-danger float-right tamanho_btn_sair">Sair</a>
					
				</div>
		
			</div>

			<div class="row bg-gray">
				
				<div class="col-xl-6 offset-xl-3">
					
					<div class="row">
						
						<div class="col-xl-12 mt-xl-2 text-center">
							<img src="img/Logo.jpg" class="border-3 border-success rounded">
						</div>
						
						

						<div class="col-xl-12 mt-xl-3 border-3 rounded bg-white">
							<label class="label-control font-weight-bold mt-xl-2">Assunto:</label>
							<input type="text" class="form-control">

							<label class="label-control font-weight-bold rounded">Mensagem:</label><br>
							<textarea name="mensagem" cols="79" rows="5"></textarea><br>

							<input type="submit" class="btn-dark mb-xl-2">
						</div>

						<div class="col-xl-12 mt-xl-3 mb-xl-2 border bg-white rounded">				
							<h5>Desenvolvedores: </h5>
							<ul>
								<li>Hállan da Silva Costa</li>
								<li>Hállex da Silva Costa</li>
								<li>Rian Pablo Panini</li>
								<li>Juliana Batista Gonçalves</li>
							</ul>
							
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