<?php
class Item{
    private $conn;
    public $itemname;
    public $price;
    public $itemDescription;
    public $img;
    public $table_name;
    public $imageFile;
    public $destination;

    public function __construct($db){
        $this->conn = $db;
    }
    function imageUpload($image){
        $this->destination = "images/".$this->table_name;
        $upload_location = "../".$this->destination;
        if(!is_dir($upload_location)){
            mkdir($upload_location, 0766, true);
        }
        if(move_uploaded_file($image["tmp_name"], $upload_location."/".$image['name'])){
            return true;
        }
        else{
            return false;
        }
    }
    function create(){
        if($this->imageUpload($this->imageFile)){
            $imageUrl = $this->destination."/".$this->img;
            $stmt = $this->conn->prepare("INSERT INTO ".$this->table_name."(name, description, img, price) 
            VALUES (:name, :description, :img, :price)");
            $stmt->bindParam(':name', $this->itemname);
            $stmt->bindParam(':description', $this->itemDescription);
            $stmt->bindParam(':img', $imageUrl);
            $stmt->bindParam(':price', $this->price);
            if($stmt->execute()){
                return true;
            }
            else{
                return false;
            }
        }
    }
    function update($item){
        $stmt = $this->conn->prepare("UPDATE $item->table_name SET name=:name, description=:description, price=:price, img=:img WHERE id=:id");
        $stmt->bindParam(':name', $item->name);
        $stmt->bindParam(':description', $item->description);
        $stmt->bindParam(':price', $item->price);
        $stmt->bindParam(':img', $item->img);
        $stmt->bindParam(':id', $item->id);
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    function delete($item){
        $stmt = $this->conn->prepare("DELETE FROM $item->table_name WHERE id=:id");
        $stmt->bindParam(':id', $item->id);
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    function fetchAll($table_name){
        $stmt = $this->conn->prepare("SELECT * FROM $table_name");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->execute()){
            $result = $stmt->fetchAll(); 
            return $result;
        }
        else{
            return null;
        }
    }
    function inventory(){
        $stmt = $this->conn->prepare("SHOW TABLES");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if($stmt->execute()){
            return $stmt->fetchAll();
        }
        else{
            return null;
        }
    }
    
}
?>