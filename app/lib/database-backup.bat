@ECHO OFF

set TIMESTAMP=%DATE:~10,4%%DATE:~4,2%%DATE:~7,2%

"C:\xampp\mysql\bin\mysqldump.exe" -uroot -hlocalhost --databases tsis_db > "C:\xampp\htdocs\tsis\database_back_up\backup_db_%date:~-10,2%-%date:~-7,2%-%date:~-4,4%.sql"