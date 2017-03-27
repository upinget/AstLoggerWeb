<html>
<head>
<title>Logger Modify Result</title>    
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
	include('loggerModifyForm.php');
	?>    
	</div>  
	<div class="ui-layout-center">
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$formname=addslashes($_POST['formname']);
		if ($formname=="loggerModifyForm") {
			$ip=addslashes($_POST['ip']);
			$port=addslashes($_POST['port']);
			if (strlen($ip) && strlen($port)) {
				// format the sql statement using the username and password fields of the form
				$sql="SELECT id_srvip, id_srvport, id_description FROM t_astsrvinfo WHERE id_srvip='$ip' and id_srvport=$port";
				$result=mysql_query($sql);
				$row=mysql_fetch_array($result);
				if (mysql_num_rows($result)==1) {
					$srvip = $row['id_srvip'];
					$srvport = $row['id_srvport'];
					$description = $row['id_description'];
					// format the form
					echo "<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">";
					echo "<link rel=\"stylesheet\" href=\"libs/css/astlogger.css\">";
					echo "<form action=\"loggerModifyResult.php\" method=\"post\">";
					echo "<table>";
					// hidden item ip 
					echo "<tr>";
					echo "<td ></td>";
					echo "<td ></td>";
					echo "<td ><input name=\"ip\" type=\"hidden\" id=\"ip\" value=\"";
					echo $srvip;
					echo "\"></td>";
					echo "</tr>";
					// hidden item port 
					echo "<tr>";
					echo "<td ></td>";
					echo "<td ></td>";
					echo "<td ><input name=\"port\" type=\"hidden\" id=\"port\" value=\"";
					echo $srvport;
					echo "\"></td>";
					echo "</tr>";					
					echo "<tr>";
					echo "<td >Logger IP</td>";
					echo "<td >:</td>";
					echo "<td >";
					echo $srvip;
					echo "</td>";
					echo "</tr>";										
					echo "<tr>";
					echo "<td >Logger Port</td>";
					echo "<td >:</td>";
					echo "<td >";
					echo $srvport; 
					echo "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td >Description</td>";
					echo "<td >:</td>";
					echo "<td><textarea name=\"description\" id=\"description\" rows=\"1\" cols=\"80\" >$description</textarea></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td ></td>";
					echo "<td ></td>";
					echo "<td ><input name=\"formname\" type=\"hidden\" id=\"formname\" value=\"loggerModifyResult\" /></td>";
					echo "</tr>";					
					echo "<tr>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td><input type=\"submit\" value=\"  Modify  \"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";
				}
			}			
		} else {
			// ip and port sent from Form
			$ip=addslashes($_POST['ip']);
			$port=addslashes($_POST['port']);
			$description=addslashes($_POST['description']);
			$sql = "UPDATE t_astsrvinfo SET id_description='$description' WHERE id_srvip='$ip' and id_srvport=$port";
			$result=mysql_query($sql);
			if (mysql_affected_rows()==1) {
				$_SESSION['s_systemMessage'] = "Modify logger IP:$ip Port:$port successfully.";
				// audit trial
				$auditTrial = "modify logger IP:$ip Port:$port successfully.";
				insertAuditTrial($auditTrial);				
			} else {
				$_SESSION['s_systemMessage'] = "Modify logger IP:$ip Port:$port failed.";
				// audit trial
				$auditTrial = "modify logger IP:$ip Port:$port failed.";
				insertAuditTrial($auditTrial);				
			}
			header("location: welcome.php?action=loggerModify");			
		}
	}
	?>		
	</div>
</body>
</html>
