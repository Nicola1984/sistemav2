<?php
define('CHAT_TOKEN', 'l77pida8jcu4b7qc');
define('CHAT_URL', 'instance258543');

function sendMessage($to,$msg){
	$data = [
		'phone' => $to,
		'body' => $msg,
	];
	$json = json_encode($data);
	//$url = CHAT_URL.'sendMessage?token='.CHAT_TOKEN;
	$url = 'https://api.chat-api.com/'.CHAT_URL.'/sendMessage?token='.CHAT_TOKEN;
	$options = stream_context_create(['http' => [
			'method' => 'POST',
			'header' => 'Content-type: application/json',
			'content' => $json
		]
	]);

	$result = file_get_contents($url, false, $options);
	if($result) return json_decode($result);

	return false;
}

$msg = "Esta es una prueba desde la app";
$phone = '573148597354';
$result = sendMessage($phone,$msg);
	if($result !== false){
		if($result->sent == 1){
			echo "Mensaje enviado!<br>";
			echo $result->message;
		}else{
			echo $result->message;
		}
	}else{
		var_dump($result);
	}

?>