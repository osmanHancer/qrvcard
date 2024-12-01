<?php
require_once __DIR__ . "/_login.php";
require __DIR__ . '/../helper/helper.php';
require __DIR__ . '/../helper/dbC.php';


$action = $_POST["_action"];

$db = dbC::getDB();

if ($action == "delete") { //delete
    $data = $db->set("
        DELETE FROM users WHERE id=:id 
        ", [
        'id' => $_POST["id"],
    ]);
    if (isset($data['ar'])) {
        array_map('unlink', glob(UPLOAD_PATH . $_POST["id"] . '_*'));
    }
} elseif (isset($_POST["id"])) { //update
    $isDeleteImg = isset($_POST['_img']) && $_POST['_img'] == '-1';
    if ($isDeleteImg) {
        array_map('unlink', glob(UPLOAD_PATH . $_POST["id"] . '_*'));
    }

    if (!strlen($_POST["passw"]) > 1) $_POST["passw"] = generateRandomString(12);
    $rnd = $_POST["rand"];
    unset($_POST["rand"]);
    $fields = dbc::getSetFields($_POST);
    $data = $db->set("
        UPDATE users SET  $fields
        WHERE id=:id ;  
", $_POST);
} else { //insert

    $rnd = generateRandomString(10);
    $_POST["passw"] = generateRandomString(12);
    $_POST["rand"] = $rnd;
    $fields = dbc::getInsertFields($_POST);
    $data = $db->set("
        INSERT INTO users$fields
    ", $_POST);
    $_POST["id"] = $data["li"];
}

if (isset($_FILES['img']) && isset($_POST['id'])) {
    echo uploadFile($_POST["id"], $rnd, $_FILES['img']);
}

echo $data["ar"] ?? -9;


//  $url = 'blob:https://web.whatsapp.com/b4f7b391-e7c1-4618-a998-0a0d56583583';


// $sorgu = $my_conn->query("SELECT * FROM student WHERE id=1");
// $cikti = $sorgu->fetch(PDO::FETCH_ASSOC);
// echo "<br />".$cikti["id"];
// https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=https://solidelectron.com/q/?1_S6Nz1QJDiz