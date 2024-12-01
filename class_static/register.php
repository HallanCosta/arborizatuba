<!DOCTYPE html>
<?php 
	require_once 'conexao.php';

		$name = $_POST['name'] ?? NULL;
		$username = $_POST['username'] ?? NULL;
		$password = $_POST['password'] ?? NULL;

		if (isset($_POST['insert'])) {
			$sql = "INSERT INTO `logins`(`name`, `username`, `password`) VALUES(:name, :username, :password)";
			$params = array(
				':name' => $name,
				':username' => $username,
				':password' => $password
			);
			if ($name != NULL) {
				$lastInsertId = DB::insertDB($sql, $params);
				if ($lastInsertId > 0) {
					$color = 'color: green';
					$mensagem = '<strong>Successfully</strong> to Register!';
				} else {
					$color = 'color: red';
					$mensagem = '<strong>Failure</strong> to Register!';
				}
			}
		} elseif (isset($_POST['delete'])) {
			$sql = "DELETE FROM `logins` WHERE username = :username AND password = :password";
			$params = array(
				'username' => $username,
				'password' => $password
			);
			$affectedRow = DB::deleteDB($sql, $params);

			if ($affectedRow > 0) {
					$color = 'color: green';
					$mensagem = '<strong>Successfully</strong> to Delete!';
			} else {
				$color = 'color: red';
				$mensagem = '<strong>Failure</strong> to Delete!';
			}
		} elseif (isset($_POST['update'])) {
			$sql = "UPDATE `logins` SET name = :name  WHERE username = :username AND password = :password";
			$params = array(
				':name' => $name,
				':username' => $username,
				':password' => $password
			);
			$affectedRow = DB::updateDB($sql, $params);

			if ($affectedRow > 0) {
					$color = 'color: green';
					$mensagem = '<strong>Successfully</strong> to Update!';
			} else {
				$color = 'color: red';
				$mensagem = '<strong>Failure</strong> to Update!';
			}
		}


 ?>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form name="submitForm" method="post">
		<div>
			<label>Name: <input type="text" id="txtName"required name="name"></label>
		</div>
		<div>
			<label>Login: <input type="text" id="txtLogin"required name="username"></label>
		</div>
		<div>
			<label>Password: <input type="text" id="txtPassword"required name="password"></label>
		</div>
		<?php if (isset($mensagem)): ?>
		<span style="<?= $color ?>"><?= $mensagem ?></span>
		<?php endif; ?>
		<span id="spResultado"></span>
		<br>
		<input type="submit" value="insert" name="insert">
		<input type="submit" value="delete" name="delete">
		<input type="submit" value="update" name="update">
	</form>
</body>
</html>