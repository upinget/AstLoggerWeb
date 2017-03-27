<html>
<head>
<title>Audit Trial Result</title>    
<?php 
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
		include('auditTrialForm.php');
	?>    
	</div>  
	<div class="ui-layout-center">
	<?php
		include_once('utility.php');
		include('navbar.php');
		if($_SERVER["REQUEST_METHOD"] == "GET") {
			$startTime = $_SESSION['s_startTime'];
			$endTime = $_SESSION['s_endTime'];			
			$queryContains = $_SESSION['s_queryContains'];
			$nav_page = addslashes($_GET['page']);
		} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
			// clean up the session variable s_startTime and s_endTime
			if(isset($_SESSION['s_startTime'])) {
				unset($_SESSION['s_startTime']);
			}				
			if(isset($_SESSION['s_endTime'])) {
				unset($_SESSION['s_endTime']);
			}				
			// clean up the session variable s_queryContains
			if(isset($_SESSION['s_queryContains'])) {
				unset($_SESSION['s_queryContains']);	
			}		
			// start time and end time 
			$startTime = strtotime(addslashes($_POST['startdatetime']));
			if ($startTime > 0) {
				// remember the query start time in session
				$_SESSION['s_startTime'] = $startTime;				
			}
			$endTime = strtotime(addslashes($_POST['enddatetime']));
			if ($endTime > 0) {
				// remember the query start time in session
				$_SESSION['s_endTime'] = $endTime;
			}				
			// contans from the form 
			$queryContains=addslashes($_POST['contains']);	
			if (strlen($queryContains)) {
				// remember the contains in session 
				$_SESSION['s_queryContains'] = $queryContains; 
			}		
		} // $_SERVER
		// format the SQL statement 
		if (($startTime > 0) && ($endTime > 0)) {
			if (strlen($queryContains)) {	
				$sql = "SELECT id_starttime, id_message FROM t_astaudittrial WHERE 
					(id_starttime>=$startTime AND id_starttime <= $endTime) AND id_message LIKE '%$queryContains%'";		
			} else {
				$sql = "SELECT id_starttime, id_message FROM t_astaudittrial WHERE 
					(id_starttime>=$startTime AND id_starttime <= $endTime)";								
			}
			$nav = new navbar;
			$nav->nav_numrowsperpage = $_SESSION['s_callrecordperpage'];			
			$result = $nav->execute($sql, $db, "mysql");
			if (mysql_num_rows($result) > 0) {
				echo "<table width=\"100%\" border=\"1\">"; 
				echo "<tr><th>Date Time</th><th>Message</th></tr>"; 
				while($row = mysql_fetch_array($result)){ 
					echo "<tr>";
					echo "<td width=\"20%\">";
					echo unix_timestamp_to_human($row['id_starttime']);
					echo "</td>";
					echo "<td>";
					echo $row['id_message'];
					echo "</td>";										
				} 
				// display the netvigation 
				echo "<tr>";			
				$links = $nav->getlinks("sides", "on");
				echo "<td>";
				echo $links[0]; // Previous 
				echo "</td>";
				echo "<td align=\"right\">";				
				echo $links[1]; // Next
				echo "</td>";	
				echo "</tr>";	
				echo "</table>";
			} // mysql_num_rows > 0 
		} // if extension or agentid provided in the form 
	?>		
	</div>
</body>
</html>

