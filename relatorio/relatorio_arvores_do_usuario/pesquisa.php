<!DOCTYPE html>
<?php 
require_once '../class_static/conexao.class.php';

$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?? 1;
$perPage = filter_input(INPUT_GET, 'per-page', FILTER_VALIDATE_INT) && filter_input(INPUT_GET, 'per-page', FILTER_VALIDATE_INT) <= 50 ? filter_input(INPUT_GET, 'per-page', FILTER_VALIDATE_INT) : 5;
$txtPesquisa = '%' . filter_input(INPUT_POST, 'txtPesquisa', FILTER_SANITIZE_SPECIAL_CHARS) . '%';
//$txtPesquisa = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);

if (!empty($page) && !empty($perPage)) {
	$start = (($page > 1) ? ($page * $perPage) - $perPage : 0);
	if (!empty($txtPesquisa)) {
		$sql = "SELECT SUM(quant) AS quantTotal FROM `validadas` WHERE 1 = 1";
		$rows = DB::selectDB($sql, NULL, \PDO::FETCH_OBJ);
		if (COUNT($rows) > 0) {
			$row =& $rows[0];
			$totalTableTree = $row->quantTotal;
			
			$sql = "SELECT * FROM `validadas` WHERE 1 = 1 LIMIT {$start}, {$perPage}";
			$rows = DB::selectDB($sql, NULL, \PDO::FETCH_OBJ); 
			$pages = ceil(COUNT($rows)/$perPage);
			if (COUNT($rows) > 0) {
				//IMPRIME O RELATARIO DE TODOS OS REGISTROS;
				$sql = "SELECT * FROM `validadas` WHERE 1 = 1";
				$rows = DB::selectDB($sql, NULL, \PDO::FETCH_OBJ);
				if (!empty($txtPesquisa)) {
					$sql = "SELECT SUM(quant) AS quantTotal FROM `validadas` WHERE 1 = 1 AND logradouro LIKE :pesquisa OR bairro LIKE :pesquisa";
					$param = array(
						':pesquisa' => (String)$txtPesquisa
					);
					$rows = DB::selectDB($sql, $param, \PDO::FETCH_OBJ);
					if (COUNT($rows) > 0) {
						$row =& $rows[0];
						$totalSearchTree = $row->quantTotal;
					} else {
						$totalSearchTree = NULL;
					}
					//PUXA OS DADOS DA ARVORE PESQUISADA
					$sql = "SELECT * FROM `validadas` WHERE 1 = 1 AND logradouro LIKE :pesquisa OR bairro LIKE :pesquisa";
					$param = array(
						':pesquisa' => (String)$txtPesquisa
					);
					$rows = DB::selectDB($sql, $param, \PDO::FETCH_OBJ);
					unset($_POST['pesquisa']);
					unset($pages);
					//print_r($rows);
					if (COUNT($rows) < 1) {
						$msg = -1;//Nada Encontrado
					}
					//$pages = ceil(COUNT($rows)/$perPage);
					//print('<pre>');
						//print_r($rows);
					//print('</pre>');
				}
			}
			
		}
	} else {
		exit();
	}
}
if (isset($msg)) {
	switch ($msg) {
		case -1:
			$msg = 'Nada Encontrado';
		break;
		default:
			$msg = NULL;
		break;
	}
}

?>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<?php require_once '../Template/Head/Title/titulo.html'; ?>
</head>
<body>
	<div class="container">
		<center><h1> Pesquisa de Arvores </h1></center>
		<div class="row" style="margin-top: 70px;">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-11">
				<button type="button" class="btn btn-default pull-right" name="button" onclick="print()">Print</button>
				<?php if (empty($msg)): ?>
					<a href="index.php" class="btn btn-warning pull-left">Voltar</a>
				<?php endif; ?>
			</div>
			<div class="col-xl-1 col-lg-12 col-md-12 col-sm-12 col-xs-11">
				<table class="table">
					
					<?php if (isset($totalTableTree)): ?>
						<?php if (!empty($totalTableTree)): ?>
							<span>
								<h3 class="alert alert-info">Total de Arvores Dentro da Tabela: <?= $totalTableTree ?></h3>
							</span>
						<?php endif; ?>
					<?php endif; ?>
					<?php if (isset($totalSearchTree)): ?>
						<?php if (!empty($totalSearchTree)): ?>
							<span>
								<h3 class="alert alert-success">Total de Arvores Encontrada na Pesquisa: <?= $totalSearchTree ?></h3>
							</span>
						<?php endif; ?>
					<?php endif; ?>
					<hr>
				</table>

				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-11 form-group">
					<form action="pesquisa.php" method="POST">
						<input type="text" placeholder="Pesquisar" name="txtPesquisa" class="form-control input-lg">
					</form>
				</div>
				
				<?php if (COUNT($rows) > 0): ?>
					<table class="table table-hover">
						<thead>
							<tr>
								<?php require_once '../Template/Body/Colunas/colunas.html'; ?>
							</tr>
						</thead>

						<tbody>
							<?php foreach ($rows as $key => $value): ?>
								<tr>
									<?php require '../Template/Body/Relatorio/relatorio.php';  ?>
								</tr>
							<?php endforeach; ?>
						</tbody>

					</table>
					<?php else: ?>
						<h2 class="text-center text-danger"><?= $msg ?></h2>
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-11">
							<a href="index.php" class="btn btn-warning">Voltar</a>
						</div>
					<?php endif; ?>
					<?php 
					if (isset($pages)):
						require_once '../Template/Footer/Paginacao/paginacao.php';
					endif;
					?>
				</div>
			</div>
		</body>
		</html>