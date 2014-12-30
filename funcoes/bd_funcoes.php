<?php
	require_once("dados_conexao.php");

	function BD_ConectaCliente($pBD_Banco){	
		$vConexao = mysql_connect(BD_ServidorFramework, BD_UsuarioFramework, BD_SenhaFramework);
		mysql_select_db($pBD_Banco, $vConexao);
		mysql_set_charset('utf8', $vConexao);

		if (!($vConexao)){
			echo "<div class='alert alert-danger'>
                  	<strong>Erro!</strong>Problema ao conectar o MySQL.
	              </div>";
	        die(mysql_error());
			exit;	
		}

		return $vConexao;
	}
	
	function BD_AbreConexaoFramework(){	
		$vConexao = mysql_connect(BD_ServidorFramework, BD_UsuarioFramework, BD_SenhaFramework, true);
		mysql_select_db(BD_BancoFramework, $vConexao);
		mysql_set_charset('utf8', $vConexao);

		if (!($vConexao)){
			echo "<div class='alert alert-danger'>
                  	<strong>Erro!</strong>Problema ao conectar o MySQL.
	              </div>";
	        die(mysql_error());
			exit;	
		}

		return $vConexao;
	}
	
	function BD_FechaConexaoFramework($pConexao){
		@mysql_close($pConexao);
	}

	function BD_ExecutaSQLFramework($pSQL, $pConexao){
		if (empty($pSQL)) // SQL vazio
			return 0;
		else if (!($pConexao)) // Conexão inválida
			return 0;

		$vResposta = mysql_query($pSQL, $pConexao);
		if (!($vResposta)){
            echo "<div class='alert alert-danger' align='center'>
                      <strong>Erro!</strong> Falha no banco de dados!
                  </div>";
			exit;
		}		

		return $vResposta;
	}
?>
