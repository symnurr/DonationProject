<?php

include_once("dbconnection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	session_start();
	if (!isset($_SESSION["user_id"])) 
	{
	    header("Location: account.html");
	    exit();
	}

	$event_id = $_POST["event_id"];
	$user_id = $_SESSION["user_id"];

	$sql = "INSERT INTO donor_event (donor_id, event_id) VALUES ('$user_id', '$event_id')";

	$result = $db->query($sql);

	if ($result) {
		header("Location: ../donor_profile.php");
		exit();
	} else {
		echo "Something went wrong";
		header("Location: ../events.php");
		exit();
	}
}
