<?php
    class Category {
        // db 
        private $conn;
        private $table = 'categories';

        // properties
        public $id;
        public $name;
        public $created_at;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        // get all categories
        public function read(){
            // make query
            $query = "SELECT * FROM " . $this->table . "";

            // prepare stmt
            $stmt = $this->conn->prepare($query);

            // execute 
            if($stmt->execute()){
                return $stmt;
            } else{
                return false;
            }
        }
        // get single category
        public function read_single(){
            // make query
            $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
            // prepare stmt
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":id", $this->id);

            $stmt->execute();

            if($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                // set values
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->created_at = $row['created_at'];
            }   
            
        }
        // create category
        public function create(){
            // make query
            $query = "INSERT INTO " . $this->table . 
            " SET 
                id = :id,
                name = :name,
                created_at = now()";

            // prepare stmt
            $stmt = $this->conn->prepare($query);

            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->name = htmlspecialchars(strip_tags($this->name));

            //bind
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':name', $this->name);

            if($stmt->execute()){
                return true;
            }
            // print err if something wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
        // update category
        public function update(){
            // make query
            $query = "UPDATE " . $this->table .
            " SET 
                name = :name
                WHERE id =  :id";
            // prepare stmt
            $stmt = $this->conn->prepare($query);

            $this->name = htmlspecialchars(strip_tags($this->name));

            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":id", $this->id);

            if($stmt->execute()){
                return true;
            } else{
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }
        // delete category
        public function delete(){
            // query
            $query = "DELETE FROM " . $this->table .
            " WHERE id = :id";
            // clear input
            $this->name = htmlspecialchars(strip_tags($this->name));
            // prepare stmt
            $stmt = $this->conn->prepare($query);
            // bind param
            $stmt->bindParam(":id", $this->id);
            // execute
            if($stmt->execute()){
                return true;
            } else{
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }
    }
?>