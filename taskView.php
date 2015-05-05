<?php
require_once 'session.inc.php';
parse_str(rawurldecode($_SERVER["QUERY_STRING"]));
require_once 'db.inc.php';
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>TRACKER</title>
        <link rel="stylesheet" href="css/style.default.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href="styles/style.css" />
        <link type="text/css" href="styles/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
        <script type="text/javascript" src="scripts/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="scripts/jquery-ui-1.8.21.custom.min.js"></script>
        <link rel="stylesheet" href="css/style.default.css" type="text/css" />
        <link rel="stylesheet" href="css/responsive-tables.css">
        <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
        <script type="text/javascript" src="js/modernizr.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery.cookie.js"></script>
        <script type="text/javascript" src="js/jquery.uniform.min.js"></script>
        <script type="text/javascript" src="js/flot/jquery.flot.min.js"></script>
        <script type="text/javascript" src="js/flot/jquery.flot.resize.min.js"></script>
        <script type="text/javascript" src="js/responsive-tables.js"></script>
        <script type="text/javascript" src="js/custom.js"></script>
        <script type="text/javascript" src="commonFunctions.js"></script>
    </head>
    <body>
            <form class="stdform stdform2" method = "post" action='<?php echo $_SERVER['HTTP_REFERER']; ?>' enctype = "multipart/form-data">
            <div class="mainwrapper">
                <?php require_once 'header.inc.php'; ?>
                <?php require 'leftpanel.inc.php'; ?>
                <?php
                $query = "select * from task where task_name='" . $task_name . "' and p_name='" .$p_name ."'";
                $result = mysql_query($query);
                if ($row = mysql_fetch_assoc($result)) {
                    ?>
                    <div class="rightpanel">
                        <ul class="breadcrumbs">
                            <li><a href="home.php"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
                            <li><Strong>Task Details &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></li>
                            <li><strong><a <?php if (!strcmp($row['assigned'], $_SESSION['user']) || ($_SESSION['role'] == 1)) {echo ' href=taskUpdate.php?task_name='.rawurlencode($task_name).'&p_name='.rawurlencode($p_name);}?> >
                                        Edit Task
                                    </a></strong></li>
                        </ul>
                        <div class="pageheader">
                            <div class="pageicon"><span class="iconfa-dashboard"></span></div>
                            <div class="pagetitle">
                                <h1>TASK DETAILS</h1>
                            </div>
                        </div>
                        <div class="maincontent">
                            <div class="maincontentinner">
                                <div class="widgetbox box-inverse">
                                    <h4 class="widgettitle">Task Details</h4>
                                    <div class="widgetcontent nopadding">
                                        <div style="color: red;text-align: left" id="msgdiv"></div>
                                        <table cell-padding=10px style="width : 100%;table-layout : fixed;border-collapse: separate; border-spacing: 5px 15px;">
                                            <tr>
                                                <td style="background-color: whitesmoke;width: 15%"><label>Task Name : </label></td>
                                                <td><?php echo $row['task_name'] ?></td>

                                                <td style="background-color: whitesmoke;width: 15%"><label>Project Name : </label></td>
                                                <td><?php echo $row['p_name'] ?></td>

                                                <td style="background-color: whitesmoke;width: 15%"><label>Task Type : </label></td><td><?php echo $row['type'] ?></td>
                                            </tr>
                                            <tr>
                                                <td style="background-color: whitesmoke"><label>Team Name : </label></td><td><?php echo $row['t_name']; ?></td>
                                                <td style="background-color: whitesmoke"><label>Status : </label></td><td><?php echo $row['status'] ?></td>
                                                <td style="background-color: whitesmoke"><label>Assigned : </label></td><td><?php echo $row['assigned']; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="background-color: whitesmoke"><label>Creation Date : </label></td><td><?php echo $row['start_date']; ?></td>

                                                <td style="background-color: whitesmoke"><label>Completion Date : </label></td>
                                                <td><?php echo $row['completion_date']; ?></td>

                                                <td style="background-color: whitesmoke"><label>Efforts : </label></td><td><?php echo $row['efforts']; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="background-color: whitesmoke"><label>Languages Captured : </label></td>
                                                <td colspan="2"><textarea style="background-color: transparent;border-color: white" rows="3" cols="60" name="langs" id="langs" readonly ><?php echo $row['lang']; ?></textarea></td>
                                                <td style="background-color: whitesmoke"><label>Link To <?php
                                                        if ($row['type'] == 'Linguistic')
                                                            echo 'Screenshots';
                                                        else
                                                            echo 'TestCases';
                                                        ?> : </label></td>
                                                <td colspan="2"><textarea style="background-color: transparent;border-color: white" rows="3" cols="60" id="link" name="link" readonly ><?php echo $row['link']; ?></textarea></td>
                                            </tr>
                                            <tr>
                                                <td style="background-color: whitesmoke"><label>Description : </label></td>
                                                <td colspan="2"><textarea style="background-color: transparent;border-color: white" rows="3" cols="60" id="notes" name="notes" readonly ><?php echo $row['notes']; ?></textarea></td>
                                                <td style="background-color: whitesmoke"><label>Bugs : </label></td>
                                                <td colspan="2"><textarea style="background-color: transparent;border-color: white" rows="3" cols="60" id="bugs" name="bugs" readonly ><?php echo $row['bugs']; ?></textarea></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6"><input style="float: right;margin-right: 30px" class="btn" type="submit" value="BACK"></a></td>
                                                <!--<td colspan="1"><?php
                                                foreach ($_POST as $key => $value) {
                                                    echo "$key:$value<br>";
                                                }
                                                ?><?php
                                                foreach ($_SERVER as $key => $value) {
                                                    echo "$key:$value<br>";
                                                }
                                                ?>
                                                <?php
                                                foreach ($_SESSION as $key => $value) {
                                                    echo "$key:$value<br>";
                                                }
                                                ?><?php
                                                foreach ($_REQUEST as $key => $value) {
                                                    echo "$key:$value<br>";
                                                }
                                                ?></td>-->
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else echo 'InConsistent Data'; ?>
            </div>
        </form>

    </body>
</html>

