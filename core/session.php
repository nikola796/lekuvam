<?php
$https = false;
if(isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] != 'off') {
    $https = true;
}
$dirname = rtrim(dirname($_SERVER['PHP_SELF']), '/').'/';
session_name('test');
session_set_cookie_params(0, $dirname, '', $https, true);
session_start();