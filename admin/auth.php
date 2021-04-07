<?php
if(!(isset($_POST["Email"]) && !isset($_POST["Password"]))){
//if no values are passed from login form, return to previous page (login)
header("Location: ../index.php?e=1");
}
require_once("connect.php");
//if values are found, proceed:
$email = mysqli_real_escape_string($mysqli, $_POST["Email"]);
//convert plain password to a hash
$password = mysqli_real_escape_string($mysqli,hash("SHA256",$_POST["Password"]));
// Get current attempts
// Prepared statement
$stmt = $mysqli->prepare("SELECT Email, Attempts FROM `t_users` WHERE Email = ?");
// Put parameter into query
$stmt->bind_param("s", $email);
// Run the statement
$stmt->execute();
// Set result to this query
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $currentAttempts = $row['Attempts'];
    }
}
// Set new attempts to +1 of old value
$newAttempts = $currentAttempts + 1;
// Prepared statement
$stmt = $mysqli->prepare("UPDATE `t_users` SET `Attempts` = ? WHERE `Email` = ?");
// Put parameters into query
$stmt->bind_param("is", $newAttempts, $email);
// Run statement
$stmt->execute();
// Close statement
$stmt->close();
if($currentAttempts > 4){
    //Recapta
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
        // Build POST request:
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = '6Le7Tm4aAAAAAHXN67gA7d9ajGAUdH_g0iW_K7z0';
        $recaptcha_response = $_POST['recaptcha_response'];
        // Make and decode POST request:
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);
        // Take action based on the score returned:
        if ($recaptcha->score >= 0.5) {
            // Verified - send email
        }else{
            // Not verified - show form error
        }
    }
}
// Prepared statement
$stmt = $mysqli->prepare("SELECT * FROM `t_users` WHERE Email = ? AND Password = ?");
// Put parameter into query
$stmt->bind_param("ss", $email, $password);
// Run the statement
$stmt->execute();
// Set result to this query
$result = $stmt->get_result();
if ($result->num_rows === 1) {
    while ($row = $result->fetch_assoc()) {
         // Check access level
        $access = $row["Access"];
        $userid = $row["UID"];
        // let us log in
        session_start();
        $_SESSION["auth"] = $access;
        // Reset login attempts
        $resetAttempts = 0;
        // Prepared statement
        $stmt = $mysqli->prepare("UPDATE `t_users` SET `Attempts` = ? WHERE `t_users`.`UID` = ?");
        // Put parameters into query
        $stmt->bind_param("is", $resetAttempts, $userid);
        // Run statement
        $stmt->execute();
        // Close statement
        $stmt->close();
        echo "Record updated successfully";
        // Remember name
        $_SESSION["name"] = $row["Fname"] . " " . $row["Lname"];
        $_SESSION["userid"] = $userid;
        echo json_encode($userid);
        header("Location: index.php");
        die("Log in successful");
    }
}else {
    // if 1 is not returned, redirect to login page with e=2
    header("Location: ../index.php?e=2");
    die("Wrong information");
}

