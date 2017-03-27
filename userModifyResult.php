<html>
<head>
<title>User Modify Result</title>    
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
	include('userModifyForm.php');
	?>    
	</div>  
	<div class="ui-layout-center">
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$formname=addslashes($_POST['formname']);
		if ($formname=="userModifyForm") {
			$username=addslashes($_POST['username']);
			if (strlen($username)) {
				// format the sql statement using the username and password fields of the form
				$sql="SELECT id_groupid, id_fullname, id_email, id_agentid1, id_agentid2, id_agentid3, id_extension, id_playbackextension, id_searchextension, id_searchsplit, id_searchdnis, id_searchagentid FROM t_astuser WHERE id_username='$username'";
				$result=mysql_query($sql);
				$row=mysql_fetch_array($result);
				if (mysql_num_rows($result)==1) {
					$groupid = $row['id_groupid'];
					$fullname = $row['id_fullname'];
					$email = $row['id_email'];
					$agentid1 = $row['id_agentid1'];
					$agentid2 = $row['id_agentid2'];
					$agentid3 = $row['id_agentid3'];
					$extension = $row['id_extension'];
					$playbackextension = $row['id_playbackextension'];
					$searchextension = $row['id_searchextension'];
					$searchsplit = $row['id_searchsplit'];
					$searchdnis = $row['id_searchdnis'];
					$searchagentid = $row['id_searchagentid'];
					// format the form
					echo "<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">";
					echo "<link rel=\"stylesheet\" href=\"libs/css/astlogger.css\">";
					echo "<form action=\"userModifyResult.php\" method=\"post\">";
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
					echo "<td >$username</td>";
					echo "</tr>";						
					echo "<tr>";
					echo "<td >Full Name</td>";
					echo "<td >:</td>";
					echo "<td><textarea name=\"fullname\" id=\"fullname\" rows=\"1\" cols=\"80\" >$fullname</textarea></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td >Role</td>";
					echo "<td >:</td>";
					echo "<td>";
					echo "<select name=\"role\" id=\"role\">";		
					if ($groupid==0) { // admin group 
						echo "<option value=\"0\">Administrator</option>";
						echo "<option value=\"1\">Supervisor</option>";
						echo "<option value=\"2\">User</option>";						
					} else if ($groupid==1) { // supervisor user can never become administrator
						echo "<option value=\"1\">Supervisor</option>";					
						echo "<option value=\"2\">User</option>";						
					} else { // normal user can never become administrator
						echo "<option value=\"2\">User</option>";
						echo "<option value=\"1\">Supervisor</option>";															
					}			
					echo "</select>";
					echo "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td >Email</td>";
					echo "<td >:</td>";
					echo "<td><textarea name=\"email\" id=\"email\" rows=\"1\" cols=\"80\" >$email</textarea></td>";					
					echo "</tr>";
					echo "<tr>";
					echo "<td >AgentID #1</td>";
					echo "<td >:</td>";
					echo "<td><textarea name=\"agentid1\" id=\"agentid1\" rows=\"1\" cols=\"80\" >$agentid1</textarea></td>";					
					echo "</tr>";
					echo "<tr>";
					echo "<td >AgentID #2</td>";
					echo "<td >:</td>";
					echo "<td><textarea name=\"agentid2\" id=\"agentid2\" rows=\"1\" cols=\"80\" >$agentid2</textarea></td>";					
					echo "</tr>";
					echo "<tr>";
					echo "<td >AgentID #3</td>";
					echo "<td >:</td>";
					echo "<td><textarea name=\"agentid3\" id=\"agentid3\" rows=\"1\" cols=\"80\" >$agentid3</textarea></td>";					
					echo "</tr>";					
					echo "<tr>";
					echo "<td >Extension</td>";
					echo "<td >:</td>";
					echo "<td><textarea name=\"extension\" id=\"extension\" rows=\"1\" cols=\"80\" >$extension</textarea></td>";					
					echo "</tr>";		
					echo "<td >Playback Extension</td>";
					echo "<td >:</td>";
					echo "<td><textarea name=\"playbackextension\" id=\"playbackextension\" rows=\"1\" cols=\"80\" >$playbackextension</textarea></td>";
					echo "</tr>";										
					echo "<tr>";
					echo "<td >Search Extension</td>";
					echo "<td >:</td>";
					echo "<td><textarea name=\"searchextension\" id=\"searchextension\" rows=\"3\" cols=\"80\" >$searchextension</textarea></td>";
					echo "</tr>";		
					echo "<tr>";
					echo "<td >Search SPLIT</td>";
					echo "<td >:</td>";
					echo "<td><textarea name=\"searchsplit\" id=\"searchsplit\" rows=\"3\" cols=\"80\" >$searchsplit</textarea></td>";
					echo "</tr>";								
					echo "<tr>";
					echo "<td >Search DNIS</td>";
					echo "<td >:</td>";
					echo "<td><textarea name=\"searchdnis\" id=\"searchdnis\" rows=\"3\" cols=\"80\" >$searchdnis</textarea></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td >Search AgentID</td>";
					echo "<td >:</td>";
					echo "<td><textarea name=\"searchagentid\" id=\"searchagentid\" rows=\"3\" cols=\"80\" >$searchagentid</textarea></td>";
					echo "</tr>";															
					echo "<tr>";
					echo "<td ></td>";
					echo "<td ></td>";
					echo "<td ><input name=\"formname\" type=\"hidden\" id=\"formname\" value=\"userModifyResult\" /></td>";
					echo "</tr>";					
					echo "<tr>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td><input type=\"submit\" value=\"  Update  \"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";
				}
			}			
		} else {
			// username and password sent from Form
			$username=addslashes($_POST['username']);
			$role=addslashes($_POST['role']);
			$fullname=addslashes($_POST['fullname']);
			$email=addslashes($_POST['email']);
			// an agent may has maximum of 3 agent id
			$agentid1=addslashes($_POST['agentid1']);
			$agentid2=addslashes($_POST['agentid2']);
			$agentid3=addslashes($_POST['agentid3']);
			$extension=addslashes($_POST['extension']);
			$playbackextension=addslashes($_POST['playbackextension']);
			// an agent may be limited by search objects 
			$searchextension = addslashes($_POST['searchextension']);
			$searchsplit = addslashes($_POST['searchsplit']);
			$searchdnis = addslashes($_POST['searchdnis']);
			$searchagentid = addslashes($_POST['searchagentid']);
			$sql = "UPDATE t_astuser SET id_groupid='$role', id_fullname='$fullname', id_email='$email', id_agentid1='$agentid1',
				id_agentid2='$agentid2', id_agentid3='$agentid3', id_extension='$extension', id_playbackextension='$playbackextension',
				id_searchextension='$searchextension', id_searchsplit='$searchsplit', 
				id_searchdnis='$searchdnis', id_searchagentid='$searchagentid'  WHERE id_username='$username'";
			$result=mysql_query($sql);
			$nRows = mysql_affected_rows();
			if ($nRows==1) {
				$_SESSION['s_systemMessage'] = "Modify user $username successfully.";
				// audit trial 
				$auditTrial = "modify user $username successfully.";
				insertAuditTrial($auditTrial);
			} else {
				$_SESSION['s_systemMessage'] = "Modify user $username failed.";
				// audit trial				
				$auditTrial = "modify user $username failed.";
				insertAuditTrial($auditTrial);				
			}
			header("location: welcome.php?action=usermodify");			
		}
	}
	?>		
	</div>
</body>
</html>