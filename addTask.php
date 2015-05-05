<?php
require_once 'session.inc.php';
require_once 'db.inc.php';
require_once 'logFile.php';
$taskType = 0;
$val = '';
parse_str(rawurldecode($_SERVER["QUERY_STRING"]));
if (strpos(strtolower($_SERVER["QUERY_STRING"]), 'ling') !== FALSE) {
    $taskType = 1;
} elseif (strpos(strtolower($_SERVER["QUERY_STRING"]), 'fun') !== FALSE) {
    $taskType = 2;
}

if (!empty($_POST)) {
    /* $userid = $_SESSION['user']; */
    $type = $_POST['task_type'];
//    echo $_POST['task_name'];
    $task_name = $_POST['task_name'];
    $c_date = $_POST['c_date'];
    $com_date = $_POST['com_date'];
    $assigned = $_POST['assigned'];
    $t_name = explode("##",rawurldecode($_POST['select1']));
    $link = $_POST['link'];
    $langs = $_POST['langs'];
    $notes = $_POST['notes'];
    $bugs = $_POST['bugs'];
    $efforts = 0;

    $c_date = date('Y-m-d', strtotime($c_date));
    $com_date = date('Y-m-d', strtotime($com_date));
    /* if (mysql_query($query)) */ {
        $query = "insert into task(task_name,type,p_name,t_name,team_id,start_date,completion_date,assigned,link,lang,notes,bugs,efforts,status) values('$task_name','$type','$p_name','$t_name[0]','$t_name[1]','$c_date','$com_date','$assigned','$link','$langs','$notes','$bugs','0','Pending')";
        if (mysql_query($query)) {
            $data = "'$task_name','$type','$p_name','$t_name[0]','$t_name[1]','$c_date','$com_date','$assigned','$link','$langs','$notes','$bugs','0','Pending'";
            createlog("Add Task" , $data);
            header('Location: home.php?p_name=' . rawurlencode($p_name));
        } else {
            $val = 'Error : ' . mysql_error();
//            $val = $query;
        }
    }
//    else {
//        $status = 2;
//    }
}
//else if (isset($_POST['cancel'])) {
//    header('Location: home.php?p_name=' . $p_name);
//}
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
                    minDate: new Date(2015, 1 - 1, 1),
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
        <div class="mainwrapper">
            <?php require_once 'header.inc.php'; ?>
            <?php require 'leftPanel.inc.php'; ?>
            <div class="rightpanel">
                <div class="pageheader">
                    <div class="pageicon"><span class="iconfa-dashboard"></span></div>
                    <div class="pagetitle">
                        <h1>ADD TASK</h1>
                    </div>
                </div>
                <div class="maincontent">
                    <div class="maincontentinner">
                        <div class="widgetbox box-inverse">
                            <h4 class="widgettitle">Add Task</h4>
                            <div class="widgetcontent nopadding">
                                <form class="stdform stdform2" action="<?php echo $_SERVER['HTTP_REFERER']; ?>" method="post"  enctype="multipart/form-data" class="stdform" >
                                    <div style="color: red;text-align: left" id="msgdiv"><?php echo $val; ?></div>
                                    <p>
                                        <label>Task Name : </label>
                                        <span class="field"><input type="text" name="task_name" id="task_name" class="input-large" onchange="checkDup('<?php echo rawurlencode($p_name); ?>')"/>*</span>
                                    </p>
                                    <p>
                                        <label>Task Type : </label>
                                        <span class="field"><select name="task_type" id="task_type" onchange="changeTask()" <?php
                                            if ($taskType != 0) {
                                                echo 'disabled';
                                            }
                                            ?> >
                                                <option value="Linguistic" <?php
                                                if ($taskType == 1) {
                                                    echo 'selected';
                                                }
                                                ?>>Linguistic</option>
                                                <option value="Functional" <?php
                                                if ($taskType == 2) {
                                                    echo 'selected';
                                                }
                                                ?>>Functional</option>
                                            </select></span>
                                    </p>
                                    <p> <label>Start Date : <small><i>(yy-mm-dd)</i></small></label>
                                        <span class="field"><input id="datepicker1" type="text" name="c_date" id="c_date" value="" readonly /><a id="strtCal" class="iconfa-calendar" style="cursor: pointer"></a></span>
                                    </p>
                                    <p>
                                        <label>Completion Date : <small><i>(yy-mm-dd)</i></small></label>
                                        <span class="field"><input id="datepicker2" type="text" name="com_date"  value="" readonly /><a id="relCal" class="iconfa-calendar" style="cursor: pointer"></a></span>
                                    </p>
                                    <p>
                                        <label>Team Name </label>
                                        <?php
                                        require_once 'db.inc.php';
                                        parse_str(rawurldecode($_SERVER["QUERY_STRING"]));
                                        $query1 = "SELECT t_name,team_id FROM teams where p_name='$p_name'";
                                        $result1 = mysql_query($query1);
                                        ?>
                                        <?php
                                        echo '<span class="field"><select name="select1" id="select1" onchange=changeTeam()><option value=\'\'><----></option>';
                                        if (mysql_num_rows($result1)) {
                                            while ($line = mysql_fetch_array($result1, MYSQL_ASSOC)) {
                                                echo "<option value=\"" . rawurlencode($line['t_name'] . "##" . $line['team_id']) . "\">" . $line['t_name'] . "</option>";
                                            }
                                        }
                                        echo '</select></span>';
                                        ?>
                                    </p>
                                    <p>
                                        <label>Assigned To : </label>
                                        <span class="field"><input type="text" name="assigned"  value="" id="assigned" readonly/>*</span>
                                    </p>
                                    <p>	
                                        <label>Description</label>
                                        <span class="field"><textarea cols="80" rows="3" name="notes" class="span5"></textarea></span>
                                    </p>
                                    <p>	
                                        <label>Languages Captured</label>
                                        <span class="field"><textarea cols="80" rows="2" name="langs" class="span5"></textarea></span>
                                    </p>
                                    <p>
                                        <label id="link">Link To <?php
                                            if ($taskType == 2)
                                                echo 'TestCases';
                                            else
                                                echo 'Screenshots';
                                            ?> : </label>
                                        <span class="field"><textarea cols="80" rows="3" name="link" class="span5"></textarea></span>
                                    </p>
                                    <p>
                                        <label>Related Bugs : </label>
                                        <span class="field"><textarea cols="80" rows="3" name="bugs" class="span5"></textarea></span>
                                    </p>
                                    <p class="stdformbutton">
                                        <button type="button" name="add" class="btn btn-primary" onclick="validateTaskAdd('add', '<?php echo $p_name ?>')" >Add Task</button>
                                        <button type="reset" class="btn">Reset</button>
                                        <button type="button" class="btn" name="cancel" style="float: right" onclick="validateTaskAdd('cancel', '')" >Cancel</button>
                                    </p> 
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
