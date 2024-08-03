<?php
session_start();

function isLoggedIn()
{
    return isset($_SESSION['user']);
}

function getUser()
{
    return $_SESSION['user'] ?? null;
}

function login($username, $password)
{
    $users = json_decode(file_get_contents('data/users.json'), true);
    if (isset($users[$username]) && password_verify($password, $users[$username]['password'])) {
        $_SESSION['user'] = $username;
        return true;
    }
    return false;
}

function register($username, $password)
{
    $users = json_decode(file_get_contents('data/users.json'), true);
    if (!isset($users[$username])) {
        $users[$username] = ['password' => password_hash($password, PASSWORD_DEFAULT)];
        file_put_contents('data/users.json', json_encode($users));
        return true;
    }
    return false;
}

function addTodo($title)
{
    $todos = json_decode(file_get_contents('data/todos.json'), true);
    $user = getUser();
    $todos[$user][] = ['title' => $title, 'completed' => false];
    file_put_contents('data/todos.json', json_encode($todos));
}

function getTodos()
{
    $todos = json_decode(file_get_contents('data/todos.json'), true);
    $user = getUser();
    return $todos[$user] ?? [];

}

function updateTodo($index, $newTitle)
{
    $todos = json_decode(file_get_contents('data/todos.json'), true);
    $user = getUser();
    if (isset($todos[$user][$index])) {
        $todos[$user][$index]['title'] = $newTitle;
        file_put_contents('data/todos.json', json_encode($todos));
    }
}

function deleteTodo($index)
{
    $todos = json_decode(file_get_contents('data/todos.json'), true);
    $user = getUser();
    unset($todos[$user][$index]);
    $todos[$user] = array_values($todos[$user]); // Reindex array
    file_put_contents('data/todos.json', json_encode($todos));
}


function getUserProfile($username) {
    $users = json_decode(file_get_contents('data/users.json'), true);
    return $users[$username] ?? null;
}


function updateUserProfile($username, $password = null) {
    $file = 'data/users.json';
    $users = json_decode(file_get_contents($file), true);

    if (isset($users[$username])) {
        if ($password) {
            $users[$username]['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));
        return true;
    }
    return false;
}
