<?php

// Do all neccessary security checks etc to make sure the user is allowed to download the file, etc..

//

$file = 'C:\xampp_5.3\htdocs\intranet_test\core\files'.DIRECTORY_SEPARATOR . '5935649105fd0.gif';
$filesize = filesize($file);
header('Content-Description: File Transfer');
header("Content-type: application/forcedownload");
header("Content-disposition: attachment; filename=\"Тестов файл.png\"");
header("Content-Transfer-Encoding: Binary");
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header("Content-length: ".$filesize);
ob_clean();
flush();
readfile("$file");
exit;