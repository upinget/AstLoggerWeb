<?php
include('lock.php');
$groupID = $_SESSION['s_loginGroupid'];
if (isset($groupID)) {
	if ($groupID==0) {
		$sql="SELECT id_srvip, id_srvport, id_description FROM t_astsrvinfo";
		$result=mysql_query($sql);
		if (mysql_num_rows($result) > 0) {
			echo "Select Logger:"; 
			echo "<br />";			
			while($row = mysql_fetch_array($result)){
				$srvip = $row['id_srvip'];
				$port = $row['id_srvport'];
				$description = $row['id_description'];
				echo "<a href=\"loggerStatusResultForm.php?srvip=$srvip&port=$port\">$srvip:$port</a>";
				echo "<br />";
			}						
		}		
	}
}
?>