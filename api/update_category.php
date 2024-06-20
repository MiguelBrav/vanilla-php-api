<?php
    require_once('../includes/Category.class.php');

    if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
        header('HTTP/1.1 405 Method Not Allowed');
        exit();
    }
    
    $json_data = file_get_contents('php://input');

    if ($json_data === false || trim($json_data) === '') {
        header('HTTP/1.1 400 Bad Request');
        $response = array("message" => "Error: JSON without data.");
        echo json_encode($response);  
        exit();
    }

    $data = json_decode($json_data, true);
    
    if ($data !== null && isset($data['id']) && isset($data['name']) && isset($data['description'])) {
        $id = $data['id'];
        $name = $data['name'];
        $description = $data['description'];
    
        Category::update_Category($id,$name,$description);
    } else {
        header('HTTP/1.1 400 Bad Request');

        $response = array("message" => "Error: JSON invalid.");
        echo json_encode($response);      
    }
?>