<?php
if ($_SESSION['role'] == 2) {
    echo '<h3 align="center">My Tasks</h3><br>';
    echo '<center><table border=1 style="width : 90% ;margin-top: 2%" class="table table-bordered responsive">'
    . '<thead><tr><th>Rendering engine</th><th>#</th><th>Task Name</th><th>Project Name</th><th>Type</th><th>Status</th><th>End Date</th></tr></thead><tbody>';
    $query = "select * from task where assigned = '" . $_SESSION['user'] . "' and status != 'Completed'";
    $result = mysql_query($query);
    $rowCount = 1;
    while ($row = mysql_fetch_assoc($result)) {
        echo '<tr><td></td><td>' . $rowCount++ . '</td><td><a href=taskView.php?task_name=' . rawurlencode($row["task_name"]) . '&p_name=' . rawurlencode($row["p_name"]) . '>' . $row["task_name"] . '</a></td>'
        . '<td>' . $row["p_name"] . '</td><td>' . $row["type"] . '</td><td>' . $row["status"] . '</td><td>' . $row["completion_date"] . '</td></tr>';
    }
    echo '</tbody></table></center><br><br><br>';
}
echo '<h3 align="center">Open Tasks</h3><br>';
echo '<table border=1 style="width : 90% ;margin-top: 2%" class="display dataTable" id="domainTable">'
 . '<thead><tr style="text-align:left"><th>#</th><th>Task Name</th><th>Project Name</th><th>Type</th><th>Status</th><th>Completion Date</th></tr></thead><tbody>';
$query = "select * from task where assigned != '" . $_SESSION['user'] . "' and status != 'Completed'";
$result = mysql_query($query);
$rowCount = 1;
while ($row = mysql_fetch_assoc($result)) {
    echo '<tr><td>' . $rowCount++ . '</td><td><a href=taskView.php?task_name=' . rawurlencode($row["task_name"]) . '&p_name=' . rawurlencode($row["p_name"]) . '>' . $row["task_name"] . '</a></td>'
    . '<td>' . $row["p_name"] . '</td><td>' . $row["type"] . '</td><td>' . $row["status"] . '</td><td>' . $row["completion_date"] . '</td></tr>';
}
echo '</tbody></table>';
?>
