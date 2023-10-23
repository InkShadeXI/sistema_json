<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <input type="file" name="usuarios_file">
        <input type="submit" value="Mandar archivo">
    </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Variables de json
            $string_json = file_get_contents($_POST["usuarios_file"]);
            $objeto_json = json_decode($string_json);

            // Variables de la base de datos
            $cadena_conexion = 'mysql:dbname=empresa;host=127.0.0.1';
            $usuario = 'root';
            $clave = '';
            $bd = new PDO($cadena_conexion, $usuario, $clave);
            $query_insertar = $bd->prepare('INSERT INTO usuarios VALUES (?, ?, ?, ?)');

            function encontrar_id_valido () {
                $cadena_conexion = 'mysql:dbname=empresa;host=127.0.0.1';
                $usuario = 'root';
                $clave = '';
                $bd_id = new PDO($cadena_conexion, $usuario, $clave);
                // Encontrar el próximo ID válido
                $code = 1; // El código 1 será nuestro punto de partida.
                $codes = array(); // Aquí almacenamos todos los códigos existentes.
                $sql = "SELECT codigo FROM usuarios";
                $query_code = $bd_id->query($sql);
                // Almacena los códigos existentes en un arreglo
                foreach ($query_code as $row) {
                    $codes[] = $row['codigo'];
                }

                // Encuentra el próximo código disponible, en cada iteración agrega un valor más a la variable code, en el momento en el cual code no coincida con alguno
                // de los valores ya existentes, sale del bucle y así encontramos el valor más próximo.
                while (in_array($code, $codes)) {
                    $code++;
                }

                return $code;
            }

            // Variables de json
            $string_json = file_get_contents("usuarios.json");
            $objeto_json = json_decode($string_json);

            if ($objeto_json === null) {
                echo "El archivo está mal codificado.";
            }
            else {
                if (property_exists($objeto_json, "usuarios")) {
                    $var_users = $objeto_json->usuarios;
                    foreach ($var_users as $user) {
                        $code = encontrar_id_valido();
                        $nombre = $user->nombre;
                        $clave = $user->clave;
                        $rol = $user->rol;
                        $query_insertar->execute(array($code, $nombre, $clave, $rol));
                    }
                }
                else {
                    echo "No existe usuarios.";
                } 
            }
        }
        ?>
</body>
</html>