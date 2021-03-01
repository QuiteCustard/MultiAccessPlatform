
<?php
// Logger to record attempted logins
if(isset($email))
{
   $username = $email; 
}
else
{
    $username = "undefined";
}
$time = date("d/m/y H:i");
$ip = $_SERVER["REMOTE_ADDR"];

if(isset($_GET["e"])){
    if($_GET["e"]=="1")
    {
        $error = "No username or password entered";
    }
    else if ($_GET["e"]=="2")
    {
        $error = "Wrong information";
    }
    else if ($_GET["e"]=="3")
    {
        $error = "Trying to enter page you don't have permission for / Insecure";
    }
    else if ($_GET["e"]=="4")
    {
        $error = "Logged out";
    }
}     

$line = $time." IP:".$ip." User:".$username." Error:".$error."\r\n";
echo $line;

$file = "../errorlog.txt";
$log = fopen($file,"a+") or die("Unable to open error log");
fwrite($log,$line) or die("unable to write to file");
fclose($log);
?>