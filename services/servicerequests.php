<?php

/**
 * Saves service requests into database.
 * @param JSON $inputJson
 */
//$inputJson = file_get_contents("php://input");
//include '../resources/config.php';


function submitRequestInsert($inputJson) {

    include '../resources/config.php';
    $data = json_decode($inputJson, true);
    //var_dump($data);
    //get service request details
    $title = $data['title'];
    $description = $data['description'];

    $requestor_name = $data['requestor_name'];
    $requestor_email = $data['requestor_email'];
    $requestor_contact = $data['requestor_contact'];
    $requestor_address = isset($data['requestor_address']) ? $data['requestor_address'] : '';

    $severity = $data['severity'];
    $priority = $data['priority'];
    $status = 1;

    $portal_type = $data['portal_type'];
    $service_type = $data['service_type'];


    $comments = '';
    //$attachments = $data['attachments'];

    $sr_number = getUniqueSRNumber();
    $attachments = json_encode($data['files']);
    //Inserting service requests
   // echo $title;
    $insert_query = "INSERT INTO MJV_SERVICE_REQUEST (sr_number, title, description, requestor_name, requestor_email, requestor_contact, requestor_address, severity, priority, status, portal_type, service_type, created_date, last_updated_date, comments, attachments)
												  VALUES ('" . $sr_number . "', '" . $title . "','" . $description . "', '" . $requestor_name . "', '" . $requestor_email . "', '" . $requestor_contact . "', '" . $requestor_address . "', '" . $severity . "','" . $priority . "', 
														  '" . $status . "', '" . $portal_type . "', '" . $service_type . "', NOW(), NOW(), '" . $comments . "', '" . $attachments . "')";
    //echo $insert_query;
    if (!mysqli_query($db_connect, $insert_query)) {
        echo "Error: " . mysqli_error($db_connect);
    }

    echo $sr_number;
    mysqli_close($db_connect);
}

function loadAllServiceRequests($inputJson) {

    //Fetch all service requests
    include '../resources/config.php';
    $fetch_all_srs_query = "SELECT * FROM MJV_SERVICE_REQUEST ORDER BY created_date DESC";

    $resultArray = array();
    $result = mysqli_query($db_connect, $fetch_all_srs_query);

    if ($result) {
        while ($service_request = mysqli_fetch_assoc($result)) {
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
function getSoc($inputJson){
    include '../resources/config.php';
    $fetch_all_srs_query = "SELECT * FROM MJV_ARTICLE WHERE portal_type = '".$inputJson."' AND status='4' ORDER BY created_date DESC";

    $resultArray = array();
    $result = mysqli_query($db_connect, $fetch_all_srs_query);

    if ($result) {
        while ($service_request = mysqli_fetch_assoc($result)) {
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

function loadServiceRequests($inputJson) {

    //Fetch all service requests
    include '../resources/config.php';
    $fetch_all_srs_query = "SELECT * FROM MJV_SERVICE_REQUEST WHERE flag !='1' ORDER BY created_date DESC";

    $resultArray = array();
    $result = mysqli_query($db_connect, $fetch_all_srs_query);

    if ($result) {
        while ($service_request = mysqli_fetch_assoc($result)) {
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

function loadAllRequests($inputJson) {

    //Fetch all service requests
    include '../resources/config.php';
    $fetch_all_srs_query = "SELECT * FROM MJV_SERVICE_REQUEST WHERE flag = '1' ORDER BY created_date DESC";

    $resultArray = array();
    $result = mysqli_query($db_connect, $fetch_all_srs_query);

    if ($result) {
        while ($service_request = mysqli_fetch_assoc($result)) {
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

function assignServiceRequests($inputJson) {

    $headers = apache_request_headers();
   // var_dump($headers);
   // $get = json_decode($get,true);
    //var_dump($get);
     include '../resources/config.php';
     $token_value = $headers['Authorization'];
     $query = "SELECT DISTINCT user_id FROM MJV_TOKEN WHERE token_string='$token_value'";
		$user_id = mysqli_query($db_connect, $query);
		
			$userId_assoc = mysqli_fetch_assoc($user_id);
                       // var_dump($userId_assoc);
			$userId = $userId_assoc['user_id']; 
    $fetch_all_srs_query = "SELECT * FROM MJV_SERVICE_REQUEST WHERE assigned_to_user_id = '".$userId."' ORDER BY created_date DESC";

    $resultArray = array();
    $result = mysqli_query($db_connect, $fetch_all_srs_query);

    if ($result) {
        while ($service_request = mysqli_fetch_assoc($result)) {
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

function editServiceRequest($data) {

    // edit service request details
    $data = json_decode($data, true);
    include '../resources/config.php';

    $sr_number = $data ['sr_number'];
    $title = $data ['title'];
    $description = $data ['description'];

    $requestor_name = $data['requestor_name'];
    $requestor_email = $data['requestor_email'];
    $requestor_contact = $data['requestor_contact'];
    $requestor_address = $data['requestor_address'];

    $severity = $data['severity'];
    $priority = $data['priority'];
    $status = $data ['status'];

    $portal_type = $data ['portal_type'];
    $service_type = $data ['service_type'];

    $comments = $data ['comments'];
    
    $attachments = $data['attachments'];
$assigned_to_user_id = $data['assigned_to_user_id'];
    // Updating service requests
 $headers = apache_request_headers();
  
     $token_value = $headers['Authorization'];
     $query = "SELECT DISTINCT * FROM MJV_TOKEN as t INNER JOIN MJV_USER_PROFILE as p ON t.user_id = p.id WHERE t.token_string='$token_value'";
		$user_id = mysqli_query($db_connect, $query);
		
			$userId_assoc = mysqli_fetch_assoc($user_id);
                        //var_dump($userId_assoc);
			$userId = $userId_assoc['user_id']; 
                        
                        $cmt = '{"comment":"'.$comments .'",
                                 "commented_by":"'.$userId_assoc['email'].'",
                                 "commented_on":"'.date('l jS \of F Y h:i:s A').'",
                                 "commented_name":"'.$userId_assoc['first_name'].' '.$userId_assoc['last_name'].'",
                                 "pic":"'.$userId_assoc['profile_pic_path'].'"
                                }';
                        
                        
                        
                        $fetch_all_srs_query = "SELECT * FROM MJV_SERVICE_REQUEST WHERE sr_number='".$sr_number."' AND assigned_to_user_id ='".$userId."' ORDER BY created_date DESC";

    $resultArray = array();
    $result = mysqli_query($db_connect, $fetch_all_srs_query);

    $service_request = mysqli_fetch_assoc($result);
             $serCom = $service_request['comments'];
        if($serCom==null)
        {
            $cmt = '['.$cmt.']';
        }
        else
        {    $output = substr($serCom, 1, -1);
             $cmt = '['.$output.','.$cmt.']';
        }
        
    $update_query = "UPDATE MJV_SERVICE_REQUEST SET title = '" . $title . "',
             description = '" . $description . "',
             status = '" . $status . "',
             portal_type = '" . $portal_type . "', 
             service_type = '" . $service_type . "',               
             requestor_name = '" . $requestor_name . "', 
             requestor_email = '" . $requestor_email . "',
             requestor_contact = '" . $requestor_contact . "',
             requestor_address = '" . $requestor_address . "',
             severity = '" . $severity . "',
             priority = '" . $priority . "',
             flag = '1',
             assigned_to_user_id = '" . $assigned_to_user_id . "',
             last_updated_date = NOW(),
             comments = '" . $cmt . "',
             attachments = '" . $attachments . "' ";
    if (isset($data['assigned_to_user_id'])) {
        $assigned_to_user_id = $data['assigned_to_user_id'];
        $update_query .= ", assigned_to_user_id = '" . $assigned_to_user_id . "'";
    }

    if (isset($data['approver_user_id'])) {
        $approver_user_id = $data['approver_user_id'];
        $update_query .= ", approver_user_id = ' " . $approver_user_id . "' ";
    }

    $update_query .= " WHERE sr_number = '" . $sr_number . "' ";

    if (!mysqli_query($db_connect, $update_query)) {
        echo "Error: " . mysqli_error($db_connect);
    } else {
        echo '{"msg":"Saved Successfully","type":1}';
    }

    mysqli_close($db_connect);
}

function getUniqueSRNumber() {

    $string = "SR";
    $string .= mt_rand(10000000, 99999999);

    return $string;
}

function loadServiceRequest($srnumber) {
 include '../resources/config.php';
 $sr_number = $srnumber;
 
 // Fetch service request details by sr number
 $fetch_sr_query = "SELECT * FROM MJV_SERVICE_REQUEST WHERE sr_number = '$sr_number'";
 
 $resultArray = array ();
 $result = mysqli_query ( $db_connect, $fetch_sr_query );
 
 if ($result) {
  while ( $service_request = mysqli_fetch_assoc ( $result ) ) {
   $resultArray [] = $service_request;
  }
  
  //var_dump ( $resultArray );
  
  header ( 'Content-type: application/json' );
  return json_encode ( $resultArray, true );
 } else {
  echo "Error: " . mysqli_error ( $db_connect );
 }
 mysqli_close ( $db_connect );
}

function getServiceOptions($get) {
    include '../resources/config.php';

    $id = $get;
    $query = "SELECT * FROM MJV_PORTAL_SUB_TYPE WHERE portal_type='" . $id . "'";
    $user_id = mysqli_query($db_connect, $query);
    if ($user_id) {
//                    $userId_assoc = mysqli_fetch_assoc($user_id);
//                    var_dump($userId_assoc);
        $array = array();
        while ($row = mysqli_fetch_array($user_id, MYSQL_ASSOC)) {
            array_push($array, $row);
        }
        header('Content-type: application/json');
        echo json_encode($array);
    } else {
        echo "Error: " . mysqli_error($db_connect);
    }
    mysqli_close($db_connect);
}

function getCategoryTypesForPortal() {
    include '../resources/config.php';

    $query = "SELECT id, name, display_order FROM MJV_PORTAL_TYPE WHERE display_order IS NOT NULL ORDER BY display_order ASC";
    $results = mysqli_query($db_connect, $query);

    if ($results) {
        $resultArray = array();

        while ($temp = mysqli_fetch_assoc($results)) {
            $resultArray [] = $temp;
        }

        header('Content-type: application/json');
        return json_encode($resultArray, true);
    } else {
        echo "Error: " . mysqli_error($db_connect);
    }
    mysqli_close($db_connect);
}

function getRequestPriorityTypes() {
    include '../resources/config.php';
    $query = "SELECT * FROM MJV_SERVICE_REQUEST_PRIORITY";
    $results = mysqli_query($db_connect, $query);

    if ($results) {

        $resultArray = array();

        while ($temp = mysqli_fetch_assoc($results)) {
            $resultArray [] = $temp;
        }


        header('Content-type: application/json');
        return json_encode($resultArray, true);
    } else {
        echo "Error: " . mysqli_error($db_connect);
    }
    mysqli_close($db_connect);
}

function getRequestSeverityTypes() {
    include '../resources/config.php';

    $query = "SELECT * FROM MJV_SERVICE_REQUEST_SEVERITY";
    $results = mysqli_query($db_connect, $query);

    if ($query) {

        $resultArray = array();

        while ($temp = mysqli_fetch_assoc($results)) {
            $resultArray [] = $temp;
        }

        header('Content-type: application/json');
        return json_encode($resultArray, true);
    } else {
        echo "Error: " . mysqli_error($db_connect);
    }
    mysqli_close($db_connect);
}

function getRequestStatusTypes() {
    include '../resources/config.php';

    $query = "SELECT * FROM MJV_SERVICE_REQUEST_STATUS";
    $results = mysqli_query($db_connect, $query);

    if ($query) {

        $resultArray = array();

        while ($temp = mysqli_fetch_assoc($results)) {
            $resultArray [] = $temp;
        }

        header('Content-type: application/json');
        return json_encode($resultArray, true);
    } else {
        echo "Error: " . mysqli_error($db_connect);
    }
    mysqli_close($db_connect);
}

function searchServiceRequests($data) {

    include '../resources/config.php';

    $searchData = json_decode($data, true);

    $search_sr_query = "SELECT sr_number, title, requestor_name, portal_type, service_type, priority, status, created_date FROM mjv_service_request ";

    $searchStringAdded = false;

    if (isset($searchData['sr_number'])) {
        $sr_number = $searchData['sr_number'];
        $search_sr_query .= " WHERE sr_number = '$sr_number'";
        $searchStringAdded = true;
    }

    if (isset($searchData['portal_type'])) {
        $portal_type = $searchData['portal_type'];

        if ($searchStringAdded) {
            $search_sr_query .= " and portal_type = '$portal_type'";
        } else {
            $search_sr_query .= "WHERE portal_type = '$portal_type'";
            $searchStringAdded = true;
        }
    }

    if (isset($searchData['service_type'])) {
        $service_type = $searchData['service_type'];

        if ($searchStringAdded) {
            $search_sr_query .= " and service_type = '$service_type'";
        } else {
            $search_sr_query .= "WHERE service_type = '$service_type'";
            $searchStringAdded = true;
        }
    }

    if (isset($searchData['priority'])) {
        $priority = $searchData['priority'];

        if ($searchStringAdded) {
            $search_sr_query .= " and priority = '$priority'";
        } else {
            $search_sr_query .= "WHERE priority = '$priority'";
            $searchStringAdded = true;
        }
    }

    if (isset($searchData['severity'])) {
        $severity = $searchData['severity'];

        if ($searchStringAdded) {
            $search_sr_query .= " and severity = '$severity'";
        } else {
            $search_sr_query .= "WHERE severity = '$severity'";
            $searchStringAdded = true;
        }
    }

    if (isset($searchData['status'])) {
        $status = $searchData['status'];

        if ($searchStringAdded) {
            $search_sr_query .= " and status = '$status'";
        } else {
            $search_sr_query .= "WHERE status = '$status'";
            $searchStringAdded = true;
        }
    }

    if (isset($searchData['searchDateType'])) {

        $searchDateType = $searchData['searchDateType'];

        if (strcasecmp("FROM", $searchDateType) == 0) {

            if (isset($searchData['fromDate'])) {
                $fromDate = $searchData['fromDate'];

                if ($searchStringAdded) {
                    $search_sr_query .= " and date(created_date) >= '$fromDate'";
                } else {
                    $search_sr_query .= "WHERE date(created_date) >= '$fromDate'";
                    $searchStringAdded = true;
                }
            }
        }

        if (strcasecmp("UPTO", $searchDateType) == 0) {

            if (isset($searchData['uptoDate'])) {
                $uptoDate = $_GET['uptoDate'];

                if ($searchStringAdded) {
                    $search_sr_query .= " and date(created_date) <= '$uptoDate'";
                } else {
                    $search_sr_query .= "WHERE date(created_date) <= '$uptoDate'";
                    $searchStringAdded = true;
                }
            }
        }

        if (strcasecmp("EQUALS", $searchDateType) == 0) {

            if (isset($searchData['equalToDate'])) {
                $equalToDate = $searchData['equalToDate'];

                if ($searchStringAdded) {
                    $search_sr_query .= " and date(created_date) = '$equalToDate'";
                } else {
                    $search_sr_query .= "WHERE date(created_date) = '$equalToDate'";
                    $searchStringAdded = true;
                }
            }
        }

        if (strcasecmp("BETWEEN", $searchDateType) == 0) {

            if (isset($searchData['fromDate']) and isset($searchData['uptoDate'])) {

                $fromDate = $searchData['fromDate'];
                $uptoDate = $searchData['uptoDate'];

                if ($searchStringAdded) {
                    $search_sr_query .= " and date(created_date) BETWEEN '$fromDate' AND '$uptoDate'";
                } else {
                    $search_sr_query .= "WHERE date(created_date) BETWEEN '$fromDate' AND '$uptoDate'";
                    $searchStringAdded = true;
                }
            }
        }
    }

    $search_sr_query .= " ORDER BY sr_number DESC";
    echo $search_sr_query;

    $search_results = mysqli_query($db_connect, $search_sr_query);

    $searchResultArray = array();

    if ($search_results) {
        while ($service_request = mysqli_fetch_assoc($search_results)) {
            $searchResultArray [] = $service_request;
        }

        var_dump($searchResultArray);

        header('Content-type: application/json');
        return json_encode($searchResultArray, true);
    } else {
        echo "Error: " . mysqli_error($db_connect);
    }

    mysqli_close($db_connect);
}
function getVolunteers($params){
    include '../resources/config.php';

    $query = "SELECT email,id,first_name,last_name,profile_pic_path FROM MJV_USER_PROFILE WHERE role_id=2";
    $results = mysqli_query($db_connect, $query);

    if ($query) {

        $resultArray = array();

        while ($temp = mysqli_fetch_assoc($results)) {
            $resultArray [] = $temp;
        }

        header('Content-type: application/json');
        return json_encode($resultArray, true);
    } else {
        echo "Error: " . mysqli_error($db_connect);
    }
    mysqli_close($db_connect);
}
function getAttachments($file){
    $path = "../services/uploads/".$pic;
//$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);

                       header('Content-type: image/jpeg');
                        echo $data;
}

?>
