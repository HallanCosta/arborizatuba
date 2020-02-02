<!DOCTYPE html>
<?php
	session_start();
	$_SESSION['usuario'] = 'hallan';
	$_SESSION['id'] = 1;
	date_default_timezone_set('America/Sao_Paulo');
	require_once('class_static/conexao.php');
	/*$pasta = "img/";
	$diretorio = dir($pasta);
	echo "Lista de Arquivos do diretório '<strong>".$pasta."</strong>':<br />";
	while($arquivo = $diretorio -> read()){
		echo "<a href='".$pasta.$arquivo."'>".$arquivo."</a><br />";
	}
	$diretorio -> close();*/

	echo "<hr><br>";
	$_GET['id_arvore'] = 1;

	$query = "SELECT urlFoto FROM validadas WHERE id_usuario = :id_usuario AND id = :id";
	$param = array(
		':id_usuario'	=>	$_SESSION['id'],
		':id'	=>	$_GET['id_arvore']
	);
	$rows = DB::selectDB($query, $param, PDO::FETCH_OBJ);
	$count = count($rows);







?>
<html lang="pt-BR">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Pagina Criada para testes</title>
		<meta name="description" content="curso de bootstrap 3">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
	<body>

		<!-- Botão para acionar modal -->
		<a href="" class="item-link" data-toggle="modal" data-target="#ModalFotoCentralizado">Link</a>
	

		<!-- Modal -->
		<div class="modal fade" id="ModalFotoCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
		 
		  <div class="modal-dialog modal-dialog-centered" role="document">
		   
		    <div class="modal-content">
		     
		      <div class="modal-header">
		        
		        <h5 class="modal-title text-center" id="TituloModalCentralizado">Foto da árvore</h5>
		        
		        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
		          <span aria-hidden="true">&times;</span>
		        </button>

		      </div>

		      <div class="modal-body">

		        <table>

		        	<tbody>
		        		<?php
		        			if ($count > 0):
							foreach ($rows as $row):
								$urlFoto = $row->urlFoto;

								//$diretorio = $urlFoto; // esta linha não precisas é só um exemplo do conteudo que a variável vai ter
								// selecionar só .jpg
								$imagens = glob($urlFoto, GLOB_BRACE);
								
								
							

		        		?>
		      			<?php foreach ($imagens as $imagem): ?>
		        		<tr>
							<a href=""><img src="<?=  $imagem; ?>"></a>
		        		</tr>
		      				
		      			<?php endforeach; ?>
		      			<?php endforeach; ?>
		      			<?php endif; ?>
		        	</tbody>

		        </table>
		      </div>

		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
		      </div>

		    </div>

		  </div>

		</div>


	</body>

	<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</html>