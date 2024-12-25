<?php

include_once("dbconnection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$firstname = $_POST["firstname"];
	$lastname = $_POST["lastname"];
	$birthday = $_POST["birthday"];
	$jobtitle = $_POST["jobtitle"];
	$institution = $_POST["institution"];
	$email = $_POST["email"];
	$phone = $_POST["phone"];
	$psw = $_POST["password"];

	$sql = "INSERT INTO donor (first_name, last_name, birthday, job_title, institution, email, phone, password) 
	    VALUES ('$firstname', '$lastname', '$birthday', '$jobtitle', '$institution', '$email', '$phone', '$psw')";

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
