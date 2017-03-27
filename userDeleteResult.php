<html>
<head>
<title>User Delete Result</title>    
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
	include('userDeleteForm.php');
	?>    
	</div>  
	<div class="ui-layout-center">
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$formname=addslashes($_POST['formname']);
		if ($formname=="userDeleteForm") {
			$username=addslashes($_POST['username']);
			if (strlen($username)) {
				// format the sql statement using the username and password fields of the form
				$sql="SELECT id_fullname, id_email, id_agentid1, id_agentid2, id_agentid3, id_extension FROM t_astuser WHERE id_username='$username'";
				$result=mysql_query($sql);
				$row=mysql_fetch_array($result);
				if (mysql_num_rows($result)==1) {
					$fullname = $row['id_fullname'];
					$email = $row['id_email'];
					$agentid1 = $row['id_agentid1'];
					$agentid2 = $row['id_agentid2'];
					$agentid3 = $row['id_agentid3'];
					$extension = $row['id_extension'];
					// format the form
					echo "<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">";
					echo "<link rel=\"stylesheet\" href=\"libs/css/astlogger.css\">";
					echo "<form action=\"userDeleteResult.php\" method=\"post\">";
					echo "<table>";
					echo "<tr>";
					echo "<td ></td>";
					echo "<td ></td>";
					echo "<td ><input name=\"username\" type=\"hidden\" id=\"username\" value=\"";
					echo $username;
					echo "\"></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td >Username</td>";
					echo "<td >:</td>";
					echo "<td >";
					echo $username;
					echo "</td>";
					echo "</tr>";										
					echo "<tr>";
					echo "<td >Full Name</td>";
					echo "<td >:</td>";
					echo "<td >";
					echo $fullname; 
					echo "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td >Email</td>";
					echo "<td >:</td>";
					echo "<td >";
					echo $email; 
					echo "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td >AgentID #1</td>";
					echo "<td >:</td>";
					echo "<td >";
					echo $agentid1;
					echo "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td >AgentID #2</td>";
					echo "<td >:</td>";
					echo "<td >";
					echo $agentid2;
					echo "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td >AgentID #3</td>";
					echo "<td >:</td>";
					echo "<td >";
					echo $agentid3;
					echo "</td>";
					echo "</tr>";					
					echo "<tr>";
					echo "<td >Extension</td>";
					echo "<td >:</td>";
					echo "<td >";
					echo $extension;
					echo "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td ></td>";
					echo "<td ></td>";
					echo "<td ><input name=\"formname\" type=\"hidden\" id=\"formname\" value=\"userDeleteResult\" /></td>";
					echo "</tr>";					
					echo "<tr>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td><input type=\"submit\" value=\"  Delete  \"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";
				}
			}			
		} else {
			// username and password sent from Form
			$username=addslashes($_POST['username']);
			$sql = "DELETE FROM t_astuser WHERE id_username='$username'";
			$result=mysql_query($sql);
			if (mysql_affected_rows()==1) {
				$_SESSION['s_systemMessage'] = "Delete user $username successfully.";
				// audit trial
				$auditTrial = "delete user $username successfully.";
				insertAuditTrial($auditTrial);				
			} else {
				$_SESSION['s_systemMessage'] = "Delete user $username failed.";
				// audit trial
				$auditTrial = "delete user $username failed.";
				insertAuditTrial($auditTrial);				
			}
			header("location: welcome.php?action=userdelete");			
		}
	}
	?>		
	</div>
</body>
</html>