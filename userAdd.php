<?php
include('lock.php');
include_once('auditTrial.php');
include_once('parameter.php');
$groupID = $_SESSION['s_loginGroupid'];
$policyUsernameMinLength = getParameter("al_policyusernameminlength"); 
$policyUsernameMaxLength = getParameter("al_policyusernamemaxlength");
$policyPasswdMinLength = getParameter("al_policypasswdminlength");
$policyPasswdMaxLength = getParameter("al_policypasswdmaxlength");
$policyPasswdNumDigits = getParameter("al_policypasswdnumdigits");
$policyPasswdNumCaps = getParameter("al_policypasswdnumcaps"); 
if (isset($groupID)) {
	if ($groupID==0) {
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			// username and password sent from Form 
			$username=addslashes($_POST['username']); 
			$password=addslashes($_POST['password']);
			$verfication=addslashes($_POST['verfication']);	 
			$role=addslashes($_POST['role']);	 
			$fullname=addslashes($_POST['fullname']);	
			$email=addslashes($_POST['email']);
			// an agent may has maximum of 3 agent id 
			$agentid1=addslashes($_POST['agentid1']);
			$agentid2=addslashes($_POST['agentid2']);	
			$agentid3=addslashes($_POST['agentid3']);	
			$extension=addslashes($_POST['extension']);	
			if (strlen($username) && strlen($password)) {
				if ($password==$verfication) {
					$password = md5($password);
					$sql = "INSERT into t_astuser (id_username, id_password, id_groupid, 
						id_fullname, id_email, id_agentid1, id_agentid2, id_agentid3, id_extension) 
						VALUES ('$username', '$password', '$role', '$fullname', '$email', '$agentid1', '$agentid2', '$agentid3', '$extension')";
					$result=mysql_query($sql);
					if (mysql_affected_rows()==1) {						
						$_SESSION['s_systemMessage'] = "Add user $username successfully.";
						// audit trial
						$auditTrial = "add user $username successfully.";		
						insertAuditTrial($auditTrial);
					} else {
						$_SESSION['s_systemMessage'] = "Add user $username failed.";
						// audit trial
						$auditTrial = "add user $username failed.";		
						insertAuditTrial($auditTrial);
					}					
				} else {
					$_SESSION['s_systemMessage'] = "Password verfication not matched, add user failed.";			
				}
			} else {
				$_SESSION['s_systemMessage'] = "Mandatory fileds are not provided, add user failed.";			
			}
			header("location: welcome.php?action=useradd");	
		} else {
			$form = "
			<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">
			<link rel=\"stylesheet\" href=\"libs/css/astlogger.css\">
			<form class=\"userAddForm\" id=\"userAddForm\"  action=\"userAdd.php\" method=\"post\">
			<table>
			<tr>
			<td >Username(*)</td>
			<td >:</td>
			<td ><input name=\"username\" type=\"text\" id=\"username\"></td>
			</tr>
			<tr>
			<td >Full Name</td>
			<td >:</td>
			<td ><input name=\"fullname\" type=\"text\" id=\"fullname\"></td>
			</tr>
			<tr>
			<td >Password(*)</td>
			<td >:</td>
			<td ><input name=\"password\" type=\"password\" id=\"password\"></td>
			</tr>
			<tr>
			<td >Verify(*)</td>
			<td >:</td>
			<td ><input name=\"verfication\" type=\"password\" id=\"verfication\"></td>
			</tr>
			<tr>
			<td >Role</td>
			<td >:</td>
			<td>
			<select name=\"role\" id=\"role\">
			<option value=\"2\">User</option>
			<option value=\"1\">Supervisor</option>
			<option value=\"0\">Administrator</option>
			</select>
			</td>
			</tr>
			<tr>
			<td >Email</td>
			<td >:</td>
			<td ><input name=\"email\" type=\"text\" id=\"email\"></td>
			</tr>
			<tr>
			<td >AgentID #1</td>
			<td >:</td>
			<td ><input name=\"agentid1\" type=\"text\" id=\"agentid1\"></td>
			</tr>
			<tr>
			<td >AgentID #2</td>
			<td >:</td>
			<td ><input name=\"agentid2\" type=\"text\" id=\"agentid2\"></td>
			</tr>
			<tr>
			<td >AgentID #3</td>
			<td >:</td>
			<td ><input name=\"agentid3\" type=\"text\" id=\"agentid3\"></td>
			</tr>
			<tr>
			<td >Extension</td>
			<td >:</td>
			<td ><input name=\"extension\" type=\"text\" id=\"extension\"></td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input type=\"submit\" value=\"  Submit  \"></td>
			</tr>
			</table>
			</form>
			";
			echo $form; 
		}
	}
}
?>
<script type="text/javascript">
    $(function(){
    	jQuery.validator.addMethod(
			"ContainsAtLeastDigit",
			function (value) { 
				return /\d{<?php echo $policyPasswdNumDigits;?>}/.test(value); 
			},  
			"Your password must contain <?php echo $policyPasswdNumDigits;?> digit."
		);
		
    	jQuery.validator.addMethod(
			"ContainsAtLeastCapitalLetter",
			function (value) { 
				return /[A-Z]{<?php echo $policyPasswdNumCaps;?>}/.test(value); 
			},  
			"Your password must contain at <?php echo $policyPasswdNumCaps;?> capital letter."
		);		
        
        $('#userAddForm').validate({
			rules: {
				username: {
					required: true, 
					rangelength: [<?php echo "$policyUsernameMinLength, $policyUsernameMaxLength";?>],
				}, 
				fullname: {
					required: true,
				}, 
				email: {
					required: true, 
					email: true, 
				},
				password: {
					required: true, 
					rangelength: [<?php echo "$policyPasswdMinLength, $policyPasswdMaxLength";?>],
					ContainsAtLeastDigit: true,
					ContainsAtLeastCapitalLetter: true, 
				},
				verfication: {
					required: true, 
					rangelength: [<?php echo "$policyPasswdMinLength, $policyPasswdMaxLength";?>],
					ContainsAtLeastDigit: true,
					ContainsAtLeastCapitalLetter: true,		
					equalTo: "#password",			
				},
            },
            messages: {
            	password: "Password at least <?php echo $policyPasswdMinLength;?> characters, <?php echo $policyPasswdNumDigits;?> digit and <?php echo $policyPasswdNumCaps;?> capital letter.",
            	verfication: "Password at least <?php echo $policyPasswdMinLength;?> characters, <?php echo $policyPasswdNumDigits;?> digit and <?php echo $policyPasswdNumCaps;?> capital letter.",
            }            
        });    
    });
</script>
