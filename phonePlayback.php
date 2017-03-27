<?php
include('lock.php');
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $recordkey = addslashes($_POST['key']);
    $extension = $_SESSION['s_loginPlaybackExtension']; 
    $url = "http://localhost:5003/playback?extension=$extension&recordkey=$recordkey";
    $ch = curl_init();
    // Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Set the url
    curl_setopt($ch, CURLOPT_URL,$url);
    // Execute
    $result=curl_exec($ch);
    // Closing
    curl_close($ch);
}
?>
