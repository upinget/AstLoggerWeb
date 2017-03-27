<?php
include('lock.h');
function insertAuditTrial($message) {
	// unix timestamp 
	$timeStamp = time(); 
	// username append in the message 
	$myUsername = $_SESSION['s_loginUsername'];
	$newMessage = "$myUsername "; 
	$newMessage .= $message; 
	$sql="INSERT INTO t_astaudittrial (id_starttime, id_message) VALUES ($timeStamp, '$newMessage')";
	$result=mysql_query($sql);
	if (mysql_affected_rows()==1) {
		return true;		
	}
	return false;
}
?>
