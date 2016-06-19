<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$query = $_REQUEST['q'];
$inputJson = file_get_contents("php://input");

include 'userprofile.php';
include 'servicerequests.php';
include 'articles.php';
include 'contactus.php';
include 'announcements.php';
if(isset($_REQUEST['p'])){
    $inputJson = $_REQUEST['p'];
}
 
   
echo $query($inputJson);
