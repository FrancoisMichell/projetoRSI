<?php

header('Access-Control-Allow-Origin: *');

$result = array();
$result["sts"] = false;
$result["msg"] = "";

if (!empty($_POST)) {

	require 'functions.php';

	$result["posted"] = $_POST;

	$mac = $_POST["mac"];
	$timestamp = $_POST["timestamp"];
	$signal = $_POST["forcaSinal"];

	$insert = insert_raw_entry($mac,$timestamp,$signal);
	$update_fabricante = updateFabricante($mac);

	if ($insert["sts"]) {
		$result["sts"] = true;
	}
	else {
		$result["msg"] = $insert["msg"];
	}

}
else {
	$result["msg"] = "Nenhum dado enviado.";
}

echo json_encode($result,JSON_UNESCAPED_UNICODE);
