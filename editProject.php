<?php
require_once 'session.inc.php';
require_once 'db.inc.php';
require_once 'logFile.php';
$val = '';
parse_str(rawurldecode($_SERVER["QUERY_STRING"]));
if (isset($_POST['submit'])) {
    $description = $_POST['description'];
    $sdate = $_POST['sdate'];
    $rdate = $_POST['rdate'];
    $sdate = date('Y-m-d', strtotime($sdate));
    $rdate = date('Y-m-d', strtotime($rdate));
    $query = "update projects set start_date = '" . $sdate . "',release_date = '" . $rdate . "' ,description = '" . $description . "' where p_name = '" . $p_name . "'";
    if (mysql_query($query) == 1) {
        header('Location: home.php?p_name=' . $p_name);
        exit();
    } else {
        $val = 'Error : ' . mysql_error();
    }
} else if (isset($_POST['cancel'])) {
    $data = "start_date = '" . $sdate . "',release_date = '" . $rdate . "' ,description = '" . $description . "' where p_name = '" . $p_name . "'";
    createlog("Update Project" , $data);
    header('Location: home.php?p_name=' . $p_name);
    exit();
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Tracker</title>
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
        <div class="mainwrapper">
            <?php require 'header.inc.php'; ?>
            <?php require 'leftPanel.inc.php'; ?> <!--For LeftPanel Section-->
            <div class="rightpanel">
                <?php
                $query = "select * from projects where p_name='" . $p_name . "'";
                $result = mysql_query($query);
                if ($row = mysql_fetch_assoc($result)) {
                    ?>
                    <div class="pageheader">
                        <div class="pageicon"><span class="iconfa-laptop"></span></div>
                        <div class="pagetitle">
                            <h1>Edit Project</h1>
                        </div>
                    </div><!--pageheader-->
                    <div class="maincontent">
                        <div class="maincontentinner">
                            <div class="widgetbox box-inverse">
                                <h4 class="widgettitle">Edit Project</h4>
                                <div class="widgetcontent nopadding">
                                    <form class="stdform stdform2" method="post" action="home.php?p_name=<?php echo $p_name ?>" enctype="multipart/form-data" onsubmit="return validatepro('<?php echo $p_name ?>')">
                                        <div style="color: red;text-align: left" id="msgdiv"><?php echo $val; ?></div>
                                        <p>
                                            <label>Project Name</label>
                                            <span class="field input-xxlarge"><?php echo $p_name; ?></span>
                                        </p>
                                        <div class="par">
                                            <p>
                                                <label>Start Date<small><i>(yy-mm-dd)</i></small></label>
                                                <span class="field"><input id="datepicker1" type="text" name="sdate" class="input-small" value="<?php echo $row['start_date']; ?>" readonly /><a id="strtCal" class="iconfa-calendar" style="cursor: pointer"></a></span>
                                            </p>
                                        </div>
                                        <div class="par">
                                            <p>
                                                <label>Release Date<small><i>(yy-mm-dd)</i></small></label>
                                                <span class="field"><input id="datepicker2" type="text" name="rdate" class="input-small" value="<?php echo $row['release_date']; ?>" readonly /><a id="relCal" class="iconfa-calendar" style="cursor: pointer"></a></span>
                                            </p>
                                        </div>
                                        <p>
                                            <label>Description <small>You can put your own description for this field here.</small></label>
                                            <span class="field"><textarea cols="80" rows="5" name="description" id="location2" class="span5"><?php echo $row['description']; ?></textarea></span>
                                        </p>
                                        <p class="stdformbutton">
                                            <button type="submit" name="submit" class="btn btn-primary">Update Project</button>
                                            <button type="submit" name="cancel" id="cancel" value="cancel" onclick="clicked()" class="btn" style="float:right">Cancel</button>
                                        </p>
                                    </form>
                                </div><!--widgetcontent-->
                            </div><!--widget-->
                        </div>
                    </div>
                <?php } else echo 'Inconsistent Data !!!'; ?>
            </div>
        </div>
    </body>
</html>
