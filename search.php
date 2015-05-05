<?php

$query = "select * from task where";
if (!empty($_POST['project'])) {
    $query .= " p_name = '" . $_POST['project'] . "' and";
}
if (!empty($_POST['task'])) {
    $query .= " task_name LIKE '%" . $_POST['task'] . "%' and";
}
if (!empty($_POST['team'])) {
    $query .= " t_name LIKE '%" . $_POST['team'] . "%' and";
}
if (!empty($_POST['type'])) {
    $query .= " type='" . $_POST['type'] . "' and";
}
if (!empty($_POST['status'])) {
    $query .= " status='" . $_POST['status'] . "' and";
}
$query = substr($query, 0, -3);
echo "<center><table class='display dataTable' id='domainTable' border=0 style=\'width : 90% ;margin-top: 2%\'>";
echo '<thead><tr><th>#</th><th>Task Name</th><th>Project</th><th>Team</th><th>Type</th><th>Assigned To</th><th>Status</th><th>Completion Date</th></tr></thead><tbody>';
$rowCount = 1;
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)) {
    echo "<tr><td>".$rowCount++."</td>";
    echo '<td><a href=taskView.php?task_name=' . rawurlencode($row["task_name"]) . '&p_name=' . rawurlencode($row["p_name"]) . '>' . $row["task_name"] . '</a></td><td>' . $row["p_name"] . '</td><td>' . $row["t_name"] . '</td><td>' . $row["type"] . '</td><td>' . $row["assigned"] . '</td><td>';
    echo $row["status"] . '</td><td>' . $row["completion_date"] . '</td></tr>';
}
echo '</tbody></table></center>';
?>
