<?php
session_start();
if(isset($_SESSION['usuario'])){
    header("Location: control/index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Access Form</title>
</head>
<body>
    <form name="forma" id="forma">
        <fieldset>
            <legend>Access Form</legend>
            <label for="usuario">User</label>
            <input type="text" id="usuario">
            <br>
            <label for="pass">Password</label>
            <input type="password" id="pass">
            <br>
            <input id="btnEnviar" type="button" value="Log in">
        </fieldset>
    </form>
    
    <script type="text/javascript" src="scripts/jquery-3.3.1.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(
            function() {
              $('#btnEnviar').click(
                function() {
                    try {
                        var myUser = new Object(); 
                        obj = document.getElementById('usuario');
                        if(obj.value == ""){
                            alert("El campo usuario esta vacio");
                            obj.focus(); 
                            return; 
                        }
                        myUser.usuario = obj.value; 
                        // pass field 
                        obj = document.getElementById('pass');
                        if(obj.value==""){
                            alert("El campo password esta vácio");
                            obj.focus();
                            return;
                        }
                        myUser.pass = obj.value;
                        var json = JSON.stringify(myUser);
                        $.post(
                            "http://localhost:8090/curso_web-master/services/login.php",
                            json, 
                            function(responseText, status){
                                try{
                                    //alert(responseText);
                                    if(status == "success"){
                                        //console.log(responseText);
                                        res = JSON.parse(responseText);
                                        if(res.estado=="OK"){
                                            //console.warn("Login Success!")
                                            alert("Bienvenido");
                                            window.location.href="index.php";
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
                    }catch(e) {
                        console.warn("Error: " + e );
                        alert("Hubo un evento inesperado!");
                    }
                }
              );
            }         
        ); 
    </script>
</body>
</html>