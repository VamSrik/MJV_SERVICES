<?php

$uploadDir = 'uploads/';
if(!isset($_REQUEST['q'])){
    $attachId = $_POST['attachId'];
    $temp = explode(".", $_FILES["file"]["name"]);
$newfilename = round(microtime(true)) . '.' . end($temp);
//$verifyToken = md5('unique_salt' . $_POST['timestamp']);
//var_dump($_FILES['file']);
if (!empty($_FILES)) {
    $tempFile   = $_FILES['file']['tmp_name'];
    $uploadDir  = $uploadDir;
    $targetFile = $uploadDir . $attachId.'__-__'.$_FILES['file']['name'];

    // Save the file
    //echo $uploadDir;
    if(move_uploaded_file($tempFile, $targetFile))
                {
    echo 1;
    }
    else{
    echo 0;
    }
}
}
else
{
    unlink($uploadDir.$_REQUEST['q']);
    echo 1;
}
?>