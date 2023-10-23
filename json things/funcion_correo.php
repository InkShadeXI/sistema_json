1 <?php 	
	use PHPMailer\PHPMailer\PHPMailer;
	require "vendor/autoload.php"; 
	function enviar_email ($dir_destino, $dir_origen, $asunto, $mensaje) {
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPDebug  = 0;                      
		$mail->SMTPAuth   = false;
		$mail->Host       = "localhost";    
		$mail->Port       = 1025;              
		// introducir usuario de google
		$mail->Username   = "Shade"; 
		// introducir clave
		$mail->Password   = "shd1";   	
		$mail->SetFrom($dir_origen, 'Test');
		// asunto
		$mail->Subject = $asunto;
		// cuerpo
		$mail->MsgHTML($mensaje);
		// adjuntos
		//$mail->addAttachment("empleado.xsd");
		// destinatario
		$address = $dir_destino;
		$mail->AddAddress($address, "Test");
		// enviar
		$resul = $mail->Send();
		if (!$resul) {
			echo "Error" . $mail->ErrorInfo;
		} 
		else {
			echo "Enviado";
		}
	}

?>