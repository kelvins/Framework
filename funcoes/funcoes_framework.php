<?php			
	// Variáveis GLOBAIS utilizadas também na tela de configurações
  	// #### - Variáveis de Conexão - ###
	$vBaseDados  = '';
  	$vBancoDados = '';

	$vTabelaClientes  = '';
  	$vTabelaProdutos  = '';
  	$vTabelaVendas    = '';
  	$vTabelaVendasProdutos = '';

	$vCodProduto       = '';
  	$vNomeProduto      = '';
  	$vCategoriaProduto = '';
  	$vDescricaoProduto = '';
  	$vDataProduto      = '';
  	$vValorProduto     = '';
  	$vQuantProduto     = '';

  	$vCodCliente  = '';
  	$vNomeCliente = '';
  	$vSexoCliente = '';

  	$vVendaCodCliente = '';
  	$vVendaCodigo     = '';

  	$vVenCodigo     	   = '';
  	$vProCodigo     	   = '';
  	// #################################


	// Valida se usuário está logado no framework
	function ValidaLogin(){
		ob_start();
		session_start();
	
		if($_SESSION['USU_CATEGORIA'] == '') {
			header('location: login.php');
		}

		$vPagina = end(explode("/", $_SERVER['PHP_SELF']));

		if( ($vPagina == 'usuarios.php' || $vPagina == 'configuracoes.php') && $_SESSION['USU_CATEGORIA'] == 'Usuario' ){
			header('location: inicial.php');
		}
		if( $vPagina == 'index.php' ){
			header('location: inicial.php');
		}

	}	

	// Valida quais recomendações estarão disponíveis para seleção na tela de recomendações do framework
	function ValidaRecomendacoes(){
		$vCodRecomendacoes = '';

		CarregaDadosConexao();

		if( !empty($GLOBALS["vCodProduto"])  && !empty($GLOBALS["vTabelaProdutos"]) 		&& !empty($GLOBALS["vQuantProduto"]) 	&&
			!empty($GLOBALS["vVendaCodigo"]) && !empty($GLOBALS["vTabelaVendas"])   		&& !empty($GLOBALS["vVendaCodCliente"]) &&
			!empty($GLOBALS["vVenCodigo"])   && !empty($GLOBALS["vTabelaVendasProdutos"])   && !empty($GLOBALS["vProCodigo"]) 		&&
			!empty($GLOBALS["vBaseDados"])   && !empty($GLOBALS["vBancoDados"]) ){
		
			$vCodRecomendacoes = '1, 2, 5, 6, 7, 8';

			if(!empty($GLOBALS["vCategoriaProduto"])){
				$vCodRecomendacoes .= ', 3';
			}
			if(!empty($GLOBALS["vValorProduto"])){
				$vCodRecomendacoes .= ', 4';
			}
		
		}

		if( empty($vCodRecomendacoes) )
			return '0';
		else
			return $vCodRecomendacoes;

	}

	function CarregaDadosConexao(){
  		require_once("bd_funcoes.php");
		$vConexao = BD_AbreConexaoFramework(); 
	    $vSQL = "SELECT * FROM TB_CONEXAO LIMIT 1";
	    $vResultado = BD_ExecutaSQLFramework($vSQL, $vConexao);
	    while($vLinha = mysql_fetch_array($vResultado)){
	      	$GLOBALS["vBancoDados"] = $vLinha["CON_BANCO_DADOS"];
	      	$GLOBALS["vBaseDados"]  = $vLinha["CON_NOME_BANCO"];

	      	$GLOBALS["vTabelaClientes"]  = $vLinha["CON_TABELA_CLIENTES"];
	      	$GLOBALS["vTabelaProdutos"]  = $vLinha["CON_TABELA_PRODUTOS"];
	      	$GLOBALS["vTabelaVendas"]    = $vLinha["CON_TABELA_VENDAS"];

	      	$GLOBALS["vCodProduto"]       = $vLinha["CON_CODIGO_PRODUTO"];
	      	$GLOBALS["vNomeProduto"]      = $vLinha["CON_NOME_PRODUTO"];
	      	$GLOBALS["vCategoriaProduto"] = $vLinha["CON_CATEGORIA_PRODUTO"];
	      	$GLOBALS["vDescricaoProduto"] = $vLinha["CON_DESCRICAO_PRODUTO"];
	      	$GLOBALS["vDataProduto"]      = $vLinha["CON_DATA_PRODUTO"];
	      	$GLOBALS["vValorProduto"]     = $vLinha["CON_VALOR_PRODUTO"];
	      	$GLOBALS["vQuantProduto"]     = $vLinha["CON_QUANT_PRODUTO"];

	      	$GLOBALS["vCodCliente"]  = $vLinha["CON_CODIGO_CLIENTE"];
	      	$GLOBALS["vNomeCliente"] = $vLinha["CON_NOME_CLIENTE"];
		    $GLOBALS["vSexoCliente"] = $vLinha["CON_SEXO_CLIENTE"];

	      	$GLOBALS["vVendaCodCliente"] = $vLinha["CON_COD_VENDA_CLIENTE"];
	      	$GLOBALS["vVendaCodigo"] 	 = $vLinha["CON_COD_VENDA"];

		    $GLOBALS["vTabelaVendasProdutos"]  = $vLinha["CON_TABELA_VENDAS_PRODUTOS"];
		    $GLOBALS["vVenCodigo"]             = $vLinha["CON_VENDA_COD"];
		    $GLOBALS["vProCodigo"]             = $vLinha["CON_PRODUTO_COD"];
	    }
	}

?>