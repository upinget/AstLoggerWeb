<html>
<head>
<title>Call Search Result</title>    
<?php 
include('layoutjscss.php');
?>      
<link rel="stylesheet" type="text/css" href="libs/css/mp3-player-button.css" />
<script type="text/javascript" src="libs/soundmanager/script/soundmanager2.js"></script>
<script type="text/javascript" src="libs/soundmanager/script/mp3-player-button.js"></script>
<script>
$(document).ready(function() {
    $('.phoneplayback').click(function(event) { // trigger on form submit
        event.preventDefault(); // prevent the default submit
        var values = $(this).serialize();
        $.ajax({ // process the form using $.ajax()
            type      : 'POST', // POST request
            url       : 'phonePlayback.php', // php page 
            data      : values // form values
        });
        return false;
    });
});    
  
soundManager.setup({
  // required: path to directory containing SM2 SWF files
  url: 'libs/soundmanager/swf/'
});
</script>
</head>
<body>
	<div class="ui-layout-north"> 
	<?php
	include('header.php'); 
	?>
	</div>     
    <div class="ui-layout-west">
	<?php
		include('callSearchForm.php');
	?>    
	</div>  
	<div class="ui-layout-center">
	<?php
		include_once('utility.php');
		include_once('callData.php');
		include_once('appData.php');
		include_once('auditTrial.php');
		include_once('parameter.php');
		include_once('dictionary.php');
		include('navbar.php');
		if($_SERVER["REQUEST_METHOD"] == "GET") {
			$startTime = $_SESSION['s_startTime'];
			$endTime = $_SESSION['s_endTime'];			
			$queryExtension = $_SESSION['s_queryExtension'];
			$queryAgentID = $_SESSION['s_queryAgentID'];
			$queryCLID = $_SESSION['s_queryCLID'];
			$queryDNIS = $_SESSION['s_queryDNIS'];
			$queryKEY = $_SESSION['s_queryKEY'];
			$queryUCID = $_SESSION['s_queryUCID'];						
			$nav_page = addslashes($_GET['page']);
			$getKey = addslashes($_GET['key']);			
			$getUcid = addslashes($_GET['ucid']);
			$getSplit = $_SESSION['s_querySplit'];			
			$getTG = $_SESSION['s_queryTG'];		
		} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
			// clean up the session variable s_startTime and s_endTime
			if(isset($_SESSION['s_startTime'])) {
				unset($_SESSION['s_startTime']);
			}				
			if(isset($_SESSION['s_endTime'])) {
				unset($_SESSION['s_endTime']);
			}				
			// clean up the session variable s_queryExtension
			if(isset($_SESSION['s_queryExtension'])) {
				unset($_SESSION['s_queryExtension']);	
			}		
			// clean up the session variable s_queryAgentID
			if(isset($_SESSION['s_queryAgentID'])) {
				unset($_SESSION['s_queryAgentID']);
			}
			// clean up the session variable s_queryCLID
			if(isset($_SESSION['s_queryCLID'])) {
				unset($_SESSION['s_queryCLID']);
			}			
			// clean up the session variable s_queryDNIS
			if(isset($_SESSION['s_queryDNIS'])) {
				unset($_SESSION['s_queryDNIS']);
			}				
			// clean up the session variable s_querySplit
			if(isset($_SESSION['s_querySplit'])) {
				unset($_SESSION['s_querySplit']);
			}
			// clean up the session variable s_queryTG
			if(isset($_SESSION['s_queryTG'])) {
				unset($_SESSION['s_queryTG']);
			}
			// clean up the session variable s_queryKEY
			if(isset($_SESSION['s_queryKEY'])) {
				unset($_SESSION['s_queryKEY']);
			}
			// clean up the session variable s_queryTG
			if(isset($_SESSION['s_queryUCID'])) {
				unset($_SESSION['s_queryUCID']);
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
			// extension from the form 
			$queryExtension=addslashes($_POST['extension']);	
			if (strlen($queryExtension)) {
				// remember the query extension in session 
				$_SESSION['s_queryExtension'] = $queryExtension; 
			}		
			// agentID from the form
			$queryAgentID=addslashes($_POST['agentid']);
			if (strlen($queryAgentID)) {
				// remember the query agentID in session
				$_SESSION['s_queryAgentID'] = $queryAgentID;
			}		
			// CLID from the form
			$queryCLID=addslashes($_POST['clid']);
			if (strlen($queryCLID)) {
				// remember the query CLID in session
				$_SESSION['s_queryCLID'] = $queryCLID;
			}
			// DNIS from the form
			$queryDNIS=addslashes($_POST['dnis']);
			if (strlen($queryDNIS)) {
				// remember the query CLID in session
				$_SESSION['s_queryDNIS'] = $queryDNIS;
			}
			// Split from the form
			$querySplit=addslashes($_POST['split']);
			if (strlen($querySplit)) {
				// remember the query Split in session
				$_SESSION['s_querySplit'] = $querySplit;
			}
			// TG from the form
			$queryTG=addslashes($_POST['tg']);
			if (strlen($queryTG)) {
				// remember the query TG in session
				$_SESSION['s_queryTG'] = $queryTG;
			}				
			// KEY from the form
			$queryKEY=addslashes($_POST['key']);
			if (strlen($queryKEY)) {
				// remember the query KEY in session
				$_SESSION['s_queryKEY'] = $queryKEY;
			}
			// UCID from the form
			$queryUCID=addslashes($_POST['ucid']);
			if (strlen($queryUCID)) {
				// remember the query KEY in session
				$_SESSION['s_queryUCID'] = $queryUCID;
			}
				
		} // $_SERVER
		// remember the destination page 
		$pageWithParameters = curPageNameWithParameters();
		$_SESSION['s_loginDestination'] = $pageWithParameters;		
		// consider the special case first  
		if (isset($getKey) && strlen($getKey)) {		
			$sql="SELECT id_uniquekey, id_device, id_ucid, id_starttime, id_endtime, id_calldirection, id_recpath, id_recformat, id_archivepath, 
			id_origcallingnumber, id_origcallednumber, id_callingnumber, id_callednumber, id_agentid, id_split, id_trunkgroup, id_trunkmember
			FROM t_astcalldata WHERE id_uniquekey='$getKey'";					
		} else if (isset($getUcid) && strlen($getUcid)) {
			$sql="SELECT id_uniquekey, id_device, id_ucid, id_starttime, id_endtime, id_calldirection, id_recpath, id_recformat, id_archivepath, 
			id_origcallingnumber, id_origcallednumber, id_callingnumber, id_callednumber, id_agentid, id_split, id_trunkgroup, id_trunkmember
			FROM t_astcalldata WHERE id_ucid='$getUcid'";				
		} else if ($_SESSION['s_loginGroupid'] <= 1) { // 0 is admin, 1 is supervisor 
			if (($startTime > 0) && ($endTime > 0)) {
				$sql="SELECT id_uniquekey, id_device, id_ucid, id_starttime, id_endtime, id_calldirection, id_recpath, id_recformat, id_archivepath, 
				id_origcallingnumber, id_origcallednumber, id_callingnumber, id_callednumber, id_agentid, id_split, id_trunkgroup, id_trunkmember FROM t_astcalldata
				WHERE id_starttime>=$startTime AND id_endtime <=$endTime ";
				// consider the queryExtension
				if (strlen($queryExtension)) {
					$sql .= " AND ";
					$sql .= "id_device='$queryExtension'";
				}
				// consider the queryAgentID
				if (strlen($queryAgentID)) {
					$sql .= " AND ";
					$sql .= "id_agentid='$queryAgentID'";
				}
				// consider the CLID
				if (strlen($queryCLID)) {
					$sql .= " AND ";
					$sql .= "(id_origcallingnumber LIKE '%$queryCLID%' OR id_callingnumber LIKE '%$queryCLID%')";
				}
				// consider the DNIS
				if (strlen($queryDNIS)) {
					$sql .= " AND ";
					$sql .= "(id_origcallednumber LIKE '%$queryDNIS%' OR id_callednumber LIKE '%$queryDNIS%')";
				}
				// consider the Split
				if (strlen($querySplit)) {
					$sql .= " AND ";
					$sql .= "id_split='$querySplit'";
				}
				// consider the TG
				if (strlen($queryTG)) {
					$sql .= " AND ";
					$sql .= "id_trunkgroup='$queryTG'";
				}
				// consider the KEY
				if (strlen($queryKEY)) {
					$sql .= " AND ";
					$sql .= "id_uniquekey LIKE '%$queryKEY%'";
				}					
				// consider the UCID
				if (strlen($queryUCID)) {
					$sql .= " AND ";
					$sql .= "id_ucid LIKE '%$queryUCID%'";
				}
				if ($_SESSION['s_loginGroupid'] == 1) { // supervisor specific 
					if (strlen($_SESSION['s_loginSearchExtension']) || strlen($_SESSION['s_loginSearchSPLIT']) ||
						strlen($_SESSION['s_loginSearchDNIS']) || strlen($_SESSION['s_loginSearchAgentID'])) {
						$sql .= " AND (";
						$condOR = false;
						if (strlen($_SESSION['s_loginSearchExtension'])) {
							$sql .= $_SESSION['s_loginSearchExtension'];
							$condOR = true;
						}
						if (strlen($_SESSION['s_loginSearchSPLIT'])) {
							if ($condOR) {
								$sql .= " OR ";
							}
							$sql .= $_SESSION['s_loginSearchSPLIT'];
							$condOR = true;
						}
						if (strlen($_SESSION['s_loginSearchDNIS'])) {
							if ($condOR) {
								$sql .= " OR ";
							}
							$sql .= $_SESSION['s_loginSearchDNIS'];
							$condOR = true;
						}
						if (strlen($_SESSION['s_loginSearchAgentID'])) {
							if ($condOR) {
								$sql .= " OR ";
							}
							$sql .= $_SESSION['s_loginSearchAgentID'];
							$condOR = true;
						}
						$sql .= ")";						
					}								
				} // supervisor specific 
			} // if (($startTime > 0) && ($endTime > 0))		 
		} else if ($_SESSION['s_loginGroupid'] == 2) { // 2 is normal user 
			if (($startTime > 0) && ($endTime > 0)) {
				if (strlen($_SESSION['s_loginAgentID1']) || strlen($_SESSION['s_loginAgentID2']) || 
					strlen($_SESSION['s_loginAgentID3']) || strlen($_SESSION['s_loginExtension']) || 
					strlen($_SESSION['s_loginSearchExtension']) || strlen($_SESSION['s_loginSearchSPLIT']) || 
					strlen($_SESSION['s_loginSearchDNIS']) || strlen($_SESSION['s_loginSearchAgentID'])) {
					$sql="SELECT id_uniquekey, id_device, id_ucid, id_starttime, id_endtime, id_calldirection, id_recpath, id_recformat, id_archivepath, 
					id_origcallingnumber, id_origcallednumber, id_callingnumber, id_callednumber, id_agentid, id_split, id_trunkgroup, id_trunkmember FROM t_astcalldata
					WHERE (id_starttime>=$startTime AND id_endtime <=$endTime) AND (";
					$condOR = false;					
					if (strlen($_SESSION['s_loginAgentID1'])) {
						$tmp = $_SESSION['s_loginAgentID1'];
						$sql .= "id_agentid='$tmp'";
						$condOR = true;
					}
					if (strlen($_SESSION['s_loginAgentID2'])) {
						if ($condOR) {
							$sql .= " OR ";
						}
						$tmp = $_SESSION['s_loginAgentID2'];
						$sql .= "id_agentid='$tmp'";
						$condOR = true;
					}
					if (strlen($_SESSION['s_loginAgentID3'])) {
						if ($condOR) {
							$sql .= " OR ";
						}
						$tmp = $_SESSION['s_loginAgentID3'];
						$sql .= "id_agentid='$tmp'";
						$condOR = true;
					}
					if (strlen($_SESSION['s_loginExtension'])) {
						if ($condOR) {
							$sql .= " OR ";
						}
						$tmp = $_SESSION['s_loginExtension'];
						$sql .= "id_device='$tmp'";
						$condOR = true;
					}
					if (strlen($_SESSION['s_loginSearchExtension'])) {
						if ($condOR) {
							$sql .= " OR ";
						}
						$sql .= $_SESSION['s_loginSearchExtension'];
						$condOR = true;
					}
					if (strlen($_SESSION['s_loginSearchSPLIT'])) {
						if ($condOR) {
							$sql .= " OR ";
						}
						$sql .= $_SESSION['s_loginSearchSPLIT'];
						$condOR = true;							
					}
					if (strlen($_SESSION['s_loginSearchDNIS'])) {
						if ($condOR) {
							$sql .= " OR ";
						}
						$sql .= $_SESSION['s_loginSearchDNIS'];
						$condOR = true;							
					}
					if (strlen($_SESSION['s_loginSearchAgentID'])) {
						if ($condOR) {
							$sql .= " OR ";
						}
						$sql .= $_SESSION['s_loginSearchAgentID'];	
						$condOR = true;
					}
					$sql .= ")";
				} else {
					$_SESSION['s_systemMessage'] = "User without agentID or extension, please contact system administrator.";
					header("location: welcome.php");
				} // strlen
			} // if (($startTime > 0) && ($endTime > 0))				
		} else {  
			$_SESSION['s_systemMessage'] = "Unknown groupID.";
			header("location: welcome.php");
		}
		$nav = new navbar;
		$nav->nav_numrowsperpage = $_SESSION['s_callrecordperpage']; 
		$result = $nav->execute($sql, $db, "mysql");
		$callRecordDownload = getParameter("al_callrecorddownload");
		if (mysql_num_rows($result) > 0) {
			// remember the sql in session 
			$_SESSION['s_callQuerySQL'] = $sql; 
			echo "<table width=\"100%\" border=\"1\">"; 
			echo "<tr><th>Key</th><th>Extension</th><th>UCID</th><th>Start Time</th><th>^</th><th>Play</th>";
            // phone playback
            if (!empty($_SESSION['s_loginPlaybackExtension'])) {
                echo "<th>P</th>";
            }            
			// email
			if ($_SESSION['s_loginGroupid'] <= 1) {
				if ($callRecordDownload=="true") {				
					echo "<th>D</th>";
				}				
				echo "<th>@</th>"; 
			}
			echo "<th>Calling</th><th>Called</th><th>Agent</th><th>Split</th><th>TG</th><th>TM</th></tr>"; 
			while($row = mysql_fetch_array($result)){ 
				echo "<tr>";
				echo "<td>";
				$key = $row['id_uniquekey'];
				if (hasAppData($key)) {
					echo "<a href=\"callSearchResult.php?key=$key\">$key</a>";
				} else {
					echo $key;						
				}
				echo "</td>";						
				echo "<td>"; 
				$posName = getDictionary($row['id_device']);
				if (strlen($posName)) {
					echo $posName;
				} else {
					echo $row['id_device'];
				}				
				echo "</td>";
				echo "<td>"; 
				$ucid = $row['id_ucid']; 
				//if (hasMultipleUcidCalls($ucid)) {
				//	echo "<a href=\"callSearchResult.php?ucid=$ucid\">$ucid</a>";
				//} else {
					echo $ucid; 
				//}
				echo "</td>";
				echo "<td>";
				echo unix_timestamp_to_human($row['id_starttime']);
				echo "</td>";
				echo "<td align=\"center\">";
				if ($row['id_calldirection']==0) {
					echo "<img src=\"libs/img/incomingcall.png\" alt=\"Inbound\">"; 						
				} else if ($row['id_calldirection']==1) {
					echo "<img src=\"libs/img/outgoingcall.png\" alt=\"Outbound\">";						
				} else if ($row['id_calldirection']==2) {
					echo "<img src=\"libs/img/agentcall.png\" alt=\"Outbound\">";						
				}
				echo "</td>";
				// the playback item begin 
				echo "<td>";	
				echo "<a href=\"playback.php?recordkey=$key\" ";
				$mime_type = "audio/".$row['id_recformat'];
				echo "type=\"$mime_type\" ";
				if ($_SESSION['s_loginGroupid'] > 0) {
					echo "oncontextmenu=\"return false;\" ";	
				}
				echo "class=\"sm2_button\">";
				echo secondMinute($row['id_endtime']-$row['id_starttime']);
				echo "</a>";
				echo secondMinute($row['id_endtime']-$row['id_starttime']);								
				echo "</td>";
                if (!empty($_SESSION['s_loginPlaybackExtension'])) {
                    // phone playback URL
                    echo "<td align=\"center\">";					
                    //echo "<form id=\"phoneplayback\" action=\"phonePlayback.php\" method=\"post\">";
                    echo "<form class=\"phoneplayback\">";
                    echo "<input type=\"hidden\" name=\"key\" value=\"$key\">";
                    echo '<div id="phoneplaybackurl">';					
                    echo "<input type=\"image\" src=\"libs/img/phoneplayback.png\" border=\"0\" >";
                    echo "</div>";					
                    echo "</form>";	
                    echo "</td>";
                }                 
				if ($_SESSION['s_loginGroupid'] <= 1) {
					if ($callRecordDownload=="true") {
						// download URL 
						echo "<td align=\"center\">";					
						echo "<form action=\"download.php\" method=\"post\">";
						echo "<input type=\"hidden\" name=\"key\" value=\"$key\">";
						echo '<div id="downloadurl">';					
						echo "<input type=\"image\" src=\"libs/img/download.png\" border=\"0\" >";
						echo "</div>";					
						echo "</form>";				
						echo "</td>";
					}
					// email
					echo "<td align=\"center\">";
					echo "<a href=\"callSearchEmailResult.php?key=";
					echo $key;
					echo "\"><img src=\"libs/img/email.png\"></a>";
					echo "</td>";
				}	               
				// the playback item ended 																													
				echo "<td>";
				$origCallingNumber = $row['id_origcallingnumber']; 
				$callingNumber = $row['id_callingnumber']; 				
				if (strlen($origCallingNumber) >= strlen($callingNumber)) {
					if ($row['id_calldirection']==0) { // inbound 
						if (is_numeric($origCallingNumber)) {
							echo "<a href=\"callto:$origCallingNumber\">$origCallingNumber</a>";
						} else {
							echo $origCallingNumber;
						}						
					} else {
						echo $origCallingNumber;						
					}
				} else {
					if ($row['id_calldirection']==0) { // inbound
						if (is_numeric($callingNumber)) {
							echo "<a href=\"callto:$callingNumber\">$callingNumber</a>";
						} else {
							echo $callingNumber;
						}						
					} else {
						echo $callingNumber;						
					}					
				}
				echo "</td>";				
				echo "<td>";
				$origCalledNumber = $row['id_origcallednumber']; 
				$calledNumber = $row['id_callednumber']; 
				if (strlen($origCalledNumber) >= strlen($calledNumber)) {
					if ($row['id_calldirection']==1) { // outbound
						if (is_numeric($origCalledNumber)) {
							echo "<a href=\"callto:$origCalledNumber\">$origCalledNumber</a>";							
						} else {
							echo $origCalledNumber;							
						}												
					} else {						
						echo $origCalledNumber;						
					}									
				} else {
					if ($row['id_calldirection']==1) { // outbound
						if (is_numeric($calledNumber)) {
							echo "<a href=\"callto:$calledNumber\">$calledNumber</a>"; 
						} else {
							echo $calledNumber;							
						}												
					} else {
						echo $calledNumber;						
					}											
				}
				echo "</td>";			
				echo "<td>";
				$agentName = getDictionary($row['id_agentid']);
				if (strlen($agentName)) {
					echo $agentName;				
				} else {
					echo $row['id_agentid'];					
				}
				echo "</td>";
				echo "<td>";
				$splitName = getDictionary($row['id_split']);
				if (strlen($splitName)) {
					echo $splitName;
				} else {
					echo $row['id_split'];
				}				
				echo "</td>";
				echo "<td align=\"right\">";
				echo $row['id_trunkgroup'];
				echo "</td>";
				echo "<td align=\"right\">";
				echo $row['id_trunkmember'];
				echo "</td>";						
				echo "</tr>"; 
			} 
			// display the netvigation 
			echo "<tr>";			
			$links = $nav->getlinks("sides", "on");
			echo "<td>";
			echo $links[0]; // Previous 
			echo "</td>";
			echo "<td></td><td></td><td></td><td></td><td></td>";
            if (!empty($_SESSION['s_loginPlaybackExtension'])) {
                echo "<td></td>"; // phoneplayback 
            }            
			// email
			if ($_SESSION['s_loginGroupid'] <= 1) {
				// download all voice files in this page 
				if ($callRecordDownload=="true") {				
					echo "<td align=\"center\">";
					echo "<form action=\"download.php\" method=\"post\">";
					echo "<input type=\"hidden\" name=\"key\" value=\"all\">";
					echo "<input type=\"hidden\" name=\"page\" value=\"$nav_page\">";				
					echo '<div id="downloadurl">';
					echo "<input type=\"image\" src=\"libs/img/download.png\" border=\"0\" >";
					echo "</div>";
					echo "</form>";
					echo "</td>";
				}												
				echo "<td></td>"; // email 
			} 
			echo "<td></td><td></td><td></td><td></td><td></td>";
			echo "<td align=\"right\">";				
			echo $links[1]; // Next
			echo "</td>";	
			echo "</tr>";	
			echo "</table>";
			// audit trial
			$auditTrial = "call search $sql successfully.";
			insertAuditTrial($auditTrial);				
			if (isset($getKey) && strlen($getKey)) {
				// display appData
				$sql = "SELECT id_calldata0, id_calldata1, id_calldata2, id_calldata3, id_calldata4,
				id_calldata5, id_calldata6, id_calldata7, id_calldata8, id_calldata9 FROM t_astappdata WHERE id_uniquekey='$getKey'";
				$result=mysql_query($sql);
				$row=mysql_fetch_array($result);
				if (mysql_num_rows($result)==1) {
					echo "<table>"; 
					// id_calldata0					
					echo "<tr>";
					echo "Application Data for Key $getKey:";
					echo "</tr>";
					// id_calldata0
					echo "<tr>";
					echo "<td>";
					echo "calldata0:";
					echo "</td>";
					echo "<td>";
					echo $row['id_calldata0'];
					echo "</td>";
					echo "</tr>";
					// id_calldata1
					echo "<tr>";
					echo "<td>";
					echo "calldata1:";
					echo "</td>";
					echo "<td>";
					echo $row['id_calldata1'];
					echo "</td>";
					echo "</tr>";
					// id_calldata2
					echo "<tr>";
					echo "<td>";
					echo "calldata2:";
					echo "</td>";
					echo "<td>";
					echo $row['id_calldata2'];
					echo "</td>";
					echo "</tr>";
					// id_calldata3
					echo "<tr>";
					echo "<td>";
					echo "calldata3:";
					echo "</td>";
					echo "<td>";
					echo $row['id_calldata3'];
					echo "</td>";
					echo "</tr>";
					// id_calldata4
					echo "<tr>";
					echo "<td>";
					echo "calldata4:";
					echo "</td>";
					echo "<td>";
					echo $row['id_calldata4'];
					echo "</td>";
					echo "</tr>";
					// id_calldata5
					echo "<tr>";
					echo "<td>";
					echo "calldata5:";
					echo "</td>";
					echo "<td>";
					echo $row['id_calldata5'];
					echo "</td>";
					echo "</tr>";
					// id_calldata6
					echo "<tr>";
					echo "<td>";
					echo "calldata6:";
					echo "</td>";
					echo "<td>";
					echo $row['id_calldata6'];
					echo "</td>";
					echo "</tr>";
					// id_calldata7
					echo "<tr>";
					echo "<td>";
					echo "calldata7:";
					echo "</td>";
					echo "<td>";
					echo $row['id_calldata7'];
					echo "</td>";
					echo "</tr>";
					// id_calldata8
					echo "<tr>";
					echo "<td>";
					echo "calldata8:";
					echo "</td>";
					echo "<td>";
					echo $row['id_calldata8'];
					echo "</td>";
					echo "</tr>";
					// id_calldata9
					echo "<tr>";
					echo "<td>";
					echo "calldata9:";
					echo "</td>";
					echo "<td>";
					echo $row['id_calldata9'];
					echo "</td>";
					echo "</tr>";
					echo "</table>";	
					// audit trial
					$auditTrial = "data search $sql successfully.";
					insertAuditTrial($auditTrial);											
				}			
			}					
		} // mysql_num_rows > 0 
	?>		
	</div>
</body>
</html>

