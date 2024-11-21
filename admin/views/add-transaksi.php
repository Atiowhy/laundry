<?php
session_start();
include '../controller/action_customer.php';
include '../controller/action_transaksi.php';
include '../controller/action_service.php';
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
                    <?php if (isset($_GET['detail'])) : ?>
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h5>Transaksi Laundry <?= $row[0]['customer_name'] ?></h5>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="list d-flex justify-content-end gap-4">
                                                        <a href="transaksi.php" class="btn btn-info">Kembali</a>
                                                        <a target="_blank" href="print.php?id=<?= $idDetail ?>" class="btn btn-warning">Print</a>
                                                        <?php if ($row[0]['order_status'] == 0) : ?>
                                                            <a href="add-transaksi-pickup.php?pickup=<?= $idDetail ?>" class="btn btn-success">Ambil Cucian</a>
                                                        <?php endif ?>
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
                                                        <td><?= $row[0]['order_code'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tanggal Laundry</th>
                                                        <td><?= $row[0]['order_date'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status</th>
                                                        <td>
                                                            <?php switch ($row[0]['order_status']) {
                                                                case '1':
                                                                    $badge = "<span class='badge bg-success '>Sudah dikembalikan</span>";
                                                                    break;
                                                                default:
                                                                    $badge = "<span class='badge text-black bg-warning'> baru</span>";
                                                                    break;
                                                            }
                                                            echo $badge
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
                                                        <td><?= $row[0]['customer_name'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Telepon</th>
                                                        <td><?= $row[0]['phone'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Alamat</th>
                                                        <td><?= $row[0]['address'] ?></td>
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
                                                        $no = 1;
                                                        foreach ($row as $key => $value) : ?>
                                                            <tr>
                                                                <td><?= $no++ ?></td>
                                                                <td><?= $value['service_name'] ?></td>
                                                                <td><?= $value['price'] ?></td>
                                                                <td><?= $value['qty'] ?></td>
                                                                <td><?= $value['subtotal'] ?></td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <form action='../controller/action_transaksi.php?edit=<?php echo isset($_GET['edit']) ? $resultDataUser['id'] : ''; ?>' method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-header fs-1"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Transaksi</div>
                                            <div class="card-body">
                                                <?php if (isset($_GET['success-delete'])): ?>
                                                    <div id="alert" class="alert alert-success" role="alert">Deleted Success</div>
                                                <?php endif; ?>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-12">
                                                        <label for="" class="form-label">Name Customer</label>
                                                        <select name="id_customer" class="form-control" id="">
                                                            <option value="">Pilih customer</option>
                                                            <?php while ($resultDataCustomer = mysqli_fetch_assoc($dataCustomer)): ?>
                                                                <option value="<?= $resultDataCustomer['id'] ?>"><?= $resultDataCustomer['customer_name'] ?></option>
                                                            <?php endwhile; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-4 row">
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Tanggal Transaksi</label>
                                                        <input type="date" name="order_date" class="form-control">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Kode Transaksi</label>
                                                        <input type="text" value="<?= $code ?>" class="form-control" name="order_code" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="card">
                                            <div class="card-header fs-1">Detail Transaksi</div>

                                            <div class="card-body">
                                                <?php if (isset($_GET['success-delete'])): ?>
                                                    <div id="alert" class="alert alert-success" role="alert">Deleted Success</div>
                                                <?php endif; ?>

                                                <div class="mb-3 row">
                                                    <div class="col-sm-1">
                                                        <label for="" class="form-label">Paket</label>
                                                    </div>
                                                    <div class="col-11">
                                                        <select name="id_service[]" class="form-control" id="">
                                                            <option value="">Pilih paket</option>
                                                            <?php foreach ($rowPaket as $key => $value): ?>
                                                                <option value="<?= $value['id'] ?>"><?= $value['service_name'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-4 row">
                                                    <div class="col-sm-1">
                                                        <label for="" class="form-label">Qty</label>
                                                    </div>
                                                    <div class="col-sm-11">
                                                        <input name="qty[]" class="form-control" value="" type="text">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-1">
                                                        <label for="" class="form-label">Paket</label>
                                                    </div>
                                                    <div class="col-11">
                                                        <select name="id_service[]" class="form-control" id="">
                                                            <option value="">Pilih paket</option>
                                                            <?php foreach ($rowPaket as $key => $value): ?>
                                                                <option value="<?= $value['id'] ?>"><?= $value['service_name'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-4 row">
                                                    <div class="col-sm-1">
                                                        <label for="" class="form-label">Qty</label>
                                                    </div>
                                                    <div class="col-sm-11">
                                                        <input name="qty[]" class="form-control" value="" type="text">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-12">
                                                        <button class="btn btn-primary w-100 shadow-lg" name="simpan" type="submit">Tambah Transaksi</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
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