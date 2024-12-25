<?php

include_once("dbconnection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$institution = $_POST["institution"];
	$foundingdate = $_POST["foundingdate"];
	$purpose = $_POST["purpose"];
	$email = $_POST["email"];
	$phone = $_POST["phone"];
	$psw = $_POST["password"];

	$sql = "INSERT INTO recipient (institution_name, founding_date, purpose, email, phone, password) 
	    VALUES ('$institution', '$foundingdate', '$purpose', '$email', '$phone', '$psw')";

	$result = $db->query($sql);

	if ($result) {
		header("Location: ../account.html");
		exit();
	} else {
		echo "Something went wrong";
		header("Location: ../account.html");
		exit();
	}
}
