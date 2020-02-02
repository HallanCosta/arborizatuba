<!DOCTYPE html>
<?php
require_once '../class_static/conexao.class.php';
$id_arvore = filter_input(INPUT_GET, 'id_arvore', FILTER_VALIDATE_INT);
$id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_VALIDATE_INT);
$msg = NULL;

if (!empty($id_arvore) && !empty($id_usuario)) {
	$sql = "SELECT * FROM validadas WHERE 1 = 1 AND id = :id_arvore AND id_usuario = :id_usuario";
	$param = array(
		':id_arvore' => (Integer)$id_arvore,
		':id_usuario' => (Integer)$id_usuario
	);
	$rows = DB::selectDB($sql, $param, PDO::FETCH_OBJ);
	var_dump($rows);
	$row =& $rows;

}
if(isset($_REQUEST['atualizar_dados']) && COUNT($row) > 0){
	if (strlen(filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING)) === 9 && strpos(filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING), '-')) {
		$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
		if (strlen(filter_input(INPUT_POST, 'tp_logradouro', FILTER_SANITIZE_STRING)) <= 8) {
			$tp_logradouro = filter_input(INPUT_POST, 'tp_logradouro', FILTER_SANITIZE_STRING);
			if (strlen(filter_input(INPUT_POST, 'logradouro', FILTER_SANITIZE_STRING)) <= 100) {
				$logradouro = filter_input(INPUT_POST, 'logradouro', FILTER_SANITIZE_STRING);
				if (strlen(filter_input(INPUT_POST, 'num', FILTER_SANITIZE_STRING)) <= 4) {
					$numero = filter_input(INPUT_POST, 'num', FILTER_SANITIZE_NUMBER_INT);
					if (strlen(filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING)) <= 6) {
						$complemento = filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING);
						if (strlen(filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING)) <= 30) {
							$bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
							if (strlen(filter_input(INPUT_POST, 'especie', FILTER_SANITIZE_STRING)) <= 35) {
								$especie = filter_input(INPUT_POST, 'especie', FILTER_SANITIZE_STRING);
								switch (filter_input(INPUT_POST, 'porte', FILTER_VALIDATE_INT)) {
									case 1:
									$porte = "Pequeno";
									break;
									case 2:
									$porte = "Medio";
									break;
									case 3:
									$porte = "Grande";
									break;
									default:
									$porte = NULL;
									break;
								}
								if (strlen(filter_input(INPUT_POST, 'quant', FILTER_SANITIZE_NUMBER_INT)) <= 11) {
									$quantidade = filter_input(INPUT_POST, 'quant', FILTER_SANITIZE_NUMBER_INT);
									if (strlen(filter_input(INPUT_POST, 'ultima_poda', FILTER_SANITIZE_STRING)) <= 10) {
										$ultima_poda = filter_input(INPUT_POST, 'ultima_poda', FILTER_SANITIZE_NUMBER_INT);
										if (strlen(filter_input(INPUT_POST, 'proxima_poda', FILTER_SANITIZE_STRING)) <= 10) {
											$proxima_poda = filter_input(INPUT_POST, 'proxima_poda', FILTER_SANITIZE_STRING);
											$msg = 1;
										} else {
												$msg = -10;//Proxima Poda invalido
											}
										} else {
											$msg = -9;//Ultima Poda invalido
										}
									} else {
										$msg = -8;//Quantidade invalido
									}
								} else {
									$msg = -7;//Especie invalido
								}							
							} else {
								$msg = -6;//Bairro invalido
							}
						} else {
							$msg = -5;//Número do Complemento invalido
						}
					} else {
						$msg = -4;//Número da Rua invalido
					}
				} else {
					$msg = -3;//Logradouro invalido
				}
			} else {
				$msg = -2;//Tipo de Logradouro invalido
			}
		} else {
			$msg = -1;	//CEP Invalido
		}
	}

	switch ($msg) {
		case 1:
		$sql = "UPDATE `validadas`
		SET cep = :cep,
		tp_logradouro = :tp_logradouro,
		logradouro = :logradouro,
		num = :numero,
		complemento = :complemento,
		bairro = :bairro,
		especie = :especie,
		porte = :porte,
		quant = :quantidade,
		ult_poda = :ultima_poda,
		prox_poda = :proxima_poda 
		WHERE 1 = 1 AND id = :id_arvore AND id_usuario = :id_usuario";
		$params = array(
			':id_arvore' => (Integer)$id_arvore,
			':id_usuario' => (Integer)$id_usuario,
			':cep' => (String)$cep,
			':tp_logradouro' => (String)$tp_logradouro,
			':logradouro' => (String)$logradouro,
			':bairro' => (String)$bairro,
			':numero' => (Integer)$numero,
			':complemento' => (String)$complemento,
			':especie' => (String)$especie,
			':porte' => (String)$porte,
			':quantidade' => (Integer)$quantidade,
			':ultima_poda' => (String)$ultima_poda,
			':proxima_poda' => (String)$proxima_poda
		);
		$affectedRow = DB::updateDB($sql, $params);
		if ($affectedRow > 0) {
			print("
				<script>
				window.alert('Dados atualizados com sucesso')
				window.location.href = 'relatorio_do_usuario.php?page=1'
				</script>
				");
		} else {
			print('<div class="alert alert-warning">
				<h4>Atenção</h4>
				É necessario que alterar algum campo para fazer a atualização dos dados da Arvore.<br>
				(Caso queira voltar para a pagina de Tabela de Arvores clique no botão <strong>voltar</strong> no fim do formulario)
				</div>
				');
		}
		break;
		case -1:
		print('<div class="alert alert-warning">
			<h4>Atenção</h4>
			CEP Invalido!
			</div>
			');
		break;
		case -2:
		print('<div class="alert alert-warning">
			<h4>Atenção</h4>
			Tipo de Logradouro Invalido, o Complemento deve conter no maximo 8 caracteres
			</div>
			');
		break;
		case -3:
		print('<div class="alert alert-warning">
			<h4>Atenção</h4>
			Logradouro Invalido, o Logradouro deve conter no maximo 100 caracteres
			</div>
			');
		break;
		case -4:
		print('<div class="alert alert-warning">
			<h4>Atenção</h4>
			Número da Rua Invalido, o Número da Rua deve conter no maximo 4 caracteres.
			</div>
			');
		break;
		case -5:
		print('<div class="alert alert-warning">
			<h4>Atenção</h4>
			Complemento Invalido, o Complemento deve conter no maximo 6 caracteres.
			</div>
			');
		break;
		case -6:
		print('<div class="alert alert-warning">
			<h4>Atenção</h4>
			Bairro Invalido, o Bairro deve conter no maximo 30 caracteres
			</div>
			');
		break;
		case -7:
		print('<div class="alert alert-warning">
			<h4>Atenção</h4>
			Especie Invalida, o Especie deve conter no maximo 35 caracteres
			</div>
			');
		break;
		case -8:
		print('<div class="alert alert-warning">
			<h4>Atenção</h4>
			Quantidade Invalida, o Complemento deve conter no maximo 7 caracteres
			</div>
			');
		break;
		case -9:
		print('<div class="alert alert-warning">
			<h4>Atenção</h4>
			Data Invalido! (Ultima Poda)
			</div>
			');
		break;
		case -10:
		print('<div class="alert alert-warning">
			<h4>Atenção</h4>
			Data Invalido! (Proxima Poda)
			</div>
			');
		break;
		default:
		$msg = NULL;
		break;
	}

	?>
	<html lang="pt-br" ltr="dir">
	<head>
		<meta charset="UTF-8">
		<?php require_once '../Template/Head/Title/titulo.html'; ?>
		<link rel="stylesheet" href="../bootstrap/css/4.3.1/bootstrap.min.css">
		<script type="text/javascript" src="../jqeury/jqeury-3.4.1.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="form-row position-relative mt-3">
				<div class="col-xl-12">
					<center><h1> Atualizar Cadastro da Arvore </h1></center>
				</div>
				<hr><br>
				<div class="offset-2 col-xl-7 mt-5">
					<h3>*  - Campos Obrigatorios</h3>
				</div>
				<div class="offset-2 col-xl-7">
					<form method="POST">
						<?php foreach ($rows as $row): ?>
							<div class="form-group">
								<label for=""><strong>*</strong>CEP: </label>
								<input type="text" tabindex="1" required name="cep" value="<?= $row->cep ?>" class="form-control" maxlength="9">
							</div>
							<div class="form-group">
								<label for=""><strong>*</strong>Tipo de Logradouro: </label>
								<input type="text" tabindex="1" required name="tp_logradouro" value="<?= $row->tp_logradouro ?>" class="form-control" maxlength="8">
							</div>
							<div class="form-group">
								<label for=""><strong>*</strong>Logradouro: </label>
								<input type="text" tabindex="1" required name="logradouro" value="<?= $row->logradouro ?>" class="form-control" maxlength="100">
							</div>
							<div class="form-group">
								<label for=""><strong>*</strong>Número da Rua: </label>
								<input type="text" tabindex="1" required name="num" value="<?= $row->num ?>" class="form-control" maxlength="4">
							</div>
							<div class="form-group">
								<label for=""><strong>*</strong>Complemento: </label>
								<input type="text" tabindex="1" required name="complemento" value="<?= $row->complemento ?>" class="form-control" maxlenght="6">
							</div>
							<div class="form-group">
								<label for=""><strong>*</strong>Bairro: </label>
								<input type="text" tabindex="1" required name="bairro" value="<?= $row->bairro ?>" class="form-control" maxlength="30">
							</div>
							<div class="form-group">
								<label for=""><strong>*</strong>Especie: </label>
								<input type="text" tabindex="1" required name="especie" value="<?= $row->especie ?>" class="form-control" maxlength="35">
							</div>
							<div class="form-group">
								<label for=""><strong>*</strong>Porte: </label>
								<select name="porte" class="form-control">
									<optgroup label="Selecione o Porte da Arvore"></optgroup>
									<option value="1">Pequeno</option>
									<option value="2">Medio</option>
									<option value="3">Grande</option>
								</select>
							</div>
							<div class="form-group">
								<label for=""><strong>*</strong>Quantidade: </label>
								<input type="text" tabindex="1" required name="quant" value="<?= $row->quant ?>" class="form-control" maxlength="11">
							</div>
							<div class="form-group">
								<label for=""><strong>*</strong>Ultima Poda: </label>
								<input type="date" tabindex="1" required name="ultima_poda" value="<?= $row->ult_poda ?>" class="form-control" maxlength="10">
							</div>
							<div class="form-group">
								<label for=""><strong>*</strong>Proxima Poda: </label>
								<input type="date" tabindex="1" required name="proxima_poda" value="<?= $row->prox_poda ?>" class="form-control">
							</div>
							<a href="relatorio_do_usuario.php?page=1" tabindex="3" class="btn btn-warning">Voltar</a>
							<input type="submit" tabindex="2" name="atualizar_dados" value="Atualizar Dados" class="btn btn-success">&nbsp;
						<?php endforeach ?>
					</form>
				</div>
			</div>
		</div>
	</body>
	</html>