<?php
$textUpload = "";
if ($_FILES['file']) {
    $uploadfile = __DIR__.'/../images/'. $_FILES['file']['name'];
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {

        header('Content-Type: application/json; charset=utf-8', true);
        echo json_encode(array("message" => "Upload is OK"));
    }else{
        header('Content-Type: application/json; charset=utf-8', true);
        echo json_encode(array("message" => $_FILES['file']['error']."Upload is NOT OK  ".$uploadfile));
    }
}



