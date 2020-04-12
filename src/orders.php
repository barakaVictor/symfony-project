<?php
include_once '../config/cor.php';
include_once '../config/dbConnection.php';
include_once '../objects/Order.php';
$database = new Database();
$db = $database->connectToDb();
if($db){
    $order = new Order($db);
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $order_id = json_decode(file_get_contents("php://input"));
        echo json_encode($order->fetchItemsOrdered($order_id->id),JSON_PRETTY_PRINT);
    }
    else{
        $list_of_orders = $order->getAll();
        if($list_of_orders != null){
            http_response_code(200);
            echo json_encode($list_of_orders,JSON_PRETTY_PRINT);
        }
    }
}
?>