<?php
include_once '../config/cor.php';
include_once '../config/dbConnection.php';
include_once '../objects/Item.php';
$database = new Database();
$db = $database->connectToDb();
$item_to_update = json_decode(file_get_contents("php://input"));
if($db){
    $item = new Item($db);
    if($item->update($item_to_update->item)){
        http_response_code(201);
        echo json_encode("Item updated successfully");
    }
    else{
        //http_response_code(503);
        echo json_encode("Unable to update item");
    }
}
?>