# Vcard

## start  docker
- docker compose up
- open browser: http://localhost:8803/admin/

## start2  php builtin server 
- php82 -S 0.0.0.0:8803 -t ./public
- open browser: http://localhost:8803/admin/

## start apache & php or nginx php 
 point to share ./public folder.

##  admin password and other conf
look ./public/_config.php
