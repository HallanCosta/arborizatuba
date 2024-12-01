<?php
header("Pragma: no-cache");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, cachehack=".time());
header("Cache-Control: no-store, must-revalidate");
header("Cache-Control: post-check=-1, pre-check=-1", false); 
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once('libary/libary.php');

try{
	$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?? 1;
	$perPage = filter_input(INPUT_GET, 'per-page', FILTER_VALIDATE_INT) && filter_input(INPUT_GET, 'per-page', FILTER_VALIDATE_INT) <= 50 ? filter_input(INPUT_GET, 'per-page', FILTER_VALIDATE_INT) : 10;

	if (isset($_SESSION['usuario']) && isset($_SESSION['id']) && $_SESSION['cargo'] == 0){

		$start = (($page > 1) ? ($page * $perPage) - $perPage : 0);
		
		$query = "SELECT * FROM validadas WHERE id_usuario = :id_usuario";
		$param = array(

			':id_usuario'	=>	$_SESSION['id']
		);
		$rows = DB::selectDB($query, $param, PDO::FETCH_OBJ);

		$pages = ceil(COUNT($rows)/$perPage);
		if (COUNT($rows) > 0) {
			$sql = "SELECT validadas.id, validadas.cep, validadas.tp_logradouro, validadas.logradouro, validadas.num, validadas.complemento, validadas.bairro, validadas.especie, validadas.porte, validadas.quant, conf_poda.estado, validadas.prox_poda, validadas.urlFoto FROM `validadas` INNER JOIN conf_poda ON 1 = 1 AND validadas.id = conf_poda.id_validadas AND id_usuario = {$_SESSION['id']} LIMIT {$start}, {$perPage}";
			$rows = DB::selectDB($sql, NULL, \PDO::FETCH_OBJ);

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
	<!-- <link rel="stylesheet" href="relatorio/bootstrap/css/3.3.7/bootstrap.min.css"> -->
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
							<a class="dropdown-item" href="inicio/contato.html">Sobre</a>
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
						<label class="text-cad">Atualizar dados da árvore</label>
					</div>						

				</div>
				
				<br>

				<div class="row">

					<div class="col-xl-12">

						<table class="table table-hover table-bordered table-responsive">
							
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
									<th>Status</th>
									<th>Proxima poda</th>
									<th>Foto</th>
									<th></th>
								</tr>
							</thead>

							<tbody>
								<?php foreach ($rows as $row): ?>
									<tr>
										<td><?= $row->id ?></td>
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

											if ($row->estado == 0) {
												echo $estado = "Poda não agendada";
											}elseif ($row->estado == 1) {
												echo $estado = "Poda agendada";
											}else{
												echo $estado = "Podada";
											}

											?>
											
										</td>


										
										<td>
											<?php
											$prox_poda = $row->prox_poda;
											echo $prox_poda = date("d/m/Y", strtotime($prox_poda)); 
											?>	
										</td>

										<td>
											<a href="<?=$row->urlFoto;?>?id_arvore=<?=$row->id;?>" target="_blank"  class="item-link">Link</a>

										</td>
										
										<td>

											
											

											<a href="alterar_arvore2.php?id_arvore=<?= $row->id ?>" class="btn btn-warning font-weight-bold">Editar</a>

											<!-- <a href="acao_podas.php?id_arvore=<?= $row->id ?>&prox_poda=<?= $row->prox_poda ?>" class="btn btn-success">Podar</a> -->
											
										</td>
									</tr>

								<?php endforeach; ?>
								
							</tbody>
							
						</table>



					</div>

				</div>



				<div class="row">
					
					<div class="col-xl-12 d-flex justify-content-center">

						<?php require_once 'relatorio/Template/Footer/Paginacao/paginacao.php' ?>

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