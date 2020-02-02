<!DOCTYPE html>
<?php 
require_once '../class_static/conexao.class.php';

$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?? 1;
$perPage = filter_input(INPUT_GET, 'per-page', FILTER_VALIDATE_INT) && filter_input(INPUT_GET, 'per-page', FILTER_VALIDATE_INT) <= 50 ? filter_input(INPUT_GET, 'per-page', FILTER_VALIDATE_INT) : 5;

if (!empty($page) && !empty($perPage)) {
	$start = (($page > 1) ? ($page * $perPage) - $perPage : 0);

	$sql = "SELECT * FROM `validacao` WHERE 1 = 1"; 
	$rows = DB::selectDB($sql, NULL, \PDO::FETCH_OBJ);
	$pages = ceil(COUNT($rows)/$perPage);

	if (COUNT($rows) > 0) {
		$sql = "SELECT * FROM `validacao` WHERE 1 = 1 LIMIT {$start}, {$perPage}";
		$rows = DB::selectDB($sql, NULL, \PDO::FETCH_OBJ);
	}
} elseif ($page === 0) {
	header('location: index.php?page=1');
} else {
	exit();
}

?>

<html lang="pt-br" dir="ltr">
<head>
	<meta charset="utf-8">
	<!-- <link rel="stylesheet" href="../bootstrap/css/4.3.1/bootstrap.min.css"> -->
	<link rel="stylesheet" href="../bootstrap/css/3.3.7/bootstrap.min.css">
	<?php require_once '../Template/Head/Title/titulo.html' ?>
</head>
<body>
	<div class="container">
		<div class="row" style="margin-top: 70px;">
			<center><h1> Lista de Aprovação de Arvores </h1></center>
			<div class="col-md-12">
				<!-- <form action="truncate.php" method="post">
					<input type="submit" class="btn btn-light" name="truncate2" value="Empty Database">
				</form> -->
				<button type="button" class="btn btn-default pull-right" onclick="print()" name="button">Print</button>
				<hr><br  />
			</div>

			<!-- <div class="col-md-12 text-center">
				<form action="search2.php" method="post" class="form-group">
					<input type="text" placeholder="Search" name="search" class="form-control">
				</form>
			</div> -->

			<table class="table table-hover">
				<thead>
					<tr>
						<?php require '../Template/Body/Colunas/colunas.html'; ?>
					</tr>
				</thead>

				<tbody>
					<?php if (!empty($rows)): ?>
						<?php foreach ($rows as $row => &$value): ?>
							<tr>
								<?php require '../Template/Body/Relatorio/relatorio.php'; ?>
								<td class="col-md-1"><a href="validar_arvore.php?id_arvore=<?= $value->id ?>&id_usuario=<?= $value->id_usuario ?>" class="btn btn-success pull-right">Validar</a></td>
								
								<td class="col-md-1"><a href="descartar_arvore.php?id_arvore=<?= $value->id ?>&id_usuario=<?= $value->id_usuario ?>" class="btn btn-danger">Descartar</a></td>
							</tr>
						<?php endforeach; ?>
					<?php endif ?>
				</tbody>
			</table>

			<?php require_once '../Template/Footer/Paginacao/paginacao.php' ?>

		</div>
	</div>
</body>
</html>
