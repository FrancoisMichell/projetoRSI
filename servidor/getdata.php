<?php

header('Access-Control-Allow-Origin: *');

require 'functions.php';


$result = array();
$result["success"] = true;
$result["msg"] = array();

$profiles = get_profiles();
$manufactures = get_manufactures();
$daily_freq = get_daily_freq();
$shift_freq = get_shift_freq();
$sos = get_sos();

if ($profiles["sts"]) { 
	$result["profiles"] = array();
	$result["profiles"]["profiles"] = $profiles["profiles"];
	$result["profiles"]["qts"] = $profiles["qts"];
	$result["profiles"]["pcts"] = $profiles["pcts"];
}
else { $result["msg"][] = $profiles["msg"]; }

if ($manufactures["sts"]) { 
	$result["manufactures"] = array();
	$result["manufactures"]["names"] = $manufactures["names"];
	$result["manufactures"]["qts"] = $manufactures["qts"];
	$result["manufactures"]["pcts"] = $manufactures["pcts"];
}
else { $result["msg"][] = $manufactures["msg"]; }

if ($daily_freq["sts"]) { 
	$result["daily_freq"] = array();
	$result["daily_freq"]["days"] = $daily_freq["days"];
	$result["daily_freq"]["qts"] = $daily_freq["qts"];
	$result["daily_freq"]["pcts"] = $daily_freq["pcts"];
}
else { $result["msg"][] = $manufactures["msg"]; }

if ($shift_freq["sts"]) { 
	$result["shift_freq"] = array();
	$result["shift_freq"]["stamps"] = $shift_freq["stamps"];
	$result["shift_freq"]["qts"] = $shift_freq["qts"];
	$result["shift_freq"]["pcts"] = $shift_freq["pcts"];
}
else { $result["msg"][] = $manufactures["msg"]; }

if ($sos["sts"]) { 
	$result["sos"] = array();
	$result["sos"]["names"] = $sos["names"];
	$result["sos"]["qts"] = $sos["qts"];
	$result["sos"]["pcts"] = $sos["pcts"];
}
else { $result["msg"][] = $manufactures["msg"]; }

echo json_encode($result);


?>