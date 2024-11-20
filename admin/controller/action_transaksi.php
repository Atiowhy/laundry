<?php
include '../config/db.php';

// select data
$dataTransaksi = mysqli_query($connection, "SELECT customer.customer_name, transaksi.* FROM transaksi LEFT JOIN customer ON customer.id = transaksi.id_customer ORDER BY id DESC");

// get data detail transaksi
$id = isset($_GET['detail']) ? $_GET['detail'] : '';
$queryDetailTrans = mysqli_query($connection, "SELECT customer.customer_name, type_of_service.service_name, transaksi.order_code, transaksi.order_date, detail_transaksi.* FROM detail_transaksi LEFT JOIN transaksi ON transaksi.id = detail_transaksi.id_order LEFT JOIN type_of_service ON type_of_service.id = detail_transaksi.id_service LEFT JOIN customer ON customer.id = transaksi.id_customer WHERE transaksi.id = '$id'");

// get data paket detail
$queryPaketDetail = mysqli_query($connection, "SELECT customer.customer_name, customer.phone, customer.address, transaksi.order_code, transaksi.order_date, transaksi.order_status, type_of_service.service_name, type_of_service.price, detail_transaksi.* FROM detail_transaksi LEFT JOIN type_of_service ON detail_transaksi.id_service = type_of_service.id LEFT JOIN transaksi ON transaksi.id = detail_transaksi.id_order LEFT JOIN customer ON customer.id = transaksi.id_customer WHERE detail_transaksi.id_order = '$id'");
// $rowPaketDetail = mysqli_fetch_assoc($queryPaketDetail);
$row = [];
while ($dataDetailTrans = mysqli_fetch_assoc($queryPaketDetail)) {
    $row[] = $dataDetailTrans;
}
// echo "<pre>";
// print_r($row);
// die;

// tanggal transaksi
$transaksiDate = date('l, d-m-y');

// no invoice
// 001, jika ada, auto increment id + 1, selain itu 001
// MAX : terbesar MIN : terkecil
$queryInvoice = mysqli_query($connection, "SELECT MAX(id) AS no_invoice FROM transaksi");
// jika didalam table transaksi ada datanya
$string_unique = "INV";
$currentDate = date('dmy');
if (mysqli_num_rows($queryInvoice) > 0) {
    $rowInvoice = mysqli_fetch_assoc($queryInvoice);
    $incrementCode = $rowInvoice['no_invoice'] + 1;
    $code = $string_unique . "/" . $currentDate . "/" . "000" . "/" . $incrementCode;
} else {
    $code = "0001";
}

// simpan
if (isset($_POST['simpan'])) {
    $id_customer = $_POST['id_customer'];
    $order_date = $_POST['order_date'];
    $order_code = $_POST['order_code'];

    // insert ke table trans-order
    $queryInsert = mysqli_query($connection, "INSERT INTO transaksi (id_customer, order_date, order_code) VALUES ('$id_customer', '$order_date', '$order_code')");


    // looping transaksi
    // ambil id terakhir
    $last_id = mysqli_insert_id($connection);

    // mengambil nilai yang lebih dari satu
    $id_service = $_POST['id_service'];
    // insert ke table trans-order-detail
    foreach ($id_service as $key => $value) {
        $id_service = array_filter($_POST['id_service']);
        $qty = array_filter($_POST['qty']);
        $id_service = $_POST['id_service'][$key];
        $qty = $_POST['qty'][$key];

        // query untuk mengambil harga dari table type_of_service
        $queryPaket = mysqli_query($connection, "SELECT id, price FROM type_of_service WHERE id = '$id_service'");
        $rowPaket = mysqli_fetch_assoc($queryPaket);
        $harga = isset($rowPaket['price']) ? $rowPaket['price'] : '';

        // subtotal
        $subtotal = (int)$qty * (int)$harga;

        if ($id_service > 0) {
            $insertTransDetail = mysqli_query($connection, "INSERT INTO detail_transaksi (id_order, id_service, qty, subtotal) VALUES ('$last_id', '$id_service', '$qty', '$subtotal')");
        }
    }
    header('location: ../views/transaksi.php');
}

// delete transaksi
try {
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $sqlDelete = mysqli_query($connection, "DELETE FROM transaksi WHERE id = '$id'");
        if ($sqlDelete) {
            header('location: ../views/transaksi.php?delete-success');
        } else {
            header('location: ../views/transaksi.php?delete-failed');
        }
    }
} catch (\Throwable $th) {
    throw $th;
}