<?php 
function saveContactUsRequest($contactUsData) {
	include '../resources/config.php';
	$data = json_decode ( $contactUsData, true );
	
	$name = $data ['name'];
	$phone = $data ['contact_number'];
	
	$email = $data ['email'];
	$message = $data ['message'];
	
	// Inserting into contact us
	$insert_query = "INSERT INTO MJV_CONTACT_US (name,  email, contact_number, message)
												  VALUES ('$name', '$email', '$phone', '$message')";
	
	if (! mysqli_query ( $db_connect, $insert_query )) {
		echo "Error: " . mysqli_error ( $db_connect );
	} else {
		echo '{"msg":"Saved Successfully","type":1}';
	}	
	
	mysqli_close ( $db_connect );
}
?>