<!DOCTYPE html>
<html>
<script type="text/javascript" src="libs/jdMenu/jquery.dimensions.js"></script>
<script type="text/javascript" src="libs/jdMenu/jquery.positionBy.js"></script>
<script type="text/javascript" src="libs/jdMenu/jquery.bgiframe.js"></script>
<script type="text/javascript" src="libs/jdMenu/jquery.jdMenu.js"></script>
<link rel="stylesheet" href="libs/jdMenu/jquery.jdMenu.css">
<link rel="stylesheet" href="libs/css/astlogger.css">
<div id="logo">
AstLogger Web 1.4.12
</div>
<div>
<ul class="jd_menu">
	<li><a href="logout.php">Logout</a></li>
	<li><a href="welcome.php?callsearch">Call Search</a></li>	
	<?php
		include('lock.php');
		$groupID = $_SESSION['s_loginGroupid'];
		if (isset($groupID)) {
			if ($groupID==0) {
				// Admin Menu 
				echo "<li><a href=\"#\" class=\"accessible\">Admin</a>";
				echo "<ul>";
					echo "<li><a href=\"#\" class=\"accessible\">User</a>";
					echo "<ul>";			
						echo "<li><a href=\"welcome.php?action=userlist\">List User</a></li>";				
						echo "<li><a href=\"welcome.php?action=useradd\">Add User</a></li>";
						echo "<li><a href=\"welcome.php?action=usermodify\">Modify User</a></li>";			
						echo "<li><a href=\"welcome.php?action=userdelete\">Delete User</a></li>";
						echo "<li><a href=\"welcome.php?action=resetpasswd\">Reset Password</a></li>";
					echo "</ul>";
					echo "</li>";

					echo "<li><a href=\"#\" class=\"accessible\">Dictionary</a>";
					echo "<ul>";
					echo "<li><a href=\"welcome.php?action=dictionarylist\">List Dictionary</a></li>";
					echo "<li><a href=\"welcome.php?action=dictionaryadd\">Add Dictionary</a></li>";
					echo "<li><a href=\"welcome.php?action=dictionarymodify\">Modify Dictionary</a></li>";
					echo "<li><a href=\"welcome.php?action=dictionarydelete\">Delete Dictionary</a></li>";
					echo "</ul>";
					echo "</li>";					
					
					echo "<li><a href=\"#\" class=\"accessible\">System Parameter</a>";
					echo "<ul>";
						echo "<li><a href=\"welcome.php?action=paramList\">List System Parameter</a></li>";
						echo "<li><a href=\"welcome.php?action=paramModify\">Modify System Parameter</a></li>";
						echo "<li><a href=\"welcome.php?action=paramUpgrade\">Upgrade System Tables</a></li>";
					echo "</ul>";
					echo "</li>";	
					
					echo "<li><a href=\"#\" class=\"accessible\">Logger Information</a>";
					echo "<ul>";
						echo "<li><a href=\"welcome.php?action=loggerList\">List Logger</a></li>";
						echo "<li><a href=\"welcome.php?action=loggerAdd\">Add Logger</a></li>";					
						echo "<li><a href=\"welcome.php?action=loggerModify\">Modify Logger</a></li>";
						echo "<li><a href=\"welcome.php?action=loggerDelete\">Delete Logger</a></li>";					
					echo "</ul>";
					echo "</li>";
				echo "</ul>";
				echo "</li>";
				// Logger Status 
				echo "<li><a href=\"welcome.php?action=loggerStatus\">Logger Status</a></li>";
				// Log Menu 				
				echo "<li><a href=\"#\" class=\"accessible\">Logs</a>";
				echo "<ul>";
				echo "<li><a href=\"welcome.php?action=auditTrial\">Audit Trial</a></li>";
				echo "</ul>";
				echo "</li>";											
			}
		}
	?>
	<li><a href="#" class="accessible">Options</a>
		<ul>
			<li><a href="welcome.php?action=chgpasswd">Change Password</a></li>
			<li><a href="welcome.php?action=chgrecpage">Change Records Per Page</a></li>			
		</ul>
	</li>
</ul>
</div>
</html>