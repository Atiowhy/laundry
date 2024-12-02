<?php
include '../config/db.php';

// select user
$sqlDataUser = mysqli_query($connection, "SELECT users.*, level.nama_level FROM users LEFT JOIN level ON users.id_level = level.id");

// insert user
try {
    if (isset($_POST['add-user'])) {
        $id_level = $_POST['id_level'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = sha1($_POST['password']);

        if (!$id_level || !$name || !$email || !$password) {
            throw new Exception("Error Processing Request", 1);
        }

        $query = "INSERT INTO users (id_level, name, email, password) VALUES ('$id_level', '$name', '$email', '$password')";
        $sqlInsert = mysqli_query($connection, $query);

        if ($sqlInsert) {
            header('location: ../views/user.php?insert-success');
        } else {
            header('location: ../views/user.php?insert-failed');
        }
    }
} catch (\Throwable $th) {
    //throw $th;
}

// delete
try {
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $sqlDelete = mysqli_query($connection, "DELETE FROM users WHERE id = '$id'");
        if ($sqlDelete) {
            header('location: ../views/user.php?delete-success');
        } else {
            header('location: ../views/user.php?delete-failed');
        }
    }
} catch (\Throwable $th) {
    throw $th;
}

// updateUsers
$idEdit = isset($_GET['edit']) ? $_GET['edit'] : '';
$dataUserId = mysqli_query($connection, "SELECT users.*, level.nama_level FROM users LEFT JOIN level ON users.id_level = level.id WHERE users.id = '$id'");
$resultDataUser = mysqli_fetch_assoc($dataUserId);

// queryUpdate
try {
    if (isset($_POST['edit-user'])) {
        $id_level = $_POST['id_level'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        if (empty($resultDataUser['id_level'])) {
            $sqlUpdate = mysqli_query($connection, "UPDATE users SET id_level = '$id_level', name = '$name', email = '$email' WHERE id = '$idEdit'");

            if ($sqlUpdate) {
                header('location: ../views/user.php?update-success');
            } else {
                header('location: ../views/user.php?update-failed');
            }
        } else {
            $sqlUpdate = mysqli_query($connection, "UPDATE users SET  name = '$name', email = '$email' WHERE id = '$idEdit'");
            if ($sqlUpdate) {
                header('location: ../views/user.php?update-success');
            } else {
                header('location: ../views/user.php?update-failed');
            }
        }
    }
} catch (\Throwable $th) {
    throw $th;
}
