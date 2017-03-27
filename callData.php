<?php
include('lock.h');
include_once('auditTrial.php');
function hasMultipleUcidCalls($ucid) {
	$sql="SELECT id_uniquekey FROM t_astcalldata WHERE id_ucid='$ucid'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if (mysql_num_rows($result)>1) {
		return true; 	
	}
	return false;
}

function recPath($key) {
	$sql="SELECT id_recpath, id_archivepath FROM t_astcalldata WHERE id_uniquekey='$key'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if (mysql_num_rows($result)==1) {
		if (file_exists(substr($row['id_recpath'], 1))) {
			$recpath = $row['id_recpath'];
		} else {
			$recpath = $row['id_archivepath'];
		}
		$pos = strpos($recpath, ".ssl");
		if ($pos!==FALSE) {
			return substr($recpath, 0, $pos);			
		}
		$pos = strpos($recpath, ".gpg");
		if ($pos!==FALSE) {
			return substr($recpath, 0, $pos);
		}		
		return $recpath; 
	}
}

function recPathArray($key) {
	$sql="SELECT id_recpath, id_archivepath, id_recformat FROM t_astcalldata WHERE id_uniquekey='$key'";   
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if (mysql_num_rows($result)==1) {
		if (file_exists(substr($row['id_recpath'], 1))) {
			$recpath = $row['id_recpath'];
		} else {
			$recpath = $row['id_archivepath'];
		}
		$recformat = $row['id_recformat'];       
		if ((strpos($recpath, ".ssl")!==FALSE) ||
			(strpos($recpath, ".gpg")!==FALSE)) {			
			$url = "http://localhost:5003/recordpath?recordkey=$key";
			$ch = curl_init();
			// Will return the response, if false it print the response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// Set the url
			curl_setopt($ch, CURLOPT_URL,$url);
			// Execute
			$result=curl_exec($ch);
			// Closing
			curl_close($ch);
			if (!empty($result)) {
				$data = json_decode($result, true);
				if (!empty($data)) {
					if ($data['result']=='success') {
						return array($data['recordpath'], $recformat, $data['decrypted'], $data['filename']); 
					} 
				} 
			} 		
		} else {           
			$pos = strrpos($recpath, "/");
			$filename = substr($recpath, $pos+1);            
			return array($recpath, $recformat, "false", $filename);		
		}
	}
	return array();
}
?>