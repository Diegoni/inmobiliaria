@ECHO OFF

wget localhost/inmobiliaria/index.php/cuotas/actualizar/
DEL index.html
cd C:\xampp\mysql\bin
set aa=%date:~6,4%
set mm=%date:~3,2%
set dd=%date:~0,2%
mysqldump -u root -p --password= --databases inmobiliaria > C:\sql\inmobiliaria_%aa%.%mm%.%dd%.sql