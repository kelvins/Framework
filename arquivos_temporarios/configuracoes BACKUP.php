<?php
  require_once("funcoes/dependencias.php");
  require_once("funcoes/funcoes_framework.php");
  ValidaLogin();

  require_once("funcoes/bd_funcoes.php");

  $vConexao = BD_AbreConexao(); 

  $vSaida = '';

  if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Testa se as variáveis existem e se não estão vazias
    if( isset($_POST["edBaseDados"]) && isset($_POST["edTabelaCliente"]) && 
        isset($_POST["edTabelaProduto"]) && isset($_POST["edTabelaVendas"]) && isset($_POST["edTabelaVendasProdutos"]) &&
        !empty($_POST["edBaseDados"]) && !empty($_POST["edTabelaCliente"]) && 
        !empty($_POST["edTabelaProduto"]) && !empty($_POST["edTabelaVendas"]) && !empty($_POST["edTabelaVendasProdutos"]) ){
    
      // Faz uma busca na tabela para ver se tem algum dado cadastrado
      $vSQL = "SELECT * FROM TB_CONEXAO";
      $vEncontrou = false;
      $vResultado = BD_ExecutaSQL($vSQL, $vConexao);
      while($vLinha = mysql_fetch_array($vResultado)){
        $vEncontrou = true;
      }

      // Se já tiver algum dado na tabela ele irá fazer um UPDATE se não ele fará um INSERT
      if( $vEncontrou ){
        $vSQL = " UPDATE TB_CONEXAO SET                                     " .
                "   CON_BANCO_DADOS     = '".$_POST['edBancoDados']."',     " .
                "   CON_NOME_BANCO      = '".$_POST['edBaseDados']."',      " .
                "   CON_TABELA_CLIENTES = '".$_POST['edTabelaCliente']."',  " .
                "   CON_TABELA_PRODUTOS = '".$_POST['edTabelaProduto']."',  " .
                "   CON_TABELA_VENDAS   = '".$_POST['edTabelaVendas']."',   " .
                "                                                           " .
                "   CON_CODIGO_CLIENTE = '".$_POST['edCodCli']."',          " .
                "   CON_NOME_CLIENTE   = '".$_POST['edNomeCli']."',         " .
                "   CON_SEXO_CLIENTE   = '".$_POST['edSexoCli']."',         " .
                "                                                           " .
                "   CON_CODIGO_PRODUTO    = '".$_POST['edCodPro']."',       " .
                "   CON_NOME_PRODUTO      = '".$_POST['edNomePro']."',      " .
                "   CON_CATEGORIA_PRODUTO = '".$_POST['edCategoriaPro']."', " .
                "   CON_DESCRICAO_PRODUTO = '".$_POST['edDescPro']."',      " .
                "   CON_DATA_PRODUTO      = '".$_POST['edDataPro']."',      " .
                "   CON_VALOR_PRODUTO     = '".$_POST['edValorPro']."',     " .
                "   CON_QUANT_PRODUTO     = '".$_POST['edQuantPro']."',     " .
                "                                                           " .
                "   CON_COD_VENDA_CLIENTE = '".$_POST['edCodVendaCli']."',  " .
                "   CON_COD_VENDA         = '".$_POST['edCodVenda']."',     " .

                "   CON_TABELA_VENDAS_PRODUTOS = '".$_POST['edTabelaVendasProdutos']."',  " .
                "   CON_VENDA_COD              = '".$_POST['edVenCodigo']."',             " .
                "   CON_PRODUTO_COD            = '".$_POST['edProCodigo']."';             " ;
      }else{

       $vSQL =  "INSERT INTO TB_CONEXAO (                  " .
                "        CON_CODIGO,                       " .
                "        CON_BANCO_DADOS,                  " .
                "        CON_NOME_BANCO,                   " .
                "        CON_TABELA_CLIENTES,              " .
                "        CON_TABELA_PRODUTOS,              " .
                "        CON_TABELA_VENDAS,                " .
                "                                          " .
                "        CON_CODIGO_CLIENTE,               " .
                "        CON_NOME_CLIENTE,                 " .
                "        CON_SEXO_CLIENTE,                 " .
                "                                          " .
                "        CON_CODIGO_PRODUTO,               " .
                "        CON_NOME_PRODUTO,                 " .
                "        CON_CATEGORIA_PRODUTO,            " .
                "        CON_DESCRICAO_PRODUTO,            " .
                "        CON_DATA_PRODUTO,                 " .
                "        CON_VALOR_PRODUTO,                " .
                "        CON_QUANT_PRODUTO,                " .
                "                                          " .
                "        CON_COD_VENDA_CLIENTE,            " .
                "        CON_COD_VENDA,                    " .
                "                                          " .
                "        CON_TABELA_VENDAS_PRODUTOS,       " .
                "        CON_VENDA_COD,                    " .
                "        CON_PRODUTO_COD)                  " .
                "                                          " .
                "        VALUES                            " . 
                "                                          " .
                "        (null,                            " .
                "        '".$_POST['edBancoDados']."',     " .
                "        '".$_POST['edBaseDados']."',      " .
                "        '".$_POST['edTabelaCliente']."', " .
                "        '".$_POST['edTabelaProduto']."', " .
                "        '".$_POST['edTabelaVendas']."',   " .
                "                                          " .
                "        '".$_POST['edCodCli']."',         " .
                "        '".$_POST['edNomeCli']."',        " .
                "        '".$_POST['edSexoCli']."',        " .
                "                                          " .
                "        '".$_POST['edCodPro']."',         " .
                "        '".$_POST['edNomePro']."',        " .
                "        '".$_POST['edCategoriaPro']."',   " .
                "        '".$_POST['edDescPro']."',        " .
                "        '".$_POST['edDataPro']."',        " .
                "        '".$_POST['edValorPro']."',       " .
                "        '".$_POST['edQuantPro']."',       " .
                "                                          " .
                "        '".$_POST['edCodVendaCli']."',    " .
                "        '".$_POST['edCodVenda']."',       " .
                "                                          " .
                "        '".$_POST['edTabelaVendasProdutos']."', " .
                "        '".$_POST['edVenCodigo']."',            " .
                "        '".$_POST['edProCodigo']."')            " ;
      }
      
      if (BD_ExecutaSQL($vSQL, $vConexao)){                
        $vSaida = 
            "<div class='alert alert-success' align='center'>
              Dados salvos com sucesso
            </div>";
      }else{
        $vSaida = 
            "<div class='alert alert-danger' align='center'>
              Erro ao salvar os dados, tente novamente
            </div>";
      }

    }else{
      $vSaida = 
          "<div class='alert alert-danger' align='center'>
            Não foi possível salvar os dados, verifique os campos de nome das tabelas
          </div>";
    }

    // Independente se foi salvo ou não ele carrega todos os campos novamente
    $vBancoDados = $_POST["edBancoDados"];
    $vBaseDados  = $_POST["edBaseDados"];

    $vTabelaClientes  = $_POST["edTabelaCliente"];
    $vTabelaProdutos  = $_POST["edTabelaProduto"];
    $vTabelaVendas    = $_POST["edTabelaVendas"];

    $vCodProduto       = $_POST["edCodPro"];
    $vNomeProduto      = $_POST["edNomePro"];
    $vCategoriaProduto = $_POST["edCategoriaPro"];
    $vDescricaoProduto = $_POST["edDescPro"];
    $vDataProduto      = $_POST["edDataPro"];
    $vValorProduto     = $_POST["edValorPro"];
    $vQuantProduto     = $_POST["edQuantPro"];

    $vCodCliente  = $_POST["edCodCli"];
    $vNomeCliente = $_POST["edNomeCli"];
    $vSexoCliente = $_POST["edSexoCli"];

    $vVendaCodCliente = $_POST["edCodVendaCli"];
    $vVendaCodigo     = $_POST["edCodVenda"];

    $vTabelaVendasProdutos  = $_POST["edTabelaVendasProdutos"];
    $vVenCodigo             = $_POST["edVenCodigo"];
    $vProCodigo             = $_POST["edProCodigo"];

  }else{
    // Se a página não foi requisitada com POST ele busca os dados do banco para carregar os campos da tela; 
    $vSQL = "SELECT * FROM TB_CONEXAO";

    $vResultado = BD_ExecutaSQL($vSQL, $vConexao);
    while($vLinha = mysql_fetch_array($vResultado)){
      $vBancoDados = $vLinha["CON_BANCO_DADOS"];
      $vBaseDados  = $vLinha["CON_NOME_BANCO"];

      $vTabelaClientes  = $vLinha["CON_TABELA_CLIENTES"];
      $vTabelaProdutos  = $vLinha["CON_TABELA_PRODUTOS"];
      $vTabelaVendas    = $vLinha["CON_TABELA_VENDAS"];

      $vCodProduto       = $vLinha["CON_CODIGO_PRODUTO"];
      $vNomeProduto      = $vLinha["CON_NOME_PRODUTO"];
      $vCategoriaProduto = $vLinha["CON_CATEGORIA_PRODUTO"];
      $vDescricaoProduto = $vLinha["CON_DESCRICAO_PRODUTO"];
      $vDataProduto      = $vLinha["CON_DATA_PRODUTO"];
      $vValorProduto     = $vLinha["CON_VALOR_PRODUTO"];
      $vQuantProduto     = $vLinha["CON_QUANT_PRODUTO"];

      $vCodCliente  = $vLinha["CON_CODIGO_CLIENTE"];
      $vNomeCliente = $vLinha["CON_NOME_CLIENTE"];
      $vSexoCliente = $vLinha["CON_SEXO_CLIENTE"];

      $vVendaCodCliente = $vLinha["CON_COD_VENDA_CLIENTE"];
      $vVendaCodigo     = $vLinha["CON_COD_VENDA"];

      $vTabelaVendasProdutos  = $vLinha["CON_TABELA_VENDAS_PRODUTOS"];
      $vVenCodigo             = $vLinha["CON_VENDA_COD"];
      $vProCodigo             = $vLinha["CON_PRODUTO_COD"];
    }

  }

  BD_FechaConexao($vConexao);
?>

<!DOCTYPE html>
<html>

  <head>
    <?php Head(); ?>
    <title>Configurações - Framework</title>
  </head>

  <body>
  
    <div class="container-fluid">
      <div class="row">

        <?php Menu(); ?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
          <h2 class="page-header">Configuração do Framework</h2>
          <?php echo $vSaida; ?>

          <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">

            <div class="form-group col-sm-12">
              <h4 class="page-header">Dados da Base de Dados</h4>
              <div class="form-group col-sm-6">
                <label>* Nome da Base de Dados</label>
                <input type="text" class="form-control" id="edBaseDados" placeholder="Ex.: db_loja_virtual" required="true" name="edBaseDados" value=<?php echo $vBaseDados; ?> >
              </div>
              <div class="form-group col-sm-6">
                <label>* Banco de dados</label>
                <select class="form-control" id="edBancoDados" name="edBancoDados">
                  <option value="MySQL">MySQL</option>
                </select>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <h4 class="page-header">Dados dos Produtos</h4>
              <div class="form-group col-sm-6">
                <label>* Nome da Tabela de Produtos</label>
                <input type="text" class="form-control" id="edTabelaProduto" placeholder="Ex.: tb_produtos" required="true" name="edTabelaProduto" value=<?php echo $vTabelaProdutos; ?> >
              </div>
              <div class="form-group col-sm-6">
                <label>* Nome do Campo Código do Produto</label>
                <input type="text" class="form-control" id="edCodPro" placeholder="Ex.: pro_codigo" required="true" name="edCodPro" value=<?php echo $vCodProduto; ?> >
              </div>
              <div class="form-group col-sm-6">
                <label>Nome do Campo Nome do Produto</label>
                <input type="text" class="form-control" id="edNomePro" placeholder="Ex.: pro_nome" name="edNomePro" value=<?php echo $vNomeProduto; ?> >
              </div>
              <div class="form-group col-sm-6">
                <label>Nome do Campo Categoria do Produto</label>
                <input type="text" class="form-control" id="edCategoriaPro" placeholder="Ex.: pro_categoria" name="edCategoriaPro" value=<?php echo $vCategoriaProduto; ?> >
              </div>
              <div class="form-group col-sm-6">
                <label>Nome do Campo Descrição do Produto</label>
                <input type="text" class="form-control" id="edDescPro" placeholder="Ex.: pro_desc" name="edDescPro" value=<?php echo $vDescricaoProduto; ?> >
              </div>
              <div class="form-group col-sm-6">
                <label>Nome do Campo Data de Entrada do Produto</label>
                <input type="text" class="form-control" id="edDataPro" placeholder="Ex.: pro_entrada" name="edDataPro" value=<?php echo $vDataProduto; ?> >
              </div>
              <div class="form-group col-sm-6">
                <label>Nome do Campo Valor do Produto</label>
                <input type="text" class="form-control" id="edValorPro" placeholder="Ex.: pro_valor" name="edValorPro" value=<?php echo $vValorProduto; ?> >
              </div>
              <div class="form-group col-sm-6">
                <label>* Nome do Campo Quantidade do Produto</label>
                <input type="text" class="form-control" id="edQuantPro" placeholder="Ex.: pro_quantidade" required="true" name="edQuantPro" value=<?php echo $vQuantProduto; ?> >
              </div>
            </div>

            <div class="form-group col-sm-12">
              <h4 class="page-header">Dados dos Clientes</h4>
              <div class="form-group col-sm-6">
                <label>Nome da Tabela de Clientes</label>
                <input type="text" class="form-control" id="edTabelaCliente" placeholder="Ex.: tb_clientes" name="edTabelaCliente" value=<?php echo $vTabelaClientes; ?> >
              </div>
              <div class="form-group col-sm-6">
                <label>Nome do Campo Código do Cliente</label>
                <input type="text" class="form-control" id="edCodCli" placeholder="Ex.: cli_id" name="edCodCli" value=<?php echo $vCodCliente; ?> >
              </div>
              <div class="form-group col-sm-6">
                <label>Nome do Campo Nome do Cliente</label>
                <input type="text" class="form-control" id="edNomeCli" placeholder="Ex.: cli_nome" name="edNomeCli" value=<?php echo $vNomeCliente; ?> >
              </div>
              <div class="form-group col-sm-6">
                <label>Nome do Campo Sexo do Cliente</label>
                <input type="text" class="form-control" id="edSexoCli" placeholder="Ex.: cli_sexo" name="edSexoCli" value=<?php echo $vSexoCliente; ?> >
              </div>
            </div>

            <div class="form-group col-sm-12">
              <h4 class="page-header">Dados das Vendas</h4>
              <div class="form-group col-sm-6">
                <label>* Nome da Tabela de Vendas</label>
                <input type="text" class="form-control" id="edTabelaVendas" placeholder="Ex.: tb_vendas" name="edTabelaVendas" value=<?php echo $vTabelaVendas; ?> >
              </div>
              <div class="form-group col-sm-6">
                <label>* Nome do Campo Código da Venda</label>
                <input type="text" class="form-control" id="edCodVenda" placeholder="Ex.: ven_codigo" name="edCodVenda" value=<?php echo $vVendaCodigo; ?> >
              </div>
              <div class="form-group col-sm-6">
                <label>* Nome do Campo Código do Cliente</label>
                <input type="text" class="form-control" id="edCodVendaCli" placeholder="Ex.: ven_cli_cod" name="edCodVendaCli" value=<?php echo $vVendaCodCliente; ?> >
              </div>
            </div>

            <div class="form-group col-sm-12">
              <h4 class="page-header">Dados dos Produtos das Vendas</h4>
              <div class="form-group col-sm-6">
                <label>* Nome da Tabela de Vendas/Produtos</label>
                <input type="text" class="form-control" id="edTabelaVendasProdutos" placeholder="Ex.: tb_venda_produto" name="edTabelaVendasProdutos" value=<?php echo $vTabelaVendasProdutos; ?> >
              </div>
              <div class="form-group col-sm-6">
                <label>* Nome do Campo Código da Venda</label>
                <input type="text" class="form-control" id="edVenCodigo" placeholder="Ex.: ven_codigo" name="edVenCodigo" value=<?php echo $vVenCodigo; ?> >
              </div>
              <div class="form-group col-sm-6">
                <label>* Nome do Campo Código do Produto</label>
                <input type="text" class="form-control" id="edProCodigo" placeholder="Ex.: pro_codigo" name="edProCodigo" value=<?php echo $vProCodigo; ?> >
              </div>
            </div>

            <div class="form-group col-sm-12" align="right">
            <div class="form-group col-sm-8" align="left">Obs.: Campos com (*) são de preenchimento obrigatório.</div>
            <div class="form-group col-sm-4">
              <button type="submit" class="btn btn-primary" style="width: 100%;"><i class="glyphicon glyphicon-ok"></i>Salvar</button>
            </div>
            </div>

          </form>

        </div>
      </div>
    </div>

  </body>
</html>