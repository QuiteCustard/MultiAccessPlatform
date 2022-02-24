<?php
// Connection to db
$db_server = "hidden";
$db_user = "hidden";
$db_password = "hidden";
$db_database ="hidden";
$mysqli = new mysqli($db_server,$db_user,$db_password,$db_database);

if($mysqli->connect_error) {
  exit('Error connecting to database');
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli->set_charset("utf8mb4");
