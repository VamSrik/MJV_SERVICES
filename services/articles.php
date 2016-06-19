<?php
/**
 * Saves article details into database.
 * @param JSON $inputJson
 */


function cotentUpload($data){
     $headers = apache_request_headers();
   // var_dump($headers);
   // $get = json_decode($get,true);
    //var_dump($get);
     $data = json_decode($data,true);
     include '../resources/config.php';
     $token_value = $headers['Authorization'];
     //var_dump($token_value);
		$query = "SELECT * FROM MJV_TOKEN INNER JOIN MJV_USER_TO_ROLE ON MJV_TOKEN.user_id = MJV_USER_TO_ROLE.user_id WHERE MJV_TOKEN.token_string='$token_value'";
		$user_id = mysqli_query($db_connect, $query);
		if($user_id) {
                    $userId_assoc = mysqli_fetch_assoc($user_id);
                   // var_dump($userId_assoc);
                      //header('Content-type: application/json');
                   
	$status =1;
	if($userId_assoc['role_id'] == 1) {
		$status = 4;
	}
        
        $title = $data['title'];
		$portal_type = $data['portal_type'];
		$created_by = $data['created_by'];
		$last_updated_by = $data['last_updated_by'];
		$content = $data['content'];
                $user_id = $userId_assoc['user_id'];
                $attachments = json_encode($data['files']);
		//$attachments = $data['attachments'];
				
		//Inserting user profile
		$insert_query = "INSERT INTO MJV_ARTICLE (portal_type, title, created_by, created_date, last_updated_by, last_updated_date, status, content, attachments)
		VALUES ('$portal_type','$title', '$user_id', NOW(), '$user_id', NOW(), '$status','$content','$attachments' )";
		//echo $insert_query;
		if(! mysqli_query($db_connect, $insert_query)) {
			echo "Error: " . mysqli_error($db_connect);
		}
                else{
                    echo '{"msg":"Created Successfully","type":1}';
                }
                }
	
		//get the employee details
		

}
function loadAllUploadContent($inputJson){
            
		//Fetch all service requests
            include '../resources/config.php';
		$fetch_all_srs_query = "SELECT * FROM MJV_ARTICLE ORDER BY created_date DESC";
	
		$resultArray = array ();
		$result = mysqli_query($db_connect, $fetch_all_srs_query);
	
		if($result) {
			while ( $service_request = mysqli_fetch_assoc($result)) {
				$resultArray [] = $service_request;
			}
	
			//var_dump($resultArray);
	header('Content-type: application/json');
			echo json_encode($resultArray, true);
	
		} else {
			echo "Error: " . mysqli_error($db_connect);
		}
                mysqli_close($db_connect);
        }

        
        function editUploadContent($data){
            	
		//edit service request details
            $data = json_decode($data,true);
		include '../resources/config.php';
                
		$sr_number = $data['id'];
		 $title = $data['title'];
		$description = $data['content'];
		
		//$requestor_name = $data['requestor_name'];
		//$requestor_email = $data['requestor_email'];
		//$requestor_contact = $data['requestor_contact'];		
		//$requestor_address = $data['requestor_address'];
						
		//$severity = $data['severity'];
		//$priority = $data['priority'];		
		$status = $data['status'];
		
		$portal_type = $data['portal_type'];
			
		//$attachments = $data['attachments'];
		
		//Updating service requests
		$update_query = "UPDATE MJV_ARTICLE  SET title = '".$title."',content = '".$description."',status = '".$status."',portal_type = '".$portal_type."', 
														
														last_updated_date = NOW()WHERE id = '".$sr_number."'";
														//attachments = '$attachments'";
		
//		if(isset($data['assigned_to_user_id'])) {
//			$assigned_to_user_id = $data['assigned_to_user_id'];
//			$update_query .= ", assigned_to_user_id = '$assigned_to_user_id'";
//		}
//		
//		if(isset($data['approver_user_id'])) {
//			$approver_user_id = $data['approver_user_id'];
//			$update_query .= ", approver_user_id = '$approver_user_id'";
//		}
		
		//$update_query .= " WHERE sr_number = '$sr_number'";	
		  $update_query;
		if(! mysqli_query($db_connect, $update_query)) {
			echo "Error: " . mysqli_error($db_connect);
		}
                else
                {
                echo '{"msg":"Saved Successfully","type":1}';
                }
	
	mysqli_close($db_connect);
        }
 
//if($_SERVER['REQUEST_METHOD'] == "POST") {
//	//convert json object to php associative array
//	
//	}
//	
//	$editArticle = isset($_GET['editArticle']);
//	
//	if($editArticle) {
//		
//		//get the employee details
//		$title = $data['title'];
//		$portal_type = $data['portal_type'];
//		$last_updated_by = $data['last_updated_by'];
//		$content = $data['content'];
//		$attachments = $data['attachments'];
//		$article_id = $data['article_id'];
//		
//		//updating article
//		$update_query = "UPDATE MJV_ARTICLE SET portal_type = '$portal_type', title = '$title', last_updated_date = NOW(), last_updated_by = '$last_updated_by',
//		content =  '$content', attachments = '$attachments', status = '$status'
//		WHERE id = $article_id";
//	
//		echo $update_query;
//		if(! mysqli_query($db_connect, $update_query)) {
//			echo "Error: " . mysqli_error($db_connect);
//		}
//	}	
//	
//	mysqli_close($db_connect);
//
//}
//
//if($_SERVER['REQUEST_METHOD'] == "GET") {
//	
//	$loadArticles = isset($_GET['loadArticles']);
//	$rows = isset($_GET['rows']);
//	$pageNumber = isset($_GET['pageNumber']);
//	$portalType = $_GET['portalType'];
//	
//	//Get total number of records	
//	$total_rec_query = "SELECT count(id) as totalRecords FROM MJV_ARTICLE WHERE status = 1 and portal_type = $portalType";
//	$toal_rec_result = mysqli_query($db_connect, $total_rec_query);
//	$row = mysqli_fetch_assoc($toal_rec_result);
//	$rec_count = $row['totalRecords'];
//	$addLimitInQuery = true;
//	$offset = 0;
//	$page_number = 1;
//	$number_of_articles = 5;
//	
//	if($pageNumber and $rows) {		
//		$page_number = $_GET['pageNumber'];
//		$number_of_articles = $_GET['rows'];
//		
//		$offset = ($page_number - 1) * $number_of_articles;		
//	}
//	
//        
//    $fetch_articles_query = "SELECT * FROM MJV_ARTICLE WHERE status = 1 and portal_type = $portalType LIMIT $offset, $number_of_articles";
//    
//    $resultArray = array ();    
//	$result = mysqli_query($db_connect, $fetch_articles_query);
//	
//	if($result) {
//		while ( $article = mysqli_fetch_assoc($result)) {
//			$resultArray [] = $article;
//		}
//		
//		$finalResult = array();
//		$finalResult['totalArticlesCount'] = $rec_count;
//		$finalResult['articles'] = $resultArray;
//		var_dump($finalResult);
//		header('Content-type: application/json');
//		return json_encode($finalResult, true);
//		
//	} else {
//		echo "Error: " . mysqli_error($db_connect);
//	}
//	
//	mysqli_close($db_connect);
//}
?>