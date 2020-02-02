<!DOCTYPE html>
<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once '../class_static/conexao.php';
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT) ?? 1;
$perPage = filter_input(INPUT_GET, 'perPage', FILTER_SANITIZE_NUMBER_INT) && filter_input(INPUT_GET, 'perPage', FILTER_SANITIZE_NUMBER_INT) <= 50 ? filter_input(INPUT_GET, 'perPage', FILTER_SANITIZE_NUMBER_INT) : 5;

if (!empty($page) && !empty($perPage)) {
   $start = $page > 1 ? ($page * $perPage) - $perPage : 0;
   $sql = "SELECT * FROM `validadas` WHERE 1 = 1";
   $rows = DB::selectDB($sql, NULL, \PDO::FETCH_OBJ);
   $pages = ceil(COUNT($rows)/$perPage);
   if (COUNT($rows) > 0) {
      $sql = "SELECT * FROM `validadas` WHERE 1 = 1 LIMIT {$start}, {$perPage}";
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
   $sql = "SELECT * FROM `validadas` WHERE 1 = 1 " . $txtPesquisa;
   $rows = DB::selectDB($sql, NULL, \PDO::FETCH_OBJ);
   if (COUNT($rows) > 0) {
      $msg = 1;//Sucesso na Pesquisa
   } else {
      $msg = -1;//Não foi possivel entroncar este registro na pesquisa, Nada Encontrado
   }

   switch ($msg) {
      case 1:
      $sql = "SELECT SUM(quant) AS totalArvoresTabela FROM `validadas` WHERE 1 = 1";
      $resultTable = DB::selectDB($sql, NULL, \PDO::FETCH_OBJ);
      if (COUNT($resultTable) > 0) {
         $row = $resultTable[0];
         $totalArvoresTabela = $row->totalArvoresTabela;
      }

      $sql = "SELECT SUM(quant) AS totalArvoresPesquisa FROM `validadas` WHERE 1 = 1" . $txtPesquisa;
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
<html lang="pt-BR">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>ArborizaTuba - Árvores</title>
   <!-- Hállan e Hállex -->
   <?php require_once '../relatorio/Template/Head/Title/titulo.html'; ?>
   <link rel="stylesheet" href="../relatorio/bootstrap/css/4.3.1/bootstrap.min.css">
   <script type="text/javascript" src="../relatorio/jQuery/jquery-3.4.1.min.js"></script>
   <script type="text/javascript" src="../relatorio/jQuery/jquery-1.14.10.mask.min.js"></script>
   <!-- Templete pronto -->
   <link rel="stylesheet" href="css/components.css">
   <link rel="stylesheet" href="css/icons.css">
   <link rel="stylesheet" href="css/responsee.css">
   <link rel="stylesheet" href="owl-carousel/owl.carousel.css">
   <link rel="stylesheet" href="owl-carousel/owl.theme.css"> 
   <!-- CUSTOM STYLE -->
   <link rel="stylesheet" href="css/template-style.css"> 
   <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800&subset=latin,latin-ext' rel='stylesheet' type='text/css'>


   <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
   <script type="text/javascript" src="js/jquery-ui.min.js"></script>    
   <script type="text/javascript" src="../js/jquery.mask.min.js"></script>
</head>
<body class="size-1140">
   <!-- TOP NAV WITH LOGO -->  
   <header>
      <nav>
         <div class="line">
            <div class="top-nav">              
               <div class="logo logo-small">
                  <a href="index.html">DESIGN <br /><strong>THEME</strong></a>
               </div>                  
               <p class="nav-text">Custom menu text</p>
               <div class="top-nav s-12 l-5">
                  <!-- right estava atras de top-ul chevron -->
                  <ul class="top-ul chevron" style="transform: translateX(29%);">
                     <li><a href="../index.html">Home</a>
                     </li>
                     <li><a href="nossa_cidade.html">Nossa cidade</a>
                     </li>
                     <li><a href="arvores.php">Árvores</a>
                     </li>
                  </ul>
               </div>
               <ul class="s-12 l-2">
                  <li class="logo hide-s hide-m">
                     <a href="#">Arborização <br /><strong>Araçatuba</strong></a>
                  </li>
               </ul>
               <div class="top-nav s-12 l-5">
                  <ul class="top-ul chevron">
                     <li><a href="#">Usuario</a>
                      <ul>
                        <li><a href="../cadastro_usuario.php">Cadastrar-se</a>
                        </li>
                        <li><a href="../tela_login.php">Logar-se</a>
                        </li>
                     </ul>
                  </li>
                  <li><a href="#">Galeria de Fotos</a>
                   <ul>
                     <li><a href="especies_arvores.html">Espécies de Arvores</a>
                     </li>
                  </ul>
               </li>
               <li>
                  <a href="contato.html">Contato</a>
               </li>
            </ul> 
         </div>
      </div>
   </div>
</nav>
</header>
<section>
   <div id="head">
      <div class="line">
         <h1>TODAS ÁRVORES EM ARAÇATUBA</h1>
      </div>
   </div>
   <div id="content">
      <div class="line">
         <!-- Resultados/Erros -->
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
         <!-- Fim Resultados/Erros -->

         <!-- Pesquisa da tabela -->
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
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                           <div class="form-group float-left">
                              <input type="submit" name="btnPesquisar" id="btnPesquisar" class="btn btn-primary" value="Pesquisar">&nbsp;
                              <a href="<?=$_SERVER['PHP_SELF'];?>" class="btn btn-danger text-white">Limpar</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <!-- Fim pesquisa da tabela -->

         <!-- Tabela -->
         <div class="mt-3 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="d-print-table table-responsive table-responsive-sm table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl">
               <table class="table table-hover table-bordered table">
                  <thead class="thead thead-dark">
                     <tr>
                        <?php require_once '../relatorio/Template/Body/Colunas/colunas.html'; ?>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($rows as $key => &$value): ?>
                        <tr>
                           <?php/* require '../relatorio/Template/Body/Relatorio/relatorio.php';*/ ?>

                           <th scope="row"><?=$value->id;?></th>
                           <td class="text-center"><?=$value->cep;?></td>
                           <td class="text-center"><?=$value->tp_logradouro;?></td>
                           <td class="text-center"><?=$value->logradouro;?></td>
                           <td class="text-center"><?=$value->num;?></td>
                           <td class="text-center"><?=$value->complemento;?></td>
                           <td class="text-center"><?=$value->bairro;?></td>
                           <td class="text-center"><?=$value->especie;?></td>
                           <td class="text-center"><?=$value->porte;?></td>
                           <td class="text-center"><?=$value->quant;?></td>
                           <td class="text-center"><?=DateTime::createFromFormat('Y-m-d', $value->ult_poda)->format('d/m/Y');?></td>
                           <td class="text-center"><?=DateTime::createFromFormat('Y-m-d', $value->prox_poda)->format('d/m/Y');?></td>
                           <td class="text-center hidden-print"><a href="../<?=$value->urlFoto;?>?id_arvore=<?=$value->id;?>" target="_blank">Link</a></td>
                        </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>
         </div>

         <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <?php if (!filter_input(INPUT_POST, 'btnPesquisar', FILTER_SANITIZE_STRING)): ?>
               <div class="col mt-5 mt-sm-5 mt-md-5 mt-lg-5 mt-xl-5 hidden-print">
                  <?php require_once '../relatorio/Template/Footer/Paginacao/paginacao.php'; ?>
               </div>
            <?php endif; ?>
         </div> 
         <!-- Fim tabela -->
      </div>
   </div>
   <!-- GALLERY -->	
        <!--  <div id="third-block">
            <div class="line">
               <h2>Responsive gallery</h2>
               <p class="subtitile">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
               </p>
               <div class="margin">
                  <div class="s-12 m-6 l-3">
                     <img src="img/first-small.jpg">      
                     <p class="subtitile">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                     </p>
                  </div>
                  <div class="s-12 m-6 l-3">
                     <img src="img/second-small.jpg">      
                     <p class="subtitile">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                     </p>
                  </div>
                  <div class="s-12 m-6 l-3">
                     <img src="img/third-small.jpg">      
                     <p class="subtitile">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                     </p>
                  </div>
                  <div class="s-12 m-6 l-3">
                     <img src="img/fourth-small.jpg" style="height: 21vh; width: 100%;">      
                     <p class="subtitile">Benefícios da arborização de ruas.
                     </p>
                  </div>
               </div>
            </div>
         </div> -->
         <div id="fourth-block">

         </div>
      </section>
      <!-- FOOTER -->   
      <footer>
         <div class="line">
            <div class="s-12 l-6">
               <p>&copy;Copyright 2019, ArborizaTuba - Arborização Araçatuba
               </p>
            </div>
            <div class="s-12 l-6">
               <p class="right">
                  <p class="right">Equipe ArborizaTuba</p>
               </p>
            </div>
         </div>
      </footer>
      <script type="text/javascript" src="js/responsee.js"></script> 
      <script type="text/javascript" src="owl-carousel/owl.carousel.js"></script>   
      <script type="text/javascript">
         jQuery(document).ready(function($) {  
           var owl = $('#news-carousel');
           owl.owlCarousel({
              nav: true,
              dots: false,
              items: 1,
              loop: true,
              navText: ["&#xf007","&#xf006"],
              autoplay: true,
              autoplayTimeout: 4000
           });
        });	

     </script>  
  </body>
  </html>