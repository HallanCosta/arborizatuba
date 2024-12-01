<?php 
//require_once '../bootstrap_versions/bootstrap-3.3.7.html';
//require_once '../bootstrap_versions/bootstrap-4.3.1.html';
require_once '../class_static/conexao.class.php';
session_start();

$id_arvore = filter_input(INPUT_GET, 'id_arvore', FILTER_VALIDATE_INT);
$id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_VALIDATE_INT);

if (!empty($id_usuario)) {
	$sql = "SELECT usuario FROM `usuario` WHERE id = :id_usuario";
	$param = array(':id_usuario' => $id_usuario);
	$rows = DB::selectDB($sql, $param, \PDO::FETCH_OBJ); 
	if (COUNT($rows) > 0) {
		$row = $rows[0];
		$usuario_logado = $row->usuario;
	} else {
		print('<br>Erro: Usúario não encontrado no banco de dados');
	}
} else {
	exit('<br>Erro: Não foi possivel indentificar o usuario que registrou essa arvore');
}

if (!empty($id_arvore) && !empty($id_usuario)) {
	$sql = "SELECT * FROM `validacao`  WHERE 1 = 1 AND id = ? AND id_usuario = ?";
	$params = array(
		(Integer)$id_arvore,
		(Integer)$id_usuario
	);
	$rows = DB::selectDB($sql, $params, \PDO::FETCH_OBJ);
	if (COUNT($rows) > 0) {
		foreach ($rows as $row) {
			$cep = $row->cep;
			$tp_logradouro = $row->tp_logradouro;
			$logradouro = $row->logradouro;
			$bairro = $row->bairro;
			$num = $row->num;
			$complemento = $row->complemento;
			$especie = $row->especie;
			$porte = $row->porte;
			$quant = $row->quant;
			$ult_poda = $row->ult_poda;
			$prox_poda = $row->prox_poda;
			$urlFoto = $row->urlFoto;
		}
		//INSERT IN TABLE `DESCARTADAS`
		$sql = "INSERT INTO `descartadas`
		VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$params = array(
			(String)$cep,
			(String)$tp_logradouro,
			(String)$logradouro,
			(Integer)$num,
			(String)$complemento,
			(String)$bairro,
			(String)$especie,
			(String)$porte,
			(Integer)$quant,
			(String)$ult_poda,
			(String)$prox_poda,
			(String)$urlFoto,
			(Integer)$id_usuario
		);
		$lastInsertId = DB::insertDB($sql, $params);
		if ($lastInsertId > 0) {
			//print('Inserido na Tabela Descartadas');
			//print('Inserido na Tabela Fotos_Descartadas');
			//DELETE TO TABLE `VALIDACAO`
			$sql = "DELETE FROM `validacao` WHERE 1 = 1 AND id = ?";
			$param = array(
				(Integer)$id_arvore
			);
			$affectedRow = DB::deleteDB($sql, $param);
			if ($affectedRow > 0) {
				$dir = '../../arvores/' . $usuario_logado . '/' . 'fotos_descartadas/';
				if (!is_dir($dir)) {
					$pathname = $dir;
					$mode = 0777;
					$recursive = TRUE;
					mkdir($pathname, $mode, $recursive);
				}
				$nome_foto = pathinfo($urlFoto, PATHINFO_BASENAME);
				$path = '../../arvores/' . $usuario_logado . '/' . $nome_foto;
				$pathinfo_mode = PATHINFO_BASENAME;
				$pathinfo_basename = pathinfo($path, $pathinfo_mode);
				$source = $path;
				$destination = $dir.$pathinfo_basename;
				if (copy($source, $destination)) {
					$remove_success = unlink($source);
					if ($remove_success) {
						$newUrlFoto = 'arvores/' . $usuario_logado . '/' . 'fotos_descartadas/' . $nome_foto;
						$sql = "UPDATE `descartadas` SET urlFoto = :newUrlFoto WHERE id_usuario = :id_usuario";
						$param = array(':newUrlFoto' => $newUrlFoto, ':id_usuario' => $id_usuario);
						$affectedRow = DB::updateDB($sql, $param);
						if ($affectedRow > 0) {
							header('Location: index.php');
						} else {
							echo '<div class="alert alert-danger">
							Houve um erro: Falha ao atualizar o diretorio da foto no banco de dados.
							</div>';
						}
					} else {
						echo '<div class="alert alert-danger">
						Houve um erro: Não foi possivel localizar o diretorio da foto para deleta-la.
						</div>';
					}
				} else {
					echo '<div class="alert alert-danger">
					Houve um erro: Falha ao mover a foto da pasta descartadas para pasta fotos_descartadas.
					</div>';
				}
			} else {
				print('<div class="alert alert-danger">
					Houve um erro: Falha ao deletar os dados da Tabela `Validação`.
					</div>
					');
			}

		} else {
			print('<div class="alert alert-danger">
				Houve um erro: Falha ao inserir os dados na Tabela `Descartadas`.
				</div>
				');
		}	
	} else {
		print('<div class="alert alert-warning">
			Está arvore já foi descartada.
			</div>
			');
	}
}