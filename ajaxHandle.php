<?php
require_once 'logFile.php';
require_once 'session.inc.php';
require_once 'db.inc.php';
parse_str($_SERVER["QUERY_STRING"]);
if ($_POST['act'] == 'changeTeam') {
    $team = explode("##", rawurldecode($_POST['t_name']));
    $query = "select lead from teams where t_name = '" . $team[0] . "'";
    if ($result = mysql_query($query)) {
        if ($row = mysql_fetch_array($result)) {
            echo $row[0];
        }
    }
} else if ($_POST['act'] == 'TeamAdd') {
    $query = "select * from teams where t_name = '" . $_POST['t_name'] . "' and p_name = '" . $_POST['p_name'] . "'";
    if ($result = mysql_query($query)) {
        if (mysql_num_rows($result)) {
            echo TRUE;
        } else {
            $query = "insert into teams(t_name,p_name,lead) values ('" . $_POST['t_name'] . "','" . $_POST['p_name'] . "','" . $_POST['iqe'] . "')";
            if ($result = mysql_query($query)) {
                $data = "'" . $_POST['t_name'] . "','" . $_POST['p_name'] . "','" . $_POST['iqe'] . "'";
                createlog("Add Team" , $data);
                echo FALSE;
            } else {
                echo TRUE;
            }
        }
    }
} else if ($_POST['act'] == 'getTaskTeam') {
    $query = "select * from task where p_name = '" . $_POST['projectname'] . "'";
    $team = '<option value=""><-----></option>';
    $task = '<option value=""><-----></option>';
    if ($result = mysql_query($query)) {
        while ($row = mysql_fetch_assoc($result)) {
            $team .= "<option value = '" . $row['t_name'] . "'>" . $row['t_name'] . "</option>";
            $task .= "<option value = '" . $row['task_name'] . "'>" . $row['task_name'] . "</option>";
        }
    }
    echo "Team:<select name=team>" . $team . '</select>';
    echo "Task:<select name=task>" . $task . '</select>';
} else if ($_POST['act'] == 'addtoSession') {
    session_start();
    $_SESSION['proList'] = $_POST['proList'];
    echo true;
} else if ($_POST['act'] == 'delTeam') {
    $query = "delete from teams where team_id = " . $_POST['team_id'];
    if ($result = mysql_query($query)) {
        $data = 'Deletion Team id : ' . $_POST['team_id'];
        createlog("Delete Team" , $data);
        echo TRUE;
    } else {
        echo FALSE;
    }
} else if ($_POST['act'] == 'checkDup') {
    if(empty($_POST['task_name'])){
        $query = "select * from projects where p_name = '" . rawurldecode($_POST['p_name']) . "'";
    } else {
        $query = "select * from task where task_name = '" . rawurldecode($_POST['task_name']) . "' and p_name = '" . rawurldecode($_POST['p_name']) . "'";
    }
    if ($result = mysql_query($query)) {
        if (mysql_num_rows($result)) {
            echo TRUE;
        } else {
            echo FALSE;
        }
    }
}
?>