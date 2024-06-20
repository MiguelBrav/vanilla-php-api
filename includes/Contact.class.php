<?php
require_once('Database.class.php');

class Contact{
    public static function create_Contact($name,$lastname,$email,$cellphone,$categoryid){
        $database = new Database();
        $conn = $database->getConnection();

        // check if exists
        $checkStmt = $conn->prepare('SELECT COUNT(*) FROM Contact WHERE name = :name and lastname = :lastname');
        $checkStmt->bindParam(':name', $name);
        $checkStmt->bindParam(':lastname', $lastname);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();

        if ($count > 0) {
            header('HTTP/1.1 409 Conflict');
            $response = array("message" => "Contact already exists");
            echo json_encode($response);          
            return;
        }
        
        $stmt = $conn->prepare('INSERT INTO Contact (name,lastname,email,cellphone,category_id)
         VALUES(:name, :lastname,:email,:cellphone,:category_id)');
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':lastname',$lastname);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':cellphone',$cellphone);
        $stmt->bindParam(':category_id',$categoryid);

        try {
            if($stmt->execute()){
                header('HTTP/1.1 201 Created');
                $response = array("message" => "Contact created");
                echo json_encode($response);   
            }else{
                header('HTTP/1.1 404 Not Found');
                $response = array("message" => "Contact failed to be created");
                echo json_encode($response);   
            }
        }  catch (PDOException $e) {
            header('HTTP/1.1 500 Internal Server Error');
            $response = array("message" => "Database error: " . $e->getMessage());
            echo json_encode($response);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            $response = array("message" => "An error occurred: " . $e->getMessage());
            echo json_encode($response);
        }
    }

    public static function update_Contact($contactId,$name,$lastname,$email,$cellphone,$categoryid){
        $database = new Database();
        $conn = $database->getConnection();

        // check if exists
        $checkStmt = $conn->prepare('SELECT COUNT(*) FROM Contact WHERE id = :id');
        $checkStmt->bindParam(':id', $contactId);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();

        if ($count == 0) {
            header('HTTP/1.1 409 Conflict');
            $response = array("message" => "Contact does not exists");
            echo json_encode($response);          
            return;
        }
        
        $stmt = $conn->prepare('UPDATE Contact set name = :name, lastname = :lastname, 
        email = :email, cellphone = :cellphone, category_id = :category_id 
        where id = :id');
        $stmt->bindParam(':id', $contactId);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':lastname',$lastname);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':cellphone',$cellphone);
        $stmt->bindParam(':category_id',$categoryid);

        try {
            if($stmt->execute()){
                header('HTTP/1.1 200');
                $response = array("message" => "Contact updated");
                echo json_encode($response);   
            }else{
                header('HTTP/1.1 404 Not Found');
                $response = array("message" => "Contact failed to be updated");
                echo json_encode($response);   
            }
        } catch (PDOException $e) {
            header('HTTP/1.1 500 Internal Server Error');
            $response = array("message" => "Database error: " . $e->getMessage());
            echo json_encode($response);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            $response = array("message" => "An error occurred: " . $e->getMessage());
            echo json_encode($response);
        }
    }

    public static function delete_Contact($contactId){
        $database = new Database();
        $conn = $database->getConnection();

        // check if exists
        $checkStmt = $conn->prepare('SELECT COUNT(*) FROM Contact WHERE id = :id');
        $checkStmt->bindParam(':id', $contactId);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();

        if ($count == 0) {
            header('HTTP/1.1 409 Conflict');
            $response = array("message" => "Contact does not exists");
            echo json_encode($response);          
            return;
        }
        
        $stmt = $conn->prepare('Delete from Contact WHERE id = :id');
        $stmt->bindParam(':id', $contactId);


        try {
            if($stmt->execute()){
                header('HTTP/1.1 200');
                $response = array("message" => "Contact deleted");
                echo json_encode($response);   
            }else{
                header('HTTP/1.1 404 Not Found');
                $response = array("message" => "Contact failed to be deleted");
                echo json_encode($response);   
            }
        } catch (PDOException $e) {
            header('HTTP/1.1 500 Internal Server Error');
            $response = array("message" => "Database error: " . $e->getMessage());
            echo json_encode($response);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            $response = array("message" => "An error occurred: " . $e->getMessage());
            echo json_encode($response);
        }
    }

    public static function get_AllContacts() {
        $database = new Database();
        $conn = $database->getConnection();
    
        $stmt = $conn->prepare('SELECT id,name,lastname,email,cellphone,category_id FROM Contact');
        $stmt->execute();
    
        $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        try {
            if($contacts) {
                header('Content-Type: application/json');
                header('HTTP/1.1 200 OK');
                echo json_encode($contacts);
            } else {
                header('HTTP/1.1 204 No Content');
            }
        } catch (PDOException $e) {
            header('HTTP/1.1 500 Internal Server Error');
            $response = array("message" => "Database error: " . $e->getMessage());
            echo json_encode($response);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            $response = array("message" => "An error occurred: " . $e->getMessage());
            echo json_encode($response);
        }
    }

    public static function get_ContactById($id) {
        $database = new Database();
        $conn = $database->getConnection();
    
        $stmt = $conn->prepare('SELECT id, name, lastname, email, cellphone, category_id FROM Contact WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
        try {
            $stmt->execute();    
            $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if($contact) {
                header('Content-Type: application/json');
                header('HTTP/1.1 200 OK');
                echo json_encode($contact);
            } else {
                header('HTTP/1.1 204 No Content');
            }
        } catch (PDOException $e) {
            header('HTTP/1.1 500 Internal Server Error');
            $response = array("message" => "Database error: " . $e->getMessage());
            echo json_encode($response);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            $response = array("message" => "An error occurred: " . $e->getMessage());
            echo json_encode($response);
        }
    }
}
?>