<?php
require 'functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'], $_GET['index'])) {
    if ($_GET['action'] === 'edit') {
        $index = $_GET['index'];
        $todos = getTodos();
        $task = $todos[$index]['title'];
        // Render edit form
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'], $_GET['index'])) {
    if ($_GET['action'] === 'delete') {
        deleteTodo($_GET['index']);
    }
    header('Location: index.php');
    exit();
}
