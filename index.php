<?php
//IP Grabber
//Variables

if(isset($_GET['id'])){
    if($_GET['id'] == 'list'){
        $file = "urls.json";
        $json = json_decode(file_get_contents($file), true);
        foreach ($json as $item) {
            echo $item['id']. ': ' .$item['url'] . '<br>';
        }
    }else {
        $file = "urls.json";
        $json = json_decode(file_get_contents($file), true);
        foreach ($json as $item) {
            if ($item['id'] == $_GET['id']) {
                logAndRedirect($item['url'], $item['id']);
            }
        }
    }
}else if(isset($_GET['url'])){
    $row = 1;
    $found = false;
    $file = "urls.json";
    $json = json_decode(file_get_contents($file), true);
    $found = false;
    if (strpos($_GET['url'], 'https://') !== false || strpos($_GET['url'], 'http://') !== false) {
        foreach($json as $item){
            if($item['url'] == $_GET['url']){
                echo $item['id'];
                $found = true;
            }
        }
        if($found == false) {
            $hash = incrementalHash();
            echo $hash;
            array_push($json, array('id' => $hash, 'url' => $_GET['url']));
        }
        file_put_contents($file, json_encode($json));
    }else{
        echo "Please specify https or http";
    }

}

function incrementalHash($len = 5){
    $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $base = strlen($charset);
    $result = '';

    $now = explode(' ', microtime())[1];
    while ($now >= $base){
        $i = $now % $base;
        $result = $charset[$i] . $result;
        $now /= $base;
    }
    return substr($result, -5);
}
function logAndRedirect($url,$id){
    $protocol = $_SERVER['SERVER_PROTOCOL'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $port = $_SERVER['REMOTE_PORT'];
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $time = $_SERVER['REQUEST_TIME'];
    //Print IP, Hostname, Port Number, User Agent and Referer To Log.TXT

    $fh = fopen('log.txt', 'a');
    fwrite($fh, 'IP Address: '."".$ip ."\n");
    fwrite($fh, 'Hostname: '."".$hostname ."\n");
    fwrite($fh, 'Port Number: '."".$port ."\n");
    fwrite($fh, 'User Agent: '."".$agent ."\n");
    fwrite($fh, 'Time:'."".$time."\n");
    fwrite($fh, 'Refered to:'."".$url." with id ".$id."\n\n");
    fclose($fh);
    header('Location: '.$url);
    exit;
}
?>
