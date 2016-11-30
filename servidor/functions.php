<?php

#mysql_close($link);

function start_db_connection()
{
	# ----- Database credentials -------------------
	$host = "localhost";
	$username = "1244473";
	$password = "pass123";
	$dbname = "1244473";

	$conn = mysql_connect($host, $username, $password);

	if (!$conn) { return 0; }
	else { 
		mysql_select_db($dbname);
		return $conn;
	}
}

function get_profiles()
{
	$obj = array();
	$obj["sts"] = false;
	$obj["msg"] = "";
	$obj["profiles"] = array();
	$obj["qts"] = array();
	$obj["pcts"] = array();

	$conn = start_db_connection();
	if ($conn) {
		$sql = "SELECT `profiles`.`profile`,count(*) AS `qt` FROM `profile_mac_assoc` INNER JOIN `profiles` ON `profiles`.`id` = `profile_mac_assoc`.`profile_id` GROUP BY `profile`";
		$ret = mysql_query($sql,$conn);

		while ($result = mysql_fetch_assoc($ret)) {						
			$obj["profiles"][] = $result["profile"];
			$obj["qts"][] = $result["qt"];			
		}

		$total = 0;

		foreach ($obj["qts"] as $value) { $total = $total + $value; }
		foreach ($obj["qts"] as $val) {
			$obj["pcts"][] = ($val*100)/$total;
		}

		if (!empty($obj["profiles"])) { $obj["sts"] = true; }

		if (!$ret) { $obj["msg"] = "Falha: " . mysql_error(); }
	}
	mysql_close($conn);
	return $obj;
}

function get_manufactures()
{
	$obj = array();
	$obj["sts"] = false;
	$obj["msg"] = "";
	$obj["names"] = array();
	$obj["qts"] = array();
	$obj["pcts"] = array();

	$conn = start_db_connection();
	if ($conn) {
		$sql = "SELECT CASE WHEN COUNT(*) > 3 THEN `nic`.`mfr` WHEN COUNT(*) < 4 THEN 'OUTROS' END as `mfr`, count(*) AS `qt` FROM `nic_mac_assoc` INNER JOIN `nic` ON `nic_mac_assoc`.`nic_id` = `nic`.`id` GROUP BY `mfr`";
		$ret = mysql_query($sql,$conn);

		while ($result = mysql_fetch_assoc($ret)) {
			$obj["names"][] = $result["mfr"];
			$obj["qts"][] = $result["qt"];
		}

		$total = 0;

		foreach ($obj["qts"] as $value) { $total = $total + $value; }
		foreach ($obj["qts"] as $val) {
			$obj["pcts"][] = ($val*100)/$total;
		}

		if (!empty($obj["names"])) { $obj["sts"] = true; }

		if (!$ret) { $obj["msg"] = "Falha: " . mysql_error(); }
	}
	mysql_close($conn);
	return $obj;
}


function get_sos()
{
	$obj = array();
	$obj["sts"] = false;
	$obj["msg"] = "";
	$obj["names"] = array();
	$obj["qts"] = array();
	$obj["pcts"] = array();

	$conn = start_db_connection();
	if ($conn) {
		$sql = "SELECT `so` , COUNT( * ) AS `qt` FROM `nic_mac_assoc` INNER JOIN `nic` ON `nic_mac_assoc`.`nic_id` = `nic`.`id` GROUP BY `so`";
		$ret = mysql_query($sql,$conn);

		while ($result = mysql_fetch_assoc($ret)) {
			$obj["names"][] = $result["so"];
			$obj["qts"][] = $result["qt"];			
		}

		$total = 0;

		foreach ($obj["qts"] as $value) { $total = $total + $value; }
		foreach ($obj["qts"] as $val) {
			$obj["pcts"][] = ($val*100)/$total;
		}

		if (!empty($obj["names"])) { $obj["sts"] = true; }

		if (!$ret) { $obj["msg"] = "Falha: " . mysql_error(); }
	}
	mysql_close($conn);
	return $obj;
}


function get_daily_freq()
{
	$obj = array();
	$obj["sts"] = false;
	$obj["msg"] = "";
	$obj["days"] = array();
	$obj["qts"] = array();
	$obj["pcts"] = array();

	$conn = start_db_connection();
	if ($conn) {
		$sql = "SELECT CASE WHEN `timestmp` LIKE '2016-11-22%' THEN '2016-11-22' WHEN `timestmp` LIKE '2016-11-23%' THEN '2016-11-23' WHEN `timestmp` LIKE '2016-11-24%' THEN '2016-11-24' WHEN `timestmp` LIKE '2016-11-25%' THEN '2016-11-25' WHEN `timestmp` LIKE '2016-11-26%' THEN '2016-11-26' WHEN `timestmp` LIKE '2016-11-27%' THEN '2016-11-27' END AS `day` ,COUNT(`mac_id`) AS `qt` FROM `raw_entries` GROUP BY `day`";
		$ret = mysql_query($sql,$conn);

		while ($result = mysql_fetch_assoc($ret)) {
			$obj["days"][] = $result["day"];
			$obj["qts"][] = $result["qt"];
		}

		$total = 0;

		foreach ($obj["qts"] as $value) { $total = $total + $value; }
		foreach ($obj["qts"] as $val) {
			$obj["pcts"][] = ($val*100)/$total;
		}

		if (!empty($obj["days"])) { $obj["sts"] = true; }

		if (!$ret) { $obj["msg"] = "Falha: " . mysql_error(); }
	}
	mysql_close($conn);
	return $obj;
}

function get_shift_freq()
{
	$obj = array();
	$obj["sts"] = false;
	$obj["msg"] = "";
	$obj["stamps"] = array();
	$obj["qts"] = array();
	$obj["pcts"] = array();

	$conn = start_db_connection();
	if ($conn) {
		$sql = "SELECT CASE WHEN `timestmp` LIKE '% 05:%' THEN 'Manhã (05h - 11h59)' WHEN `timestmp` LIKE '% 06:%' THEN 'Manhã (05h - 11h59)' WHEN `timestmp` LIKE '% 07:%' THEN 'Manhã (05h - 11h59)' WHEN `timestmp` LIKE '% 08:%' THEN 'Manhã (05h - 11h59)' WHEN `timestmp` LIKE '% 09:%' THEN 'Manhã (05h - 11h59)' WHEN `timestmp` LIKE '% 10:%' THEN 'Manhã (05h - 11h59)' WHEN `timestmp` LIKE '% 11:%' THEN 'Manhã (05h - 11h59)'  WHEN `timestmp` LIKE '% 12:%' THEN 'Tarde (12h - 17h59)' WHEN `timestmp` LIKE '% 13:%' THEN 'Tarde (12h - 17h59)' WHEN `timestmp` LIKE '% 14:%' THEN 'Tarde (12h - 17h59)' WHEN `timestmp` LIKE '% 15:%' THEN 'Tarde (12h - 17h59)' WHEN `timestmp` LIKE '% 16:%' THEN 'Tarde (12h - 17h59)' WHEN `timestmp` LIKE '% 17:%' THEN 'Tarde (12h - 17h59)'  WHEN `timestmp` LIKE '% 18:%' THEN 'Noite (18h - 23h59)' WHEN `timestmp` LIKE '% 19:%' THEN 'Noite (18h - 23h59)' WHEN `timestmp` LIKE '% 20:%' THEN 'Noite (18h - 23h59)' WHEN `timestmp` LIKE '% 21:%' THEN 'Noite (18h - 23h59)' WHEN `timestmp` LIKE '% 22:%' THEN 'Noite (18h - 23h59)' WHEN `timestmp` LIKE '% 23:%' THEN 'Noite (18h - 23h59)' WHEN `timestmp` LIKE '% 00:%' THEN 'Madrugada (00h - 04h59)' WHEN `timestmp` LIKE '% 01:%' THEN 'Madrugada (00h - 04h59)' WHEN `timestmp` LIKE '% 02:%' THEN 'Madrugada (00h - 04h59)' WHEN `timestmp` LIKE '% 03:%' THEN 'Madrugada (00h - 04h59)' WHEN `timestmp` LIKE '% 04:%' THEN 'Madrugada (00h - 04h59)' END AS `stamp`, COUNT(`mac_id`) AS `qt` FROM `raw_entries` GROUP BY `stamp`;";
		$ret = mysql_query($sql,$conn);

		while ($result = mysql_fetch_assoc($ret)) {
			$obj["stamps"][] = $result["stamp"];
			$obj["qts"][] = $result["qt"];
		}

		$total = 0;

		foreach ($obj["qts"] as $value) { $total = $total + $value; }
		foreach ($obj["qts"] as $val) {
			$obj["pcts"][] = ($val*100)/$total;
		}

		if (!empty($obj["stamps"])) { $obj["sts"] = true; }

		if (!$ret) { $obj["msg"] = "Falha: " . mysql_error(); }
	}
	mysql_close($conn);
	return $obj;
}

function insert_mac_mapping($mac)
{
	$obj = array();
	$obj["sts"] = false;
	$obj["msg"] = "";
	$obj["id"] = 0;

	$conn = start_db_connection();
	if ($conn) {
		$sql = "INSERT IGNORE INTO mac_mapping (mac) VALUES ('".$mac."');";
		$ret = mysql_query($sql,$conn);

		if (!$ret) {
			$obj["msg"] = "Falha ao inserir end. MAC ao banco: " . mysql_error();
		}
		else {
			#$sql = "SELECT id FROM mac_mapping WHERE mac = '".$mac."'";
			#$ret = mysql_query($sql,$conn);
			#if (!$ret) {
				#$obj["msg"] = "Não foi possível retorar ID última inserção: ". mysql_error();
			#}
			#else {
				#$obj["id"] = $ret["id"];
				$obj["id"] = mysql_insert_id();
				$obj["sts"] = true;
			#}
		}

	}
	mysql_close($conn);
	return $obj;

}


function insert_raw_entry($mac,$timestamp,$signal)
{

	$obj = array();
	$obj["sts"] = false;
	$obj["msg"] = "";	

	$mac_insert = insert_mac_mapping($mac);
	if (!$mac_insert["sts"]) { $obj["msg"] = $mac_insert["msg"]; }
	else {
		$conn = start_db_connection();
		if ($conn) {
			$sql = "INSERT INTO raw_entries (mac_id,timestmp,signalStr) VALUES (".$mac_insert["id"].",'".$timestamp."','".$signal."');";
			$ret = mysql_query($sql,$conn);

			if (!$ret) {
				$obj["msg"] = "SQL: ".$sql." || ERRO: " . mysql_error();				
			}
			else {
				$obj["sts"] = true;
			}

		}
		mysql_close($conn);		
	}
	return $obj;
}

/*
function insert_mac_nic($mfr)
{
	$obj = array();
	$obj["sts"] = false;
	$obj["msg"] = "";
	$obj["id"] = 0;

	$conn = start_db_connection();
	if ($conn) {
		$sql = "INSERT IGNORE INTO nic (mfr) VALUES ('".$mfr."');";
		$ret = mysql_query($sql,$conn);

		if (!$ret) {
			$obj["msg"] = "Falha ao inserir nic ao banco: " . mysql_error();
		}
		else {
			#$sql = "SELECT id FROM mac_mapping WHERE mac = '".$mac."'";
			#$ret = mysql_query($sql,$conn);
			#if (!$ret) {
				#$obj["msg"] = "Não foi possível retorar ID última inserção: ". mysql_error();
			#}
			#else {
				#$obj["id"] = $ret["id"];
				$obj["id"] = mysql_insert_id();
				$obj["sts"] = true;
			#}
		}

	}
	mysql_close($conn);
	return $obj;

}
*/

public function getFabricante($mac) {
    $retorno = "";
    $mac = str_replace(':','',$mac);
    $mac = strtoupper($mac);
    $url = "http://api.macvendors.com/" . urlencode($mac);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    if($response) {
        $retorno = $response;
        //echo $response;
    } else {
        $retorno = "SEM FABRICANTE";
        //echo "Nao foi encontrado fabricante do MAC: ".$mac;
    }
    return $retorno;
}


public function updateFabricante($mac) {
    $soma_erros = 0;
	$conn = start_db_connection();
    $stmt = $conn->prepare('SELECT * FROM  mac_mapping WHERE mac = ?');
    $stmt->bind_param('s', trim($mac, '"'));
    $stmt->execute();
    $macs = $stmt->get_result();
    while ($mac = $macs->fetch_assoc()) {
        $mac_id = $mac['id'];

        // retorna o numero de dias que foi registrado o mac
        $day_frequency = $this->getFrequencia($mac_id);

        // retorna o nome do fabricante
        $fabricante = $this->getFabricante($mac['mac']);
        //echo $fabricante;

        //retorna o id do fabricante
        $fabricante_id = $this->verificaInsereFabricante($fabricante);

        // insere o relacionamento do fabricante
        $soma_erros += $this->insereRelacionamentoFabricante($fabricante_id,$mac_id,$day_frequency);
        
    }
    mysql_close($conn);	
    return 1;
}

public function verificaInsereFabricante($fabricante){
    //print_r($fabricante);
    //echo gettype($fabricante);
    $stmt = $this->conn->prepare('select * from nic where mfr = ?');
    $stmt->bind_param('s', trim($fabricante, '"'));
    $stmt->execute();
    $fabricante_database = $stmt->get_result();
    if ($fabricante_database->num_rows == 0) {
        $stmt1 = $this->conn->prepare('INSERT INTO nic (mfr) values (?)');
        $stmt1->bind_param('s',$fabricante );
        $result = $stmt1->execute();
        if ($result) {
            $id =  $stmt1->insert_id;
        }else{
            $id = 0;
        }
        $stmt1->close();
    }else{
        $fabricante_id = $fabricante_database->fetch_array(MYSQLI_ASSOC);
        $id = $fabricante_id['id'];
    }
    $stmt->close();
    return $id;
}


public function getFrequencia($mac_id){
    $stmt = $this->conn->prepare("SELECT  `mac_id` ,COUNT(  `day` ) AS  `day_frequency`
    FROM ( SELECT  `mac_id` ,
    CASE
    WHEN  `timestmp` LIKE  '2016-11-21%'
    THEN  '2016-11-21'
    WHEN  `timestmp` LIKE  '2016-11-22%'
    THEN  '2016-11-22'
    WHEN  `timestmp` LIKE  '2016-11-23%'
    THEN  '2016-11-23'
    WHEN  `timestmp` LIKE  '2016-11-24%'
    THEN  '2016-11-24'
    WHEN  `timestmp` LIKE  '2016-11-25%'
    THEN  '2016-11-25'
    WHEN  `timestmp` LIKE  '2016-11-26%'
    THEN  '2016-11-26'
    WHEN  `timestmp` LIKE  '2016-11-27%'
    THEN  '2016-11-27'
    END AS  `day`
    FROM  `raw_entries`
    GROUP BY  `mac_id` ,  `day`) AS  `r1`
    where mac_id = ?
    GROUP BY  `mac_id`");
    $stmt->bind_param('i',$mac_id);
    $result = $stmt->execute();
    $frequencias = $stmt->get_result();
    if ($result) {
        $frequencias = $frequencias->fetch_array(MYSQLI_ASSOC);
        $frequencia = $frequencias['day_frequency'];
    }else{
        $frequencia = 0;
    }
    $stmt->close();
    return $frequencia;
}


public function insereRelacionamentoFabricante($fabricante_id, $mac_id,$day_frequency){
    $stmt = $this->conn->prepare('INSERT INTO nic_mac_assoc(mac_id , nic_id, daily_frequency) values (?,?,?)');
    $stmt->bind_param('iii',$mac_id, $fabricante_id , $day_frequency );
    $result = $stmt->execute();
    $stmt->close();
    if ($result) {
        // inserido
        $response = 0;
    }else{
        // falhou
        $response = 1;
    }
    return $response;
}
