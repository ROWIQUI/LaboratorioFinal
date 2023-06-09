<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <link rel="stylesheet" href="formulariolab.css" type="text/css" />
</head>

<body>
    <div class="group">
        <form method="POST" action=" ">
            <h2><em>Formulario de Registro</em></h2>
            <label for="nombre"><b>Nombre</b> <span><em>(requerido)</em></span>
                <input type="text" name="nombre" class="forma-input" required /></label>

            <label for="papellido"><b>Primer Apellido</b> <span><em>(requerido)</em></span>
                <input type="text" name="papellido" class="forma-input" required /></label>

            <label for="sapellido"><b>Segundo Apellido</b> <span><em>(requerido)</em></span>
                <input type="text" name="sapellido" class="forma-input" required /></label>

            <label for="email"><b>Email</b> <span><em>(requerido)</em></span>
                <input type="email" name="email" class="forma-input" id="input-email" pattern="\S+@\S+\.\S+"
                    required /></label>
            <label for="login"><b>Login</b> <span><em>(requerido)</em></span>
                <input type="text" name="login" class="forma-input" required /></label>

            <label for="password"><b>Password</b> <span><em>(requerido)</em></span>
                <input type="password" name="password" class="forma-input" minlength="4" maxlength="8" id="clave"
                    required /></label>

            <input class="form-btn" name="submit" type="submit" value="Suscribirse" />

            <?php

            if (array_key_exists('submit', $_POST)) {
                $nombre = trim($_POST['nombre']);
                $papellido = trim($_POST['papellido']);
                $sapellido = trim($_POST['sapellido']);
                $email = trim($_POST['email']);
                $login = trim($_POST['login']);
                $password = trim($_POST['password']);

                //Conexión con PDO
            
                $host = 'localhost';
                $user = 'root';
                $pass = '';
                $datab = 'laboratorio';

                //Create connection
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                $connection = mysqli_connect($host, $user, $pass);

                //Check connection
                // if (!$connection) {
                //     echo "No se ha podido conectar con el servidor" . mysqli_error($connection);
                // } else {
                //     echo "Hemos conectado al servidor <br>";
                // }
                $db = mysqli_select_db($connection, $datab);
                //if ($db->connect_error) {
                //  die("Connection faile: " . $db->connect_error);
                // }
            
                $sql = "INSERT INTO usuarios (Nombre, P_apellido, S_apellido, email, Login, password ) VALUES ('$nombre', '$papellido', '$sapellido', '$email', '$login', '$password')";

                if (strlen($nombre) < 1 || strlen($papellido) < 1 || strlen($sapellido) < 1 || strlen($email) < 1 || strlen($login) < 1 || strlen($password) < 1) {
                    echo '<script type="text/javascript">
                    alert("Faltan datos en el formulario");
                    window.location.href="formulariolab.php";
                    </script>';
                } else if (!$connection) {
                    echo '<script type="text/javascript">
                    alert("Ha fallado la conexión a la base de datos");
                    window.location.href="formulariolab.php";
                    </script>';
                } else {
                    try {
                        mysqli_query($connection, $sql);
                        echo '<script type="text/javascript">
                    alert("Registro completado con éxito");
                    window.location.href="formulariolab.php";
                    </script>';
                    } catch (mysqli_sql_exception $e) {
                        echo '<script type="text/javascript">
                    alert("Email duplicado");
                    window.location.href="formulariolab.php";
                    </script>';
                        throw $e;
                    }
                }


                //if (!$db) {
                //    echo "No se ha podido encontrar la Tabla";
                // } else {
                //    echo "Tabla seleccionada";
                // }
                // ;
            
                $connection->close();

            }

            ?>

        </form>
        <form method="POST" action=" ">
            <input class="form-btn" name="consulta" type="submit" value="Consulta" />
            <?php
            if (array_key_exists('consulta', $_POST)) {
             //Conexión con PDO
            
             $host = 'localhost';
             $user = 'root';
             $pass = '';
             $datab = 'laboratorio';  

             //Create connection
             mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
             $connection = mysqli_connect($host, $user, $pass);

             $db = mysqli_select_db($connection, $datab);
             $sql = "SELECT Nombre, P_apellido, S_apellido, email, Login FROM usuarios";
                try {
                    $result = mysqli_query($connection, $sql);
                    echo "- <h3>Registros guardados</h3> </br></br>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        $nombre = $row['Nombre'];
                        $papellido = $row['P_apellido'];
                        $sapellido = $row['S_apellido'];
                        $email = $row['email'];
                        $login = $row['Login'];
                        echo "- $nombre / $papellido / $sapellido / $email /  $login </br></br>";
                    }
                } catch (mysqli_sql_exception $e) {
                    echo '<script type="text/javascript">
                alert("Error en la consulta");
                window.location.href="formulariolab.php";
                </script>';
                    throw $e;
                }
             $connection->close();
            }
            ?>
        </form>
    </div>
</body>

</html>