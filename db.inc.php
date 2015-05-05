<?php
	$server='localhost';
	$dbname='localization';
	$dbuser='root';
	$dbpasswd='';
	
	@mysql_connect($server,$dbuser,$passwd) or die('Server not available');
	@mysql_select_db($dbname) or die('Database not available');
//	echo 'DB Setup Successfully';
//        php how to check number of open mysql connections
?>