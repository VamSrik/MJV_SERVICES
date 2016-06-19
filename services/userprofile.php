<?php

/*
 * 
 */

/**
 * Saves user details, username details and contributions to mjv into database.
 * @param JSON $inputJson
 */

$inputJson = file_get_contents("php://input");

function saveUserDoc($data,$newfilename) {
    include '../resources/config.php';
	//convert json object to php associative array
	//$data = json_decode($inputJson, true);
	//get the employee details
	$first_name = $data['firstName'];
        $last_name = $data['lastName'];
	$email = $data['emailId'];
	$id_proof_type = $data['idProofType']['id'];
	$id_proof_name = $data['idProofName'];
	$id_proof_value = $data['idProofValue'];
	$profession = $data['profession'];
	$contact_number = $data['contactNumber'];
	$contributions_list = $data['contributions'];
	$username = $data['username'];
	$pwd = $data['password'];
        //var_dump($db_connect);
	//var_dump($data);
	//Inserting user profile
	$insert_query = 'INSERT INTO MJV_USER_PROFILE (first_name,last_name,email,id_proof_type, id_proof_name, id_proof_value, profession, profile_pic_path, contact_number) VALUES ("'.$first_name.'","'.$last_name.'","'.$email.'","'.$id_proof_type.'", "'.$id_proof_name.'", "'.$id_proof_value.'", "'.$profession.'", "'.$newfilename.'", "'.$contact_number.'")';
	//echo $insert_query;	
	if(! mysqli_query($db_connect, $insert_query)) {
    	echo "Error: " . mysqli_error($db_connect);
	}
	
	//Selecting the last inserted user id for further insertions
	$userId =  mysqli_insert_id($db_connect);
	
	//Inserting users
	$insert_query = 'INSERT INTO MJV_USERS (user_email,password,user_id) VALUES ("'.$email.'","'.$pwd.'","'.$userId.'")';
	//echo $insert_query;
	if(! mysqli_query($db_connect, $insert_query)) {
    	echo "Error: " . mysqli_error($db_connect);
	}
	
        $insert_query = "INSERT INTO MJV_USER_TO_ROLE VALUES ($userId,2)";
		echo $insert_query;
		if(! mysqli_query($db_connect, $insert_query)) {
			echo "Error: " . mysqli_error($db_connect);
		}
	//Inserting user contributions
	foreach ($contributions_list as $portalType) {
  $insert_query = "INSERT INTO MJV_USER_CONTRIBUTIONS (user_id, portal_type) VALUES ($userId,$portalType)";
  
  if(! mysqli_query($db_connect, $insert_query)) {
      echo "Error: " . mysqli_error($db_connect);
  }
 }
		echo 'done';
	
	mysqli_close($db_connect);
	
}

function loginAuth($post) {
     include '../resources/config.php';
     
   $post = json_decode($post,true);
	$username = $post['user'];
        $pwds = $post['password'];
       
	 $query = "SELECT * FROM MJV_USERS WHERE user_email='".$username."' AND password='".$pwds."'";
	$result = mysqli_query($db_connect, $query);
        $row = mysqli_fetch_row($result);
	 $count = mysqli_num_rows($result);
	//var_dump($row);
	//echo $row[0]['user_id'];
	header('Content-type: application/json');
	if($count > 0) {		
		 $token = getToken(16);
                 $query = "SELECT * FROM MJV_TOKEN where user_id='".$row[2]."'";
	$result = mysqli_query($db_connect, $query);
         $countToken = mysqli_num_rows($result);
         if($countToken > 0){
             $query = "UPDATE MJV_TOKEN SET token_string = '".$token."' WHERE user_id = '".$row[2]."'";
	$result = mysqli_query($db_connect, $query);
         } else {
                  $query = "INSERT INTO MJV_TOKEN (user_id, token_string) VALUES ('".$row[2]."','".$token."')";
	if(!mysqli_query($db_connect, $query)){
			echo "Error: " . mysqli_error($db_connect);
		}
         }
         
    $obj = array( 'token' => $token,'Auth'=>true);
    echo json_encode($obj);
	} else {
      $obj = array( 'msg' => 'Invalid User or Password','Auth'=>false);
    echo json_encode($obj);
		
	}
        mysqli_close($db_connect);
}
function logout(){
    $headers = apache_request_headers();
   // var_dump($headers);
   // $get = json_decode($get,true);
    //var_dump($get);
     include '../resources/config.php';
     $token_value = $headers['Authorization'];
	
		
	
		//delete token for user - only logged in users will have active tokens
		
		$delete_query = "DELETE FROM MJV_TOKEN WHERE token_string = '".$token_value."'";
	
		if(! mysqli_query($db_connect, $delete_query)) {
			echo "Error: " . mysqli_error($db_connect);
		}
                else{
                    header('Content-type: application/json');
                    $msg = array('msg'=>'Logout Successfully','type'=>1);
                    echo json_encode($msg);
                }
		mysqli_close($db_connect);
	
	
};
function emailCheck() {
    $token = getToken(16);
    $obj = array( 'token' => $token);
    echo json_encode($obj);
	$username = $_GET['username'];
	$query = "SELECT * FROM MJV_USERS WHERE username='$username'";
	$result = mysqli_query($db_connect, $query);
	$count = mysqli_num_rows($result);
	mysqli_close($db_connect);
	header('Content-type: application/json');
	
	if($count > 0) {		
		return "{'userExists':true}";
	} else {
		return "{'userExists':false}";
	}
}
function getUserProfile($get){
    $headers = apache_request_headers();
   // var_dump($headers);
   // $get = json_decode($get,true);
    //var_dump($get);
     include '../resources/config.php';
     $token_value = $headers['Authorization'];
     //var_dump($token_value);
	 $query = "SELECT DISTINCT user_id FROM MJV_TOKEN WHERE token_string='$token_value'";
		$user_id = mysqli_query($db_connect, $query);
		if($user_id) {
			$userId_assoc = mysqli_fetch_assoc($user_id);
                      //  var_dump($userId_assoc);
			$userId = $userId_assoc['user_id']; 
                        $query = "SELECT * FROM MJV_USER_PROFILE WHERE id = '$userId'";
			$result = mysqli_query($db_connect, $query);
			$temp = mysqli_fetch_assoc($result);
                        echo json_encode($temp);
                }
				 mysqli_close($db_connect);
    
}

function getUserPic($get){
    $headers = apache_request_headers();
   // var_dump($headers);
   // $get = json_decode($get,true);
    //var_dump($get);
     include '../resources/config.php';
     $token_value = $headers['Authorization'];
     //var_dump($token_value);
		$query = "SELECT DISTINCT user_id FROM MJV_TOKEN WHERE token_string='$token_value'";
		$user_id = mysqli_query($db_connect, $query);
		if($user_id) {
			$userId_assoc = mysqli_fetch_assoc($user_id);
                       // var_dump($userId_assoc);
			$userId = $userId_assoc['user_id']; 
                        $query = "SELECT * FROM MJV_USER_PROFILE WHERE id = '$userId'";
			$result = mysqli_query($db_connect, $query);
			$temp = mysqli_fetch_assoc($result);
                        $imgPath = $temp['profile_pic_path'];
                        $path = "../services/uploads/".$imgPath;
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        
                        header('Content-type: image/jpeg');
                        echo $base64;
                        //echo json_encode($temp);
                }
				 mysqli_close($db_connect);
    
}
function getPic($pic){
    //echo $pic;
    $path = "../services/uploads/".$pic;
//$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
//echo $data;
//$base64 = base64_encode($data);
                        
                       header('Content-type: image/jpeg');
                        echo $data;
}
function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd >= $range);
    return $min + $rnd;
}

function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet) - 1;
    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max)];
    }
    return $token;
}
function getSubHeader(){
     $headers = apache_request_headers();
   // var_dump($headers);
   // $get = json_decode($get,true);
    //var_dump($get);
     include '../resources/config.php';
     $token_value = $headers['Authorization'];
     //var_dump($token_value);
		$query = "SELECT * FROM MJV_TOKEN INNER JOIN MJV_USER_TO_ROLE ON MJV_TOKEN.user_id = MJV_USER_TO_ROLE.user_id WHERE MJV_TOKEN.token_string='$token_value'";
		$user_id = mysqli_query($db_connect, $query);
		if($user_id) {
                    $userId_assoc = mysqli_fetch_assoc($user_id);
                   // var_dump($userId_assoc);
                      header('Content-type: application/json');
                    if($userId_assoc['role_id']==='2'){
                      
                        $json = '{"menu":[{
                    "name": "Knowledge Portal",
                    "link": "home.knowledgeportal"

                },
                {
                    "name": "Wonders Of JRG",
                    "link": "home.wondersofjrg"},
            {
                    "name": "Need Help",
                    "link": "home.needhelp"},
            {
                    "name": "Donations",
                    "link": "home.donations"},
                    {
                    "name": "Volunteer",
                    "link": "home.volunteer"}]}';
                        
                      
                    }
                    if($userId_assoc['role_id']==='1'){
                      
                        $json = '{"menu":[{
                    "name": "Knowledge Portal",
                    "link": "home.knowledgeportal"

                },
                {
                    "name": "Wonders Of JRG",
                    "link": "home.wondersofjrg"},
            {
                    "name": "Need Help",
                    "link": "home.needhelp"},
            {
                    "name": "Donations",
                    "link": "home.donations"},
                    {
                    "name": "Admin",
                    "link": "home.admin"}]}';
                        
                        
                    }
                      echo $json;
                }
                else
                {
                    echo "Error: " . mysqli_error($db_connect);
                }
                mysqli_close($db_connect);
}
function getSubmenu(){
     $headers = apache_request_headers();
   // var_dump($headers);
   // $get = json_decode($get,true);
    //var_dump($get);
     include '../resources/config.php';
     $token_value = $headers['Authorization'];
     //var_dump($token_value);
     $query = "SELECT DISTINCT user_id  FROM MJV_TOKEN WHERE token_string='$token_value'";
     $user_id = mysqli_query($db_connect, $query);
		if($user_id) {
                    $userId_assoc = mysqli_fetch_assoc($user_id);
                     $user_id = $userId_assoc['user_id'];
                    $query = "SELECT * FROM MJV_PORTAL_TYPE INNER JOIN MJV_USER_CONTRIBUTIONS ON  MJV_PORTAL_TYPE.id=MJV_USER_CONTRIBUTIONS.portal_type WHERE MJV_USER_CONTRIBUTIONS.user_id='$user_id'";
		$user_id = mysqli_query($db_connect, $query);
		if($user_id) {
//                    $userId_assoc = mysqli_fetch_assoc($user_id);
//                    var_dump($userId_assoc);
                    $array = array();
                    while ($row = mysqli_fetch_array($user_id, MYSQL_ASSOC)) {
    array_push($array, $row);
}
//var_dump($array);
header('Content-type: application/json');
echo json_encode($array);
                }
                }
		
                 mysqli_close($db_connect);
}

function getUsersByContribution($portalType) {
    include '../resources/config.php';
    $portal_type = $portalType;

    // Fetch service request details by sr number
    $fetch_contributing_users_query = "SELECT user_id FROM MJV_USER_CONTRIBUTIONS WHERE portal_type = '$portal_type'";

    $userProfilesArray = array ();
    $resultArray = array ();
    $result = mysqli_query ( $db_connect, $fetch_contributing_users_query );

    if ($result) {
        
        while ( $user_id = mysqli_fetch_assoc ( $result ) ) {
            $resultArray [] = $user_id;
        }

        if($resultArray.length > 0) {
            $userIds = join(',', array_fill(0, count($resultArray), '?'));
            $fetch_userprofiles_query = "SELECT user_id, first_name,last_name, profile_pic_path FROM MJV_USER_PROFILE WHERE user_id IN (" +$userIds + ")";

            $userProfilesResult = mysqli_query ( $db_connect, $fetch_userprofiles_query );

            if ($userProfilesResult) {
                 while ( $user_profile = mysqli_fetch_assoc ( $userProfilesResult ) ) {
                    $userProfilesArray [] = $user_profile;
                 }
            } else {
                echo "Error: " . mysqli_error ( $db_connect );
            }

        }

    } else {
        echo "Error: " . mysqli_error ( $db_connect );
    }
    header ( 'Content-type: application/json' );
    return json_encode ( $userProfilesArray, true );
    mysqli_close ( $db_connect );

}

function getUserProfileLite($get){
 include '../resources/config.php';
 $userId = $get;
  $query = "SELECT first_name, last_name FROM MJV_USER_PROFILE WHERE id = '$userId'";
  $result = mysqli_query($db_connect, $query);
  $result = mysqli_fetch_assoc($result);
  echo json_encode($result);
}

?>