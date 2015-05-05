<div class="leftpanel">
    <div class="leftmenu">        
        <ul class="nav nav-tabs nav-stacked">
            <li class="nav-header" style="font-size:18"><b>PROJECTS</b></li>
                <?php
                $query = "select p_name from projects";
                $result = mysql_query($query);
                while ($row = mysql_fetch_array($result)) {
                    echo "<li style='word-wrap: break-word'><a href=home.php?p_name=" . rawurlencode($row[0]) . ">" . $row[0] . "</a></li>";
                }
                ?>
        </ul>
    </div><!--leftmenu-->
</div><!-- leftpanel -->
