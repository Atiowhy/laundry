<?php
// include '../config/db.php';
include '../config/db.php';

// select data level
$sqlDataLevel = mysqli_query($connection, "SELECT * FROM level ORDER BY id DESC");

// get data id
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$query = "SELECT * FROM level WHERE id = '$id'";
$sqlDataId = mysqli_query($connection, $query);
$resultDataId = mysqli_fetch_assoc($sqlDataId);

// insert data level
try {
    if (isset($_POST['add-level'])) {
        $nama_level = $_POST['nama_level'];

        // validasi form
        if (empty($nama_level)) {
            throw new Exception('Nama level tidak boleh kosong');
        }

        // insert data level
        $query = "INSERT INTO level (nama_level) VALUES ('$nama_level')";
        $sqlInsertLevel = mysqli_query($connection, $query);

        // validasi
        if ($sqlInsertLevel) {
            header('location: ../views/level.php?insert-success');
        } else {
            header('location: ../views/add-level.php?insert-failed');
        }
    }
} catch (\Throwable $th) {
    throw $th;
}

// delete
try {
    if (isset($_GET['delete'])) {
        $idDel = $_GET['delete'];
        $query = "DELETE FROM level WHERE id = '$idDel'";
        $sqlDelete = mysqli_query($connection, $query);

        if ($sqlDelete) {
            header('location: ../views/level.php?delete-success');
        } else {
            header('location: ../views/add-level.php?delete-failed');
        }
    }
} catch (\Throwable $th) {
    throw new Exception("Error Processing Request");
}

// edit
try {
    if (isset($_POST['edit-level'])) {
        $nama_level = $_POST['nama_level'];

        if (!$nama_level) {
            throw new Exception("Error Processing Request", 1);
        }
        $query = "UPDATE level SET nama_level = '$nama_level' WHERE id = '$id'";
        $sqlEdit = mysqli_query($connection, $query);

        if ($sqlEdit) {
            header('location: ../views/level.php?edit-success');
        } else {
            header('location: ../views/add-level.php?edit-failed');
        }
    }
} catch (\Throwable $th) {
    throw $th;
}
