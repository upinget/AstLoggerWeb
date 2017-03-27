<html>
<head>
<title>User List Result</title>    
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
	include('userListForm.php');
	?>    
	</div>  
	<div class="ui-layout-center">
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$formname=addslashes($_POST['formname']);
		if ($formname=="userListForm") {
			$username=addslashes($_POST['username']);
			if (strlen($username)) {
				// format the sql statement using the username and password fields of the form
				$sql="SELECT id_username, id_groupid, id_fullname, id_email, id_agentid1, id_agentid2, id_agentid3, id_extension 
					FROM t_astuser WHERE id_username LIKE '%$username%'";
			} else {
				// format the sql statement using the username and password fields of the form
				$sql="SELECT id_username, id_groupid, id_fullname, id_email, id_agentid1, id_agentid2, id_agentid3, id_extension FROM t_astuser";
			}
			$result=mysql_query($sql);
			if (mysql_num_rows($result) > 0) {
				// format the form
				echo "<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">";
				echo "<link rel=\"stylesheet\" href=\"libs/css/astlogger.css\">";
				echo "<table width=\"100%\" border=\"1\">";
				echo "<tr>";
				echo "<th>Username</th><th>Group</th><th>Fullname</th><th>Email</th><th>AgentID #1</th><th>AgentID #2</th><th>AgentID #3</th><th>Extension</th>";
				echo "</tr>"; 
				while($row = mysql_fetch_array($result)){
					$username = $row['id_username'];
					$groupid = $row['id_groupid'];
					$fullname = $row['id_fullname'];
					$email = $row['id_email'];
					$agentid1 = $row['id_agentid1'];
					$agentid2 = $row['id_agentid2'];
					$agentid3 = $row['id_agentid3'];
					$extension = $row['id_extension'];
					echo "<tr>";
					echo "<td>";
					echo $username;
					echo "</td>";
					echo "<td>";
					if ($groupid==0) {
						echo "Administrator"; 
					} else if ($groupid==1) {
						echo "Supervisor";
					} else if ($groupid==2) {
						echo "User";
					}
					echo "</td>";
					echo "<td>";
					echo $fullname;
					echo "</td>";
					echo "<td>";
					echo $email;
					echo "</td>";
					echo "<td>";
					echo $agentid1;
					echo "</td>";
					echo "<td>";
					echo $agentid2;
					echo "</td>";
					echo "<td>";
					echo $agentid3;
					echo "</td>";
					echo "<td>";
					echo $extension;
					echo "</td>";						
					echo "</tr>";
				}		
				echo "</table>";
				echo "</form>";
				// audit trial 
				$username=addslashes($_POST['username']);
				if (strlen($username)) {
					$auditTrial = "list user like $username successfully.";
					insertAuditTrial($auditTrial);						
				} else {
					$auditTrial = "list all users successfully.";
					insertAuditTrial($auditTrial);					
				}
			}		
		} 
	}
	?>		
	</div>
</body>
</html>