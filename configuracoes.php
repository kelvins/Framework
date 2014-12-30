<?php
  require_once("funcoes/dependencias.php");
  require_once("funcoes/funcoes_framework.php");
  require_once("funcoes/bd_funcoes.php");

  ValidaLogin();

  // Variaveis utilizadas para visualização de conteudos da pagina
  $pag1 = '<div id="pag1" hidden>';
  $pag2 = '<div id="pag2" hidden>';
  $pag3 = '<div id="pag3" hidden>';  
  $pag4 = '<div id="pag4" hidden>';
  $pag5 = '<div id="pag5" hidden>';
  $pag6 = '<div id="pag6" hidden>';
  $pag7 = '<div id="pag7" hidden>';

  // Variaveis utilizadas para carregar as opcoes de selecao de cada campo
  $vOpcoesTabelaCliente        = '';
  $vOpcoesTabelaProdutos       = '';
  $vOpcoesTabelaVendas         = '';
  $vOpcoesTabelaVendasProdutos = '';

  $vOpcoesCodProduto       = '';
  $vOpcoesNomeProduto      = '';
  $vOpcoesCategoriaProduto = '';
  $vOpcoesDescricaoProduto = '';
  $vOpcoesDataProduto      = '';
  $vOpcoesValorProduto     = '';
  $vOpcoesQuantProduto     = '';

  $vOpcoesCodCliente  = '';
  $vOpcoesNomeCliente = '';
  $vOpcoesSexoCliente = '';

  $vOpcoesVendaCodCliente = '';
  $vOpcoesVendaCodigo     = '';

  $vOpcoesVenCodigo = '';
  $vOpcoesProCodigo = '';

  // Se a requisicao for GET
  if($_SERVER["REQUEST_METHOD"] == "GET"){

    $vConexao = BD_AbreConexaoFramework();

    $vSQL = "SELECT * FROM TB_CONEXAO";

    $vResultado = BD_ExecutaSQLFramework($vSQL, $vConexao);
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

    if (isset($_GET["pag1"])){
      // ########## GET PAG 1 ##########
      $pag1 = '<div id="pag1">';
      // ########## FIM GET PAG 1 ##########
    }else if (isset($_GET["pag2"])){
      // ########## GET PAG 2 ##########      
      $pag2 = '<div id="pag2">';
      $vConexao = BD_ConectaCliente($vBaseDados);
      
      $vSQL = "SHOW TABLES";

      $vResultado = BD_ExecutaSQLFramework($vSQL, $vConexao);
      while($vLinha = mysql_fetch_array($vResultado)){

        $vConteudo = $vLinha["Tables_in_". strtolower($vBaseDados)];

        // Se não conseguiu encontrar nenhuma tabela
        if( empty($vConteudo) ){
          $vSaida = '<div class="alert alert-danger" role="alert" align="center">
                      <strong>Atenção!</strong> Não foi possível encontrar a base de dados informada
                    </div>
                    <div class="form-group col-sm-4" align="center">
                      <a href="configuracoes.php?pag1" class="btn btn-warning" role="button" style="width: 100%;">
                        <i class="glyphicon glyphicon-chevron-left"></i> Voltar
                      </a>
                    </div>';
          $pag2 = '<div id="pag2" hidden>';
          break;
        }
        
        if( $vConteudo == strtolower($vTabelaClientes) ){
          $vOpcoesTabelaCliente .= '<option selected value="'. $vConteudo .'">'. $vConteudo .'</option>';
        }else{
          $vOpcoesTabelaCliente .= '<option value="'. $vConteudo .'">'. $vConteudo .'</option>';        
        }       

        if( $vConteudo == strtolower($vTabelaProdutos) ){
          $vOpcoesTabelaProdutos .= '<option selected value="'. $vConteudo .'">'. $vConteudo .'</option>';
        }else{
          $vOpcoesTabelaProdutos .= '<option value="'. $vConteudo .'">'. $vConteudo .'</option>';        
        }      

        if( $vConteudo == strtolower($vTabelaVendas) ){
          $vOpcoesTabelaVendas .= '<option selected value="'. $vConteudo .'">'. $vConteudo .'</option>';
        }else{
          $vOpcoesTabelaVendas .= '<option value="'. $vConteudo .'">'. $vConteudo .'</option>';        
        }        

        if( $vConteudo == strtolower($vTabelaVendasProdutos) ){
          $vOpcoesTabelaVendasProdutos .= '<option selected value="'. $vConteudo .'">'. $vConteudo .'</option>';
        }else{
          $vOpcoesTabelaVendasProdutos .= '<option value="'. $vConteudo .'">'. $vConteudo .'</option>';        
        }
        
      }
      // ########## FIM GET PAG 2 ##########
    }else if (isset($_GET["pag3"])){
      // ########## GET PAG 3 ##########
      if( empty($vTabelaProdutos) )
        header('location: configuracoes.php?pag4');

      $vConexao = BD_ConectaCliente($vBaseDados);
      
      $vSQL = "DESCRIBE ". $vTabelaProdutos;

      $vResultado = BD_ExecutaSQLFramework($vSQL, $vConexao);
      while($vLinha = mysql_fetch_array($vResultado)){
        
        $vConteudo = strtolower($vLinha["Field"]);
        
        if( $vConteudo == strtolower($vCodProduto) ){
          $vOpcoesCodProduto .= '<option selected value="'. $vConteudo .'">'. $vConteudo .'</option>';
        }else{
          $vOpcoesCodProduto .= '<option value="'. $vConteudo .'">'. $vConteudo .'</option>';        
        }       

        if( $vConteudo == strtolower($vNomeProduto) ){
          $vOpcoesNomeProduto .= '<option selected value="'. $vConteudo .'">'. $vConteudo .'</option>';
        }else{
          $vOpcoesNomeProduto .= '<option value="'. $vConteudo .'">'. $vConteudo .'</option>';        
        }      

        if( $vConteudo == strtolower($vCategoriaProduto) ){
          $vOpcoesCategoriaProduto .= '<option selected value="'. $vConteudo .'">'. $vConteudo .'</option>';
        }else{
          $vOpcoesCategoriaProduto .= '<option value="'. $vConteudo .'">'. $vConteudo .'</option>';        
        }        

        if( $vConteudo == strtolower($vDescricaoProduto) ){
          $vOpcoesDescricaoProduto .= '<option selected value="'. $vConteudo .'">'. $vConteudo .'</option>';
        }else{
          $vOpcoesDescricaoProduto .= '<option value="'. $vConteudo .'">'. $vConteudo .'</option>';        
        }

        if( $vConteudo == strtolower($vDataProduto) ){
          $vOpcoesDataProduto .= '<option selected value="'. $vConteudo .'">'. $vConteudo .'</option>';
        }else{
          $vOpcoesDataProduto .= '<option value="'. $vConteudo .'">'. $vConteudo .'</option>';        
        }

        if( $vConteudo == strtolower($vValorProduto) ){
          $vOpcoesValorProduto .= '<option selected value="'. $vConteudo .'">'. $vConteudo .'</option>';
        }else{
          $vOpcoesValorProduto .= '<option value="'. $vConteudo .'">'. $vConteudo .'</option>';        
        }

        if( $vConteudo == strtolower($vQuantProduto) ){
          $vOpcoesQuantProduto .= '<option selected value="'. $vConteudo .'">'. $vConteudo .'</option>';
        }else{
          $vOpcoesQuantProduto .= '<option value="'. $vConteudo .'">'. $vConteudo .'</option>';        
        }
        
      }

      $pag3 = '<div id="pag3">';
      // ########## FIM GET PAG 3 ##########
    }else if (isset($_GET["pag4"])){
      // ########## GET PAG 4 ##########
      if( empty($vTabelaClientes) )
        header('location: configuracoes.php?pag5');

      $vConexao = BD_ConectaCliente($vBaseDados);
      
      $vSQL = "DESCRIBE ". $vTabelaClientes;

      $vResultado = BD_ExecutaSQLFramework($vSQL, $vConexao);
      while($vLinha = mysql_fetch_array($vResultado)){
        
        $vConteudo = strtolower($vLinha["Field"]);
        
        if( $vConteudo == strtolower($vCodCliente) ){
          $vOpcoesCodCliente .= '<option selected value="'. $vConteudo .'">'. $vConteudo .'</option>';
        }else{
          $vOpcoesCodCliente .= '<option value="'. $vConteudo .'">'. $vConteudo .'</option>';        
        }       

        if( $vConteudo == strtolower($vNomeCliente) ){
          $vOpcoesNomeCliente .= '<option selected value="'. $vConteudo .'">'. $vConteudo .'</option>';
        }else{
          $vOpcoesNomeCliente .= '<option value="'. $vConteudo .'">'. $vConteudo .'</option>';        
        }      

        if( $vConteudo == strtolower($vSexoCliente) ){
          $vOpcoesSexoCliente .= '<option selected value="'. $vConteudo .'">'. $vConteudo .'</option>';
        }else{
          $vOpcoesSexoCliente .= '<option value="'. $vConteudo .'">'. $vConteudo .'</option>';        
        }        
        
      }

      $pag4 = '<div id="pag4">';
      // ########## FIM GET PAG 4 ##########
    }else if (isset($_GET["pag5"])){
      // ########## GET PAG 5 ##########
      if( empty($vTabelaVendas) )
        header('location: configuracoes.php?pag6');

      $vConexao = BD_ConectaCliente($vBaseDados);
      
      $vSQL = "DESCRIBE ". $vTabelaVendas;

      $vResultado = BD_ExecutaSQLFramework($vSQL, $vConexao);
      while($vLinha = mysql_fetch_array($vResultado)){
        
        $vConteudo = strtolower($vLinha["Field"]);
        
        if( $vConteudo == strtolower($vVendaCodCliente) ){
          $vOpcoesVendaCodCliente .= '<option selected value="'. $vConteudo .'">'. $vConteudo .'</option>';
        }else{
          $vOpcoesVendaCodCliente .= '<option value="'. $vConteudo .'">'. $vConteudo .'</option>';        
        }       

        if( $vConteudo == strtolower($vVendaCodigo) ){
          $vOpcoesVendaCodigo .= '<option selected value="'. $vConteudo .'">'. $vConteudo .'</option>';
        }else{
          $vOpcoesVendaCodigo .= '<option value="'. $vConteudo .'">'. $vConteudo .'</option>';        
        }           
        
      }

      $pag5 = '<div id="pag5">';
      // ########## FIM GET PAG 5 ##########
    }else if (isset($_GET["pag6"])){
      // ########## GET PAG 6 ##########
      if( empty($vTabelaVendasProdutos) )
        header('location: configuracoes.php?pag7');

      $vConexao = BD_ConectaCliente($vBaseDados);
      
      $vSQL = "DESCRIBE ". $vTabelaVendasProdutos;

      $vResultado = BD_ExecutaSQLFramework($vSQL, $vConexao);
      while($vLinha = mysql_fetch_array($vResultado)){
        
        $vConteudo = strtolower($vLinha["Field"]);
        
        if( $vConteudo == strtolower($vVenCodigo) ){
          $vOpcoesVenCodigo .= '<option selected value="'. $vConteudo .'">'. $vConteudo .'</option>';
        }else{
          $vOpcoesVenCodigo .= '<option value="'. $vConteudo .'">'. $vConteudo .'</option>';        
        }       

        if( $vConteudo == strtolower($vProCodigo) ){
          $vOpcoesProCodigo .= '<option selected value="'. $vConteudo .'">'. $vConteudo .'</option>';
        }else{
          $vOpcoesProCodigo .= '<option value="'. $vConteudo .'">'. $vConteudo .'</option>';        
        }           
        
      }

      $pag6 = '<div id="pag6">';
      // ########## FIM GET PAG 6 ##########
    }else if (isset($_GET["pag7"])){
      $pag7 = '<div id="pag7">';
    }

    BD_FechaConexaoFramework($vConexao);

  }// FIM GET

  // Se o metodo de requisicao for POST
  if($_SERVER["REQUEST_METHOD"] == "POST"){

    $vConexao = BD_AbreConexaoFramework();

    if( isset($_POST["edBaseDados"]) && isset($_POST["edBancoDados"]) ){

      $vSQL = "SELECT CON_NOME_BANCO, CON_BANCO_DADOS FROM TB_CONEXAO";
      $vEncontrou = false;
      $vResultado = BD_ExecutaSQLFramework($vSQL, $vConexao);
      while($vLinha = mysql_fetch_array($vResultado)){
        $vEncontrou = true;
      }
      if( $vEncontrou ){
        $vSQL = " UPDATE TB_CONEXAO SET                                     " .
                "   CON_BANCO_DADOS     = '".$_POST['edBancoDados']."',     " .
                "   CON_NOME_BANCO      = '".$_POST['edBaseDados']."'       " ;
      }else{
        $vSQL = "INSERT INTO TB_CONEXAO (                  " .
                "        CON_CODIGO,                       " .
                "        CON_BANCO_DADOS,                  " .
                "        CON_NOME_BANCO)                   " .
                "                                          " .
                "        VALUES                            " . 
                "                                          " .
                "        (null,                            " .
                "        '".$_POST['edBancoDados']."',     " .
                "        '".$_POST['edBaseDados']."')      " ;
      }
      if(BD_ExecutaSQLFramework($vSQL, $vConexao)){                
        header('location: configuracoes.php?pag2');
      }else{
        $vSaida = 
            "<div class='alert alert-danger' align='center'>
              Erro ao salvar os dados, tente novamente
            </div>";
      }

    }else if( isset($_POST["edTabelaProduto"]) ){

      if( $_POST["edTabelaProduto"] == null ){
          $vSaida = '<div class="alert alert-danger" role="alert" align="center">
                      <strong>Atenção!</strong> Você precisa selecionar ao menos o nome da tabela de produtos
                    </div>
                    <div class="form-group col-sm-4" align="center">
                      <a href="configuracoes.php?pag2" class="btn btn-warning" role="button" style="width: 100%;">
                        <i class="glyphicon glyphicon-chevron-left"></i> Voltar
                      </a>
                    </div>';
          $pag2 = '<div id="pag2" hidden>';
      }else{
        ValidaDadosJaCadastrados();
        $vSQL = " UPDATE TB_CONEXAO SET                                                   " .
                "   CON_TABELA_CLIENTES = '".$_POST['edTabelaCliente']."',                " .
                "   CON_TABELA_PRODUTOS = '".$_POST['edTabelaProduto']."',                " .
                "   CON_TABELA_VENDAS   = '".$_POST['edTabelaVendas']."',                 " .
                "   CON_TABELA_VENDAS_PRODUTOS = '".$_POST['edTabelaVendasProdutos']."'   " ;
        
        if(BD_ExecutaSQLFramework($vSQL, $vConexao)){                
          header('location: configuracoes.php?pag3');
        }else{
          $vSaida = 
              "<div class='alert alert-danger' align='center'>
                Erro ao salvar os dados, tente novamente
              </div>";
        }
      }

    }else if( isset($_POST["edCodPro"]) ){

      ValidaDadosJaCadastrados();
      $vSQL = " UPDATE TB_CONEXAO SET                                     " .
              "   CON_CODIGO_PRODUTO    = '".$_POST['edCodPro']."',       " .
              "   CON_NOME_PRODUTO      = '".$_POST['edNomePro']."',      " .
              "   CON_CATEGORIA_PRODUTO = '".$_POST['edCategoriaPro']."', " .
              "   CON_DESCRICAO_PRODUTO = '".$_POST['edDescPro']."',      " .
              "   CON_DATA_PRODUTO      = '".$_POST['edDataPro']."',      " .
              "   CON_VALOR_PRODUTO     = '".$_POST['edValorPro']."',     " .
              "   CON_QUANT_PRODUTO     = '".$_POST['edQuantPro']."'      " ;
      
      if(BD_ExecutaSQLFramework($vSQL, $vConexao)){                
        header('location: configuracoes.php?pag4');
      }else{
        $vSaida = 
            "<div class='alert alert-danger' align='center'>
              Erro ao salvar os dados, tente novamente
            </div>";
      }

    }else if( isset($_POST["edCodCli"]) || isset($_POST["edNomeCli"]) || isset($_POST["edSexoCli"]) ){

      ValidaDadosJaCadastrados();
      $vSQL = " UPDATE TB_CONEXAO SET                                     " .
              "   CON_CODIGO_CLIENTE = '".$_POST['edCodCli']."',          " .
              "   CON_NOME_CLIENTE   = '".$_POST['edNomeCli']."',         " .
              "   CON_SEXO_CLIENTE   = '".$_POST['edSexoCli']."'          " ;
      
      if(BD_ExecutaSQLFramework($vSQL, $vConexao)){                
        header('location: configuracoes.php?pag5');
      }else{
        $vSaida = 
            "<div class='alert alert-danger' align='center'>
              Erro ao salvar os dados, tente novamente
            </div>";
      }

    }else if( isset($_POST["edCodVenda"]) || isset($_POST["edCodVendaCli"]) ){

      ValidaDadosJaCadastrados();
      $vSQL = " UPDATE TB_CONEXAO SET                                     " .
              "   CON_COD_VENDA_CLIENTE = '".$_POST['edCodVendaCli']."',  " .
              "   CON_COD_VENDA         = '".$_POST['edCodVenda']."'      " ;
      
      if(BD_ExecutaSQLFramework($vSQL, $vConexao)){                
        header('location: configuracoes.php?pag6');
      }else{
        $vSaida = 
            "<div class='alert alert-danger' align='center'>
              Erro ao salvar os dados, tente novamente
            </div>";
      }

    }else if( isset($_POST["edVenCodigo"]) || isset($_POST["edProCodigo"]) ){

      ValidaDadosJaCadastrados();
      $vSQL = " UPDATE TB_CONEXAO SET                                " .
              "   CON_VENDA_COD    = '".$_POST['edVenCodigo']."',    " .
              "   CON_PRODUTO_COD  = '".$_POST['edProCodigo']."'     " ;
      
      if(BD_ExecutaSQLFramework($vSQL, $vConexao)){         
        header('location: configuracoes.php?pag7');
      }else{
        $vSaida = 
            "<div class='alert alert-danger' align='center'>
              Erro ao salvar os dados, tente novamente
            </div>";
      }

    }
  
    BD_FechaConexaoFramework($vConexao);

  }// FIM POST

  // Funcao que valida se ja possui dados cadastrados antes de dar um UPDATE na tabela
  function ValidaDadosJaCadastrados(){
      $vSQL = "SELECT * FROM TB_CONEXAO";
      $vEncontrou = false;
      $vResultado = BD_ExecutaSQLFramework($vSQL, $vConexao);
      while($vLinha = mysql_fetch_array($vResultado)){
        $vEncontrou = true;
      }
      if( !$vEncontrou ){
        header('location: configuracoes.php?pag1');
      }
  }

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
          
          <?php echo $pag1; ?>
            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
              <div class="form-group col-sm-12">

                <h4 class="page-header"> (1/6) Dados da Base de Dados</h4>

                <div class="form-group col-sm-6">
                  <label>* Nome da Base de Dados</label>
                  <input type="text" class="form-control" id="edBaseDados" placeholder="Ex.: db_loja_virtual" required="true" onblur="showForm()" name="edBaseDados" value=<?php echo $vBaseDados; ?> >
                </div>

                <div class="form-group col-sm-6">
                  <label>* Sistema Gerenciador de Banco de Dados (SGBD)</label>
                  <select class="form-control" id="edBancoDados" name="edBancoDados">
                    <option value="MySQL">MySQL</option>
                  </select>
                </div>

                <div class="form-group col-sm-8" align="left">Obs.: Campos com (*) são de preenchimento obrigatório.</div>
                <div class="form-group col-sm-4" align="right">
                  <button type="submit" class="btn btn-primary" style="width: 100%;"><i class="glyphicon glyphicon-ok"></i> Salvar e Prosseguir</button>
                </div>

              </div>
            </form>
          </div>
        
          <?php echo $pag2; ?>
            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
              <div class="form-group col-sm-12">

                <h4 class="page-header"> (2/6) Nomes das Tabelas</h4>
                
                <div class="form-group col-sm-6">
                  <label>* Tabela de Produtos</label>
                  <select class="form-control" id="edTabelaProduto" name="edTabelaProduto">
                    <option value="">Selecionar</option>
                    <?php echo $vOpcoesTabelaProdutos; ?>
                  </select>
                </div>

                <div class="form-group col-sm-6">
                  <label>Tabela de Clientes</label>
                  <select class="form-control" id="edTabelaCliente" name="edTabelaCliente">
                    <option value="">Selecionar</option>
                    <?php echo $vOpcoesTabelaCliente; ?>
                  </select>
                </div>

                <div class="form-group col-sm-6">
                  <label>Tabela de Vendas</label>
                  <select class="form-control" id="edTabelaVendas" name="edTabelaVendas">
                    <option value="">Selecionar</option>
                    <?php echo $vOpcoesTabelaVendas; ?>
                  </select>
                </div>

                <div class="form-group col-sm-6">
                  <label>Tabela de Vendas/Produtos</label>
                  <select class="form-control" id="edTabelaVendasProdutos" name="edTabelaVendasProdutos">
                    <option value="">Selecionar</option>
                    <?php echo $vOpcoesTabelaVendasProdutos; ?>
                  </select>
                </div>

                <div class="form-group col-sm-6" align="left">Obs.: Campos com (*) são de preenchimento obrigatório.</div>
                <div class="form-group col-sm-3" align="right">
                  <a href="configuracoes.php?pag1" class="btn btn-warning" style="width: 100%;"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</a>
                </div>
                <div class="form-group col-sm-3" align="right">
                  <button type="submit" class="btn btn-primary" style="width: 100%;"><i class="glyphicon glyphicon-ok"></i> Salvar e Prosseguir</button>
                </div>

              </div>
            </form>
          </div>

          <?php echo $pag3; ?>
            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">

              <div class="form-group col-sm-12">

                <h4 class="page-header"> (3/6) Dados da Tabela Produtos</h4>
                
                <div class="form-group col-sm-6">
                  <label>* Código do Produto</label>
                  <select class="form-control" id="edCodPro" name="edCodPro">
                    <option value="">Selecionar</option>
                    <?php echo $vOpcoesCodProduto; ?>
                  </select>
                </div>

                <div class="form-group col-sm-6">
                  <label>Nome do Produto</label>
                  <select class="form-control" id="edNomePro" name="edNomePro">
                    <option value="">Selecionar</option>
                    <?php echo $vOpcoesNomeProduto; ?>
                  </select>
                </div>

                <div class="form-group col-sm-6">
                  <label>Categoria do Produto (FK)</label>
                  <select class="form-control" id="edCategoriaPro" name="edCategoriaPro">
                    <option value="">Selecionar</option>
                    <?php echo $vOpcoesCategoriaProduto; ?>
                  </select>
                </div>

                <div class="form-group col-sm-6">
                  <label>Descrição do Produto</label>
                  <select class="form-control" id="edDescPro" name="edDescPro">
                    <option value="">Selecionar</option>
                    <?php echo $vOpcoesDescricaoProduto; ?>
                  </select>
                </div>

                <div class="form-group col-sm-6">
                  <label>Data de Entrada do Produto</label>
                  <select class="form-control" id="edDataPro" name="edDataPro">
                    <option value="">Selecionar</option>
                    <?php echo $vOpcoesDataProduto; ?>
                  </select>
                </div>
                
                <div class="form-group col-sm-6">
                  <label>Valor do Produto</label>
                  <select class="form-control" id="edValorPro" name="edValorPro">
                    <option value="">Selecionar</option>
                    <?php echo $vOpcoesValorProduto; ?>
                  </select>
                </div>
               
                <div class="form-group col-sm-6">
                  <label>* Quantidade do Produto</label>
                  <select class="form-control" id="edQuantPro" name="edQuantPro">
                    <option value="">Selecionar</option>
                    <?php echo $vOpcoesQuantProduto; ?>
                  </select>
                </div>

                <div class="form-group col-sm-6" align="left">Obs.: Campos com (*) são de preenchimento obrigatório.</div>
                <div class="form-group col-sm-3" align="right">
                  <a href="configuracoes.php?pag2" class="btn btn-warning" style="width: 100%;"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</a>
                </div>
                <div class="form-group col-sm-3" align="right">
                  <button type="submit" class="btn btn-primary" style="width: 100%;"><i class="glyphicon glyphicon-ok"></i> Salvar e Prosseguir</button>
                </div>

              </div>

            </form>
          </div>

          <?php echo $pag4; ?>
            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">

              <div class="form-group col-sm-12">
              
                <h4 class="page-header"> (4/6) Dados da Tabela Clientes</h4>
                
                <div class="form-group col-sm-6">
                  <label>Código do Cliente</label>
                  <select class="form-control" id="edCodCli" name="edCodCli">
                    <option value="">Selecionar</option>
                    <?php echo $vOpcoesCodCliente; ?>
                  </select>
                </div>

                <div class="form-group col-sm-6">
                  <label>Nome do Cliente</label>
                  <select class="form-control" id="edNomeCli" name="edNomeCli">
                    <option value="">Selecionar</option>
                    <?php echo $vOpcoesNomeCliente; ?>
                  </select>
                </div>

                <div class="form-group col-sm-6">
                  <label>Sexo do Cliente</label>
                  <select class="form-control" id="edSexoCli" name="edSexoCli">
                    <option value="">Selecionar</option>
                    <?php echo $vOpcoesSexoCliente; ?>
                  </select>
                </div>
                
                <div class="form-group col-sm-6" align="left">Obs.: Campos com (*) são de preenchimento obrigatório.</div>
                <div class="form-group col-sm-3" align="right">
                  <a href="configuracoes.php?pag3" class="btn btn-warning" style="width: 100%;"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</a>
                </div>
                <div class="form-group col-sm-3" align="right">
                  <button type="submit" class="btn btn-primary" style="width: 100%;"><i class="glyphicon glyphicon-ok"></i> Salvar e Prosseguir</button>
                </div>

              </div>

            </form>
          </div>

          <?php echo $pag5; ?>
            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">

              <div class="form-group col-sm-12">
              
                <h4 class="page-header"> (5/6) Dados da Tabela Vendas</h4>

                <div class="form-group col-sm-6">
                  <label>* Código da Venda</label>
                  <select class="form-control" id="edCodVenda" name="edCodVenda">
                    <option value="">Selecionar</option>
                    <?php echo $vOpcoesVendaCodigo; ?>
                  </select>
                </div>

                <div class="form-group col-sm-6">
                  <label>* Código do Cliente (FK)</label>
                  <select class="form-control" id="edCodVendaCli" name="edCodVendaCli">
                    <option value="">Selecionar</option>
                    <?php echo $vOpcoesVendaCodCliente; ?>
                  </select>
                </div>
              
                <div class="form-group col-sm-6" align="left">Obs.: Campos com (*) são de preenchimento obrigatório.</div>
                <div class="form-group col-sm-3" align="right">
                  <a href="configuracoes.php?pag4" class="btn btn-warning" style="width: 100%;"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</a>
                </div>
                <div class="form-group col-sm-3" align="right">
                  <button type="submit" class="btn btn-primary" style="width: 100%;"><i class="glyphicon glyphicon-ok"></i> Salvar e Prosseguir</button>
                </div>

              </div>

            </form>
          </div>

          <?php echo $pag6; ?>
            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">

              <div class="form-group col-sm-12">
              
                <h4 class="page-header"> (6/6) Dados da Tabela Vendas/Produtos</h4>

                <div class="form-group col-sm-6">
                  <label>* Código da Venda (FK)</label>
                  <select class="form-control" id="edVenCodigo" name="edVenCodigo">
                    <option value="">Selecionar</option>
                    <?php echo $vOpcoesVenCodigo; ?>
                  </select>
                </div>

                <div class="form-group col-sm-6">
                  <label>* Código do Produto (FK)</label>
                  <select class="form-control" id="edProCodigo" name="edProCodigo">
                    <option value="">Selecionar</option>
                    <?php echo $vOpcoesProCodigo; ?>
                  </select>
                </div>

                <div class="form-group col-sm-6" align="left">Obs.: Campos com (*) são de preenchimento obrigatório.</div>
                <div class="form-group col-sm-3" align="right">
                  <a href="configuracoes.php?pag5" class="btn btn-warning" style="width: 100%;"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</a>
                </div>
                <div class="form-group col-sm-3" align="right">
                  <button type="submit" class="btn btn-primary" style="width: 100%;"><i class="glyphicon glyphicon-ok"></i> Salvar e Finalizar</button>
                </div>

              </div>

            </form>
          </div>

          <?php echo $pag7; ?>

            <div class="form-group col-sm-12">
            
              <h4 class="page-header"> Concluído</h4>

              <p>Parabéns você concluiu a etapa de configuração do framework, a partir de agora poderá acessar a página recomendações e selecionar as recomendações desejadas.</p>

              <div class="form-group col-sm-8" align="left"></div>
              <div class="form-group col-sm-4" align="right">
                <a href="inicial.php" class="btn btn-primary" style="width: 100%;"><i class="glyphicon glyphicon-home"></i> Voltar a Página Inicial</a>
              </div>

            </div>

          </div>

        </div>
      </div>
    </div>

  </body>
</html>