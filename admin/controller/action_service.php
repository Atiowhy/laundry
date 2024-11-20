<?php
include '../config/db.php';

// get data service
$queryGetData = mysqli_query($connection, "SELECT * FROM type_of_service ORDER BY id DESC");



// looping data paket
$rowPaket = [];
while ($dataPaket = mysqli_fetch_assoc($queryGetData)) {
    $rowPaket[] = $dataPaket;
}

// get data service by id
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryGetDataById = mysqli_query($connection, "SELECT * FROM type_of_service WHERE id = '$id'");
$dataServiceId = mysqli_fetch_assoc($queryGetDataById);

// insert data service
try {
    if (isset($_POST['add-service'])) {
        $service_name = $_POST['service_name'];
        $price = $_POST['price'];
        $deskripsi = $_POST['description'];

        $queryAdd = mysqli_query($connection, "INSERT INTO type_of_service (service_name, price, description) VALUES ('$service_name', '$price', '$deskripsi')");

        if ($queryAdd) {
            header('location: ../views/service.php?insert-success');
        } else {
            header('location: ../views/service.php?insert-failed');
        }
    }
} catch (\Throwable $th) {
    throw $th;
}

// update service
try {
    if (isset($_POST['edit-service'])) {
        $service_name = $_POST['service_name'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        $queryUpdate = mysqli_query($connection, "UPDATE type_of_service SET service_name = '$service_name', price = '$price', description = '$description' WHERE id = '$id'");

        if ($queryUpdate) {
            header('location: ../views/service.php?update-success');
        } else {
            header('location: ../views/service.php?update-failed');
        }
    }
} catch (\Throwable $th) {
    throw $th;
}

// delete data service
try {
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];

        $queryDelete = mysqli_query($connection, "DELETE FROM type_of_service WHERE id = '$id'");

        if ($queryDelete) {
            header('location: ../views/service.php?delete-success');
        } else {
            header('location: ../views/service.php?delete-failed');
        }
    }
} catch (\Throwable $th) {
    throw $th;
}
