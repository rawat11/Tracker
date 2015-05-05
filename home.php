<?php
require_once 'session.inc.php';
require_once 'db.inc.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TRACKER</title>
        <link rel="stylesheet" href="css/jquery.dataTables.css">
        <script src="js/jquery.js" language="javascript" type="text/javascript"></script>
        <script src="js/jquery.dataTables.js" language="javascript" type="text/javascript"></script>
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
        <script class="init" language="javascript" type="text/javascript">
            $(document).ready(function () {
                $('#domainTable').DataTable();
//                $('tbody').css({'text-align' : 'center'});
            });
        </script>
    </head>
    <body onfocus="par_disable();">
        <form method="POST" enctype="multipart/form-data">
            <div class="mainwrapper">
                <?php require_once 'header.inc.php'; ?>
                <?php require 'leftPanel.inc.php'; ?>
                <div class="rightpanel">
                    <?php
                    if (strpos(strtolower($_SERVER["QUERY_STRING"]), 'p_name') !== FALSE) {
                        parse_str(($_SERVER["QUERY_STRING"]));
                        ?>
                        <ul class="breadcrumbs">
                            <li><a href="home.php"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
                            <li><Strong>Project Details &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></li> 
                            <li><strong><a <?php if ($_SESSION['role'] == 1) echo "href=\"editProject.php?p_name=$p_name\"" ?> style="cursor: pointer">Edit Project</a></strong></li>
                            <li class="right">
                                <a <?php if ($_SESSION['role'] == 1) echo 'onclick="addTeam(\'' . $p_name . '\')"'; ?> style="cursor: pointer"><i class="iconfa-trophy"></i><b>Add Team</b></a>
                            </li>
                            <li class="right">
                                <a href="" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-tint"></i> <b>Add New Task Here</b></a>
                                <?php if ($_SESSION['role'] != 3) { ?>
                                    <ul class="dropdown-menu pull-right">

                                        <li><a href="addtask.php?p_name=<?php echo $p_name; ?>&fun=true">Functional Task</a></li>
                                        <li><a href="addtask.php?p_name=<?php echo $p_name; ?>&ling=true">Linguistic Task</a></li>
                                    </ul>
                                <?php } ?>
                            </li>
                        </ul>
                    <?php } ?>
                    <div class="pageheader">
                        <?php
                        if (strpos(strtolower($_SERVER["QUERY_STRING"]), 'p_name') !== FALSE) {
                            echo '<div class="pageicon"><span class="iconfa-envelope"></span></div>';
                            echo '<div class="pagetitle"><h1>PROJECT DETAILS</h1></div>';
                        } elseif (strpos(strtolower($_SERVER["QUERY_STRING"]), 'bulkedit') !== FALSE) {
                            echo '<div class="pageicon"><span class="iconfa-key"></span></div>';
                            echo '<div class="pagetitle"><h1>BULK EDIT</h1></div>';
                        } else {
                            ?>
                            Project Name : <select id="project" name="project" onchange="getTaskTeam()">
                                <option value=''><-----></option>
                                <?php
                                $result = mysql_query("select p_name from projects");
                                while ($row = mysql_fetch_assoc($result)) {
                                    echo "<option value = '" . $row['p_name'] . "'>" . $row['p_name'] . "</option>";
                                }
                                ?>
                            </select>
                            <span id="TaskTeam">
                                Team : <input type="text" name="team">
                                Task : <input type="text" name="task">
                            </span>
                            Type : <select name="type">
                                <option value=''><-----></option>
                                <option value="Functional">Functional</option>
                                <option value="Linguistic">Linguistic</option>
                            </select>
                            Status : <select name="status">
                                <option value=''><-----></option>
                                <option value="Ready">Ready</option>
                                <option value="Blocked">Blocked</option>
                                <option value="Running">Running</option>
                                <option value="Completed">Completed</option>
                                <option value="Pending">Pending</option>
                            </select>
                            <input class='btn btn-primary' style="margin-bottom: 12px" type="submit" value="Search" name="search">
                        <?php } ?>
                    </div>
                    <div class="maincontent">
                        <div class="maincontentinner">
                            <div class="row-fluid">   
                                <br/>
                                <?php
//                	require_once 'session.inc.php';	
//                        echo '<script>alert(parent.document.URL.length)</script>';
                                if (empty($_POST)) {
                                    if (strcmp($_SERVER["QUERY_STRING"], '') == 0) {
                                        require_once 'dashBoard.php';
                                    } else if (strpos(strtolower($_SERVER["QUERY_STRING"]), 'p_name') !== FALSE) {
                                        require_once 'proDetails.php';
                                    } elseif (strpos(strtolower($_SERVER["QUERY_STRING"]), 'bulkedit') !== FALSE) {
                                        require_once 'bulkEdit.php';
                                    }
                                } else {
                                    if (isset($_POST['search'])) {
                                        require_once 'search.php';
                                    } else if (isset($_POST['bulkedit']) || isset($_POST['bulkeditDelete']) || strpos(strtolower($_SERVER["QUERY_STRING"]), 'bulkedit') !== FALSE) {
                                        require_once 'bulkEdit.php';
                                    } else if (strpos(strtolower($_SERVER["QUERY_STRING"]), 'p_name') !== FALSE) {
                                        require_once 'proDetails.php';
                                    } else {
                                        require_once 'dashBoard.php';
                                    }
                                }
//                        else if(strpos($_SERVER["QUERY_STRING"] , 'bulkedit') !== FALSE){
//                            require_once 'bulkedit.php';
//                        }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>