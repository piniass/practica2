<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inicio de Sesión</title>
    <style>
      html,body{
        height:100%;
      }
      body {
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
      }
      form {
        background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        gap:10px;
      }

      input {
        width:100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
      }
      #submit{
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        #submit:hover {
            background-color: #0056b3;
        }

        a{
            width: 100%;;
            padding: 10px;
            background-color: 	#355E3B;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;  
            box-sizing: border-box;
            text-align: center;
            text-decoration:none;
            transition: background-color 0.3s;

        }
        a:hover {
            background-color: #008000;
        }
    </style>
</head>
<body>
        <?php

        include_once 'claseConexionBD.php';
        $BD = new ConectarBD();
        $con = $BD->getConexion();


            function comprobarNombre() {
                if(isset($_REQUEST['enviar'])){
                    if(empty($_REQUEST['usuario'])){
                       return "<p>Nombre vacio</p>";
                    } 
                }             
            }

            function comprobarPwd() {
                if(isset($_REQUEST['enviar'])){
                    if(empty($_REQUEST['contrasena'])){
                        return "<p>Contraseña vacia</p>";
                    } 
                }            
            }
    
            
          
            $loginCorrecto = false;

            if(isset($_REQUEST['enviar'])){
                $stmt=$con->query('SELECT * FROM usuarios');
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $usuario = $_REQUEST['usuario'];
                        $pwd = $_REQUEST['contrasena'];
                while ( $bddUsuarios = $stmt->fetch() ){
                    if($bddUsuarios['nombre'] = $usuario && $pwd == $bddUsuarios['contrasena']){
                        
                        $loginCorrecto = true;
                    }
                }

                if($loginCorrecto){
                    SESSION_START();
                    $_SESSION['nombre'] = $usuario;
                    header('location: gestor.php');
                    echo '<p>Login correcto!</p>';
                } else {
                    echo '<p>Los datos introducidos no son correctos.</p>';
                    
                }
            }

        ?>
        <form action="" method="post">
            <h2>Iniciar Sesión</h2>
            <input type="text" name="usuario" placeholder="Usuario" >
            <?php echo comprobarNombre() ?>
            <input type="password" name="contrasena" placeholder="Contraseña">
            <?php echo comprobarPwd() ?>
            <input type="submit" id="submit" name="enviar">
            <a class="register-button" href="#">Registrarse</a>
        </form>

</body>
</html>
