<?php
@session_start();

/*
$length = 6;
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
}
echo  $randomString;
exit;
*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../resources/PHPMailer/PHPMailer/src/Exception.php';
require '../resources/PHPMailer/PHPMailer/src/PHPMailer.php';
require '../resources/PHPMailer/PHPMailer/src/SMTP.php';
include('conexion.php');
include('conexion2.php');
$condicion = $_POST["condicion"];
$datetime = date('Y-m-d H:i:s');


if($condicion=='table1'){
	$pagina = $_POST["pagina"];
	$consultasporpagina = $_POST["consultasporpagina"];
	$filtrado = $_POST["filtrado"];

	if($pagina==0 or $pagina==''){
		$pagina = 1;
	}

	if($filtrado!=''){
		$filtrado = ' WHERE nombre1 LIKE "%'.$filtrado.'%" or nombre2 LIKE "%'.$filtrado.'%" or apellido1 LIKE "%'.$filtrado.'%" or apellido2 LIKE "%'.$filtrado.'%" or documento_numero LIKE "%'.$filtrado.'%" or correo LIKE "%'.$filtrado.'%" or telefono1 LIKE "%'.$filtrado.'%"';
	}

	$limit = $consultasporpagina;
	$offset = ($pagina - 1) * $consultasporpagina;

	$sql1 = "SELECT * FROM modelos";
	$proceso1 = mysqli_query($conexion2,$sql1);
	$conteo1 = mysqli_num_rows($proceso1);

	$paginas = ceil($conteo1 / $consultasporpagina);

	$sql2 = "SELECT * FROM modelos ".$filtrado." ORDER BY fecha_inicio DESC LIMIT ".$limit." OFFSET ".$offset."";
	$proceso2 = mysqli_query($conexion2,$sql2);

	$html = '';

	$html .= '
		<div class="col-xs-12">
	        <h1>Productos</h1>
	        <table class="table table-bordered">
	            <thead>
	            <tr>
	                <th class="text-center">T Doc</th>
	                <th class="text-center">N Doc</th>
	                <th class="text-center">Nombre</th>
	                <th class="text-center">Género</th>
	                <th class="text-center">Correo</th>
	                <th class="text-center">Teléfono</th>
	                <th class="text-center">Estatus</th>
	                <th class="text-center">Sede</th>
	                <th class="text-center">Ingreso</th>
	                <th class="text-center">Opciones</th>
	            </tr>
	            </thead>
	            <tbody>
	';

	while($row2 = mysqli_fetch_array($proceso2)) {
		$html .= '
	                <tr>
	                    <td style="text-align:center;">'.$row2["documento_numero"].'</td>
	                    <td style="text-align:center;">'.$row2["documento_tipo"].'</td>
	                    <td style="text-align:justify;">'.$row2["nombre1"]." ".$row2["nombre2"]." ".$row2["apellido1"]." ".$row2["apellido2"].'</td>
	                    <td style="text-align:center;">'.$row2["genero"].'</td>
	                    <td style="text-align:center;">'.$row2["correo"].'</td>
	                    <td style="text-align:center;">'.$row2["telefono1"].'</td>
	                    <td  style="text-align:center;">'.$row2["estatus"].'</td>
	                    <td style="text-align:center;">'.$row2["sede"].'</td>
	                    <td nowrap="nowrap">'.$row2["fecha_inicio"].'</td>
	                    <td nowrap="nowrap">
	                    	<button type="button" class="btn btn-success">A</button>
	                    	<button type="button" class="btn btn-danger">R</button>
	                    </td>
	                </tr>
	    ';
	}

	$html .= '
	            </tbody>
	        </table>
	        <nav>
	            <div class="row">
	                <div class="col-xs-12 col-sm-6">
	                    <p>Mostrando '.$consultasporpagina.' de '.$conteo1.' productos disponibles</p>
	                </div>
	                <div class="col-xs-12 col-sm-6">
	                    <p>Página '.$pagina.' de '.$paginas.' </p>
	                </div>
	            </div>
	            <nav aria-label="Page navigation example">
					<ul class="pagination">
	';
	
	if ($pagina > 1) {
		$html .= '
							<li class="page-item">
								<a class="page-link" href="./index.php?pagina='.($pagina-1).'">
									<span aria-hidden="true">Anterior</span>
								</a>
							</li>
		';
	}

	$diferenciapagina = 3;
	
	/*********MENOS********/
	if($pagina==2){
		$html .= '
	                		<li class="page-item">
		                        <a class="page-link" href="./test5.php?pagina='.($pagina-1).'">
		                            '.($pagina-1).'
		                        </a>
		                    </li>
		';
	}else if($pagina==3){
		$html .= '
		                    <li class="page-item">
		                        <a class="page-link" href="./test5.php?pagina='.($pagina-2).'">
		                            '. $pagina-2 .'
		                        </a>
		                    </li>
		                    <li class="page-item">
		                        <a class="page-link" href="./test5.php?pagina='.($pagina-1).'">
		                            '.($pagina-1).'
		                        </a>
		                    </li>
	';
	}else if($pagina>=4){
		$html .= '
	                		<li class="page-item">
		                        <a class="page-link" href="./test5.php?pagina='.($pagina-3).'">
		                            '.($pagina-3).'
		                        </a>
		                    </li>
		                    <li class="page-item">
		                        <a class="page-link" href="./test5.php?pagina='.($pagina-2).'">
		                            '.($pagina-2).'
		                        </a>
		                    </li>
		                    <li class="page-item">
		                        <a class="page-link" href="./test5.php?pagina='.($pagina-1).'">
		                            '.($pagina-1).'
		                        </a>
		                    </li>
		';
	} 

	/*********MAS********/
	$opcionmas = $pagina+3;
	for ($x=$pagina;$x<=$opcionmas;$x++) {
		$html .= '
		                    <li class="page-item 
		';

		if ($x == $pagina){ 
			$html .= '"active"';
		}

		$html .= '">';

		$html .= '
		                        <a class="page-link" href="./test5.php?pagina='.$x.'">'.$x.'</a>
		                    </li>
		';
	}

	if ($pagina < $paginas) {
		$html .= '
		                    <li class="page-item">
		                        <a class="page-link" href="./test5.php?pagina='.($pagina+1).'">
		                            <span aria-hidden="true">Siguiente</span>
		                        </a>
		                    </li>
		';
	}

	$html .= '

					</ul>
				</nav>
	        </nav>
	    </div>
	';

	$datos = [
		"estatus"	=> "ok",
		"html"	=> $html,
		"sql2"	=> $sql2,
	];
	echo json_encode($datos);
}



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