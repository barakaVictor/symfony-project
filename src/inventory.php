<?php
include_once '../config/cor.php';
include_once '../config/dbConnection.php';
include_once '../objects/Item.php';
$database = new Database();
$db = $database->connectToDb();
if($db){
    $item = new Item($db);
    $inventory = $item->inventory();
    if($inventory != null){
        http_response_code(200);
        echo json_encode($inventory);
    }
}
?>