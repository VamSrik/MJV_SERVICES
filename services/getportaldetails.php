<?php
include '../resources/config.php';
if ($_SERVER ['REQUEST_METHOD'] == "GET") {	
	
	$portalsList = isset($_GET['portalsList']);
	$subPortals = isset($_GET['subPortals']);
	
	if($portalsList) { 
		$query = "SELECT id, name, display_order FROM MJV_PORTAL_TYPE ORDER BY display_order";
		$results = mysqli_query ($db_connect, $query);
		$resultArray = array ();
		
		while ( $temp = mysqli_fetch_assoc($results)) {
			$resultArray [] = $temp;
		}
		var_dump($resultArray);
		$finalResult = array();
		
		if($subPortals) {
			foreach ($resultArray as $portalType) {
				$portalId =  $portalType['id'];
				$query = "SELECT id, name, portal_type FROM MJV_PORTAL_SUB_TYPE WHERE portal_type = $portalId ORDER BY name";
				$subTypesList = mysqli_query ($db_connect, $query);
				
				$subTypesArray = array ();
				while ( $temp = mysqli_fetch_assoc($subTypesList)) {
					$subTypesArray [] = $temp;
				}
				
				$portalType['serviceTypes'] = $subTypesArray;
				$finalResult[] = $portalType;
			}
		} else {
			$finalResult = $resultArray;
		}
		
		header('Content-type: application/json');
		return json_encode($resultArray, true);
	}
	
	
	// Fetching id proofs 
	$idProofTypes = isset($_GET['idProofTypes']);
	
	if($idProofTypes) {
		$query = "SELECT * FROM MJV_ID_PROOFS";
		$results = mysqli_query ($db_connect, $query);
		$resultArray = array ();
	
		while ( $temp = mysqli_fetch_assoc($results)) {
			$resultArray [] = $temp;
		}
		var_dump($resultArray);
	
		header('Content-type: application/json');
		return json_encode($resultArray, true);
	}
	
	
	// Fetching service request severities
	$sr_severities = isset($_GET['sr_severities']);
	
	if($sr_severities) {
		$query = "SELECT * FROM MJV_SERVICE_REQUEST_SEVERITY";
		$results = mysqli_query ($db_connect, $query);
		$resultArray = array ();
	
		while ( $temp = mysqli_fetch_assoc($results)) {
			$resultArray [] = $temp;
		}
		var_dump($resultArray);
	
		header('Content-type: application/json');
		return json_encode($resultArray, true);
	}
	
	// Fetching service request priority
	$sr_priorities = isset($_GET['sr_priorities']);
	
	if($sr_priorities) {
		$query = "SELECT * FROM MJV_SERVICE_REQUEST_PRIORITY";
		$results = mysqli_query ($db_connect, $query);
		$resultArray = array ();
	
		while ( $temp = mysqli_fetch_assoc($results)) {
			$resultArray [] = $temp;
		}
		var_dump($resultArray);
	
		header('Content-type: application/json');
		return json_encode($resultArray, true);
	}
	
	// Fetching service request status
	$sr_status_list = isset($_GET['sr_status_list']);
	
	if($sr_status_list) {
		$query = "SELECT * FROM MJV_SERVICE_REQUEST_STATUS";
		$results = mysqli_query ($db_connect, $query);
		$resultArray = array ();
	
		while ( $temp = mysqli_fetch_assoc($results)) {
			$resultArray [] = $temp;
		}
		var_dump($resultArray);
	
		header('Content-type: application/json');
		return json_encode($resultArray, true);
	}
	
	
	
}
?>