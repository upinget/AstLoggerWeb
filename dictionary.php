<?php
include('lock.h');
function getDictionary($id) {
	$sql="SELECT id_name FROM t_dictionary WHERE id_id='$id'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if (mysql_num_rows($result)==1) {
		$value = $row['id_name']; 		
		return $value; 
	}
}

function insertDictionary($id, $name) {
	$sql="INSERT INTO t_dictionary (id_id, id_name) VALUES ('$id', '$name')";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if (mysql_affected_rows()==1) {
		return true;
	}
	return false;
}

function setDictionary($id, $name) {
	$sql="UPDATE t_dictionary SET id_name='$name' WHERE id_id='$id'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if (mysql_affected_rows()==1) {
		return true;
	}
	return false;
}
?>