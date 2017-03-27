<?php
include('lock.h');
function getOption($userid, $variable) {
	$sql="SELECT pValue FROM tOption WHERE id_userid=$userid AND pVariable='$variable'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if (mysql_num_rows($result)==1) {
		$value = $row['pValue']; 		
		return $value; 
	}
}

function insertOption($userid, $variable, $value) {
	$sql="INSERT INTO tOption (id_userid, pVariable, pValue) VALUES ($userid, '$variable', '$value')";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if (mysql_affected_rows()==1) {
		return true;
	}
	return false;
}

function setOption($userid, $variable, $value) {
	$sql="UPDATE tOption SET pValue='$value' WHERE id_userid=$userid AND pVariable='$variable'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if (mysql_affected_rows()==1) {
		return true;
	}
	return false;
}
?>