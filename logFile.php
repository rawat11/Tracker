<?php
function createlog( $action, $details){
    $data = "\n" . time() . "  |  " . $_SESSION['role'] . ":" . $_SESSION['user'] . "  |  ";
    $logfile = fopen("log\log.txt", "a") or die("Unable to Open Log File");
    $data .= $action . "  |  " . $details . "  |" . PHP_EOL;
    fwrite($logfile, $data);
    fclose($logfile); 
}
?>