<?php

include_once("dbconnection.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
}

$sql = "SELECT * FROM recipient WHERE email = '$email' AND password = '$password'";
$result = $db->query($sql);

if ($result) {
    $row = $result->fetch_assoc();

    $_SESSION["user_id"] = $row["recipient_id"];

    header("Location: ../recipient.php");
    exit();
} else {
    header("Location: ../account.html");
    exit();
}
