<?php
class Order{
    private $conn;
    public $firstName;
    public $lastName;
    public $p_address;
    public $email;
    public $phoneNumber;
    public $mtransaction;
    public $amount;
    public $oderDescription;
    public $orderedItems;

    public function __construct($db){
        $this->conn = $db;
    }
    function create(){
        $stmt = $this->conn->prepare("INSERT INTO orders(firstName, lastName, p_address, email, pnumber, mtransaction, amount) 
        VALUES (:firstName, :lastName, :p_address, :email, :phoneNumber, :mtransaction, :amount)");
        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':p_address', $this->p_address);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phoneNumber', $this->phoneNumber);
        $stmt->bindParam(':mtransaction', $this->mtransaction);
        $stmt->bindParam(':amount', $this->amount);
        if($stmt->execute()){
            $id = $this->conn->lastInsertId();
            $stmt_items = $this->conn->prepare("INSERT INTO ordered_items(order_id, item_name, quantity, price) 
            VALUES(:order_id, :item_name, :quantity, :price)");
            foreach($this->orderedItems as $item){
            $stmt_items->bindParam(':order_id', $id);
            $stmt_items->bindParam(':item_name', $item->name);
            $stmt_items->bindParam(':quantity', $item->quantity);
            $stmt_items->bindParam(':price', $item->price);
            $stmt_items->execute();
            }
            return true;
        }
        else{
            return false;
        }
    }
    function update(){
        return null;
    }
    function getAll(){
        $stmt = $this->conn->prepare("SELECT * FROM orders");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->execute()){
            $result = $stmt->fetchAll(); 
            return $result;
        }
        else{
            return null;
        }
    }
    function fetchItemsOrdered($id){
        $stmt = $this->conn->prepare("SELECT * FROM ordered_items WHERE order_id =:order_id");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->bindParam(':order_id', $id);
        if($stmt->execute()){
            return $stmt->fetchAll();
        }
        else{
            return null;
        }
    }
}
?>