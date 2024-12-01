<?php

$uploadpath = __DIR__ . "/_uploads/";
if (!count($_GET) > 0) {
    $impath = $uploadpath . 'default.jpg';
} else {

    foreach ($_GET as $key => $value) {
        $usercode = $key;
        break;
    }
    $impath = $uploadpath . $usercode . '.jpg';
    if (!file_exists($impath)) {
        $impath = $uploadpath . 'default.jpg';
    }
}

$imginfo = getimagesize($impath);
header("Content-type: " . $imginfo['mime']);
header("Cache-Control: max-age=2628000, public"); //1month cache
readfile($impath);
