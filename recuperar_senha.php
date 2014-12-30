<?php
    require_once("funcoes/dependencias.php");

    $vSaida = "";    

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if($_POST["edEmail"] != "" ){
            
            $vNome      = "";
            $vLogin     = "";
            $vSenha     = "";
            $vEmail     = $_POST['edEmail'];
            $vEncontrou = false;

            require_once("funcoes/bd_funcoes.php");
            $vConexao = BD_AbreConexao();        

            $vSQL = " SELECT USU.USU_CODIGO,          " .
                    "        USU.USU_NOME,            " .
                    "        USU.USU_LOGIN,           " .
                    "        USU.USU_EMAIL,           " .
                    "        USU.USU_SENHA,           " .
                    "        USU.USU_CATEGORIA        " .
                    "                                 " .
                    " FROM TB_USUARIOS USU            " .
                    "                                 " .
                    " WHERE USU.USU_EMAIL = '$vEmail' " .
                    "   AND USU.USU_ATIVO = true      ";
            
            $vResultado = BD_ExecutaSQL($vSQL, $vConexao);
            while($vLinha = mysql_fetch_array($vResultado)){
                $vNome      = $vLinha["USU_NOME"];
                $vLogin     = $vLinha["USU_LOGIN"];
                $vSenha     = $vLinha["USU_SENHA"];
                $vEncontrou = true;
            }

            BD_FechaConexao($vConexao);

            $vAssunto = 'Recuperação de Senha';

            $vMensagem .= "<br><br>Email Automático de Recuperação de Senha do Framework de Recomendação para Lojas Virtuais";
            $vMensagem .= "<br><br><strong>Nome : </strong>". $vNome;
            $vMensagem .= "<br><strong>Login : </strong>". $vLogin;
            $vMensagem .= "<br><strong>Senha : </strong>". $vSenha;
            $vMensagem .= "<br><br><strong> Favor não responder este email. </strong>";

            //codificações necessarias 
            $vHeader  = "Content-Type:text/html; charset=UTF-8\n"; 
            $vHeader .= "From: ". $vNome ."<". $vEmail .">\n"; 

            if( mail($vEmail, $vAssunto, $vMensagem, $vHeader) ){
                $vSaida = "
                        <div class='alert alert-success' align='center'> 
                            E-mail enviado com sucesso.
                        </div>";
            }else{                
                $vSaida = "
                        <div class='alert alert-danger' align='center'> 
                            E-mail não enviado, tente novamente.
                        </div>";
            }
        }else{
            $vSaida = "
                <div class='alert alert-danger' align='center'> 
                    E-mail não enviado, tente novamente.
                </div>";
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-br">

  <head>
    <?php Head(); ?>
    <title>Recuperar Senha - Framework</title>
  </head>

  <body style="background-color: rgb(250, 250, 250);">

    <div align="center">
      <?php echo $vSaida; ?>
      <div style="width: 30%; padding-top: 50px;">
        <h3 class="page-header">Recuperar Senha</h3>
        <div align="left">

        <form role="form" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
          <div class="form-group">
            <label for="exampleInputEmail1">E-mail</label>
            <input type="email" class="form-control" id="edEmail" placeholder="E-mail..." required="true">
          </div>
          </div>
          <div align="right">
          <button type="button" class="btn btn-warning" style="width: 30%;" onClick="javascript:window.location.href='login.php'"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</button>
          <button type="submit" class="btn btn-primary" style="width: 30%;"><i class="glyphicon glyphicon-envelope"></i> Enviar</button>
          </div>
        </form>

      </div>
    </div>

  </body>
</html>