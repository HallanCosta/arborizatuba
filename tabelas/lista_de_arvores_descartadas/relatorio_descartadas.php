<!DOCTYPE html>
<?php 
require_once '../class_static/conexao.class.php';
session_start();

if (isset($_SESSION['cargo'])) {
	if ($_SESSION['cargo'] == 1) {
		print('<script>window.alert("Você não tem acesso a essa página");window.location.href="../../menu_principal.php";</script>');
	} elseif ($_SESSION['cargo'] == 0) {
		if ($_SESSION['cargo']) {
			print('<script>window.alert("Você não tem acesso a essa página");window.location.href="../../menu_principal.php";</script>');
		}
	}
} else {
	print('<script>window.alert("Você não tem acesso a essa página");window.location.href="../../tela_login.php";</script>');
}

$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
$perPage = filter_input(INPUT_GET, 'perPage', FILTER_SANITIZE_NUMBER_INT) && filter_input(INPUT_GET, 'perPage', FILTER_SANITIZE_NUMBER_INT) <= 50 ? filter_input(INPUT_GET, 'perPage', FILTER_SANITIZE_NUMBER_INT) : 5;

if (!empty($page) && !empty($perPage)) {
	$start = $page > 1 ? ($page * $perPage) - $perPage : 0;
	$sql = "SELECT * FROM `descartadas` WHERE 1 = 1";
	$rows = DB::selectDB($sql, NULL, \PDO::FETCH_OBJ);
	$pages = ceil(COUNT($rows)/$perPage);
	if (COUNT($rows) > 0) {
		$sql = "SELECT * FROM `descartadas` WHERE 1 = 1 LIMIT {$start}, {$perPage}";
		$rows = DB::selectDB($sql, NULL, \PDO::FETCH_OBJ);
	}
} elseif ($page == 0) {
	header('Location: relatorio_validadas?page=1');
} else {
	exit();
}

if (filter_input(INPUT_POST, 'btnPesquisar')) {
	$txtPesquisa = '';
	if (filter_input(INPUT_POST, 'txtPesquisaCEP', FILTER_SANITIZE_STRING) && filter_input(INPUT_POST, 'txtPesquisaCEP', FILTER_SANITIZE_STRING) != '') {
		$txtPesquisa .= ' AND cep LIKE "%' . filter_input(INPUT_POST, 'txtPesquisaCEP', FILTER_SANITIZE_STRING) . '%" ';
	}
	if (filter_input(INPUT_POST, 'txtPesquisaEndereco', FILTER_SANITIZE_STRING) && filter_input(INPUT_POST, 'txtPesquisaEndereco', FILTER_SANITIZE_STRING) != '') {
		$txtPesquisa .= ' AND logradouro LIKE "%' . filter_input(INPUT_POST, 'txtPesquisaEndereco', FILTER_SANITIZE_STRING) . '%" ';
	}
	if (filter_input(INPUT_POST, 'txtPesquisaBairro', FILTER_SANITIZE_STRING) && filter_input(INPUT_POST, 'txtPesquisaBairro', FILTER_SANITIZE_STRING) != '') {
		$txtPesquisa .= ' AND bairro LIKE "%' . filter_input(INPUT_POST, 'txtPesquisaBairro', FILTER_SANITIZE_STRING) . '%" ';
	}
	$sql = "SELECT * FROM `descartadas` WHERE 1 = 1 " . $txtPesquisa;
	$rows = DB::selectDB($sql, NULL, \PDO::FETCH_OBJ);
	if (COUNT($rows) > 0) {
		$msg = 1;//Sucesso na Pesquisa
	} else {
		$msg = -1;//Não foi possivel entroncar este registro na pesquisa, Nada Encontrado
	}

	switch ($msg) {
		case 1:
		$sql = "SELECT SUM(quant) AS totalArvoresTabela FROM `descartadas` WHERE 1 = 1";
		$resultTable = DB::selectDB($sql, NULL, \PDO::FETCH_OBJ);
		if (COUNT($resultTable) > 0) {
			$row = $resultTable[0];
			$totalArvoresTabela = $row->totalArvoresTabela;
		}

		$sql = "SELECT SUM(quant) AS totalArvoresPesquisa FROM `descartadas` WHERE 1 = 1" . $txtPesquisa;
		$resultSearch = DB::selectDB($sql, NULL, \PDO::FETCH_OBJ);
		if (COUNT($resultSearch) > 0) {
			$row = $resultSearch[0];
			$totalArvoresPesquisa = $row->totalArvoresPesquisa;
		}
		unset($_POST['btnPesquisar']);
		unset($_POST['txtPesquisaCEP']);
		unset($_POST['txtPesquisaEndereco']);
		unset($_POST['txtPesquisaBairro']);	
		unset($msg);
		break;
		case -1:
		$errorMsg = 'Nada Encontrado';
		unset($msg);
		break;
		default:
		# code...
		break;
	}
}

?>
<html lang="pt-br" dir="ltr">
<head>
	<meta charset="UTF8">
	<?php require_once '../Template/Head/Title/titulo.html'; ?>
	<link rel="stylesheet" href="../bootstrap/css/4.3.1/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<script type="text/javascript" src="../jQuery/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="../jQuery/jquery-1.14.10.mask.min.js"></script>
	<script type="text/javascript" src="../js/script.js"></script>
	<script type="text/javascript" src="../js/script.js"></script>
</head>
<body>
	<div class="container-fluid">
		<div class="row position-relative mt-3" style="/*margin: 70px;*/">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<center><h1>Lista de Arvores Descartadas</h1></center>
				<button class="btn btn-info float-left hidden-print" onclick="voltar_menu_principal()">Menu Principal</button>
				<button class="btn btn-secondary float-right hidden-print" onclick="print()">Print</button>
				<hr><br>
			</div>

			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<?php if (isset($errorMsg)): ?>
					<div class="alert alert-warning">
						<span class="text-center">
							<h3><?=$errorMsg;unset($errorMsg);?></h3>
						</span>
					</div>
				<?php endif; ?>
				<?php if (isset($totalArvoresTabela)): ?>
					<div class="alert alert-info">
						<span class="text-left">
							<h3>Total de Arvores Registradas: <?=$totalArvoresTabela;unset($totalArvoresTabela);?></h3>
						</span>
					</div>
				<?php endif; ?>
				<?php if (isset($totalArvoresPesquisa)): ?>
					<div class="alert alert-warning">
						<span class="text-left">
							<h3>Total de Arvores da Pesquisa: <?=$totalArvoresPesquisa;unset($totalArvoresPesquisa);?></h3>
						</span>
					</div>
				<?php endif; ?>
			</div>
			
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 hidden-print">
				<div class="form">
					<form action="#" method="POST">
						<div class="form-group">
							<div class="card">
								<div class="card-header">
									<label for=""><h2 class="font-weight-bold">Pesquisa</h2></label>
								</div>
								<div class="card-body">
									<div class="form-row">
										<div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12">
											<div class="form-group">
												<label class="card-title font-weight-bold">CEP</label>
												<input type="text" onkeydown="$(this).mask('00000-000', {reverse: false})" placeholder="Pesquisa por CEP" name="txtPesquisaCEP" id="txtPesquisaCEP" value="<?=filter_input(INPUT_POST, 'txtPesquisaCEP', FILTER_SANITIZE_STRING)?filter_input(INPUT_POST, 'txtPesquisaCEP', FILTER_SANITIZE_STRING):'';?>" class="form-control">&nbsp;
											</div>
										</div>
										<div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12">
											<div class="form-group">
												<label for="" class="card-title font-weight-bold">Endereco</label>
												<input type="text" placeholder="Pesquisa por Endereco" name="txtPesquisaEndereco" id="txtPesquisaEndereco" value="<?=filter_input(INPUT_POST, 'txtPesquisaEndereco', FILTER_SANITIZE_STRING)?filter_input(INPUT_POST, 'txtPesquisaEndereco', FILTER_SANITIZE_STRING):'';?>" class="form-control">&nbsp;
											</div>
										</div>
										<div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12">
											<div class="form-group">
												<label for="" class="card-title font-weight-bold">Bairro</label>
												<input type="text" placeholder="Pesquisa por Bairro" name="txtPesquisaBairro" id="txtPesquisaBairro" value="<?=filter_input(INPUT_POST, 'txtPesquisaBairro', FILTER_SANITIZE_STRING)?filter_input(INPUT_POST, 'txtPesquisaBairro', FILTER_SANITIZE_STRING):'';?>" class="form-control">&nbsp;
											</div>
										</div>
									</div>
								</div>
								<div class="card-footer">
									<div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group">
											<input type="submit" name="btnPesquisar" id="btnPesquisar" class="btn btn-primary" value="Pesquisar">&nbsp;
											<a href="<?=$_SERVER['PHP_SELF'];?>" class="btn btn-danger">Limpar</a>
										</div>
									</div>
									<div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
										<blockquote class="card-blockquote">
											<footer class="blockquote-footer float-right"><cite title="" class="text-gray-dark"><?=DateTime::createFromFormat('Y-m-d', date('Y-m-d'))->format('d/m/Y')?></cite></footer>
										</blockquote>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="mt-3 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<div class="d-print-table table-responsive table-responsive-sm table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl">
					<table class="table table-hover table-bordered table">
						<thead class="thead thead-dark">
							<tr>
								<?php require_once '../Template/Body/Colunas/colunas.html'; ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($rows as $key => &$value): ?>
								<tr>
									<?php require '../Template/Body/Relatorio/relatorio.php'; ?>
									<?php if ($_SESSION['cargo'] == 2): ?>
										<td class="hidden-print"><a href="validar_arvore.php?id_arvore=<?=$value->id;?>&id_usuario=<?=$value->id_usuario;?>" class="btn btn-success pull-right">Validar</a></td>
									<?php endif; ?>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<?php if (!filter_input(INPUT_POST, 'btnPesquisar', FILTER_SANITIZE_STRING)): ?>
					<div class="col mt-5 mt-sm-5 mt-md-5 mt-lg-5 mt-xl-5 hidden-print">
						<?php require_once '../Template/Footer/Paginacao/paginacao.php'; ?>
					</div>
				<?php endif; ?>
			</div> 
		</div>
	</div>
</body>
</html>