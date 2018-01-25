<?php
session_start();
if(!isset($_SESSION['usuario'])){
	header("Location: ../index.php");
	//die("No tienes permiso en esta seccion");
}
	if(isset($_GET['salir'])){
		session_destroy();
		header("Location: index.php");

	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Aplicacion de Peliculas</title>
</head>
<body>
	<a href="index.php?salir=1">Salir </a>

	<form name="forma" id="forma" action="upload.php" method="post" enctype="multipart/form-data" target="peliculaFrame">
	<fieldset>
	<!--legen para poner un especie de titulo, -->
			<legend>AGREGAR PELICULA</legend>
			<label for="titulo">Titulo</label> 
				<input type="text" name="titulo"  id="titulo" placeholder="Ingresa Titulo">
			<br>
			<label for="sinopsis">Sinopsis</label>
				<textarea name="sinopsis" id="sinopsis" cols="50" rows="3"> </textarea>
			<label for="imagen">Ingresa la Imagen</label>
				<input type="file" name="imagen" id="imagen">
			<br>
			<br>

				<input type="button" value="Agregar Pelicula" onclick="javascript:Envia();"> | 
				<input type="reset" value="Limpiar"> 
	</fieldset>
</form>
	<iframe src="" name="peliculaFrame" style="display:none"> 

	</iframe>
<h4>Lista de Peliculas</h4>
<table>
		<tr> 
			<td>ID</td>
			<td>TITULO</td>
			<td>SINOPSIS</td>
			<td>FOTO</td>
			<td>COMENTARIOS</td>
			<td>NUEVO COMENTARIO</td>
		</tr>
	<?php 
		require("../scripts/conexion.php");
		require("../Clases/Pelicula.php");
		$p= new Pelicula($conData);
		$res=$p->consulta('0');
		if($res['estado']!="OK" || $res['filas']==0){
			echo"<tr> <td colspan='4'> No hay Resultados a Mostrar </td> </tr>";
		}else{
				foreach ($res['datos'] as $fila) {
					echo "<tr>";
					echo "<td>".$fila['id']."</td>";
					echo "<td>".$fila['titulo']."</td>";
					echo "<td>".$fila['sinopsis']."</td>";
					echo "<td><img src='".$fila['ruta']."' width='200' height='90'> </td>";
					echo "<td>".$fila['comentarios']."</td>";
					echo"<td> <textarea id='comentario_".$fila["id"]."'> </textarea> 
							   <input type='button' value='Guardar' onclick='javascript:AddComentario(".$fila['id'].");'>
						</td>";
					echo "</tr>";
				}

		}
		?>
</table>
<script src="../scripts/jquery-3.3.1.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		function recarga(){

			window.Location.href="index.php";


		}
		function AddComentario(id){
			obj= document.getElementById('comentario_'+id);
			if(obj.value==""){
				alert("El comentario esta vacio");
				obj.focus();
				return;
			}else{
				var comentario= new Object();
				comentario.id= id;
				comentario.comment= obj.value;
				json= JSON.stringify(comentario);
				//ver los datos en formato json alert(json);
				//ver lo que tiene el objeto  alert("Id:"+id+" Comentario: "+obj.value);
				   $.post(
                            "http://localhost:8090/curso_web-master/control/services/add.php",
                            json, 
                            function(responseText, status){
                                try{
                                    //alert(responseText);
                                    if(status == "success"){
                                        //console.log(responseText);
                                        res = JSON.parse(responseText);
                                        if(res.estado=="OK"){
                                            //console.warn("Login Success!")
                                            alert("Comentario Agregado");
                                            window.location.href="index.php";
                                            //podemos mandar la funcion de recarga
                                           // window.location.reload();                                             
                                        }else {
                                        alert(res.estado);
                                        console.error("Status: " + res.estado);
                                    }
                                    }
                                }catch(e){
                                    console.log("Error " + e);
                                }
                            }
                        );                       
				}
			}
		
		function Envia(){
			alert("Hola");
			document.forma.submit();
		}
	</script>
</body>
</html>