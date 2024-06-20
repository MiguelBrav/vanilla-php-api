<?php
    require_once('../includes/Contact.class.php');

    if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
        header('HTTP/1.1 405 Method Not Allowed');
        exit();
    }
    
    if (isset($_GET['id'])){
        $id = $_GET['id'];

        Contact::delete_Contact($id);
    } else {
        header('HTTP/1.1 400 Bad Request');
        $response = array("message" => "Error: Missing id parameter.");
        echo json_encode($response);  
    }
?>