<?php
session_start();
include '../controller/action_transaksi.php';
include '../config/db.php';

$tanggal_dari = isset($_GET['tanggal-dari']) ? $_GET['tanggal-dari'] : '';
$tanggal_sampai = isset($_GET['tanggal-sampai']) ? $_GET['tanggal-sampai'] : '';
$order_status = isset($_GET['order_status']) ? $_GET['order_status'] : '';


$query = "SELECT customer.customer_name, transaksi.* FROM transaksi LEFT JOIN customer ON customer.id = transaksi.id_customer";

// jika paramater status tidak 0
if ($tanggal_dari != "") {
    $query .= " WHERE transaksi.order_date = '$tanggal_dari'";
}
if ($tanggal_sampai != "") {
    $query .= " OR transaksi.order_date = '$tanggal_sampai'";
}
if ($order_status != "") {
    $query .= " AND transaksi.order_status = $order_status";
    // print_r($query);
    // die;
}

$sqldataTransaksi = mysqli_query($connection, $query);
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
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header fs-1">Data Transaksi</div>
                                    <div class="card-body">
                                        <?php if (isset($_GET['success-delete'])): ?>
                                            <div id="alert" class="alert alert-success" role="alert">Deleted Success</div>
                                        <?php endif; ?>
                                        <!-- filter data transaksi -->
                                        <div class="filter d-flex">
                                            <p>Filter</p>
                                            <span class="bx bx-filter"></span>
                                        </div>
                                        <form action="" method="get">
                                            <div class="mb-3 row">
                                                <div class="col-sm-3">
                                                    <label class="form-label">Tanggal Dari</label>
                                                    <input type="date" name="tanggal-dari" class="form-control">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="form-label">Tanggal Sampai</label>
                                                    <input type="date" name="tanggal-sampai" class="form-control">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="order_status" id="" class="form-control">
                                                        <option value="">--Pilih Status--</option>
                                                        <option value="0">Baru</option>
                                                        <option value="1">Sudah Dikembalikan</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3 d-flex align-items-end">
                                                    <button name="filter" class="btn btn-primary">Tampilkan Laporan</button>
                                                </div>
                                            </div>
                                        </form>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-primary ">
                                                    <th class="text-white">No</th>
                                                    <th class="text-white">Nama Customer</th>
                                                    <th class="text-white">Kode Transaksi</th>
                                                    <th class="text-white">Tanggal Transaksi</th>
                                                    <th class="text-white">Status</th>
                                                    <th class="text-white">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                while ($rowDataTransaksi = mysqli_fetch_assoc($sqldataTransaksi)):
                                                ?>
                                                    <tr>
                                                        <td><?php echo  $no++; ?></td>
                                                        <td><?php echo  $rowDataTransaksi['customer_name'] ?></td>
                                                        <td><?php echo  $rowDataTransaksi['order_code'] ?></td>
                                                        <td><?php echo  $rowDataTransaksi['order_date'] ?></td>
                                                        <td><?php
                                                            switch ($rowDataTransaksi['order_status']) {
                                                                case '1':
                                                                    $badge = "<span class='badge bg-success '>Sudah dikembalikan</span>";
                                                                    break;

                                                                default:
                                                                    $badge = "<span class='badge bg-warning '>Baru</span>";
                                                                    break;
                                                            }
                                                            echo $badge;
                                                            ?></td>
                                                        <td>
                                                            <a href="../views/add-transaksi.php?detail=<?php echo $rowDataTransaksi['id'] ?>" class="btn btn-primary btn-sm"><span class="tf-icon bx bx-show">Detail</span></a>
                                                            <a target="_blank" href="../views/print.php?id=<?php echo $rowDataTransaksi['id'] ?>" class="btn btn-warning btn-sm"><span class="tf-icon bx bx-printer">Print</span></a>
                                                        </td>
                                                    </tr>
                                                <?php endwhile ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
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