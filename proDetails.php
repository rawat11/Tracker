<?php
require_once 'logFile.php';
parse_str(rawurldecode($_SERVER["QUERY_STRING"]));
$uploadedStatus = 0;
$err = '';
if (isset($_POST['upload'])) {
    $uploadedStatus = 1;
    if (isset($_FILES["file"])) {
        if ($_FILES["file"]["error"] > 0) {
            $err = "Return Code: " . $_FILES["file"]["error"] . "<br />";
        } else {
            $allowed = array('xls', 'xlsx');
            $filename = $_FILES['file']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {
                $uploadedStatus = 2;
            }
            else {
                if (file_exists($_FILES["file"]["name"])) {
                    unlink($_FILES["file"]["name"]);
                }
//            $storage = $_SERVER['DOCUMENT_ROOT'] . '/LocTool/log/'. rawurldecode($p_name) ;
                $storage = 'log/' . rawurldecode($p_name);
//            echo $_SERVER['DOCUMENT_ROOT'];
//            echo $storage;
//            echo '*******************'.file_exists(dirname($storage)) . '************';
//            if(file_exists(dirname($storage)) == 'TRUE')
//                echo 'file exists';
//            else
//                echo 'file does not exist';
                /* Absolute Path !!!! Find Another Way */
                $storage .= '/' . $_FILES["file"]["name"];
                move_uploaded_file($_FILES["file"]["tmp_name"], $storage);
                $query = "update projects set file='" . $_FILES["file"]["name"] . "' where p_name='" . $p_name . "'";
                $result = mysql_query($query);
                if ($result) {
                    $data = "file='" . $_FILES["file"]["name"] . "' where p_name='" . $p_name . "'";
                    createlog("File Upload" , $data);
                    $uploadedStatus = 3;
                }
            }
        }
    } else {
        echo "No file selected <br />";
    }
}
$query = "select * from projects where p_name='" . $p_name . "'";
$result = mysql_query($query);
if ($row = mysql_fetch_assoc($result)) {
    echo '<div style=\'float: left\'>';
    echo 'Project Name : ' . $row["p_name"] . '<br>';
    echo 'Description : ' . $row["description"] . '<br>';
    echo 'Start Date : ' . $row["start_date"] . '<br>';
    echo 'Release Date : ' . $row["release_date"] . '</br>';
    echo 'OT Matrix : <a href="download.php?file_name=' . rawurlencode($p_name) . '/' . rawurlencode($row["file"]) . '">' . $row["file"] . '</a></br>';
    echo '<input type="file" name="file" id="file" /><input type="submit" class=\'btn btn-primary\' name="upload" value="Upload New" />&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:red">';
    if ($uploadedStatus == 1)
        echo 'File not Uploaded - ' . $err;
    else if ($uploadedStatus == 3)
        echo 'File Uploaded Successfully<br>';
    else if ($uploadedStatus == 2)
        echo 'Upload xls/xlsx Files only';
    echo '</span></div><div style = \'float:right;margin-right : 300px\'><table class="table table-bordered responsive">';
    echo '<tr><th>Rendering engine</th><th>Team</th><th>Lead</th>';
    if ($_SESSION['role'] == 1) {
        echo '<th></th>';
    }
    echo '</tr>';
    $query = "select * from teams where p_name='" . $p_name . "'";
    $result = mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
        echo "<tr><td>#</td><td>" . $row['t_name'] . "</td><td>" . $row['lead'] . "</td>";
        if ($_SESSION['role'] == 1) {
            echo "<td><span class='icon-trash' style='cursor : pointer' onclick=delTeam('" . $row['team_id'] . "','" . rawurlencode($p_name) . "') ></span></td>";
        }
        echo "</tr>";
    }
    echo '</table></div><table id=\'domainTable\' class=\'display dataTable\' border=0 style=\'width : 90% ;margin-top: 2%\'>';
    echo '<thead><tr style="text-align:left"><th>#</th><th>Task Name</th><th>Task Type</th><th>Status</th><th>Efforts</th><th>Assigned</th><th>Last Modified</th></tr></thead>';
    $query = "select * from task where p_name='" . $p_name . "'";
    $result = mysql_query($query);
    $rowCount = 1;
    while ($row = mysql_fetch_assoc($result)) {
        echo '<tbody><tr><td>' . $rowCount++ . '</td><td><a href=taskView.php?task_name=' . rawurlencode($row["task_name"]) . '&p_name=' . rawurlencode($row["p_name"]) . '>' . $row["task_name"] . '</a></td><td>' . $row["type"] . '</td><td>' . $row["status"] . '</td><td>'
        . $row["efforts"] . '</td><td>' . $row["assigned"] . '</td><td>' . $row["modified_date"] . '</td></tr></tbody>';
    }
    echo '</table>';
}
?>