<?php
// Connection to db
$db_server = "remote.ac";
$db_user = "WS269058_wad";
$db_password = "Btdy02@4";
$db_database ="WS269058_wad";
$mysqli = new mysqli($db_server,$db_user,$db_password,$db_database);

if($mysqli->connect_error) {
  exit('Error connecting to database');
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli->set_charset("utf8mb4");