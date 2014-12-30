<?php
	// Cria base de dados
	require_once("bd_funcoes.php");

	$vConexao = BD_AbreConexaoFramework();

	$vBaseCriada = 0;
    $vSQL = "SHOW TABLES";
  	$vResultado = BD_ExecutaSQLFramework($vSQL, $vConexao);
  	while($vLinha = mysql_fetch_array($vResultado)){
  		$vBaseCriada ++;
  	}

  	if($vBaseCriada < 3){
  		mysql_select_db("db_framework") or die(mysql_error());
		$vDB = '
		/* Tabela de usuarios (Categorias : Administrador ou Usuario) */
		CREATE TABLE TB_USUARIOS(
			USU_CODIGO INTEGER NOT NULL AUTO_INCREMENT,
			USU_NOME VARCHAR(50) NOT NULL,
			USU_LOGIN VARCHAR(50) NOT NULL,
			USU_SENHA VARCHAR(50) NOT NULL,
			USU_EMAIL VARCHAR(50) NOT NULL,
			USU_CATEGORIA VARCHAR(20) NOT NULL,
			USU_ATIVO BOOLEAN NOT NULL,
			PRIMARY KEY(USU_CODIGO)
		);

		/* 
		   Tabela que guarda os dados da conexão
		   O nome do banco de dados
		   O nome das tabelas e dos campos que serão
		   necessários de cada tabela
		*/
		CREATE TABLE TB_CONEXAO(
			CON_CODIGO INTEGER NOT NULL AUTO_INCREMENT,
			CON_BANCO_DADOS VARCHAR(100) NOT NULL,
			CON_NOME_BANCO VARCHAR(100) NOT NULL,
			CON_TABELA_CLIENTES VARCHAR(100),
			CON_TABELA_PRODUTOS VARCHAR(100),
			CON_TABELA_VENDAS VARCHAR(100),
			CON_TABELA_VENDAS_PRODUTOS VARCHAR(100),
			
			CON_CODIGO_CLIENTE VARCHAR(100),
			CON_NOME_CLIENTE VARCHAR(100),
			CON_SEXO_CLIENTE VARCHAR(100),

			CON_CODIGO_PRODUTO VARCHAR(100),
			CON_NOME_PRODUTO VARCHAR(100),
			CON_CATEGORIA_PRODUTO VARCHAR(100),
			CON_DESCRICAO_PRODUTO VARCHAR(100),
			CON_DATA_PRODUTO VARCHAR(100),
			CON_VALOR_PRODUTO VARCHAR(100),
			CON_QUANT_PRODUTO VARCHAR(100),

			CON_COD_VENDA_CLIENTE VARCHAR(100),
			CON_COD_VENDA VARCHAR(100),

			CON_VENDA_COD VARCHAR(100),
			CON_PRODUTO_COD VARCHAR(100),

			PRIMARY KEY(CON_CODIGO)
		);

		/* Tabela onde serão armazenados os parametros selecionados */
		CREATE TABLE TB_PARAMETROS(
			PAR_CODIGO INTEGER NOT NULL AUTO_INCREMENT,
			PAR_PARAMETRO VARCHAR(50) NOT NULL,
			PAR_DESCRICAO VARCHAR(500),
			PAR_SELECIONADO BOOL,
			PRIMARY KEY(PAR_CODIGO)
		);
			
		/* Tabela onde será armazenados os possiveis sub-parametros(configuracoes) dos parametros */
		CREATE TABLE TB_PARAMETROS_AUXILIAR(
			PAR_AUX_CODIGO INTEGER NOT NULL AUTO_INCREMENT,
			PAR_CODIGO INTEGER NOT NULL,
			PAR_AUX_QUANTIDADE INTEGER,
			PAR_AUX_ESTACAO_ANO VARCHAR(10),
			PAR_AUX_DATA_INICIO DATE,
			PAR_AUX_DATA_FIM DATE,
			PAR_AUX_DESCRICAO VARCHAR(50),
			PRIMARY KEY(PAR_AUX_CODIGO),
			FOREIGN KEY(PAR_CODIGO) REFERENCES TB_PARAMETROS(PAR_CODIGO)
		);

		/* Inserts necessários para começar a usar o framework */

		/* Usuário padrão do framework, deve ser alterado após a instalação */
		INSERT INTO TB_USUARIOS VALUES(null, "Admin", "admin", "admin", "admin@admin.com.br", "Administrador", true);

		/* Criação das recomendações */
		/* 01 */INSERT INTO TB_PARAMETROS VALUES(null, "Recomendar produtos mais antigos", "Este método recomendará produtos que estão a mais tempo no estoque da loja.", false);
		/* 02 */INSERT INTO TB_PARAMETROS VALUES(null, "Recomendar produtos mais recentes", "Este método recomendará os últimos produtos adicionados ao estoque da loja.", false);
		/* 03 */INSERT INTO TB_PARAMETROS VALUES(null, "Recomendar produtos de mesma categoria", "Este método irá recomendar produtos da mesma categoria de outros produtos que o cliente já comprou.", false);
		/* 04 */INSERT INTO TB_PARAMETROS VALUES(null, "Recomendar produtos de valor semelhante", "Este método irá recomendar produtos de valor aproximado a outros produtos que o cliente já comprou.", false);

		/* 05 */INSERT INTO TB_PARAMETROS VALUES(null, "Recomendar produtos mais vendidos", "Este método irá recomendar os produtos mais vendidos da loja.", false);
		/* 06 */INSERT INTO TB_PARAMETROS VALUES(null, "Recomendar produtos menos vendidos", "Este método irá recomendar produtos menos vendidos da loja.", false);
		/* 07 */INSERT INTO TB_PARAMETROS VALUES(null, "Recomendar produtos com maior quantidade", "Este método irá recomendar produtos de maior quantidade em estoque.", false);
		/* 08 */INSERT INTO TB_PARAMETROS VALUES(null, "Recomendar produtos com menor quantidade", "Este método irá recomendar produtos de menor quantidade em estoque.", false);
		';

		if(BD_ExecutaSQLFramework($vSQL, $vConexao)){                
	        //header('location: configuracoes.php?pag4');
	    	echo 'OK CRIADA';
	    }else{
	    	echo 'NAO CRIOU';
	    }
	}
?>