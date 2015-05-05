<?php
require_once 'session.inc.php';
require_once 'db.inc.php';
parse_str(rawurldecode($_SERVER["QUERY_STRING"]));
?>
<html>
    <head>
        <title>Add Team</title>
        <script src="js/jquery.js" language="javascript" type="text/javascript"></script>
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
    </head>
    <body style="background: none; background-color: black;">
        <form class='stdform stdform2' name="addTeam" id="addTeam">
            <div class="maincontent">
                <div class="maincontentinner">
                    <div class="widgetbox box-inverse">
                        <h4 class="widgettitle">Team Details<input style="float:right" type="button" class="btn btn-primary" value="Add" onclick="addTeamValidation()"></h4>
                        <div class="widgetcontent nopadding">
                            <input type="hidden" value="<?php echo $p_name; ?>" id="p_name" >
                            <div id="msgdiv"><h4></h4></div>
                            <!--<table class="table table-bordered responsive">-->
<!--                                <tr><td><label>Team Name</label></td><td><input type="text" id="team_name" name="team_name"></td></tr>
                                <tr><td><label>IQE</label></td><td><input type="text" id="iqe" name="iqe"></td></tr>
                                <tr><td><input type="button" class="btn btn-primary" value="Add Team" onclick="addTeamValidation()"></td></tr>-->
                            <!--</table>-->
                            <p>
                                <label style='float:left;width: 75px'>Team Name</label><span class="field" style='margin-left: 100px'><input type="text" id="team_name" name="team_name"></span>
                            </p>
                            <p>
                                <label style='float:left;width: 75px'>IQE</label><span class="field" style='margin-left: 100px'><input type="text" id="iqe" name="iqe"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>