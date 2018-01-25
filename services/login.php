<?php 
session_start();
$resultado['estado'] = "Error"; 
$datos = json_decode(file_get_contents("php://input"));
if($datos->usuario == "" || $datos->pass==""){
    $_SESSION['estado'] = "Error: datos vacios";
    $resultado = $_SESSION; 
}else {
    //si existe o no existe se intenta traer el documento
    include("../scripts/conexion.php");
    //detiene y manda exception
    require("../Clases/Admin.php");
    $a=new Admin($conData);
    $res= $a->getLogin($datos->usuario,$datos->pass);
    if($res['estado']=="OK"){
        if($res['filas']==1){
                foreach ($res['datos'] as $fila) {
                    $_SESSION['usuario']=$fila['usuario'];
                    $_SESSION['pass']=$fila['pass'];
                    $_SESSION['id']=$fila['id'];
                    }
                    $resultado['estado']="OK";

        }else{
            $resultado['estado']="0 o Muchos resultados";
            session_destroy();
        }
    }else{
        $resultado['estado']= $res['estado'];
        session_destroy();
    }
    /*if($data->usuario=="root" && $data->pass="root"){
        $_SESSION['estado'] = "OK";   
         $resArray = $_SESSION; 
    } else {
        $_SESSION['estado'] = "ERROR: USUARIO INVALIDO";    
         $resArray = $_SESSION; 
        session_destroy();
    }*/
}
echo json_encode($resultado);
?>