<?php
@session_start();

$length = 6;
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
}
echo  $randomString;

exit;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../resources/PHPMailer/PHPMailer/src/Exception.php';
require '../resources/PHPMailer/PHPMailer/src/PHPMailer.php';
require '../resources/PHPMailer/PHPMailer/src/SMTP.php';
include('conexion.php');
$condicion = $_POST["condicion"];
$datetime = date('Y-m-d H:i:s');

if($condicion=='cambio_estatus1'){
	$id = $_POST['id'];
	$estatus = $_POST['estatus'];

	$sql2 = "SELECT * FROM datos_pasantes WHERE id = ".$id." and (estatus = 2 or estatus = 3)";
	$proceso2 = mysqli_query($conexion,$sql2);
	$contador2 = mysqli_num_rows($proceso2);
	if($contador2==0){
		$sql3 = "SELECT * FROM datos_pasantes WHERE id = ".$id;
		$proceso3 = mysqli_query($conexion,$sql3);
		while($row3 = mysqli_fetch_array($proceso3)) {
			$id_usuarios = $row3["id_usuarios"];
			$sql4 = "SELECT * FROM usuarios WHERE id = ".$id_usuarios;
			$proceso4 = mysqli_query($conexion,$sql4);
			while($row4 = mysqli_fetch_array($proceso4)) {
				$correo_personal = $row4["correo_personal"];
			}
		}
		$sql1 = "UPDATE datos_pasantes SET estatus = ".$estatus." WHERE id = ".$id;
		$proceso1 = mysqli_query($conexion,$sql1);
		if($estatus==2){
			$html = '';

			/***************APARTADO DE CORREO*****************/
			$mail = new PHPMailer(true);
			try {
			    $mail->isSMTP();
			    $mail->CharSet = "UTF-8";
			    $mail->Host = 'mail.camaleonpruebas.com';
			    $mail->SMTPAuth = true;
			    $mail->Username = 'test1@camaleonpruebas.com';
			    $mail->Password = 'juanmaldonado123';
			    $mail->SMTPSecure = 'tls';
			    $mail->Port = 587;

			    $mail->setFrom('test1@camaleonpruebas.com');
			    $mail->addAddress($correo_personal);
			    $mail->AddEmbeddedImage("img/mails/mailing modelo1.png", "my-attach", "mailing modelo1.png");
			    $html = "
			        <h2 style='color:#3F568A; text-align:center; font-family: Helvetica Neue,Helvetica,Arial,sans-serif;'>
			            <p>Felicitaciones tu perfil ha sido aprobado para formar parte de la familia Camaleón!.</p>
			            <p>El siguiente paso es completar tu formulario de contacto, puedes ingresar al sistema con los siguientes datos.</p>
			            <p>Usuario: | Clave: ".$clave_generada." </p>
			            <p>En el link.. https://www.camaleonmg.com</p>
			        </h2>
			        <div style='text-align:center;'>
			        	<img alt='PHPMailer' src='cid:my-attach'>
			        </div>
			    ";

			    $mail->isHTML(true);
			    $mail->Subject = 'Aprobacion Camaleon!';
			    $mail->Body    = $html;
			    $mail->AltBody = 'Este es el contenido del mensaje en texto plano';
			 
			    $mail->send();
			} catch (Exception $e) {}
			/**************************************************/

		}
		$datos = [
			"estatus"	=> "ok",
		];
	}else{
		$datos = [
			"estatus"	=> "repetidos",
		];
	}



	echo json_encode($datos);
}

?>