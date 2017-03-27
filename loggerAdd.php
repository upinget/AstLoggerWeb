<?php
include('lock.php');
include_once('auditTrial.php');
$groupID = $_SESSION['s_loginGroupid'];
if (isset($groupID)) {
	if ($groupID==0) {
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			// ip, port, description sent by the form
			$ip=addslashes($_POST['ip']); 
			$port=addslashes($_POST['port']);
			$description=addslashes($_POST['description']);	 
			if (strlen($ip) && strlen($port)) {
				$sql = "INSERT into t_astsrvinfo (id_srvip, id_srvport, id_description) VALUES ('$ip', $port, '$description')";
				$result=mysql_query($sql);
				if (mysql_affected_rows()==1) {						
					$_SESSION['s_systemMessage'] = "Add logger IP:$ip Port:$port successfully.";
					// audit trial
					$auditTrial = "add logger IP:$ip Port:$port successfully.";		
					insertAuditTrial($auditTrial);
				} else {
					$_SESSION['s_systemMessage'] = "Add logger IP:$ip Port:$port failed.";
					// audit trial
					$auditTrial = "add logger IP:$ip Port:$port failed.";		
					insertAuditTrial($auditTrial);
				}					
			} else {
				$_SESSION['s_systemMessage'] = "Mandatory fileds are not provided, add logger failed.";			
			}
			header("location: welcome.php?action=loggerAdd");	
		} else {
			$form = "
			<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">
			<link rel=\"stylesheet\" href=\"libs/css/astlogger.css\">
			<form class=\"loggerAddForm\" id=\"loggerAddForm\"  action=\"loggerAdd.php\" method=\"post\">
			<table>
			<tr>
			<td >Logger IP(*)</td>
			<td >:</td>
			<td ><input name=\"ip\" type=\"text\" id=\"ip\"></td>
			</tr>
			<tr>
			<td >Logger Port(*)</td>
			<td >:</td>
			<td ><input name=\"port\" type=\"text\" id=\"port\"></td>
			</tr>
			<tr>
			<td >Description</td>
			<td >:</td>
			<td ><input name=\"description\" type=\"text\" id=\"description\"></td>
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
    	jQuery.validator.addMethod('ipv4', function(value) {
    	    var ipv4 = /^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/;    
    	    return value.match(ipv4);
    	}, 'Invalid IPv4 address');     
    			
        $('#loggerAddForm').validate({
			rules: {
				ip: {
					required: true, 
					ipv4: true,
				}, 
				port: {
					required: true,
					number: true,
				}, 
            }           
        });    
    });
</script>

