<?php
    ob_start();
    session_start();
    
    //require_once("funcoes/cria_banco.php");
    
    // Limpa dados da session
    $_SESSION['USU_CODIGO']     = 0;
    $_SESSION['USU_NOME']       = '';
    $_SESSION['USU_EMAIL']      = '';
    $_SESSION['USU_CATEGORIA']  = '';
    $vSaida = '';

    require_once("funcoes/dependencias.php");

    // Se a requisição foi 'POST'
    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $vLogin = $_POST["usuNome"];
        $vSenha = $_POST["usuSenha"];

        $vLogou = false;

        if ($vLogin != '' && $vSenha != ''){

            require_once("funcoes/bd_funcoes.php");
            $vConexao = BD_AbreConexaoFramework();        

            $vSQL = " SELECT USU.USU_CODIGO,          " .
                    "        USU.USU_NOME,            " .
                    "        USU.USU_EMAIL,           " .
                    "        USU.USU_CATEGORIA        " .
                    "                                 " .
                    " FROM TB_USUARIOS USU            " .
                    "                                 " .
                    " WHERE USU.USU_LOGIN = '$vLogin' " .
                    "   AND USU.USU_SENHA = '$vSenha' " .
                    "   AND USU.USU_ATIVO = true      ";
            
            $vResultado = BD_ExecutaSQLFramework($vSQL, $vConexao);
            while($vLinha = mysql_fetch_array($vResultado)){
                $_SESSION['USU_CODIGO']     = $vLinha["USU_CODIGO"];
                $_SESSION['USU_NOME']       = $vLinha["USU_NOME"];
                $_SESSION['USU_EMAIL']      = $vLinha["USU_EMAIL"];
                $_SESSION['USU_CATEGORIA']  = $vLinha["USU_CATEGORIA"];

                $vLogou = true;
            }

            BD_FechaConexaoFramework($vConexao);
        }
        // Se login foi realizado com sucesso ele chama a página inicial do framework
        if ($vLogou){
            header('location: inicial.php');
        }else{
            $vSaida = "
                      <div align='center'>
                        <div class='alert alert-danger'>
                          <i>Usuário e/ou Senha inválido(s).</i>
                        </div>
                      </div>";
        }
    }
?>    

<!DOCTYPE html>
<html>
  <head>
    <?php Head(); ?>
    <title>Login - Framework</title>
  </head>

  <body style="background-color: rgb(250, 250, 250);">

    <div align="center">
      <?php echo $vSaida; ?>
      
      <div style="width: 35%; padding-top: 50px;">

        <table>
          <tr>
            <th>
              <img src="img/logo.png" style="width: 60px;">
            </th>
            <th>
              <h3 style="padding-left: 10px;" align="center">
                Framework de Recomendação para Lojas Virtuais
              </h3>
            </th>
          </tr>
        </table>

        <hr>
        
        <div align="left">

          <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
            <div class="form-group">
              <label for="exampleInputEmail1">Usuário</label>
              <input type="text" class="form-control" name="usuNome" placeholder="Usuário..." required="true" autofocus>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Senha</label>
              <input type="password" class="form-control" name="usuSenha" placeholder="Senha..." required="true">
            </div>
              <a href="recuperar_senha.php" style="text-decoration: none; color: rgb(150, 150, 200);"><i>Esqueci minha senha</i></a>
            <div align="right">
            <button type="submit" class="btn btn-primary" style="width: 60%;"><i class="glyphicon glyphicon-ok"></i> Entrar</button>
            </div>
          </form>
          
        </div>
      </div>
    </div>

  </body>
</html>