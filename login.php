<?php
$log = '';
if (isset($_POST['submit'])) {
    require_once 'db.inc.php';
    $user = $_POST['user'];
    $passwd = $_POST['passwd'];
    if (($passwd == '') || ($user == '')) {
        $log = "enterdata";
    } else if (($passwd != '') && ($user != '')) {

        $query = "select * from users where user_id='$user'";
        $result = mysql_query($query);
        if (mysql_num_rows($result) == 1) {
            $row = mysql_fetch_assoc($result);
//            session_start();
//            $_SESSION['user'] = $user;
//            $_SESSION['Last_Activity'] = time();
//            $_SESSION['role'] = $row['role'];
//            header('Location: home.php');
//
            $ldapconn = ldap_connect("adobenet.global.adobe.com") or die("Could not connect to LDAP server.");
            if ($ldapconn) {
                $ldapbind = @ldap_bind($ldapconn, 'adobenet\\' . $user, $passwd);
                if ($ldapbind) {
                    $logkey = rand(100000000, 999999999);
                    $query = "UPDATE users SET logkey = '$logkey' WHERE user_id = '$user'";
                    mysql_query($query) or die(mysql_error());
                    session_start();
                    $_SESSION['user'] = $user;
                    $_SESSION['Last_Activity'] = time();
                    $_SESSION['role'] = $row['role'];
                    header('Location: home.php');
                } else {
                    $log = "fail";
                }
            }
        }
    }
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Tracker Login Form</title>
        <link rel="stylesheet" href="css/style.css">
        <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    </head>
    <body>
        <form action="login.php" class="login" method="post">
            <h1>Tracker</h1>

            <?php if (strpos(strtolower($_SERVER["QUERY_STRING"]), 'loginagain') !== FALSE) { ?>
                Session Expired... Login Again
            <?php } ?>
            <input type="text" name="user" class="login-input" placeholder="User Name" autofocus>
            <input type="password" name="passwd" class="login-input" placeholder="Password">
            <input type="submit" name="submit" value="Login" class="login-submit">

<!--<p class="login-help"><a href="index.html">Forgot password?</a></p>-->
            <?php if ($log == "enterdata") { ?>
                <div align="center" style="width:100%; color:#FF0000; font-weight:bold; "> Enter Credentials</div>
            <?php } else if ($log == "fail") { ?>
                <div align="center" style="width:100%; color:#FF0000; font-weight:bold; ">Enter Valid Credentials</div>
            <?php } ?>
        </form>
    </body>
</html>
