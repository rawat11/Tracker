<?php
require_once 'session.inc.php';
require_once 'db.inc.php';
?>
<html>
    <head>
        <title>Bulk Edit</title>
        <link rel="stylesheet" href="css/jquery.dataTables.css">
        <script src="js/jquery.js" language="javascript" type="text/javascript"></script>
        <script src="js/jquery.dataTables.js" language="javascript" type="text/javascript"></script>
        <link rel="stylesheet" href="css/style.default.css" type="text/css" />
        <link type="text/css" href="styles/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
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
                $('#domainTable').DataTable({
                    "paging": false,
                    "ordering": true,
                    "info" : false,
                });
                $('.dataTables_filter').css({position:'relative'});
            });
        </script>
    </head>
    <body style="background: none; background-color: black;">
        <form class="stdform stdform2" name="proPopUP">
            <div class="maincontent">
                <div class="maincontentinner">
                    <div class="widgetbox box-inverse">
                        <h4 class="widgettitle">Select Projects
                            <button style="float:right;margin-top: -5px" type="button" class="btn btn-primary" onclick="getPro()" value="EDIT">EDIT</button>
                        </h4>
                        <div class="widgetcontent nopadding">
                            <table class="display dataTable" id="domainTable">
                                <thead><tr><th>#</th></tr></thead>
                                <tbody>
                                    <?php
                                    $query = "select p_name from projects";
                                    $result = mysql_query($query);
                                    while ($row = mysql_fetch_array($result)) {
                                        echo "<tr><td><label><input type='checkbox' name='check_list' value='" . rawurlencode($row[0]) . "'>" . $row[0] . "</label></td></tr>";
//                                echo "<p><label style='float:left;width: 10px'><input type='checkbox' name='check_list' value='" . rawurlencode($row[0]) . "'></label><span class='field' style='margin-left: 110px'>" . $row[0] . "</span></p>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>