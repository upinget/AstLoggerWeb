<html>
<head>
<title>Logger List Result</title>    
<?php 
include('config.php');
include_once('auditTrial.php');
session_start();
include('layoutjscss.php');
?>
</head>
<body>
	<div class="ui-layout-north"> 
	<?php
	include('header.php'); 
	?>
	</div>     
	<div class="ui-layout-west">
	<?php
	include('loggerListForm.php');
	?>    
	</div>  
	<div class="ui-layout-center">
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$formname=addslashes($_POST['formname']);
		if ($formname=="loggerListForm") {
			$ip=addslashes($_POST['ip']);
			if (strlen($ip)) {
				// format the sql statement using the username and password fields of the form
				$sql="SELECT id_srvip, id_srvport, id_description FROM t_astsrvinfo WHERE id_srvip LIKE '%$ip%'";
			} else {
				// format the sql statement using the username and password fields of the form
				$sql="SELECT id_srvip, id_srvport, id_description FROM t_astsrvinfo";
			}
			$result=mysql_query($sql);
			if (mysql_num_rows($result) > 0) {
				// format the form
				echo "<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">";
				echo "<link rel=\"stylesheet\" href=\"libs/css/astlogger.css\">";
				echo "<table width=\"100%\" border=\"1\">";
				echo "<tr>";
				echo "<th>Logger IP</th><th>Logger Port</th><th>Description</th>";
				echo "</tr>"; 
				while($row = mysql_fetch_array($result)){
					$srvip = $row['id_srvip'];
					$port = $row['id_srvport'];
					$description = $row['id_description'];
					echo "<tr>";
					echo "<td>";
					echo $srvip;
					echo "</td>";
					echo "<td>";
					echo $port;
					echo "</td>";
					echo "<td>";
					echo $description;
					echo "</td>";
					echo "</tr>";
				}		
				echo "</table>";
				echo "</form>";
				// audit trial 
				if (strlen($ip)) {
					$auditTrial = "list logger information like $ip successfully.";
					insertAuditTrial($auditTrial);						
				} else {
					$auditTrial = "list all logger information successfully.";
					insertAuditTrial($auditTrial);					
				}
			}		
		} 
	}
	?>		
	</div>
</body>
</html>
