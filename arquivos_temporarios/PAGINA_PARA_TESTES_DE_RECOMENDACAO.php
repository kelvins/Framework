<?php
	require_once("../recomende.php");
	$vArray = array(Recomende(2, 5));
	if(!empty($vArray)){
		for ($i=0; $i < count($vArray); $i++) { 
			echo implode(", ", $vArray[$i]);
		}
	}
?>