<?php
	require_once("funcoes/bd_funcoes.php"); // Carrega arquivo de funcoes de conexao com o banco de dados
	require_once("funcoes/funcoes_framework.php"); // Carrega arquivo de funcoes de conexao com o banco de dados

  	$vSQL_Geral = "";
  	$vQuantidade = 0;
  	$vRecomendacao = array();
	
	/*
	* Verifica se a chamada foi feita com GET, se sim chama a função de recomendação
	* que gera o array e retorna o array formatado em JSON.
	* O if valida se a requisição foi GET e se os campos usuario e quantidade existem e estão preenchidos.
	*/
  	if( $_SERVER["REQUEST_METHOD"] == "GET" && 
  		isset($_GET["usuario"]) && !empty($_GET["usuario"]) &&
  		isset($_GET["quantidade"]) && !empty($_GET["quantidade"]) ){

  		$vArrayAuxiliar = Recomende($_GET["usuario"], $_GET["quantidade"]);

  		echo json_encode($vArrayAuxiliar, JSON_FORCE_OBJECT);
  	}

	/* 
	* Função que recebe o código do cliente e a quantidade de produtos que deseja recomendar
	* realiza a busca no banco para ver qual recomendação está selecionada, e chama o arquivo determinado da recomendação
	* que irá retornar os itens a serem recomendados
	*/
	function Recomende($pCodCliente, $pQuantidade){

		$GLOBALS["vQuantidade"] = $pQuantidade;
	    CarregaDadosConexao();

	    // Garante que os campos obrigatórios estejam preenchidos antes de seguir com as recomendações
	    // Utiliza as tabelas de vendas para não recomendar produtos que o cliente já tenha comprado
	    if( empty($GLOBALS["vCodProduto"])     || empty($GLOBALS["vVendaCodigo"]) 		   || 
	    	empty($GLOBALS["vTabelaVendas"])   || empty($GLOBALS["vVendaCodCliente"]) 	   ||
	    	empty($GLOBALS["vQuantProduto"])   || empty($GLOBALS["vBaseDados"])       	   || 
	    	empty($GLOBALS["vBancoDados"])     || empty($GLOBALS["vTabelaClientes"])  	   || 
	    	empty($GLOBALS["vTabelaProdutos"]) || empty($GLOBALS["vTabelaVendasProdutos"]) ||
	    	empty($GLOBALS["vVenCodigo"]) 	   || empty($GLOBALS["vProCodigo"])       	   || 
	    	empty($pCodCliente) 			   || empty($pQuantidade)       		  	   ){
	    	return array();
		}

	    /* 
	    *  - SQL Padrão para todas as consultas -
	    *  Seleciona produtos diferentes dos produtos já comprados pelo cliente, produtos que tenham quantidade maior do que 0, 
	    *  e limita a quantidade selecionada de acordo com o parâmetro $pQuantidade
	    */
		$GLOBALS["vSQL_Geral"] = "SELECT ". $GLOBALS["vCodProduto"] ." FROM ". $GLOBALS["vTabelaProdutos"] ." WHERE 				" .
								 " ". $GLOBALS["vCodProduto"] ." NOT IN 											 		 		" .
								 " (SELECT VP.". $GLOBALS["vProCodigo"] ." FROM ". $GLOBALS["vTabelaVendasProdutos"] ." VP  	 	" . 
								 " 							INNER JOIN ". $GLOBALS["vTabelaVendas"] ." V  	 						" .
								 " 							ON V.". $GLOBALS["vVendaCodigo"] ." = VP.". $GLOBALS["vVenCodigo"] ." 	" . 
								 " 		WHERE V.". $GLOBALS["vVendaCodCliente"] ." = ". $pCodCliente .") 				 			" .
								 " 		AND ". $GLOBALS["vQuantProduto"] ." > 0										 				" ;

		// Busca o código da recomendação no banco de dados do framework
		$vConexao = BD_AbreConexaoFramework(); 

		$vCodigoRecomendacao = 0;

		$vSQL = "SELECT PAR_CODIGO FROM TB_PARAMETROS WHERE PAR_SELECIONADO = true";
		$vResultado = BD_ExecutaSQLFramework($vSQL, $vConexao);
	    while($vLinha = mysql_fetch_array($vResultado)){
	    	$vCodigoRecomendacao = $vLinha["PAR_CODIGO"];
	    }
		// Fecha conexão com o banco do cliente
    	BD_FechaConexaoFramework($vConexao);

    	switch($vCodigoRecomendacao) {
    		case 1: Recomendacao1($pCodCliente); break;
    		case 2: Recomendacao2($pCodCliente); break;
    		case 3: Recomendacao3($pCodCliente); break;
    		case 4: Recomendacao4($pCodCliente); break;
    		case 5: Recomendacao5($pCodCliente); break;
    		case 6: Recomendacao6($pCodCliente); break;
    		case 7: Recomendacao7($pCodCliente); break;
    		case 8: Recomendacao8($pCodCliente); break;
    		
    		default: return $GLOBALS["vRecomendacao"]; break;
    	}

    	// Garante que irá retornar a quantidade de códigos solicitados, SE ACHOU PELO MENOS 1 SE O ARRAY FOR = 0 ELE RETORNA VAZIO
    	if( count($GLOBALS["vRecomendacao"]) < $GLOBALS["vQuantidade"] && count($GLOBALS["vRecomendacao"]) > 0 ){ // Se a quantidade buscada for menor do que a solicitada
    		$GLOBALS["vQuantidade"] -= count($GLOBALS["vRecomendacao"]); // vQuantidade recebe a quantidade que falta buscar
    		// SQL busca produtos mais antigos diferentes dos já comprados e dos já buscados anteriormente limitando pela quantidade que falta buscar
    		$vSQL = " ". $GLOBALS["vSQL_Geral"] ." AND ". $GLOBALS["vCodProduto"] ." NOT IN (". implode(", ", $GLOBALS["vRecomendacao"]) .") ORDER BY ". $GLOBALS["vCodProduto"] ." LIMIT ". $GLOBALS["vQuantidade"] ." ";
    		BuscaProdutos($vSQL);
    	}else if( empty($GLOBALS["vRecomendacao"]) ){ // Se o array estiver vazio
    		$vSQL = " ". $GLOBALS["vSQL_Geral"] ." ORDER BY ". $GLOBALS["vCodProduto"] ." LIMIT ". $GLOBALS["vQuantidade"] ." ";
    		BuscaProdutos($vSQL);
    	}

    	return $GLOBALS["vRecomendacao"];

	}

	function BuscaProdutos($pSQL){
	    // Abre conexão com o banco do cliente
	    $vConexao = BD_ConectaCliente($GLOBALS["vBaseDados"]);
	    
		$vResultado = BD_ExecutaSQLFramework($pSQL, $vConexao);
	    while($vLinha = mysql_fetch_array($vResultado)){
	    	array_push($GLOBALS["vRecomendacao"], (int)$vLinha[$GLOBALS["vCodProduto"]] );
	    }

	    BD_FechaConexaoFramework($vConexao);
	}

	// Recomenda produtos mais antigos
	function Recomendacao1($pCodCliente){
		$vSQL = " ". $GLOBALS["vSQL_Geral"] ." ORDER BY ". $GLOBALS["vCodProduto"] ." LIMIT ". $GLOBALS["vQuantidade"] ." ";
		BuscaProdutos($vSQL);
	}
	
	// Recomenda produtos mais recentes
	function Recomendacao2($pCodCliente){
		$vSQL = " ". $GLOBALS["vSQL_Geral"] ." ORDER BY ". $GLOBALS["vCodProduto"] ." DESC LIMIT ". $GLOBALS["vQuantidade"] ." ";
		BuscaProdutos($vSQL);	
	}

	// Recomenda produtos de mesma categoria
	function Recomendacao3($pCodCliente){
		$vSQL = " ". $GLOBALS["vSQL_Geral"] ." AND ". $GLOBALS["vCategoriaProduto"] ." IN 						 " .
				"																								 " .
				"   	(SELECT P.". $GLOBALS["vCategoriaProduto"] ." FROM ". $GLOBALS["vTabelaProdutos"] ." P   " . 
				" 			INNER JOIN ". $GLOBALS["vTabelaVendasProdutos"] ." VP  	 							 " .
				" 				ON P.". $GLOBALS["vCodProduto"] ." = VP.". $GLOBALS["vProCodigo"] ." 			 " . 
				" 			INNER JOIN ". $GLOBALS["vTabelaVendas"] ." V  	 									 " .
				" 				ON V.". $GLOBALS["vVendaCodigo"] ." = VP.". $GLOBALS["vVenCodigo"] ." 			 " .
				"																								 " . 
				" 				WHERE V.". $GLOBALS["vVendaCodCliente"] ." = ". $pCodCliente .") 				 " .
				"  																								 " .
				"  ORDER BY	". $GLOBALS["vCategoriaProduto"] ." 												 " .
				"  LIMIT ". $GLOBALS["vQuantidade"] ." 															 " ;
		BuscaProdutos($vSQL);	
	}

	// Recomenda produtos de valor semelhante aos comprados
	function Recomendacao4($pCodCliente){
		$vSQL = " ". $GLOBALS["vSQL_Geral"] ." AND ". $GLOBALS["vValorProduto"] ."	BETWEEN 	 				 " .
				"																								 " . 
				"   	(SELECT AVG(P.". $GLOBALS["vValorProduto"] .")*0.80 FROM ". $GLOBALS["vTabelaProdutos"] ." P   	 " . 
				" 			INNER JOIN ". $GLOBALS["vTabelaVendasProdutos"] ." VP  	 							 " .
				" 				ON P.". $GLOBALS["vCodProduto"] ." = VP.". $GLOBALS["vProCodigo"] ." 			 " . 
				" 			INNER JOIN ". $GLOBALS["vTabelaVendas"] ." V  	 									 " .
				" 				ON V.". $GLOBALS["vVendaCodigo"] ." = VP.". $GLOBALS["vVenCodigo"] ." 			 " .
				"																								 " . 
				" 				WHERE V.". $GLOBALS["vVendaCodCliente"] ." = ". $pCodCliente ." 				 " .
				" 				ORDER BY ". $GLOBALS["vValorProduto"] ." LIMIT 1 ) 				 				 " .
				"																								 " . 
				"							AND																	 " . 
				"																								 " . 
				"   	(SELECT AVG(P.". $GLOBALS["vValorProduto"] .")*1.20 FROM ". $GLOBALS["vTabelaProdutos"] ." P   	 " . 
				" 			INNER JOIN ". $GLOBALS["vTabelaVendasProdutos"] ." VP  	 							 " .
				" 				ON P.". $GLOBALS["vCodProduto"] ." = VP.". $GLOBALS["vProCodigo"] ." 			 " . 
				" 			INNER JOIN ". $GLOBALS["vTabelaVendas"] ." V  	 									 " .
				" 				ON V.". $GLOBALS["vVendaCodigo"] ." = VP.". $GLOBALS["vVenCodigo"] ." 			 " .
				"																								 " . 
				" 				WHERE V.". $GLOBALS["vVendaCodCliente"] ." = ". $pCodCliente ." 				 " .
				" 				ORDER BY ". $GLOBALS["vValorProduto"] ." DESC LIMIT 1 ) 				 		 " .
				"																								 " . 
				"  LIMIT ". $GLOBALS["vQuantidade"] ." 															 " ;
		BuscaProdutos($vSQL);	
	}

	// Recomenda produtos mais vendidos
	function Recomendacao5($pCodCliente){
		$vSQL = " ". $GLOBALS["vSQL_Geral"] ." AND ". $GLOBALS["vProCodigo"] ." IN " .
				" (SELECT VP.". $GLOBALS["vProCodigo"] ." FROM ". $GLOBALS["vTabelaVendasProdutos"] ." VP " .
				"	GROUP BY VP.". $GLOBALS["vProCodigo"] ." ORDER BY COUNT(". $GLOBALS["vProCodigo"] .") ) " .
				"	LIMIT ". $GLOBALS["vQuantidade"] ." ";
		BuscaProdutos($vSQL);
	}	

	// Recomenda produtos menos vendidos
	function Recomendacao6($pCodCliente){
		$vSQL = " ". $GLOBALS["vSQL_Geral"] ." AND ". $GLOBALS["vProCodigo"] ." NOT IN " .
				" (SELECT VP.". $GLOBALS["vProCodigo"] ." FROM ". $GLOBALS["vTabelaVendasProdutos"] ." VP " .
				"	GROUP BY VP.". $GLOBALS["vProCodigo"] ." ORDER BY COUNT(". $GLOBALS["vProCodigo"] .") ) " .
				"	LIMIT ". $GLOBALS["vQuantidade"] ." ";
		BuscaProdutos($vSQL);
	}	

	// Recomenda produtos com maior quantidade em estoque
	function Recomendacao7($pCodCliente){
		$vSQL = " ". $GLOBALS["vSQL_Geral"] ." ORDER BY ". $GLOBALS["vQuantProduto"] ." DESC LIMIT ". $GLOBALS["vQuantidade"] ." ";
		BuscaProdutos($vSQL);
	}	

	// Recomenda produtos com maior quantidade em estoque
	function Recomendacao8($pCodCliente){
		$vSQL = " ". $GLOBALS["vSQL_Geral"] ." ORDER BY ". $GLOBALS["vQuantProduto"] ." LIMIT ". $GLOBALS["vQuantidade"] ." ";
		BuscaProdutos($vSQL);
	}

?>