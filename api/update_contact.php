<?php
    require_once('../includes/Contact.class.php');

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
    
    if ($data !== null && isset($data['name']) && isset($data['lastname']) && isset($data['email'])
    && isset($data['cellphone']) && isset($data['category_id']) && isset($data['id'])) {
        $id = $data['id'];
        $name = $data['name'];
        $lastname = $data['lastname'];
        $email = $data['email'];
        $cellphone = $data['cellphone'];
        $category_id = $data['category_id'];

        Contact::update_Contact($id,$name,$lastname,$email,$cellphone,$category_id);
    } else {
        header('HTTP/1.1 400 Bad Request');
        $response = array("message" => "Error: JSON invalid");
        echo json_encode($response);  
    }
?>