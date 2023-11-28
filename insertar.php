<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Pelicula</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            gap:10px;
        }

        form {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        input {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        h2{
            text-align:center;
        }

        #volver{
            text-align: center;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            padding: .75rem 1.25rem;
        }

        #volver:hover{
            background-color: #0056b3;
        }

        .insertada{
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: .25rem;
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<?php
    SESSION_START();

        if(!isset($_SESSION['nombre'])){
            header('location: login.php');
        }

    include_once 'claseConexionBD.php';

    function campoVacio($input, $campo){
        global $camposRellenos;
        if(isset($_POST['enviar'])) {
            if(empty($input)){
                $camposRellenos = false;
                return '<p>Campo '.$campo.' vacio</p>';
            } else {
                $camposRellenos = true;
            }
        }
    }
    
    function comprobarNumero($anio){
        global $camposRellenos, $esNumero;
        
            if(strlen($anio) == 4){
                $camposRellenos = true;
                $esNumero = true;
            } else{
                $camposRellenos = false;
                echo '<p>La longitud debe ser de 4 dígitos.</p>';
            }
        }
    
    
    function cargarDatos(){
        global $camposRellenos, $esNumero;
        if(isset($_POST['enviar'])){
            if($camposRellenos && $esNumero){

                $BD = new ConectarBD();
                $conn = $BD->getConexion();
                $stmt = $conn->prepare('INSERT INTO peliculas
                (titulo, director, genero, anio) ' . 'VALUES (:titulo, :director, :genero, :anio)');


                try {
                $stmt->execute( array( 
                    ':titulo' => $_POST['titulo'],
                    ':director' => $_POST['director'],
                    ':genero' => $_POST['genero'],
                    ':anio' => $_POST['anio']));
                    if ($stmt->rowCount() > 0) // Se ha realizado el borrado
                        return '<p class="insertada">Insertadas ' . $stmt->rowCount() . ' filas</p>';
                    }
                catch (PDOException $ex) {
                    print "¡Error!: " . $ex->getMessage() . "<br/>";
                    die();
                }

                $BD->cerrarConexion();



            }
        }
    }
    
    

?>

<form action="" method="post">
    <h2>Insertar Película</h2>
    Titulo<input type="text" name="titulo" id="titulo">
    <?php echo campoVacio('titulo', "titulo") ?>
    Director<input type="text" name="director" id="director">
    <?php echo campoVacio('director', "director") ?>
    Genero<input type="text" name="genero" id="genero">   
    <?php echo campoVacio('genero', "genero") ?>
    Año<input type="number" name="anio" id="anio">
    <?php echo campoVacio('anio', "año") ?>
    <?php echo comprobarNumero('anio') ?>
    <input type="submit" value="Enviar" name="enviar">
</form>
<a href="gestor.php" id="volver">Volver</a>
<?php echo cargarDatos() ?>
</body>
</html>