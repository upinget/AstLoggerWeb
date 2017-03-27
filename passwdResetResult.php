<html>
<head>
<title>Password Reset Result</title>    
<?php 
include('config.php');
include_once('utility.php');
include_once('parameter.php');
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
	include('passwdResetForm.php');
	?>    
	</div>  
	<div class="ui-layout-center">
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$formname=addslashes($_POST['formname']);
		if ($formname=="passwdResetForm") {
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
					echo "<form action=\"passwdResetResult.php\" method=\"post\">";
					echo "<table>";
					// send username as hidden 
					echo "<tr>";
					echo "<td ></td>";
					echo "<td ></td>";
					echo "<td ><input name=\"username\" type=\"hidden\" id=\"username\" value=\"";
					echo $username;
					echo "\"></td>";
					echo "</tr>";
					// send email address as hidden
					echo "<tr>";
					echo "<td ></td>";
					echo "<td ></td>";
					echo "<td ><input name=\"email\" type=\"hidden\" id=\"email\" value=\"";
					echo $email;
					echo "\"></td>";
					echo "</tr>";
					// display username 						
					echo "<tr>";
					echo "<td >Username</td>";
					echo "<td >:</td>";
					echo "<td >";
					echo $username;
					echo "</td>";
					echo "</tr>";		
					// display fullname 													
					echo "<tr>";
					echo "<td >Full Name</td>";
					echo "<td >:</td>";
					echo "<td >";
					echo $fullname; 
					echo "</td>";
					echo "</tr>";
					// display email address 
					echo "<tr>";
					echo "<td >Email</td>";
					echo "<td >:</td>";
					echo "<td >";
					echo $email; 
					echo "</td>";
					echo "</tr>";
					// send formname as hidden
					echo "<tr>";
					echo "<td ></td>";
					echo "<td ></td>";
					echo "<td ><input name=\"formname\" type=\"hidden\" id=\"formname\" value=\"passwdResetResult\" /></td>";
					echo "</tr>";					
					echo "<tr>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td><input type=\"submit\" value=\"  Password Reset  \"></td>";
					echo "</tr>";
					echo "</table>";
					echo "</form>";
				}
			}			
		} else {
			// username and password sent from Form
			$username=addslashes($_POST['username']);
			$email=addslashes($_POST['email']);			
			$resetPasswd=randomPassword();
			$encryptResetPasswd=md5($resetPasswd);
			$sql = "UPDATE t_astuser SET id_password='$encryptResetPasswd' WHERE id_username='$username'";
			$result=mysql_query($sql);
			if (mysql_affected_rows()==1) {
				$emailSender = getParameter("al_emailsenderaddress");	
				if (strlen($emailSender)) {
					// subject
					$subject = "AstLogger WEB Password Reset";
					// message
					$message = "Your password is reset to $resetPasswd";
					// To send HTML mail, the Content-type header must be set
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
					// Additional headers
					$headers .= "From: $emailSender";
					// Mail it
					if (mail($email, $subject, $message, $headers)==true) {
						$_SESSION['s_systemMessage'] = "Reset password successfully and password sent to user $username.";
						// audit trial
						$auditTrial = "reset password for user $username successfully.";
						insertAuditTrial($auditTrial);						
					} else {
						$_SESSION['s_systemMessage'] = "Password email to user failed, please inform user $username the new password is $resetPasswd";
						// audit trial
						$auditTrial = "reset password for user $username successfully, but email failed.";
						insertAuditTrial($auditTrial);						
					}
				} else {
					$_SESSION['s_systemMessage'] = "System email address is not set, please contact system administrator.";					
				}
			} else {
				$_SESSION['s_systemMessage'] = "Reset password failed.";
				// audit trial
				$auditTrial = "reset password for user $username failed.";
				insertAuditTrial($auditTrial);				
			}
			header("location: welcome.php?action=resetpasswd");			
		}
	}
	?>		
	</div>
</body>
</html>