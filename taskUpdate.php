<?php
require_once 'session.inc.php';
parse_str(rawurldecode($_SERVER["QUERY_STRING"]));
require_once 'db.inc.php';
require_once 'logFile.php';
$status = 0;
if (isset($_POST['cancel'])) {
    header('Location: home.php?p_name=' . $p_name);
} else if (!empty($_POST)) {
    $status = $_POST['status'];
    $com_date = $_POST['com_date'];
    $c_date = $_POST['c_date'];
    $link = $_POST['link'];
    $langs = $_POST['langs'];
    $notes = $_POST['notes'];
    $bugs = $_POST['bugs'];
    $efforts = $_POST['efforts'];
    require_once 'db.inc.php';

    $c_date = date('Y-m-d', strtotime($c_date));
    $com_date = date('Y-m-d', strtotime($com_date));
//    $query = "update task set t_name='" . $team_name . "',status='" . $status . "',completion_date='" . $com_date . "',assigned='" . $assigned . "',lang='" . $langs . "',link='" . $link . "',bugs='" . $bugs . "',notes='" . $notes . "',efforts='" . $efforts . "' where task_name='" . $task_name . "'";
    $query = "update task set status='" . $status . "',start_date='". $c_date ."',completion_date='" . $com_date . "',lang='" . $langs . "',link='" . $link . "',bugs='" . $bugs . "',notes='" . $notes . "',efforts='" . $efforts . "' where task_name='" . $task_name . "' and p_name = '" . $p_name . "'";
    if (mysql_query($query)) {
        $data = "status='" . $status . "',start_date='". $c_date ."',completion_date='" . $com_date . "',lang='" . $langs . "',link='" . $link . "',bugs='" . $bugs . "',notes='" . $notes . "',efforts='" . $efforts . "' where task_name='" . $task_name . "' and p_name = '" . $p_name . "'";
        createlog("Update Task" , $data);
        header('Location: taskView.php?task_name=' . $task_name . '&p_name=' . rawurlencode($p_name));
    } else {
        $status = 1;
    }
}
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
        <SCRIPT>
            $(document).ready(function () {
                $("#datepicker1").datepicker({dateFormat: 'yy-mm-dd',
                    inline: true,
                    minDate: new Date(2015, 1 - 1, 1),
                    maxDate: new Date(2017, 12 - 1, 31),
                    altField: '#datepicker_value'
                })
                $("#datepicker2").datepicker({dateFormat: 'yy-mm-dd',
                    inline: true,
                    minDate: 0,
                    maxDate: new Date(2017, 12 - 1, 31),
                    altField: '#datepicker_value'
                })
                $('#strtCal').click(function () {
                    if ($("#datepicker1").datepicker("widget").is(":visible")) {
                        $("#datepicker1").datepicker('hide');
                    } else {
                        $("#datepicker1").datepicker().datepicker("setDate", $("#datepicker1").val()).datepicker('show');
                    }
                });
                $('#relCal').click(function () {
                    if ($("#datepicker2").datepicker("widget").is(":visible")) {
                        $("#datepicker2").datepicker('hide');
                    } else {
                        $("#datepicker2").datepicker().datepicker("setDate", $("#datepicker2").val()).datepicker('show');
                    }
                });
            });
        </SCRIPT>
    </head>
    <body>
        <form class="stdform stdform2" action="<?php echo $_SERVER['HTTP_REFERER']; ?>" method = "post" enctype = "multipart/form-data">
            <div class="mainwrapper">
                <?php require_once 'header.inc.php'; ?>
                <?php require 'leftpanel.inc.php'; ?>
                <div class="rightpanel">
                    <div class="pageheader">
                        <div class="pageicon"><span class="iconfa-dashboard"></span></div>
                        <div class="pagetitle">
                            <h1>UPDATE TASK</h1>
                        </div>
                    </div>
                    <div class="maincontent">
                        <div class="maincontentinner">
                            <div class="widgetbox box-inverse">
                                <h4 class="widgettitle">Update Task</h4>
                                <div class="widgetcontent nopadding">
                                    <div style="color: red;text-align: left" id="msgdiv">
                                        <?php
                                        if ($status == 1)
                                            echo 'Inconsistent Data';
                                        ?>
                                    </div>
                                    <table style="border-collapse: separate; border-spacing: 5px 15px;">
                                        <?php
                                        $query = "select * from task where task_name='" . $task_name . "' and p_name='" .$p_name ."'";
                                        if($_SESSION['role'] != 1)
                                            $query .= "and assigned = '" . $_SESSION['user'] . "'";
                                        $result = mysql_query($query);
                                        if ($row = mysql_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td style="background-color: whitesmoke;width: 10%"><label>Task Name : </label></td>
                                                <td style="width: 18%"><?php echo $row['task_name'] ?></td>

                                                <td style="background-color: whitesmoke;width: 10%"><label>Project Name : </label></td>
                                                <td style="width: 18%"><?php echo $row['p_name'] ?></td>

                                                <td style="background-color: whitesmoke;width: 10%"><label>Task Type : </label></td><td><?php echo $row['type'] ?></td>
                                            </tr>
                                            <tr>
                                                <td style="background-color: whitesmoke"><label>Status : </label></td>
                                                <td><select name="status" id='select1'>
                                                        <option value="Ready" <?php if ($row['status'] == 'Ready') echo 'selected'; ?> >Ready</option>
                                                        <option value="Blocked" <?php if ($row['status'] == 'Blocked') echo 'selected'; ?> >Blocked</option>
                                                        <option value="Running" <?php if ($row['status'] == 'Running') echo 'selected'; ?> >Running</option>
                                                        <option value="Completed" <?php if ($row['status'] == 'Completed') echo 'selected'; ?> >Completed</option>
                                                        <option value="Pending" <?php if ($row['status'] == 'Pending') echo 'selected'; ?> >Pending</option>
                                                    </select>
                                                </td>
                                                <td style="background-color: whitesmoke"><label>Team Name : </label></td><td><?php echo $row['t_name']; ?></td>
                                                <td style="background-color: whitesmoke"><label>Assigned : </label></td><td><?php echo $row['assigned']; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="background-color: whitesmoke"><label>Start Date : </label></td>
                                                <td><input id="datepicker1" type="text" name="c_date"  value=<?php echo $row['start_date']; ?> readonly />
                                                    <a id="strtCal" class="iconfa-calendar" style="cursor: pointer"></a>
                                                </td>
                                                <td style="background-color: whitesmoke"><label>Completion Date : </label></td>
                                                <td><input id="datepicker2" type="text" name="com_date"  value=<?php echo $row['completion_date']; ?> readonly />
                                                    <a id="relCal" class="iconfa-calendar" style="cursor: pointer"></a>
                                                </td>
                                                <td style="background-color: whitesmoke"><label>Efforts : </label></td>
                                                <td><input type="text" style="width:50%; height:100%" id="efforts" name="efforts" value=<?php echo $row['efforts']; ?> ></td>
                                            </tr>
                                            <tr>
                                                <td style="background-color: whitesmoke"><label>Description : </label></td>
                                                <td colspan="5"><textarea rows="3" cols="80" id="notes" name="notes" ><?php echo $row['notes']; ?></textarea></td>
                                            </tr>
                                            <tr>
                                                <td style="background-color: whitesmoke"><label>Languages Captured : </label></td>
                                                <td colspan="5"><textarea rows="4" cols="80" name="langs" id="langs" ><?php echo $row['lang']; ?></textarea></td>
                                            </tr>
                                            <tr>
                                                <td style="background-color: whitesmoke"><label>Link To <?php
                                                        if ($row['type'] == 'Linguistic')
                                                            echo 'Screenshots';
                                                        else
                                                            echo 'TestCases';
                                                        ?> :</label></td>
                                                <td colspan="5"><textarea rows="4" cols="80" id="link" name="link" ><?php echo $row['link']; ?></textarea></td>
                                            </tr>
                                            <tr >
                                                <td style="background-color: whitesmoke"><label>Bugs : </label></td>
                                                <td colspan="5"><textarea rows="3" cols="80" id="bugs" name="bugs" ><?php echo $row['bugs']; ?></textarea></td>
                                            </tr>
                                        <tr>
                                            <td colspan="6">
                                                <input type="button" style="margin-left: 20px" class="btn btn-primary" id="update" name="update" value="UPDATE" onclick="validateTskUpdate('<?php echo rawurlencode($task_name.'&p_name='.$p_name); ?>')">
                                                <input style="float: right;margin-right: 30px" type="submit" name="cancel" class="btn" value="BACK">
                                            </td>
                                        </tr>
                                        <?php } else echo 'InConsistent Data'; ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>

