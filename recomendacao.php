<?php
  require_once("funcoes/dependencias.php");
  require_once("funcoes/funcoes_framework.php");
  ValidaLogin();
  
  require_once("funcoes/bd_funcoes.php");
  $vSaida = '';
  $ListaRecomendacoes = '';

  // Abre conexão com o banco do cliente
  $vConexao = BD_AbreConexaoFramework();

  // Válida se tem alguma base configurada, se não chama a tela de configuracoes
  $vEncontrou = false;
  $vSQL = "SELECT CON_NOME_BANCO FROM TB_CONEXAO";
  $vResultado = BD_ExecutaSQLFramework($vSQL, $vConexao);
  while($vLinha = mysql_fetch_array($vResultado)){
    $vEncontrou = true;
  }
  if(!$vEncontrou)
    header('location: configuracoes.php?pag1');


  if($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["cod"])){
      
      $vSQL = "UPDATE TB_PARAMETROS PAR SET PAR.PAR_SELECIONADO = false";
      BD_ExecutaSQLFramework($vSQL, $vConexao);

      $vSQL = "UPDATE TB_PARAMETROS PAR SET PAR.PAR_SELECIONADO = true WHERE PAR.PAR_CODIGO = ". base64_decode($_GET["cod"]) ." ";

      if (BD_ExecutaSQLFramework($vSQL, $vConexao)){                
          $vSaida = 
              '<div class="alert alert-success fade in" align="center">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  Recomendação selecionada com sucesso
              </div>';
      }else{
          $vSaida = 
              '<div class="alert alert-warning fade in" align="center">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  Não foi possível selecionar esta recomendação
              </div>';
      }
    }else if (isset($_GET["rec"])){
        $vSaida = 
            '<div class="alert alert-warning fade in" align="center">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Atenção!</strong> Esta recomendação já está seleionada
            </div>';
    }

  }

  $vEncontrou = false;
  $vSQL = "SELECT * FROM TB_PARAMETROS WHERE PAR_CODIGO IN (". ValidaRecomendacoes() .")";
  $vResultado = BD_ExecutaSQLFramework($vSQL, $vConexao);
  while($vLinha = mysql_fetch_array($vResultado)){
    
    if( $vLinha["PAR_SELECIONADO"] ){
      $vBotao = ' <a href="recomendacao.php?rec=ok" style="color: rgb(50, 50, 250);">
                    <i class="glyphicon glyphicon-thumbs-up"></i> Selecionada
                  </a>';
    }else{
      $vBotao = ' <a href="recomendacao.php?cod='. base64_encode($vLinha["PAR_CODIGO"]) .'" style="color: rgb(50, 50, 50);">
                    <i class="glyphicon glyphicon-thumbs-up"></i> Selecionar
                  </a>';
    }

    $ListaRecomendacoes .= ' <h3>'. $vLinha["PAR_CODIGO"] .'. '. $vLinha["PAR_PARAMETRO"] .'</h3>
                            <div>
                              <p>Descrição: '. $vLinha["PAR_DESCRICAO"] .'</p>
                              <div align="right">
                                '. $vBotao .'
                              </div>
                            </div>';
    $vEncontrou = true;
  }

  if( !$vEncontrou ){
    $vSaida = 
        "<div class='alert alert-danger' align='center'>
            Não foi possível carregar nenhuma recomendação
            <br>
            Certifique-se de preencher os campos na tela de configurações
        </div>";
  }

  // Fecha conexão com o banco do cliente
  BD_FechaConexaoFramework($vConexao);
?>

<!DOCTYPE html>
<html>

  <head>
    <?php Head(); ?>
    <title>Recomendações - Framework</title>

    <link rel="stylesheet" href="css/jquery-ui.css">

    <script type='text/javascript' src='js/jquery.js'></script>
    <script type="text/javascript" src="js/bootstrap.js"></script> 
    <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>

    <script>
      $(function() {
        $( "#accordion" ).accordion({
          heightStyle: "content"
        });
      });
    </script>
  
  </head>

  <body>

    <div class="container-fluid">
      <div class="row">

        <?php Menu(); ?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h2 class="page-header">Recomendações</h2>

          <?php echo $vSaida; ?>

          <form method="GET" action="<?php $_SERVER['PHP_SELF'] ?>">
            
            <div id="accordion">

              <?php echo $ListaRecomendacoes; ?>

            </div>

          </form>

        </div>
      </div>
    </div>

  </body>
</html>