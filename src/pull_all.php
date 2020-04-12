<?php
include_once '../config/cor.php';
include_once '../config/dbConnection.php';
include_once '../objects/Item.php';
$database = new Database();
$db = $database->connectToDb();
$item_type = json_decode(file_get_contents("php://input"));
if($db){
    $item = new Item($db);
    $list_of_items = $item->fetchAll($item_type->item_category);
    if($list_of_items != null){
        http_response_code(200);
        echo json_encode($list_of_items);
    }
    /*else if($list_of_items == null){
        http_response_code(503);
        echo json_encode(array("error"=>"Failed to retrieve data"));
    }*/
}
?>