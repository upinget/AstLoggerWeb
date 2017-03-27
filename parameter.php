<?php
include('lock.h');
function getParameter($variable) {
	$sql="SELECT pValue FROM tParameter WHERE pVariable='$variable'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if (mysql_num_rows($result)==1) {
		$value = $row['pValue']; 		
		return $value; 
	}
}

function insertParameter($variable, $value, $description) {
	$sql="INSERT INTO tParameter (pVariable, pValue, pDescription) VALUES ('$variable', '$value', '$description')";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if (mysql_affected_rows()==1) {
		return true;
	}
	return false;
}

function setParameter($variable, $value, $description) {
	$sql="UPDATE tParameter SET pValue='$value', pDescription='$description' WHERE pVariable='$variable'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if (mysql_affected_rows()==1) {
		return true;
	}
	return false;
}
?>