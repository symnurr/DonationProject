<?php

include("dbconnection.php");

session_start();

$donor_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$firstname = $_POST["firstname"];
	$lastname = $_POST["lastname"];
	$birthday = $_POST["birthday"];
	$jobtitle = $_POST["jobtitle"];
	$institution = $_POST["institution"];
	$email = $_POST["email"];
	$phone = $_POST["phone"];
	$psw = $_POST["password"];

	$sql = "UPDATE donor SET first_name = '$firstname', last_name = '$lastname', birthday = '$birthday',
            job_title = '$jobtitle', institution = '$institution', email = '$email', phone = '$phone', password = '$psw'
            WHERE donor_id = '$donor_id'";

	$result = $db->query($sql);

	if ($result) {
		header("Location: ../donor_profile.php");
		exit();
	} else {
		echo "Something went wrong";
		header("Location: edit_donor.php");
		exit();
	}
}

?>