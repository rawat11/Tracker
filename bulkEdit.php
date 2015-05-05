<?php
require_once 'logFile.php';
//if(!empty($_SESSION['proList'])){
//    echo $_SESSION['proList'];
//}
//if (isset($_POST['check_list']) || isset($_POST['pro_list'])) {
if(!empty($_SESSION['proList'])){
    if (isset($_POST['delete_list'])) {
        if (!empty($_POST['delete_list'])) {
            $query = "delete from task where task_id in (";
            foreach ($_POST['delete_list'] as $pro) {
                $query .= "'" . $pro . "',";
            }
            $query = substr($query, 0, -1);
            $query .= ")";
        }
        if(mysql_query($query)){
            $data = 'Task Id : ' . implode(",",$_POST['delete_list']) ;
            createlog("Delete Task" , $data);
        }
//        echo 'Delete Query : ' . $query;
    }
    $prolist = '';
    $query = "select * from projects pro join task tsk on pro.p_name=tsk.p_name where pro.p_name in (";
//    if (!empty($_POST['check_list'])) {
//        if (!isset($_POST['delete_list'])) {
//            foreach ($_POST['check_list'] as $pro) {
//                $query .= "'" . rawurldecode($pro) . "',";
//                $prolist .= "'" . rawurldecode($pro) . "',";
//            }
//            $query = substr($query, 0, -1);
//            $prolist = substr($prolist, 0, -1);
//        }
//    } else {
//        if (isset($_POST['pro_list'])) {
//            $query .= rawurldecode($_POST['pro_list']);
//            $prolist = rawurldecode($_POST['pro_list']);
//        }
//    }
    $query .= rawurldecode($_SESSION['proList']);
    $query .= ")";
    if ($_SESSION['role'] != 1) {
        $query .= " and tsk.assigned='" . $_SESSION['user'] . "'";
    }
    echo '<input type=hidden name=pro_list value=' . rawurlencode($prolist) . '>';
    echo "<center><table border=0 class='display dataTable' id='domainTable' style=\'width : 90% ;margin-top: 2%\'><caption>";
    echo "<input type='submit' class='btn btn-primary' value='Delete' name='bulkeditDelete' style='float:right'>";
    echo '</caption><thead><tr style="text-align:left"><th>#</th><th>Task Name</th><th>Project</th><th>Team</th><th>Type</th><th>Assigned To</th><th>Status</th><th>Completion Date</th></tr></thead><tbody>';
    $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) {
        echo "<tr><td><input type=checkbox name=delete_list[] value=" . rawurlencode($row["task_id"]) . "></td>";
        echo '<td><a href=taskView.php?task_name=' . rawurlencode($row["task_name"]) . '&p_name=' . rawurlencode($row["p_name"]) . '>' . $row["task_name"] . '</a></td><td>' . $row["p_name"] . '</td><td>' . $row["t_name"] . '</td><td>' . $row["type"] . '</td><td>' . $row["assigned"] . '</td><td>';
        echo $row["status"] . '</td><td>' . $row["completion_date"] . '</td></tr>';
    }
    echo '</tbody></table></center>';
} else {
    echo 'Select Projects to Bulk Edit';
}
?>

