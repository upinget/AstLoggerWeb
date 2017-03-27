<?php
include('lock.php');
$groupID = $_SESSION['s_loginGroupid'];
if (isset($groupID)) {
	if ($groupID==0) {
		$form = "
		<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">
		<link rel=\"stylesheet\" href=\"libs/css/astlogger.css\">
		<form class=\"loggerModifyForm\" id=\"loggerModifyForm\" action=\"loggerModifyResult.php\" method=\"post\">		
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
		<td ></td>
		<td ></td>
		<td ><input name=\"formname\" type=\"hidden\" id=\"formname\" value=\"loggerModifyForm\" /></td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type=\"submit\" value=\"  Search  \"></td>
		</tr>
		</table>
		</form>
		";
		echo $form; 
	}
}
?>
<script type="text/javascript">
    $(function(){   
    	jQuery.validator.addMethod('ipv4', function(value) {
    	    var ipv4 = /^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/;    
    	    return value.match(ipv4);
    	}, 'Invalid IPv4 address');     
    			
        $('#loggerModifyForm').validate({
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
