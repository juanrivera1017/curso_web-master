<?php
	$dir_subida="services/img/";
	$archivo_subido=$dir_subida . basename($_FILES['imagen']['name']);
	if(move_uploaded_file($_FILES['imagen']['tmp_name'], $archivo_subido)){
		$nombre= explode(".", $archivo_subido);
		$extension= ".". $nombre[count($nombre)-1];
		$nuevo_nombre= $dir_subida . time().$extension;
		rename($archivo_subido, $nuevo_nombre);
		require("../scripts/conexion.php");
		require("../Clases/Pelicula.php");
		$p= new Pelicula($conData);
		$res= $p->inserta($_POST['titulo'], $_POST['sinopsis'], $nuevo_nombre);
		if($res['estado']=="OK"){
			?>
			<script> parent.recarga();
			</script>
			<?php


		} else{
			unlink($nuevo_nombre);
			?>
			<script> parent.alert("Error:"<?= $res['estado'] ?>);</script>
			<?php
		}

	}
?>