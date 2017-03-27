<html>
<head>
<title>Logger Status Result</title>    
<?php 
include('config.php');
include('utility.php');
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
	include('loggerStatusListForm.php');
	?>    
	</div>  
	<div class="ui-layout-center">
	<?php
	if($_SERVER["REQUEST_METHOD"] == "GET") {
		$srvip = addslashes($_GET['srvip']);
		$port = addslashes($_GET['port']);
		$id = randomPassword();
		$response = "";
		$buffer = "";
		$xml_request ="<?xml version=\"1.0\" encoding=\"utf-8\"?><xmlrequest id=\"$id\" type=\"listextstatus\"></xmlrequest>";
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if (socket_connect($socket, $srvip, $port)) {
			socket_write($socket, $xml_request);	
			while (true) {
				$nByte = socket_recv($socket, $buffer, 4096, MSG_WAITALL);
				if ($nByte > 0) {
					$response .= $buffer; 						
				} else {
					break;						
				}
			}	
		} else {
			echo "Connect to logger $srvip:$port failed.";
			socket_close($socket);			
			// audit trial
			$auditTrial = "display logger $srvip:$port status failed.";
			insertAuditTrial($auditTrial);			
			return;
		}
		socket_close($socket);
		// display the result 
		// format the form
		echo "<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\">";
		echo "<link rel=\"stylesheet\" href=\"libs/css/astlogger.css\">";
		echo "<table width=\"100%\" border=\"1\">";
		echo "<tr>";
		echo "<th>Extension</th><th>Status</th><th>Agent</th><th>Calling</th><th>Called</th><th>UCID</th><th>Split</th><th>TG</th><th>TM</th>";
		echo "</tr>";
		$xmlresponse = new SimpleXMLElement($response);	
		// For each <extstatus> node, format the table 
		foreach ($xmlresponse->listextstatus->extstatus as $extstatus) {
			echo "<tr>";
			echo "<td>";
			echo $extstatus->extension;
			echo "</td>";
			echo "<td>";
			echo $extstatus->status;
			echo "</td>";
			echo "<td>";
			echo $extstatus->agent;
			echo "</td>";
			echo "<td>";
			echo $extstatus->calling;
			echo "</td>";
			echo "<td>";
			echo $extstatus->called;
			echo "</td>";
			echo "<td>";
			echo $extstatus->ucid;
			echo "</td>";
			echo "<td>";
			echo $extstatus->split;
			echo "</td>";
			echo "<td>";
			echo $extstatus->tgroup;
			echo "</td>";
			echo "<td>";
			echo $extstatus->tmember;
			echo "</td>";				
			echo "</tr>";
		}
		echo "</table>";
		echo "</form>";				
		// audit trial 
		$auditTrial = "display logger $srvip:$port status successfully.";
		insertAuditTrial($auditTrial);						
	}
	?>		
	</div>
</body>
</html>

