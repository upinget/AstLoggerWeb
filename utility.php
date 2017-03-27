<?php
function unix_timestamp_to_human ($timestamp = "", $format = 'd M Y - H:i:s') {
    if (empty($timestamp) || ! is_numeric($timestamp)) $timestamp = time();
    return ($timestamp) ? date($format, $timestamp) : date($format, $timestamp);
}

function secondMinute($seconds){
	/// get minutes
	$minResult = floor($seconds/60);
	/// if minutes is between 0-9, add a "0" --> 00-09
	if($minResult < 10){$minResult = 0 . $minResult;}
	/// get sec
	$secResult = ($seconds/60 - $minResult)*60;
	/// if secondes is between 0-9, add a "0" --> 00-09
	if($secResult < 10){$secResult = 0 . $secResult;}
	/// return result
	echo $minResult,":",$secResult;
}

function randomPassword() {
	$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	$pass = array(); //remember to declare $pass as an array
	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	for ($i = 0; $i < 8; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}
	return implode($pass); //turn the array into a string
}

function curPageURL() {
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {
		$pageURL .= "s";
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

function curPageName() {
	return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

function curPageNameWithParameters() {
	$url = curPageURL(); 
	$pos = strrpos($url, "/");
	$dir = substr($url, $pos+1);
	return $dir;
}

function curPageDir() {
	$url = curPageURL(); 
	$pos = strrpos($url, "/");
	$dir = substr($url, 0, $pos+1);
	return $dir;
}

//This script is developed by www.webinfopedia.com and being modified 
//For more examples in php visit www.webinfopedia.com
function zipFilesAndDownload($file_names, $display_names, $decrypted_files, $archive_file_name)
{
	$zip = new ZipArchive();
	//create the file and throw the error if unsuccessful
	if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
		exit("cannot open <$archive_file_name>\n");
	}
	//add each files of $file_name array to archive
    for($i=0; $i<=count($file_names)-1; $i++) {
		$zip->addFile($file_names[$i], $display_names[$i]);
	}
	$zip->close();
	//then send the headers to foce download the zip file
	header("Content-type: application/zip");
	header("Content-Disposition: attachment; filename=$archive_file_name");
	header("Pragma: no-cache");
	header("Expires: 0");
	readfile("$archive_file_name");
	unlink("$archive_file_name");
    for($i=0; $i<=count($file_names)-1; $i++) {
        if ($decrypted_files[$i]=="true") {
            unlink($file_names[$i]);
        }
	}    
}

function formatSQLCondInFromConfigString($configString,$name)
{
	$result = "";
	$token = explode(";", $configString);
	foreach($token as $value) {
		if (strpos($value, "-")!==FALSE) {
			$range = explode("-", $value);
			if (count($range)==2) {
				$start = intval($range[0]);
				$end = intval($range[1]);
				if ($start < $end) {
					for ($x = $start; $x <= $end; $x++) {
						if (empty($result)) {
							$result = $name .= " IN (";
							$result .= "'";
							$result .= $x;
							$result .= "'";			
						} else {
							$result .= ", ";	
							$result .= "'";
							$result .= $x;
							$result .= "'";				
						}
					}
				}				
			}
		} else {
			if (empty($result)) {
				$result = $name .= " IN (";
				$result .= "'";
				$result .= $value;
				$result .= "'";			
			} else {
				$result .= ", ";	
				$result .= "'";
				$result .= $value;
				$result .= "'";				
			}
		}
	}
	if (!empty($result)) {
		$result .= ")";
	}
	return $result;	
}

?>