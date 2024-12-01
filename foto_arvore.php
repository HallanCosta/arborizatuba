<?php
session_start();
require_once('libary/libary.php');

try{

	if (isset($_SESSION['usuario']) && isset($_SESSION['id'])){

		$query = "SELECT validadas.id, validadas.cep, validadas.tp_logradouro, validadas.logradouro, validadas.num, validadas.complemento, validadas.bairro, validadas.especie, validadas.porte, validadas.quant, conf_poda.estado, validadas.ult_poda, validadas.prox_poda, validadas.urlFoto FROM `validadas` INNER JOIN conf_poda ON 1 = 1 AND validadas.id = :id_arvore AND id_usuario = :id_usuario";
		
			//$query = "SELECT * FROM validadas WHERE id_usuario = :id_usuario AND id = :id_arvore";
		$params = array(
			':id_usuario'	=>	$_SESSION['id'],
			':id_arvore'	=>	$_GET['id_arvore']
		);
		$rows = DB::selectDB($query, $params, PDO::FETCH_OBJ);
		$count = count($rows);
		$row =& $rows[0];

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

							<?php if ($_SESSION['cargo']) == 0: ?>	
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
	<div class="row bg-success">

		<?php if ($count > 0) :
			$urlFoto = $row->urlFoto;
			$imagens = glob($urlFoto, GLOB_BRACE);
					//$imagem =& $imagens[0];
					//var_dump($imagens);
			?>
			<?php foreach ($imagens as $imagem): ?> 
				<div class="col-xl-12">
					<div class="row"><div class="col-xl-12"><h1 class="text-center font-weight-bold">.::Árvore - <?= $row->especie ?>::.</h1></div></div>
					<div class="card mb-2">
						<div class="row no-gutters">
							<div class="col-xl-4">
								<a href=""><img class="card-img" src="<?=  $imagem; ?>"/></a>	
							</div>
							<div class="col-xl-6 offset-xl-2">
								<div class="card-body">
									<table class="table table-responsive">
										<thead>
											<th><h1 class="text-center">Dados da árvore</h1></th>
										</thead>
										<tbody>
											<tr><td><h5>CEP: <?= $row->cep; ?></h5></td></tr>
											<tr><td><h5>Tipo de Logradouro: <?= $row->tp_logradouro; ?></h5></td></tr>
											<tr><td><h5>Logradouro: <?= $row->logradouro; ?></h5></td></tr>
											<tr><td><h5>Numero: <?= $row->num; ?></h5></td></tr>
											<tr><td><h5>Complemento: <?= $row->complemento; ?></h5></td></tr>
											<tr><td><h5>Bairro: <?= $row->bairro; ?></h5></td></tr>
											<tr><td><h5>Espécie: <?= $row->especie; ?></h5></td></tr>
											<tr><td><h5>Quantidade: <?= $row->porte; ?></h5></td></tr>
											<tr><td><h5>Status: <?php
											if ($row->estado == 0) {
												echo $estado = "Poda não agendada";
											}elseif ($row->estado == 1) {
												echo $estado = "Poda agendada";
											}else{
												echo $estado = "Podada";
											}
											?></h5></td></tr>
											<tr><td><h5>Data da última poda: <?= $row->ult_poda; ?></h5></td></tr>
											<tr><td><h5>Data da próxima poda: <?= $row->prox_poda; ?></h5></td></tr>
											<tr><td><p><small class="text-muted"><a href="alterar_arvore.php">Voltar - Tela atualizar árvore</a></small></p></td></tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</main>

<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/jquery-3.4.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>