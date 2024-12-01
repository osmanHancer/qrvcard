<?php
require_once __DIR__ . "/helper/helper.php";
require_once __DIR__ . '/helper/dbC.php';


$userid = null;
if (!count($_GET) > 0) exit("404: Eksik parametre");
foreach ($_GET as $key => $value) {
    $userid = $key;
    $userpass = $value;
    break;
}

if (strlen($userid) < 10)
    exit("404: Yanlış parametre");

$idd = explode("_", $userid);
if (!isset($idd[1]) || strlen($idd[1]) < 4)
    exit("404: Garip parametre");

$user = dbC::getDB()->one("SELECT * FROM users WHERE id=:id and rand=:rand LIMIT 1", [
    'id' => $idd[0],
    'rand' => $idd[1],
]);

if (!isset($user["rand"]))
    exit("404: Kullanıcı yok");


if (strlen($userpass) > 0) {
    if ( strlen($user['passw'])>3 && $userpass == $user['passw']) {
        require __DIR__ . '/_editv.phtml';
        exit();
    } else exit("401: geçiş yok");
} else {
    unset($user['passw']);
    require __DIR__ . '/_vcard.phtml';
    exit();
}
