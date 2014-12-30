<?php
  require_once("funcoes/dependencias.php");
  require_once("funcoes/funcoes_framework.php");
  ValidaLogin();

  require_once("funcoes/bd_funcoes.php");
  $vConexao = BD_AbreConexaoFramework(); 

  $vSaida ='';

  $vCodigo    = 0;
  $vNome      = '';
  $vUsuario   = '';
  $vEmail     = '';
  $vSenha     = '';
  $vCategoria = '<option value="Usuario" selected>Usuário</option>
                 <option value="Administrador">Administrador</option>';

  $vAcao1 = 'Salvar';
  $vAcao2 = 'Limpar';

  if($_SERVER["REQUEST_METHOD"] == "GET") {
    
    if (isset($_GET["Exc"])){
      $vCod = base64_decode($_GET["Exc"]);
      if( $vCod > 0 ){
        $vSQL = "UPDATE TB_USUARIOS USU SET USU.USU_ATIVO = false WHERE USU.USU_CODIGO = '$vCod' ";

        if (BD_ExecutaSQLFramework($vSQL, $vConexao)){                
            $vSaida = 
                "<div class='alert alert-success' align='center'>
                    Usuário excluído com sucesso
                </div>";
        }else{
            $vSaida = 
                "<div class='alert alert-warning' align='center'>
                    Usuário não encontrado
                </div>";
        }
      }
    }else if (isset($_GET["Cod"])){
      $vCod = base64_decode($_GET["Cod"]);
      if( $vCod > 0 ){
        $vAcao1 = 'Editar';
        $vAcao2 = 'Novo';
        $vSQL = " SELECT USU.USU_CODIGO,                  " .
                "        USU.USU_NOME,                    " .
                "        USU.USU_LOGIN,                   " .
                "        USU.USU_EMAIL,                   " .
                "        USU.USU_SENHA,                   " .
                "        USU.USU_CATEGORIA                " .
                "                                         " .
                " FROM TB_USUARIOS USU                    " .
                "                                         " .
                "   WHERE USU.USU_CODIGO = '$vCod'        " .
                "     AND USU.USU_ATIVO = true            ";
        
        $vResultado = BD_ExecutaSQLFramework($vSQL, $vConexao);
        while($vLinha = mysql_fetch_array($vResultado)){
            $vCodigo  = $vLinha["USU_CODIGO"];
            $vNome    = $vLinha["USU_NOME"];
            $vUsuario = $vLinha["USU_LOGIN"];
            $vEmail   = $vLinha["USU_EMAIL"];
            $vSenha   = $vLinha["USU_SENHA"];
            if( $vLinha["USU_CATEGORIA"] == 'Administrador' )
              $vCategoria = '
                            <option value="Usuario">Usuário</option>
                            <option value="Administrador" selected>Administrador</option>';
        }
      }
    }
  }


  if($_SERVER["REQUEST_METHOD"] == "POST") {

    if( $_POST['edNome'] != '' && $_POST['edUsuario'] != '' && $_POST['edSenha'] != ''){

      $vCodigo    = $_POST['edCodigo'];
      $vNome      = $_POST['edNome'];
      $vUsuario   = $_POST['edUsuario'];
      $vEmail     = $_POST['edEmail'];
      $vSenha     = $_POST['edSenha'];
      $vCateg     = $_POST['edCategoria'];

      if( $vCodigo == 0 ){
        $vSQL = " INSERT INTO TB_USUARIOS VALUES  " .
                " (null, '$vNome', '$vUsuario', '$vSenha', '$vEmail', '$vCateg', true)";
      }else{
        $vAcao1 = 'Editar';
        $vAcao2 = 'Novo';
        $vSQL = " UPDATE TB_USUARIOS SET            " .
                "    USU_NOME = '$vNome',           " .
                "    USU_LOGIN = '$vUsuario',       " .
                "    USU_SENHA = '$vSenha',         " .
                "    USU_EMAIL = '$vEmail',         " .
                "    USU_CATEGORIA = '$vCateg'  " .
                "                                   " .
                "  WHERE USU_CODIGO = $vCodigo      " ;
      }
      
      if (BD_ExecutaSQLFramework($vSQL, $vConexao)){                
          $vSaida = 
              "<div class='alert alert-success' align='center'>
                Usuário salvo com sucesso
              </div>";
      }

    }else{
      $vSaida = 
              "<div class='alert alert-warning' align='center'>
                Por favor preencha todos os campos corretamente
              </div>";
    }
  }


  // Carrega tabela de usuários
  $vTabela = '';  

  $vSQL = " SELECT USU.USU_CODIGO,          " .
          "        USU.USU_NOME,            " .
          "        USU.USU_LOGIN,           " .
          "        USU.USU_EMAIL,           " .
          "        USU.USU_CATEGORIA        " .
          "                                 " .
          " FROM TB_USUARIOS USU            " .
          "                                 " .
          "   WHERE USU.USU_ATIVO = true    " .
          "                                 " .
          "   ORDER BY USU.USU_CODIGO       ";
  
  $vResultado = BD_ExecutaSQLFramework($vSQL, $vConexao);
  while($vLinha = mysql_fetch_array($vResultado)){
    $vLinha["USU_CODIGO"] = base64_encode($vLinha["USU_CODIGO"]);
    $vTabela .= '
              <tr>
                <td>'. $vLinha["USU_NOME"] .'</td>
                <td>'. $vLinha["USU_EMAIL"] .'</td>
                <td align="center">'. $vLinha["USU_LOGIN"] .'</td>
                <td align="center">'. $vLinha["USU_CATEGORIA"] .'</td>
                <td align="center">
                  <a href="usuarios.php?Exc='. $vLinha["USU_CODIGO"] .'"><i class="glyphicon glyphicon-remove" style="color: rgb(250, 50, 50);"></i></a> &nbsp 
                  <a href="usuarios.php?Cod='. $vLinha["USU_CODIGO"] .'"><i class="glyphicon glyphicon-edit" style="color: rgb(0, 255, 0);"></i></a>
                </td>
              </tr>';
  }

  BD_FechaConexaoFramework($vConexao);

?>


<!DOCTYPE html>
<html lang="pt-br">

  <head>
    <?php Head(); ?>
    <title>Usuários - Framework</title>
  </head>

  <body>

    <div class="container-fluid">
      <div class="row">
        <!-- MENU LATERAL ESQUERDO -->
        <?php Menu(); ?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main"> 
          <h1 class="page-header">Usuários</h1>

           <?php echo $vSaida; ?>
        <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
          <input class="hidden" name="edCodigo" value=<?php echo $vCodigo; ?> type="text">
          <div class="form-group col-sm-6">
            <label>Nome Completo</label>
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Digite seu nome completo" required="true" name="edNome" value=<?php echo $vNome; ?> >
          </div>
          <div class="form-group col-sm-6">
            <label>Endereço de Email</label>
            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Digite seu e-mail" required="true" name="edEmail" value=<?php echo $vEmail; ?> >
          </div>
          <div class="form-group col-sm-4">
            <label>Nome de Usuário</label>
            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Usuário de acesso" required="true" name="edUsuario" value=<?php echo $vUsuario; ?>>
          </div>
          <div class="form-group col-sm-4">
            <label>Senha</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Senha de acesso" required="true" name="edSenha" value=<?php echo $vSenha; ?>>
          </div>
          <div class="form-group col-sm-4">
            <label>Categoria</label>
            <select class="form-control" name="edCategoria">
              <?php echo $vCategoria; ?>
            </select>   
          </div>
          <div class="form-group col-sm-4"></div>
          <div align="right" class="form-group col-sm-8">
            <a href="usuarios.php" class="btn btn-warning" style="width: 32%;"><i class="glyphicon glyphicon-file"></i> <?php echo $vAcao2; ?></a>
            <button type="submit" class="btn btn-primary" style="width: 32%;"><i class="glyphicon glyphicon-ok"></i> <?php echo $vAcao1; ?></button>
          </div>
        </form>

        <div class="form-group col-sm-12">
          <table class="table table-bordered">
            <tr>
              <th>Nome</th>
              <th>E-mail</th>
              <th><div align="center">Usuário</div></th>
              <th><div align="center">Permissão</div></th>
              <th><div align="center">Ações</div></th>
            </tr>
            <?php echo $vTabela; ?>
          </table>
          <p style="color: rgb(150, 150, 200);" align="right">
            <i class="glyphicon glyphicon-remove" style="color: rgb(250, 50, 50);"></i> Excluir &nbsp
            <i class="glyphicon glyphicon-edit" style="color: rgb(0, 255, 0);"></i> Editar
          </p>
        </div>

        </div>
      </div>
    </div>

  </body>
</html>