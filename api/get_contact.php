<?php
    require_once('../includes/Contact.class.php');

    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        header('HTTP/1.1 405 Method Not Allowed');
        exit();
    }
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        Contact::get_ContactById($id);
    } else {
        Contact::get_AllContacts();
    }
?>