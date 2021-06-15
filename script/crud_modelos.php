<?php
@session_start();
include('conexion.php');
$condicion = $_POST["condicion"];
$datetime = date('Y-m-d H:i:s');

if($condicion=='consultar_personal1'){
	$id = $_POST['id'];

	$sql1 = "SELECT * FROM usuarios WHERE id = ".$id;
	$proceso1 = mysqli_query($conexion,$sql1);
	while($row1 = mysqli_fetch_array($proceso1)) {
		$nombre = $row1["nombre1"]." ".$row1["nombre2"]." ".$row1["apellido1"]." ".$row1["apellido2"];
		$documento_tipo = $row1["documento_tipo"];
		$documento_numero = $row1["documento_numero"];
		$correo_empresa = $row1["correo_empresa"];
		$correo_personal = $row1["correo_personal"];
		$telefono = $row1["telefono"];
		$genero = $row1["genero"];
		$sql2 = "SELECT * FROM datos_modelos WHERE id_usuarios = ".$id;
		$proceso2 = mysqli_query($conexion,$sql2);
		while($row2 = mysqli_fetch_array($proceso2)) {
			$banco_cedula = $row2["banco_cedula"];
			$banco_nombre = $row2["banco_nombre"];
			$banco_tipo = $row2["banco_tipo"];
			$banco_numero = $row2["banco_numero"];
			$banco_banco = $row2["banco_banco"];
			$banco_bcpp = $row2["banco_bcpp"];
			$banco_tipo_documento = $row2["banco_tipo_documento"];
			$altura = $row2["altura"];
			$peso = $row2["peso"];
			$tpene = $row2["tpene"];
			$tsosten = $row2["tsosten"];
			$tbusto = $row2["tbusto"];
			$tcintura = $row2["tcintura"];
			$tcaderas = $row2["tcaderas"];
			$tipo_cuerpo = $row2["tipo_cuerpo"];
			$pvello = $row2["pvello"];
			$color_cabello = $row2["color_cabello"];
			$color_ojos = $row2["color_ojos"];
			$ptattu = $row2["ptattu"];
			$ppiercing = $row2["ppiercing"];
			$turno = $row2["turno"];
			$sede = $row2["sede"];
			$estatus = $row2["estatus"];
			$fecha_creacion = $row2["fecha_creacion"];
		}

		$sql3 = "SELECT * FROM documento_tipo WHERE id = ".$documento_tipo;
		$proceso3 = mysqli_query($conexion,$sql3);
		while($row3 = mysqli_fetch_array($proceso3)) {
			$documento_tipo_nombre = $row3["nombre"];
		}

		$sql4 = "SELECT * FROM sedes WHERE id = ".$sede;
		$proceso4 = mysqli_query($conexion,$sql4);
		while($row4 = mysqli_fetch_array($proceso4)) {
			$sedes_nombre = $row4["nombre"];
		}

		$sql5 = "SELECT * FROM documento_tipo WHERE id = ".$banco_tipo_documento;
		$proceso5 = mysqli_query($conexion,$sql5);
		while($row5 = mysqli_fetch_array($proceso5)) {
			$banco_tipo_documento_nombre = $row5["nombre"];
		}
	}

	$datos = [
		"estatus"	=> "ok",
		"nombre" => $nombre,
		"documento_tipo" => $documento_tipo_nombre,
		"documento_numero" => $documento_numero,
		"correo_personal" => $correo_personal,
		"telefono" => $telefono,
		"genero" => $genero,
		"sede" => $sedes_nombre,

		"banco_cedula" => $banco_cedula,
		"banco_nombre" => $banco_nombre,
		"banco_tipo" => $banco_tipo,
		"banco_numero" => $banco_numero,
		"banco_banco" => $banco_banco,
		"banco_bcpp" => $banco_bcpp,
		"banco_tipo_documento" => $banco_tipo_documento_nombre,
		"altura" => $altura,
		"peso" => $peso,
		"tpene" => $tpene,
		"tsosten" => $tsosten,
		"tbusto" => $tbusto,
		"tcintura" => $tcintura,
		"tcaderas" => $tcaderas,
		"tipo_cuerpo" => $tipo_cuerpo,
		"pvello" => $pvello,
		"color_cabello" => $color_cabello,
		"color_ojos" => $color_ojos,
		"ptattu" => $ptattu,
		"ppiercing" => $ppiercing,
		"turno" => $turno,
		"estatus" => $estatus,
		"fecha_creacion" => $fecha_creacion,
	];
	echo json_encode($datos);
}

?>