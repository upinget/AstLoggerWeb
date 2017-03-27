<?php
include('lock.php');
include_once('callData.php');
$recordkey = $_GET["recordkey"];
$recpathArray = recPathArray($recordkey);
if (sizeof($recpathArray)>0) {
	header("Content-type: {$recpathArray[1]}");
	header('Content-length: ' . filesize($recpathArray[0]));
	header('Content-Disposition: filename=' . $recpathArray[3]);
	header('X-Pad: avoid browser bug');
	header('Cache-Control: no-cache');
	readfile($recpathArray[0]);
	if ($recpathArray[2]=='true') {
		unlink($recpathArray[0]);
	}		
} else {
	header('HTTP/1.0 404 Not Found');	
}
?>