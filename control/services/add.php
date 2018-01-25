<?php 
	$datos=json_decode(file_get_contents("php://input"));
	$resultado= "";
	require("../../scripts/conexion.php");
	require("../../Clases/Pelicula.php");
	$p= new Pelicula($conData);
	$res=$p->addcomentario($datos->id,$datos->comment);
	if($res['estado']=="OK"){
			$resultado['result']= "true";
			$resultado['estado']="OK";
	}else{
		$resultado['result']="false";
		$resultado['estado']= $res['estado'];
	}
	echo json_encode($resultado);
?>