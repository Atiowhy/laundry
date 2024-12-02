<?php
session_start();
include '../controller/action_customer.php';
include '../controller/action_transaksi.php';
include '../controller/action_service.php';
include '../config/db.php';

$queryGetData = mysqli_query($connection, "SELECT * FROM type_of_service ORDER BY id DESC");

if (isset($_POST['ambil'])) {
    // print_r($_POST);
    // die;
    $id_customer = $_POST['id_customer'];
    $id_order = $_POST['id_order'];
    $pickup_date = date("Y-m-d");

    $sqlInsertTransaksi = mysqli_query($connection, "INSERT INTO trans_laundry_pickup (id_customer, id_order, pickup_date) VALUES ('$id_customer', '$id_order', '$pickup_date')");

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
                    <?php if (isset($_GET['detail'])) : ?>
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h5>Transaksi Laundry <?= $row[0]['customer_name'] ?>

                                                    </h5>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="list d-flex justify-content-end gap-4">
                                                        <a href="transaksi.php" class="btn btn-info">Kembali</a>
                                                        <a target="_blank" href="print.php?id=<?= $idDetail ?>" class="btn btn-warning">Print</a>

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
                                                        <th>Tanggal Selesai</th>
                                                        <td><?= $row[0]['order_end_date'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tanggal Selesai</th>
                                                        <td><?= $row[0]['order_end_date'] ?></td>
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
                                                        <td>
                                                            <?= $row[0]['customer_name'] ?>


                                                        </td>
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
                                    <form method="post">
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
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="4" align="right">Total</td>
                                                                <td>
                                                                    <input type="number" name="total_price" class="total-harga form-control" value="<?= $row[0]['total'] ?>" readonly>
                                                                    <input type="hidden" name="id_customer" value="<?= $rowPickup[0]['id_customer'] ?>">
                                                                    <input type="hidden" name="id_order" value="<?= $rowPickup[0]['id_order'] ?>">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" align="right">Bayar</td>
                                                                <td>
                                                                    <input type="number" name="pickup_pay" class="bayar form-control" value="<?= $row[0]['pickup_pay'] ?>">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" align="right">kembalian</td>
                                                                <td>
                                                                    <input type="number" name="pickup_change" class="bayar form-control" value="<?= $row[0]['pickup_change'] ?>">
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                    <?php if ($row[0]['order_status'] == 0) : ?>
                                                        <button class="btn btn-success mt-3" type="submit" name="ambil">Ambil</button>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <form action="../controller/action_transaksi.php" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="card">
                                            <div class="card-header fs-1"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Transaksi</div>
                                            <div class="card-body">
                                                <?php if (isset($_GET['success-delete'])): ?>
                                                    <div id="alert" class="alert alert-success" role="alert">Deleted Success</div>
                                                <?php endif; ?>
                                                <div class="mb-3 row">
                                                    <div class="col-sm">
                                                        <label for="" class="form-label">Kode Transaksi</label>
                                                        <input type="text" value="<?= $code ?>" class="form-control" name="order_code" readonly>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-12">
                                                        <label for="" class="form-label">Name Customer</label>
                                                        <select name="id_customer" class="form-control" id="id_customer">
                                                            <option value="">Pilih customer</option>
                                                            <?php while ($resultDataCustomer = mysqli_fetch_assoc($dataCustomer)): ?>
                                                                <option value="<?= $resultDataCustomer['id'] ?>"><?= $resultDataCustomer['customer_name'] ?></option>
                                                            <?php endwhile; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-12">
                                                        <label for="" class="form-label">Paket</label>
                                                        <select name="" class="form-control" id="id_service">
                                                            <option value="" id="id_service">Pilih Paket</option>
                                                            <?php while ($resultDataPaket = mysqli_fetch_assoc($queryGetData)): ?>
                                                                <option value="<?= $resultDataPaket['id'] ?>" data-price="<?= $resultDataPaket['price'] ?>"><?= $resultDataPaket['service_name'] ?></option>
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
                                                        <label for="" class="form-label">Tanggal Selesai</label>
                                                        <input type="date" name="order_end_date" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label for="" class="form-label">qty</label>
                                                        <input type="number" class="form-control qty" name="qty">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="btn-cta mb-3 d-flex justify-content-end">
                                            <button class="btn btn-primary add-row">Tambah Transaksi</button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Paket</th>
                                                        <th>Harga</th>
                                                        <th>Qty</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tbody-parent">

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4" align="right">Total</td>
                                                        <td>
                                                            <input type="number" name="total" class="total-harga form-control" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" align="right">Bayar</td>
                                                        <td>
                                                            <input type="number" name="pickup_pay" class="bayar form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" align="right">kembalian</td>
                                                        <td>
                                                            <input type="number" name="pickup_change" class="bayar form-control">
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="kirim">Submit</button>
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

    <script>
        let counter = 1
        $('.add-row').click(function(e) {
            let nama_paket = $('#id_service').find('option:selected').text(),
                id_paket = $('#id_service').val(),
                harga = $('#id_service').find('option:selected').data('price'),
                qty = $('.qty').val(),
                subtotal = parseInt(harga) * parseInt(qty);

            e.preventDefault()
            let newRow = `<tr>
                                <td>${counter}</td>
                                <td>${nama_paket}<input type="hidden" name="id_service[]" class="form-control" placeholder="Nama Paket" value="${id_paket}" /></td>
                                <td>${harga}<input type="hidden" name="harga[]" class="form-control harga" placeholder="Harga" value="${harga}" /></td>
                                <td>${qty}<input type="hidden" name="qty[]" class="form-control qty" placeholder="Qty" value="${qty}" /></td>
                                <td>${subtotal}<input type="hidden" name="subtotal[]" class="form-control subtotal" placeholder="Subtotal" value="${subtotal}" readonly /></td>
                              </tr>`

            $('.tbody-parent').append(newRow);
            counter++;

            let total = 0
            $('.subtotal').each(function() {
                let totalHarga = parseFloat($(this).val()) || 0
                total += totalHarga
            })
            $('.total-harga').val(total)
            $('#id_paket').val("")

            $('body').on('input', 'input[name="pickup_pay"]', function() {
                let total = parseFloat($('.total-harga').val()) || 0;
                let payment = parseFloat($(this).val()) || 0;
                let change = payment - total;
                $('input[name="pickup_change"]').val(change >= 0 ? change : 0);
            });
        })
    </script>
</body>

</html>