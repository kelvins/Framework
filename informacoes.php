<?php
  require_once("funcoes/dependencias.php");
  require_once("funcoes/funcoes_framework.php");
  ValidaLogin();
?>

<!DOCTYPE html>
<html>

  <head>
    <?php Head(); ?>
    <title>Informações - Framework</title>
  </head>

  <body>

    <div class="container-fluid">
      <div class="row">

        <?php Menu(); ?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h2 class="page-header">Framework de Recomendação para Lojas Virtuais</h2>

          <div class="jumbotron">
            <p>Este framework de recomendação para lojas virtuais foi desenvolvido como Trabalho de Graduação em Sistemas de Informação para o curso de Bacharel em Sistemas de Informação da Universidade Federal de Santa Maria - UFSM, campus de Frederico Westphalen - RS.</p>
            <p>O framework proposto pelo trabalho busca diminuir o esforço dos desenvolvedores em desenvolver e aplicar métodos de recomendações em lojas virtuais, bem como propor aos administradores das lojas virtuais uma maneiras simples e rápida de selecionar métodos de recomendação de acordo com suas necessidades.</p>
            <p>Trabalho desenvovido por Kelvin Salton do Prado e Sidnei Renato Silveira.</p>
            <p>Contato:<br>Kelvin Salton do Prado<br>kelvinpfw@hotmail.com</p>
          </div>

        </div>
      </div>
    </div>

  </body>
</html>