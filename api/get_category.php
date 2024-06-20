<?php
    require_once('../includes/Category.class.php');

    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        header('HTTP/1.1 405 Method Not Allowed');
        exit();
    }
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        Category::get_CategoryById($id);
    } else {
        Category::get_AllCategories();
    }
?>