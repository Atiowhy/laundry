<?php
include '../config/db.php';

// get data customer
$dataCustomer = mysqli_query($connection, "SELECT * FROM customer ORDER BY id DESC");

// get data customer by id
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$dataCustomerId = mysqli_query($connection, "SELECT * FROM customer WHERE id = '$id' ORDER BY id DESC");
$resultDataCustomerId = mysqli_fetch_assoc($dataCustomerId);

// insert data customer
try {
    if (isset($_POST['add-customer'])) {
        $nama_customer = $_POST['customer_name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $queryInsert = mysqli_query($connection, "INSERT INTO customer (customer_name, phone, address) VALUES ('$nama_customer', '$phone', '$address')");

        if ($queryInsert) {
            header('location: ../views/customer.php?insert-success');
        } else {
            header('location: ../views/add-customer.php?insert-failed');
        }
    }
} catch (\Throwable $th) {
    throw $th;
}

// edit data customer
try {
    if (isset($_POST['edit-customer'])) {
        $nama_customer = $_POST['customer_name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $queryEdit = mysqli_query($connection, "UPDATE customer SET customer_name = '$nama_customer', phone = '$phone', address = '$address' WHERE id = '$id'");

        if ($queryEdit) {
            header('location: ../views/customer.php?edit-success');
        } else {
            header('location: ../views/edit-customer.php?edit-failed');
        }
    }
} catch (\Throwable $th) {
    throw $th;
}

// delete customer
try {
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];

        $queryDelete = mysqli_query($connection, "DELETE FROM customer WHERE id = '$id'");

        if ($queryDelete) {
            header('location: ../views/customer.php?delete-success');
        } else {
            header('location: ../views/customer.php?delete-failed');
        }
    }
} catch (\Throwable $th) {
    throw $th;
}
