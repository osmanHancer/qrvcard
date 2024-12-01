<?php
require_once __DIR__ . '/../_config.php';


function qwput(...$args)
{
   foreach ($args as $arg) {
      if (is_object($arg) || is_array($arg) || is_resource($arg)) {
         $output = print_r($arg, true);
      } else {
         $output = (string) $arg;
      }
      fwrite(fopen('php://stdout', 'w'), $output . "\n");
   }
}

function generateRandomString($length = 10)
{
   $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $charactersLength = strlen($characters);
   $randomString = '';
   for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
   }
   return $randomString;
}
function uploadFile($id, $rnd, $file)
{
   if ($file['size'] > 4485760) return "err_file_size_max:4MB";
   array_map('unlink', glob(UPLOAD_PATH . $id. '_*')); //eskisini sil

   $yuklenecek_dosya = UPLOAD_PATH . $id . "_" . $rnd . ".jpg";
   if (!move_uploaded_file($_FILES['img']['tmp_name'], $yuklenecek_dosya))   return "err_move_uploaded_file";
   return "1";
  
}
