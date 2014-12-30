<?php

    error_reporting(0);

	function Menu(){
		
		$vPagina = end(explode("/", $_SERVER['PHP_SELF']));
		echo '<div class="col-sm-3 col-md-2 sidebar">
			  	<ul class="nav nav-sidebar">';
		
		if( $vPagina == 'inicial.php'  )
			echo '<li class="active"><a href="inicial.php"><i class="glyphicon glyphicon-home"></i> Inicial</a></li>';
		else
			echo '<li><a href="inicial.php"><i class="glyphicon glyphicon-home"></i> Inicial</a></li>';

		if( $vPagina == 'usuarios.php'  )
			echo '<li class="active"><a href="usuarios.php"><i class="glyphicon glyphicon-user"></i> Usuários</a></li>';
		else
			echo '<li><a href="usuarios.php"><i class="glyphicon glyphicon-user"></i> Usuários</a></li>';

		if( $vPagina == 'recomendacao.php'  )
			echo '<li class="active"><a href="recomendacao.php"><i class="glyphicon glyphicon-thumbs-up"></i> Recomendações</a></li>';
		else
			echo '<li><a href="recomendacao.php"><i class="glyphicon glyphicon-thumbs-up"></i> Recomendações</a></li>';

		if( $vPagina == 'configuracoes.php'  )
			echo '<li class="active"><a href="configuracoes.php?pag1"><i class="glyphicon glyphicon-cog"></i> Configurações</a></li>';
		else
			echo '<li><a href="configuracoes.php?pag1"><i class="glyphicon glyphicon-cog"></i> Configurações</a></li>';

		if( $vPagina == 'informacoes.php'  )
			echo '<li class="active"><a href="informacoes.php"><i class="glyphicon glyphicon-info-sign"></i> Informações</a></li>';
		else
			echo '<li><a href="informacoes.php"><i class="glyphicon glyphicon-info-sign"></i> Informações</a></li>';

		echo '
			    <li><a href="login.php"><i class="glyphicon glyphicon-off"></i> Sair</a></li>
			  </ul>
			  </div>';
	}

	function Head(){
		echo '
			    <meta charset="utf-8" lang="pt-br">
			    <meta name="description" content="Framework de Recomendacao para Lojas Virtuais">
			    <meta name="author" content="Kelvin Salton do Prado">
			    
            	<link rel="shortcut icon" href="img/logo.png">

			    <link href="css/bootstrap.css" rel="stylesheet">
			    <link href="css/framework.css" rel="stylesheet">
			    
			    <script src="js/jquery.mins.js"></script>
    			<script src="js/bootstrap.js"></script>';
	}

?>