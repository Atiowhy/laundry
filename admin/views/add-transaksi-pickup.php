<?php
session_start();
include '../controller/action_customer.php';
include '../controller/action_transaksi.php';
include '../controller/action_service.php';
include '../config/db.php';
include 'helper.php';

// simpan transaksi
if (isset($_POST['simpan-transaksi'])) {
    // print_r($_POST);
    // die;
    $id_customer = $_POST['id_customer'];
    $id_order = $_POST['id_order'];
    $pickup_pay = $_POST['pickup_pay'];
    $pickup_change = $_POST['pickup_change'];
    $pickup_date = date("Y-m-d");

    $sqlInsertTransaksi = mysqli_query($connection, "INSERT INTO trans_laundry_pickup (id_customer, id_order, pickup_pay, pickup_change, pickup_date) VALUES ('$id_customer', '$id_order', '$pickup_pay', '$pickup_change', '$pickup_date')");

    // ubah status order
    $updateTransaksiStatus = mysqli_query($connection, "UPDATE transaksi SET order_status = 1 WHERE id = '$id_order'");

    header('location: transaksi.php?insert-berhasil');
}
?>

<!DOCTYPE html>
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>
    <meta name="description" content="" />
    <?php include '../inc/css.php' ?>
</head>
<!-- <style>
    * {
        background-color: black;
    }
</style> -->

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <?php include '../inc/sideBar.php' ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?php include '../inc/navbar.php' ?>
                <!-- / Navbar -->
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <?php if (isset($_GET['pickup'])) : ?>
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h5>Transaksi Laundry <?= $rowPickup[0]['customer_name'] ?></h5>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="list d-flex justify-content-end gap-4">
                                                        <a href="transaksi.php" class="btn btn-info">Kembali</a>
                                                        <a target="_blank" href="print.php?id=<?= $idDetail ?>" class="btn btn-warning">Print</a>
                                                        <a href="" class="btn btn-success">Ambil Cucian</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Detail Transaksi</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <tr>
                                                        <th>No Invoice</th>
                                                        <td><?= $rowPickup[0]['order_code'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tanggal Laundry</th>
                                                        <td><?= $rowPickup[0]['order_date'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status</th>
                                                        <td>
                                                            <?php
                                                            echo changeStatus($rowPickup[0]['order_status'])
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Data Pelanggan</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <tr>
                                                        <th>Nama</th>
                                                        <td><?= $rowPickup[0]['customer_name'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Telepon</th>
                                                        <td><?= $rowPickup[0]['phone'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Alamat</th>
                                                        <td><?= $rowPickup[0]['address'] ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Transaksi Detail</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table table-responsive">
                                                <form action="" method="post">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <th>No</th>
                                                            <th>Nama Paket</th>
                                                            <th>Harga</th>
                                                            <th>Qty</th>
                                                            <th>Subtotal</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $total = 0;
                                                            $no = 1;
                                                            foreach ($rowPickup as $key => $value) : ?>
                                                                <tr>
                                                                    <td><?= $no++ ?></td>
                                                                    <td><?= $value['service_name'] ?></td>
                                                                    <td><?= $value['price'] ?></td>
                                                                    <td><?= $value['qty'] ?></td>
                                                                    <td><?= $value['subtotal'] ?></td>
                                                                </tr>
                                                                <?php

                                                                $total += $value['subtotal'];
                                                                ?>
                                                            <?php endforeach ?>
                                                            <tr>
                                                                <td colspan="4" align="right">
                                                                    <strong>Total Keseluruhan</strong>
                                                                </td>
                                                                <td>
                                                                    <strong><?= "Rp" . number_format($total) ?></strong>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" align="right">
                                                                    <strong>Dibayar</strong>
                                                                </td>
                                                                <td>
                                                                    <strong>
                                                                        <?php if (mysqli_num_rows($sqlTransPick)): ?>
                                                                            <?php $rowTransPickup = mysqli_fetch_assoc($sqlTransPick) ?>
                                                                            <input type="number" name="pickup_pay" placeholder="dibayar" value="<?= $rowTransPickup['pickup_pay'] ?>" class="form-control" readonly>
                                                                        <?php else: ?>
                                                                            <input type="number" name="pickup_pay" placeholder="dibayar" value="<?= isset($_POST['pickup_pay']) ? $_POST['pickup_pay'] : '' ?>" class="form-control">
                                                                        <?php endif ?>
                                                                    </strong>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" align="right">
                                                                    <strong>Kembalian</strong>
                                                                </td>
                                                                <?php
                                                                if (isset($_POST['proses-kembali'])) {
                                                                    $total = $_POST['total'];
                                                                    $dibayar = $_POST['pickup_pay'];
                                                                    $totalKembali = 0;
                                                                    $totalKembali = (int)$dibayar - (int)$total;
                                                                }
                                                                ?>
                                                                <td>
                                                                    <strong>

                                                                        <?php if (mysqli_num_rows($sqlTransPick)): ?>
                                                                            <input type="number" name="pickup_change" placeholder="Kembalian" class="form-control" readonly value="<?= $rowTransPickup['pickup_change'] ?>">
                                                                        <?php else: ?>
                                                                            <input type="number" name="pickup_change" placeholder="Kembalian" class="form-control" readonly value="<?= isset($totalKembali) ? $totalKembali : 0 ?>">
                                                                        <?php endif ?>


                                                                        <input type="hidden" name="total" value="<?= $total ?>">
                                                                        <input type="hidden" name="id_customer" value="<?= $rowPickup[0]['id_customer'] ?>">
                                                                        <input type="hidden" name="id_order" value="<?= $rowPickup[0]['id_order'] ?>">
                                                                    </strong>
                                                                </td>
                                                            </tr>
                                                            <?php if ($rowPickup[0]['order_status'] == 0) : ?>
                                                                <tr>
                                                                    <td colspan="5" align="right">
                                                                        <button class="btn btn-primary me-2" name="proses-kembali">Proses Kembalian</button>
                                                                        <button class="btn btn-success" name="simpan-transaksi">Simpan Transaksi</button>
                                                                    </td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <!-- Footer -->
                    <?php include '../inc/footer.php' ?>
                    <!-- / Footer -->
                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->


    <?php include '../inc/js.php' ?>
</body>

</html>