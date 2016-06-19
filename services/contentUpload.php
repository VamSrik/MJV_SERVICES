<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function contentUpload(){
    include '../resources/config.php';
    
	$segment = $data['segment'];
	$subject = $data['subject'];
	$description = $data['description'];
	$fileToUpload = $data['fileToUpload'];
	
	//var_dump($data);
	//Inserting user profile
	$insert_query = 'INSERT INTO mjv_user_profile (first_name,last_name,email,id_proof,profession,contact_number) VALUES ("'.$name.'","'.$name.'","'.$email.'","'.$id_proof.'","'.$profession.'","'.$contact_number.'")';
	echo $insert_query;	
	if(! mysqli_query($db_connect, $insert_query)) {
    	echo "Error: " . mysqli_error($db_connect);
	}
}