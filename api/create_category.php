<?php
    require_once('../includes/Category.class.php');

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
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
    
    if ($data !== null && isset($data['name']) && isset($data['description'])) {
        $name = $data['name'];
        $description = $data['description'];
    
        Category::create_Category($name,$description);
    } else {
        header('HTTP/1.1 400 Bad Request');
        $response = array("message" => "Error: JSON invalid");
        echo json_encode($response);  
    }
?>