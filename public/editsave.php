
<?php
require __DIR__ . '/helper/dbC.php';
require __DIR__ . '/helper/helper.php';


if (!isset($_POST["id"]) || !strlen($_POST["passw"]) > 3) exit("-7");

$db = dbC::getDB();
$user = $db->one("SELECT * FROM users WHERE id=:id and passw=:passw LIMIT 1", [
    'id' => $_POST["id"],
    'passw' => $_POST["passw"],
]);

if (!isset($user['id']))  exit("-8");

$isDeleteImg = isset($_POST['_img']) && $_POST['_img'] == '-1';
if ($isDeleteImg) {
    array_map('unlink', glob(UPLOAD_PATH . $_POST["id"] . '_*'));
}

$rnd = $user["rand"];
unset($_POST["rand"]);
unset($_POST["passw"]);
$fields = dbc::getSetFields($_POST);
$data = $db->set("
    UPDATE users SET $fields
    WHERE id=:id ;  
    ", $_POST);


if (isset($_FILES['img']) && isset($_POST['id'])) {
    echo uploadFile($_POST["id"], $rnd, $_FILES['img']);
}

echo $data["ar"] ?? -9;
