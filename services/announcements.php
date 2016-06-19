<?php
/**
 * Saves announcements.
 * @param JSON $inputJson
 */


function saveAnnouncement($data){
     
     $data = json_decode($data,true);
     include '../resources/config.php';
     
     /* $headers = apache_request_headers(); 
     $token_value = $headers['Authorization'];
     $query = "SELECT * FROM MJV_TOKEN INNER JOIN MJV_USER_TO_ROLE ON MJV_TOKEN.user_id = MJV_USER_TO_ROLE.user_id WHERE MJV_TOKEN.token_string='$token_value'";
     $user_id = mysqli_query($db_connect, $query);
     
     if($user_id) {
     	$userId_assoc = mysqli_fetch_assoc($user_id);
     	$userId = $userId_assoc['user_id'];
     } */
     
     $userId = 7;
        
        $title = $data['title'];
		$description = $data['description'];
		$contacts_list= json_encode($data['contacts_list'], true);
		
		
		if(isset($data['public']) && "true" == $data['public']) {
			$public = 'Y';
		} else {
			$public = 'N';
		}
				
		//Inserting announcement
		$insert_query = "INSERT INTO MJV_ANNOUNCEMENTS (title, description, contacts_list, public, created_by, created_date, last_updated_by, last_updated_date)
		VALUES ('$title','$description', '$contacts_list', '$public', '$userId', NOW(), '$userId', NOW())";
		
		if(! mysqli_query($db_connect, $insert_query)) {
			echo "Error: " . mysqli_error($db_connect);
		} else {
            echo '{"msg":"Announcement saved successfully","type":1}';
        }
}

function editAnnouncement($data){
	 
	$data = json_decode($data,true);
	include '../resources/config.php';
	 
	/* $headers = apache_request_headers();
	$token_value = $headers['Authorization'];
	$query = "SELECT * FROM MJV_TOKEN INNER JOIN MJV_USER_TO_ROLE ON MJV_TOKEN.user_id = MJV_USER_TO_ROLE.user_id WHERE MJV_TOKEN.token_string='$token_value'";
	$user_id = mysqli_query($db_connect, $query);
	 
	if($user_id) {
		$userId_assoc = mysqli_fetch_assoc($user_id);
		$userId = $userId_assoc['user_id'];
	} */
	 
	$userId = 7;
	$id = $data['id'];
	$title = $data['title'];
	$description = $data['description'];
	$contacts_list= json_encode($data['contacts_list']);


	if("true" == $data['public']) {
		$public = 'Y';
	} else {
		$public = 'N';
	}
	
	$last_updated_by = $data['last_updated_by'];

	$update_query = "UPDATE MJV_ANNOUNCEMENTS  SET title = '".$title."',
												   description = '".$description."',
												   contacts_list = '".$contacts_list."',
												   public = '".$public."',
												   last_updated_by  = '".$userId."',
												   last_updated_date = NOW()
												   WHERE id = '".$id."'";
	
	if(! mysqli_query($db_connect, $update_query)) {
		echo "Error: " . mysqli_error($db_connect);
	} else {
		echo '{"msg":"Announcement updated successfully","type":1}';
	}
}

function loadAllAnnouncements(){
            
		
        include '../resources/config.php';
		$load_announcements_query = "SELECT * FROM MJV_ANNOUNCEMENTS ORDER BY created_date DESC";
	
		$resultArray = array ();
		$result = mysqli_query($db_connect, $load_announcements_query);
	
		if($result) {
			while ( $announcement = mysqli_fetch_assoc($result)) {
				$contacts_list = json_decode($announcement['contacts_list'], true);
				$announcement['contacts_list'] = $contacts_list;
				$resultArray [] = $announcement;
			}
	
			//var_dump($resultArray);
		header('Content-type: application/json');
		return json_encode($resultArray, true);
	
		} else {
			echo "Error: " . mysqli_error($db_connect);
		}
        mysqli_close($db_connect);
}

function loadPublicAnnouncements(){


	include '../resources/config.php';
	$load_announcements_query = "SELECT * FROM MJV_ANNOUNCEMENTS WHERE public = 'Y' ORDER BY last_updated_date DESC";

	$resultArray = array ();
	$result = mysqli_query($db_connect, $load_announcements_query);

	if($result) {
		while ( $announcement = mysqli_fetch_assoc($result)) {
			$resultArray [] = $announcement;
		}

		//var_dump($resultArray);
		header('Content-type: application/json');
		echo json_encode($resultArray, true);

	} else {
		echo "Error: " . mysqli_error($db_connect);
	}
	mysqli_close($db_connect);
}

function loadInternalAnnouncements(){


	include '../resources/config.php';
	$load_announcements_query = "SELECT * FROM MJV_ANNOUNCEMENTS WHERE public = 'N' ORDER BY created_date DESC";

	$resultArray = array ();
	$result = mysqli_query($db_connect, $load_announcements_query);

	if($result) {
		while ( $announcement = mysqli_fetch_assoc($result)) {
			$resultArray [] = $announcement;
		}

		//var_dump($resultArray);
		header('Content-type: application/json');
		echo json_encode($resultArray, true);

	} else {
		echo "Error: " . mysqli_error($db_connect);
	}
	mysqli_close($db_connect);
}

function deleteAnnouncement($data) {
	
	include '../resources/config.php';
	$id = $data;	
	
	$delete_query = "DELETE FROM MJV_ANNOUNCEMENTS WHERE id = " . '" .$id. "';
	
		if(! mysqli_query($db_connect, $delete_query)) {
			echo "Error: " . mysqli_error($db_connect);
		} else {
            echo '{"msg":"Announcement deleted successfully","type":1}';
        }
        
	mysqli_close($db_connect);
	
	
}
        
        
?>