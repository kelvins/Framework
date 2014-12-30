<?php
  ob_start();
  session_start();
  require_once("funcoes/dependencias.php");
  require_once("funcoes/funcoes_framework.php");
  ValidaLogin();
  
  $vSaida = '';
  if( $_SESSION['USU_CATEGORIA'] == 'Usuario' ){
    $vSaida = '
            <p>Através deste framework você administrador da loja virtual poderá selecionar recomendações para seus produtos de forma rápida, fácil e eficiente!</p>
            <div class="alert alert-info" role="alert">Recomendações: Você poderá selecionar os parâmetros e sub-parâmetros para recomendar os produtos na sua loja virtual, de forma rápida e fácil.</div>';
  }else if( $_SESSION['USU_CATEGORIA'] == 'Administrador' ){
    $vSaida = '
            <p>Através deste framework você administrador da loja virtual poderá selecionar recomendações para seus produtos de forma rápida, fácil e eficiente!</p>
            <p>Algumas funcionalidades do sistema:</p>
            <div class="alert alert-success" role="alert">Usuários: Você poderá visualizar, cadastrar, editar e excluir os usuários do sistema. Tendo assim um controle maior sobre o acesso ao sistema.</div>
            <div class="alert alert-info" role="alert">Recomendações: Você poderá selecionar os parâmetros e sub-parâmetros para recomendar os produtos na sua loja virtual, de forma rápida e fácil.</div>
            <div class="alert alert-warning" role="alert">Configurações: Antes de selecionar as recomendações desejáveis, você deve acessar esta página e preencher alguns campos necessários para a configuração do framework.</div>';
  }
?>

<!DOCTYPE html>
<html>

  <head>
    <?php Head(); ?>
    <title>Inicial - Framework</title>
  </head>

  <body>

    <div class="container-fluid">
      <div class="row">

        <?php Menu(); ?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h2 class="page-header">Framework de Recomendação para Lojas Virtuais</h2>

          <div class="jumbotron">
            <?php echo $vSaida; ?>
          </div>

        </div>
      </div>
    </div>

  </body>
</html>