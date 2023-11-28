<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Peliculas</title>
    <style>

        *{
            font-family:sans-serif;
        }
        table {
        border-collapse: collapse;
        width: 600px;
        border: 1px solid #ddd; /* Borde alrededor de la tabla */
        }

        th, td {
            text-align: left;
            padding: 8px;
            text-align:center;
            
        }

        th {
            background-color: #f2f2f2; /* Color de fondo del encabezado */
        }

        tr:nth-child(even) {
            background-color: #f9f9f9; /* Color de fondo de filas pares */
        }

        tr:hover {
            background-color: #f2f2f2; /* Cambio de color al pasar el ratón */
        }

        .btn-container{
            display:flex;
            gap:10px;
        }

        a{
            text-decoration: none;
            padding: 10px;
            background-color: #09f;
            color: #fff;
        }

        a:hover{
            background-color:#09f9;
            color:black;
        }

    </style>
</head>
<body>
    <?php
        include_once 'claseConexionBD.php';

        SESSION_START();

        if(!isset($_SESSION['nombre'])){
            header('location: login.php');
        }

        $nom = $_SESSION['nombre'];

        echo '<h2>Bienvenido '. $nom .'</h2>';
    ?>

    <a href="insertar.php">Insertar película</a>
    <a href="cerrar.php">Cerrar Sesion</a>
   
    <br><br>
    
    <table border="1">
        <thead>
            <tr>
                <td>Codigo</td>
                <td>Pelicula</td>
                <td>Director</td>
                <td>Genero</td>
                <td>Año</td>
                <td>Gestion</td>
            </tr>
        </thead>
        <tbody>

            <?php
            $BD = new ConectarBD();
            $conn = $BD->getConexion(); 
            $stmt = $conn->prepare('SELECT * FROM peliculas');
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            
            while ( $peliculas = $stmt->fetch() ) {
                echo "<tr>";
                echo "<td>".$peliculas['codigo']."</td>
                <td>".$peliculas['titulo'].
                "</td><td>".$peliculas['director'].
                "</td><td>".$peliculas['genero']."</td>
                <td>".$peliculas['anio']."</td>
                <td>";
                ?>

                <div class='btn-container'>
                    <a href = "borrar.php?Id=<?php echo $peliculas['codigo'] ?>" >Eliminar</a>
                    <a href = "modificar.php?Id=<?php echo $peliculas['codigo'] ?>" >Modificar</a>
                </div>    
                </td>

                <?php
                echo "</tr>";
                } 
                ?>
            
        </tbody>
    </table>
</body>
</html>