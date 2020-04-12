<?php
include_once '../config/cor.php';
include_once '../config/dbConnection.php';
include_once '../objects/Order.php';

$database = new Database();
$db = $database->connectToDb();
if($db){
    $order = new Order($db);
    $data = json_decode(file_get_contents("php://input"));

    $order->firstName = $data->firstName;
    $order->lastName = $data->lastName;
    $order->p_address = $data->address;
    $order->email = $data->email;
    $order->phoneNumber = $data->pnumber;
    $order->mtransaction = $data->mtransaction;
    $order->amount = $data->amount;
    $order->oderDescription = $data->OrderDescription;
    $order->orderedItems = $data->OrderedItems;

    if($order->create()){
        //http_response_code(201);
        $confirmed_order = (array)$order;
        array_push($confirmed_order['orderedItems'],array('name'=>'Total','actualPrice'=>$order->amount));
        echo json_encode(array("message" => "Order received successfully",'order'=>$confirmed_order));
    }
    else{
        //http_response_code(503);
        echo json_encode(array("message" => "Unable to create order. Please retry again"));
    }
}
else{
    //http_response_code(400);
    echo json_encode(array("message" => "Unable to create order. Please retry"));
}
?>