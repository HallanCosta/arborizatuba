<!DOCTYPE html>
<?php 
  require_once '../connection.php';

  $conexao = new Conexao();
  $result = $conexao->Open();

  $id = (int)$_GET['id'];

  $sql = "SELECT * FROM arvores_usuario WHERE id = :id";
  $rows = $result->prepare($sql);
  $rows->bindParam(":id", $id, PDO::PARAM_INT);
  $rows->execute();
  $row = $rows->fetch();

  if(isset($_POST['send'])){
      $bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
      $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
      $numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_NUMBER_INT);
      $especie = filter_input(INPUT_POST, 'especie', FILTER_SANITIZE_STRING);
      $porte = filter_input(INPUT_POST, 'porte', FILTER_SANITIZE_STRING);
      $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT);
      $ultima_poda = filter_input(INPUT_POST, 'ultima_poda', FILTER_SANITIZE_STRING);
      $proxima_poda = filter_input(INPUT_POST, 'proxima_poda', FILTER_SANITIZE_STRING);

      $sql = "UPDATE arvores_usuario SET bairro = :bairro, endereco = :endereco, num = :numero, especie = :especie, porte = :porte, quant = :quantidade, ult_poda = :ultima_poda, prox_poda = :proxima_poda WHERE id = :id";

      $rows = $result->prepare($sql);
      $rows->bindParam(":id", $id, PDO::PARAM_INT);
      $rows->bindParam(":bairro", $bairro, PDO::PARAM_STR);
      $rows->bindParam(":endereco", $endereco, PDO::PARAM_STR);
      $rows->bindParam(":numero", $numero, PDO::PARAM_INT);
      $rows->bindParam(":especie", $especie, PDO::PARAM_STR);
      $rows->bindParam(":porte", $porte, PDO::PARAM_STR);
      $rows->bindParam(":quantidade", $quantidade, PDO::PARAM_INT);
      $rows->bindParam(":ultima_poda", date("Y-m-d", strtotime($ultima_poda)), PDO::PARAM_STR);
      $rows->bindParam(":proxima_poda", date("Y-m-d", strtotime($proxima_poda)), PDO::PARAM_STR);

      $rows->execute();

      header("Location: index.php");
    }
 ?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <title>.:Reporting System Arbocity</title>
  </head>
  <body>
    <div class="container">
      <div class="row" style="margin-top: 70px;">
        <center><h1> Atualizar Cadastro da Arvore </h1></center>
        <hr><br>
          <form method="post">
            <div class="form-group">
              <label for="">Bairro: </label>
              <input type="text" required name="bairro" value="<?= $row['bairro'] ?>" class="form-control">
            </div>
            <div class="form-group">
              <label for="">Endereco: </label>
              <input type="text" required name="endereco" value="<?= $row['endereco'] ?>" class="form-control">
            </div>
            <div class="form-group">
              <label for="">Número: </label>
              <input type="number" required name="numero" value="<?php echo $row['num'] ?>" class="form-control">
            </div>
            <div class="form-group">
              <label for="">Especie: </label>
              <input type="text" required name="especie" value="<?= $row['especie'] ?>" class="form-control">
            </div><div class="form-group">
              <label for="">Porte</label>
              <input type="text" required name="porte" value="<?= $row['porte'] ?>" class="form-control">
            </div><div class="form-group">
              <label for="">Quantidade: </label>
              <input type="number" required name="quantidade" value="<?= $row['quant'] ?>" class="form-control">
            </div><div class="form-group">
              <label for="">Ultima Poda: </label>
              <input type="date" required name="ultima_poda" value="<?= $row['ult_poda'] ?>" class="form-control">
            </div>
            <div class="form-group">
              <label for="">Proxima Poda: </label>
              <input type="date" required name="proxima_poda" value="<?= $row['prox_poda'] ?>" class="form-control">
            </div>
              <input type="submit" name="send" value="Update Account" class="btn btn-success">&nbsp;
              <a href="index.php" class="btn btn-warning">Back</a>
          </form>
        </div>
    </div>
  </body>
</html>
