<div class="header">
    <div class="logo">
        <a href="home.php"><img src="images/logo1.png" alt="" /></a>
    </div>
    <div class="headerinner">
        <ul class="headmenu">
            <li class="odd">
                <a <?php if ($_SESSION['role'] == 1) { ?>href="addProject.php" <?php } ?> >
                    <span class="head-icon head-message"></span>
                    <span class="headmenu-label">Add Project</span>
                </a>

            </li>
            <li>
                <?php if ($_SESSION['role'] == 3) { ?>
                <a>
                    <span class="head-icon head-message"></span>
                    <span class="headmenu-label">Add Task</span>
                </a>
                <?php } else { ?>
                <a class="dropdown-toggle" data-toggle="dropdown" data-target="#">
                    <!--<span class="count">10</span>-->
                    <span class="head-icon head-users"></span>
                    <span class="headmenu-label">Add Task</span>
                </a>
                <ul class="dropdown-menu newusers">
                    <li class="nav-header">Select Project</li>
                    <?php
                    $query2 = "select * from projects";
                    $result2 = mysql_query($query2);
                    while ($row2 = mysql_fetch_assoc($result2)) {
                    ?>
                        <li><a href="addTask.php?p_name=<?php echo $row2["p_name"] ?>"><span class="icon-edit"></span><strong><?php echo $row2["p_name"]; ?></strong></a></li>
                    <?php } ?>
                </ul>
                <?php } ?>
            </li>
            <li>
                <a <?php if($_SESSION['role'] != 3){ echo 'onclick="passChecklist()"'; } ?> >
                    <span class="head-icon icon-edit"></span>
                    <span class="headmenu-label">Bulk Edit</span>
                </a>
            </li>
            <li class="right">
                <div class="userloggedinfo">
                    <img src="images/photos/thumb1.png" alt="" />
                    <div class="userinfo">
                        <h5><?php echo $_SESSION['user']; ?></h5>
                        <ul>
                            <li><a href="">Edit Profile</a></li>
                            <li><a href="">Account Settings</a></li>
                            <li><a href="logOut.php">Sign Out</a></li>
                            <!--li><?php echo $_SESSION['role'];?></li-->
                        </ul>
                    </div>
                </div>
            </li>
        </ul><!--headmenu-->
    </div>
</div>

