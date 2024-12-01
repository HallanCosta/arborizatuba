<!DOCTYPE html>
<?php 
	require_once 'conexao.class.php';

	if (isset($_POST['login']) && isset($_POST['password'])) {
		$usuario = $_POST['login'];
		$email = $_POST['login'];
		$senha = $_POST['password'];
		if (!empty($usuario) && !empty($senha)) {
			$sql = "SELECT * FROM usuario WHERE (usuario = :usuario AND senha = :senha) OR (email = :email AND senha = :senha)";
			$params = array(
				':usuario' => (String)$usuario,
				':email' => (String)$email,
				':senha' => (String)md5($senha)
			);

			//$db = new DB;
			//$rows = $db->selectDB($sql, $params, \PDO::FETCH_OBJ);
			$rows = DB::selectDB($sql, $params, \PDO::FETCH_OBJ);
			//DB::selectDB($sql, $params, PDO::FETCH_OBJ);
			$rowCount = count($rows);

			print('<br>Número de Linahs Afetadas: ' . $rowCount);
			if ($rowCount > 0) {
				$color = "color: green";
				$mensagem = "<br>Usuario Está Cadastrado";
				print('<br>Client Login: ' . $usuario);
				print('<br>Client Senha: ' . $senha);
				print('<br>Client Senha Codificada: ' . md5($senha));
				echo '<br>';
				foreach ($rows as $row) {
					print('<br>Banco Login: ' . $row->usuario);
					print('<br>Banco Senha: ' . $row->senha);
				}
			} else {
				$color = "color: red";
				$mensagem = "<br>Usuario <strong>NÃO</strong> Está Cadastrado";
				print('<br>Login: ' . $usuario);
				print('<br>Senha: ' . $senha);
			}
		} else {
			$color = "color: black";
			$mensagem = "<strong>Campos Vazio</strong>";
		}
	}
 ?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form method="post">
		<div>
			<label>Login: <input type="text" required name="login"></label>
		</div>
		<div>
			<label>Password: <input type="text" required name="password"></label>
		</div>
		<?php if (isset($mensagem)): ?>
		<span style="<?= $color ?>"><?= $mensagem ?></span>
		<?php endif; ?>
		<br>
		<input type="submit" value="submit">
	</form>
</body>
</html>