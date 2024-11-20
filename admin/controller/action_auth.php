<?php
session_start();
include '../config/db.php';

// register
if (isset($_POST['register'])) {
    $id_level = $_POST['id_level'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    if (!$name || !$email || !$password) {
        header('location: ../register.php?fill-the-form');
    }

    $sqlRegister = mysqli_query($connection, "INSERT INTO users (id_level, name, email, password) VALUES ('$id_level', '$name', '$email', '$password')");

    if ($sqlRegister) {
        header('location: ../index.php?register-success');
    } else {
        header('location: ../register.php?register-failed');
    }
}

// login
function loginQuery($connection, $kolom, $params)
{
    $query = mysqli_query($connection, "SELECT * FROM users WHERE $kolom = '$params'");
    if (mysqli_num_rows($query) > 0) {
        return $query;
    } else {
        return false;
    }
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    // login dengan username
    $queryLogin = loginQuery($connection, "name", $email);
    $queryEmail = loginQuery($connection, "email", $email);

    if ($queryLogin) {
        $rowLogin = mysqli_fetch_assoc($queryLogin);
        if ($password == $rowLogin['password']) {
            $_SESSION['name'] = $rowLogin['name'];
            $_SESSION['id'] = $rowLogin['id'];
            $_SESSION['id_level'] = $rowLogin['id_level'];
            header('location: ../views/dashboard.php?login-name-success');
        } else {
            header('location: ../index.php?login-failed');
        }
    } elseif ($queryEmail) {
        $rowLogin = mysqli_fetch_assoc($queryEmail);
        // print_r($rowLogin);
        // die;
        if ($password == $rowLogin['password']) {
            $_SESSION['name'] = $rowLogin['name'];
            $_SESSION['id'] = $rowLogin['id'];
            $_SESSION['id_level'] = $rowLogin['id_level'];
            header('location: ../views/dashboard.php?login-email-success');
        } else {
            header('location: ../index.php?login-failed');
        }
    }
}
