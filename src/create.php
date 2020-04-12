<?php
include_once '../config/cor.php';
include_once '../config/dbConnection.php';
include_once '../objects/Item.php';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $database = new Database();
    $db = $database->connectToDb();
    //$item = json_decode(file_get_contents("php://input"));
    //$item_to_create = $item->item;
    if($db){
        $item = new Item($db);
        $item->itemname = $_POST['name'];
        $item->itemDescription = $_POST['description'];
        $item->price = $_POST['price'];
        $item->img = $_POST['img'];
        $item->table_name = $_POST['item_category'];
        $item->imageFile = $_FILES['imageFile'];
        if($item->create()){
            http_response_code(201);
            echo json_encode("Item created successfully");
        }
        else{
            //http_response_code(503);
            echo json_encode("Unable to create item");
        }
    }
}
?>