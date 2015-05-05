<?php
parse_str(rawurldecode($_SERVER["QUERY_STRING"]));
$file = "log\\" . $file_name;
basename($file);
if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
echo 'Please Try Again Later';
?>