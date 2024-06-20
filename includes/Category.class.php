<?php
require_once('Database.class.php');

class Category{
    public static function create_Category($name,$description){
        $database = new Database();
        $conn = $database->getConnection();

        // check if exists
        $checkStmt = $conn->prepare('SELECT COUNT(*) FROM Category WHERE name = :name');
        $checkStmt->bindParam(':name', $name);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();

        if ($count > 0) {
            header('HTTP/1.1 409 Conflict');
            $response = array("message" => "Category already exists");
            echo json_encode($response);          
            return;
        }
        
        $stmt = $conn->prepare('INSERT INTO Category (name,description) VALUES(:name, :description)');
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':description',$description);

        if($stmt->execute()){
            header('HTTP/1.1 201 Created');
            $response = array("message" => "Category created");
            echo json_encode($response);   
        }else{
            header('HTTP/1.1 404 Not Found');
            $response = array("message" => "Category failed to be created");
            echo json_encode($response);   
        }
    }
    
    public static function update_Category($id,$name,$description){
        $database = new Database();
        $conn = $database->getConnection();

        // check if not exists
        $checkStmt = $conn->prepare('SELECT COUNT(*) FROM Category WHERE id = :id');
        $checkStmt->bindParam(':id', $id);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();

        if ($count == 0) {
            header('HTTP/1.1 409 Conflict');
            $response = array("message" => "Category does not exists");
            echo json_encode($response);          
            return;
        }
        
        $stmt = $conn->prepare('UPDATE  Category SET name = :name, description = :description WHERE id = :id');
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':description',$description);

        if($stmt->execute()){
            header('HTTP/1.1 200 Ok');
            $response = array("message" => "Category updated");
            echo json_encode($response);   
        }else{
            header('HTTP/1.1 404 Not Found');
            $response = array("message" => "Category failed to be updated");
            echo json_encode($response);   
        }
    }

    public static function delete_Category($id){
        $database = new Database();
        $conn = $database->getConnection();

        // check if not exists
        $checkStmt = $conn->prepare('SELECT COUNT(*) FROM Category WHERE id = :id');
        $checkStmt->bindParam(':id', $id);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();

        if ($count == 0) {
            header('HTTP/1.1 409 Conflict');
            $response = array("message" => "Category does not exists");
            echo json_encode($response);          
            return;
        }
        
        $stmt = $conn->prepare('Delete from Category  WHERE id = :id');
        $stmt->bindParam(':id',$id);

        if($stmt->execute()){
            header('HTTP/1.1 200 Ok');
            $response = array("message" => "Category deleted");
            echo json_encode($response);   
        }else{
            header('HTTP/1.1 404 Not Found');
            $response = array("message" => "Category failed to be deleted");
            echo json_encode($response);  
        }
    }

    public static function get_AllCategories() {
        $database = new Database();
        $conn = $database->getConnection();
    
        $stmt = $conn->prepare('SELECT id,name,description FROM Category');
        $stmt->execute();
    
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if($categories) {
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            echo json_encode($categories);
        } else {
            header('HTTP/1.1 204 No Content');
        }
    }

    public static function get_CategoryById($id) {
        $database = new Database();
        $conn = $database->getConnection();
    
        $stmt = $conn->prepare('SELECT id,name,description FROM Category WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($category) {
            header('Content-Type: application/json');
            header('HTTP/1.1 200 OK');
            echo json_encode($category);
        } else {
            header('HTTP/1.1 204 No Content');
        }
    }
}
?>