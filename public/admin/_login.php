<?php
require_once __DIR__.'/../_config.php';
$realm = mt_rand(1, 1000000000) . "@qrsolid";
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    //ilk logini tespit etme süreye göre oturumu sonlandırabilmek için.
    setcookie("AUTH_FIRST", TRUE, time() + 50);
    // If no username provided, present the auth challenge.
    header('WWW-Authenticate: Basic realm="' . $realm . '"');
    // User will be presented with the username/password prompt
    // If they hit cancel, they will see this access denied message.
    error();
}



// If we get here, username was provided. Check password.
if ($_SERVER['PHP_AUTH_USER'] == ADMIN_USER && $_SERVER['PHP_AUTH_PW'] == ADMIN_PASS) {

    
    //ilk giriş değilse ve oturum süresi dolmuşsa (cookie expire).
    if (!isset($_COOKIE["AUTH_FIRST"]) && !isset($_COOKIE['AUTH_EXPIRE'])) {
        error();
    }

    // ilk giriş bayrağını öldürmek
    if ($_COOKIE["AUTH_FIRST"]) {
        // echo "set edildi".$_COOKIE['AUTH_EXPIRE']."_".time();
       
        setcookie("AUTH_FIRST", null, time() - 20);
    } 
    
    //her başarılı girişte süreyi uzat
    setcookie("AUTH_EXPIRE", "qrsolid", time() + 2000);
} 
else {
    error();
}

function error()
{
    header('HTTP/1.0 401 Unauthorized');
    exit('<p>Access denied!</p> Please refresh page for try login');
    setcookie("AUTH_FIRST", null, time() - 20);
    setcookie("AUTH_EXPIRE", null, time() - 20);
   
}

