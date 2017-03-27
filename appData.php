<?php
include('lock.h');
function hasAppData($key) {
	$sql="SELECT id_uniquekey FROM t_astappdata WHERE id_uniquekey='$key'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if (mysql_num_rows($result)==1) {
		return true; 	
	}
	return false;
}
?>