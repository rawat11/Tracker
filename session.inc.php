<?php
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['Last_Activity'])) {
    if (time() - $_SESSION['Last_Activity'] < 600) {
        $_SESSION['Last_Activity'] = time();
        if((strpos(strtolower($_SERVER['REQUEST_URI']), 'addproject') !== FALSE) && ($_SESSION['role'] != '1')){
            echo 'Don\'t be Smart!!! :D You don\'t have Permissions to access this Page.<br>';
            echo 'Page Under Construction :)';
            exit();
        } else if ((strpos(strtolower ($_SERVER['REQUEST_URI']), 'addtask') !== FALSE) && ($_SESSION['role'] == '3')){
            echo 'Don\'t be Smart!!! :D You don\'t have Permissions to access this Page.<br>';
            echo 'Page Under Construction :)';
            exit();
        } else if ((strpos(strtolower ($_SERVER['REQUEST_URI']), 'addteam') !== FALSE) && ($_SESSION['role'] != '1')){
            echo 'Don\'t be Smart!!! :D You don\'t have Permissions to access this Page.<br>';
            echo 'Page Under Construction :)';
            exit();
        } else if ((strpos(strtolower ($_SERVER['REQUEST_URI']), 'editproject') !== FALSE) && ($_SESSION['role'] != '1')){
            echo 'Don\'t be Smart!!! :D You don\'t have Permissions to access this Page.<br>';
            echo 'Page Under Construction :)';
            exit();
        }

    } else if((strpos(strtolower ($_SERVER["QUERY_STRING"]), 'bulkedit') !== FALSE) || (strpos(strtolower ($_SERVER["QUERY_STRING"]), 'addteam') !== FALSE)){
        echo 'OOps Session Expired... Close the Window and Login Again.';
        exit();
    }else{
        header('Location: login.php?loginagain');
    }
} else {
    header('Location: login.php');
}
?>