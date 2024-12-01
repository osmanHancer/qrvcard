<?php
define('ADMIN_USER', 'solid');
define('ADMIN_PASS', 'OPOPklkl');

$PORTAL_COMPANY = 'Solid Electron';
$PORTAL_HOST = 'solidelectron.com';

define('SUB_PATH',"/q");
define('PUBLIC_PATH', __DIR__.'/');
define('UPLOAD_PATH', PUBLIC_PATH . '_uploads/');
define('DB_PATH', PUBLIC_PATH . 'users.sqlite3');


define('HOST_URL', ($_SERVER['HTTP_HOST'] === $PORTAL_HOST ? "https://$_SERVER[HTTP_HOST]".SUB_PATH : "http://$_SERVER[HTTP_HOST]"));

$PORTAL_URL = "https://$PORTAL_HOST".SUB_PATH.'/';
// $QRAPI_URL = "https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=$PORTAL_URL?{code}"; //dead
// $QRAPI_URL = "https://quickchart.io/qr?size=500&margin=2&text=$PORTAL_URL?{code}"; // Alternative
$QRAPI_URL = "https://api.qrserver.com/v1/create-qr-code/?size=500x500&margin=18&data=$PORTAL_URL?{code}"; // Alternative

$USER_FIELDS = [
"id" => "INT",
"rand" => "TEXT",
"passw"=> "TEXT",
"name"=> "TEXT",
"img"=> "IMG",
"job"=> "TEXT",
"tel"=> "TEXT",
"email"=> "TEXT",
"company" =>"TEXT",
"website" => "TEXT",
"logo"=> "TEXT",
"address" =>"TEXT",
"note" => "TEXT",
"note_date" =>"TEXT",
"state" => "INT",
];
