<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <input type="file" value="subir usuarios" name="json_file">
        <input type="file" value="subir correo" name="email_file">
        <input type="submit">
    </form>
    <?php

    require "funcion_correo.php"; 

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //Obtenemos el json
        $string_json = file_get_contents($_POST["json_file"]);
        $objeto_json = json_decode($string_json);
        
        //Obtenemos el archivo del email
        $string_email = $_POST["email_file"];
        $fichero_email = fopen($string_email, "r");

        //Extraemos el asunto y el cuerpo del email.
        $asunto = fgets($fichero_email);
        $cuerpo = "";
        while(!feof($fichero_email)) {
            $cuerpo = $cuerpo . " " . fgets($fichero_email);
        }
        echo $asunto . "<br>" . $cuerpo;
        // Lectura correcta.
        // Validamos el json
        if ($objeto_json !== null) {
            if (property_exists($objeto_json, "usuarios")) {
                $var_users = $objeto_json->usuarios;
                foreach ($var_users as $user) {
                    $email_origen = $user->emailorigen;
                    $email_destino = $user->emaildestino;
                    $no_molestar = $user->nomolestar;
                    if ($no_molestar == 0) {
                        enviar_email($email_destino, $email_origen, $asunto, $cuerpo);
                    }
                }
            }
            else {
                echo "No existe usuarios.";
            } 
        }
        else {
            echo "Error con la validación del json.";
        }
    }
    ?>
</body>
</html>