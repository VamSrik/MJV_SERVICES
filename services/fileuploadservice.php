<?php
include 'userprofile.php';
include 'servicerequests.php';
$target_dir = "uploads/";
$temp = explode(".", $_FILES["file"]["name"]);
$newfilename = round(microtime(true)) . '.' . end($temp);
$target_file = $target_dir . $newfilename;
$uploadOk = 1;
$data=$_POST;
$query = $_REQUEST['q'];

$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["file"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($query=='user'){
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    var_dump($target_file);
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
             //echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
        var_dump($newfilename);
        var_dump($data['Deatils']);
        if($query=='user'){
             saveUserDoc($data['userDeatils'],$newfilename);
        }
        else{
        submitRequestInsert($data['Deatils'],$newfilename);
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


?> 