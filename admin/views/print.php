<?php
include '../config/db.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';

$queryDetail = mysqli_query($connection, "SELECT transaksi.order_code, transaksi.order_date, type_of_service.service_name, type_of_service.price, detail_transaksi.* FROM transaksi LEFT JOIN detail_transaksi ON detail_transaksi.id_order = transaksi.id LEFT JOIN type_of_service ON type_of_service.id = detail_transaksi.id_service WHERE transaksi.id = '$id'");

$row = [];
while ($rowDetail = mysqli_fetch_assoc($queryDetail)) {
    $row[] = $rowDetail;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi : </title>
    <style>
        body {
            margin: 20px
        }

        .struck {
            width: 80mm;
            max-width: 100%;
            border: 1px solid black;
            padding: 10px;
            margin: 0 auto;
        }

        .struck-header,
        .struck-footer {
            text-align: center;
            margin-bottom: 10px;
        }

        .struck-header h1 {
            font-size: 18px;
            margin: 0;
        }

        .struck-body {
            margin-bottom: 10px;
        }

        .struck-body table {
            border-collapse: collapse;
            width: 100%;
        }

        .struck-body table th,
        .struck-body table td {
            padding: 5px;
            text-align: center;
        }

        .struck-body table th {
            border-bottom: 1px solid black;
        }

        .total,
        .payment,
        .change {
            display: flex;
            justify-content: space-evenly;
            padding: 5px 0;
            font-weight: bold;
        }

        .total {
            margin-top: 10px;
            border-top: 1px solid black;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .struck {
                width: auto;
                border: none;
                margin: 0;
                padding: 0;
            }

            .struck-header h1,
            .struck-footer {
                font-size: 14px;
            }

            .struck-body table th,
            .struck-body table td {
                padding: 2px;
            }

            .total,
            .payment,
            .change {
                padding: 2px 0;
            }
        }
    </style>
</head>

<body>
    <div class="struck">
        <div class="struck-header">
            <h1>Toko Laundry Semua</h1>
            <p>Jl. Menuju Kebahagiaan No. 0, Kec. Rasa, Kel. Yang pernah ada</p>
            <p>0876656466</p>
            <div class="kode">
                <p></p>
            </div>
        </div>
        <div class="struck-body">
            <table>
                <thead>
                    <tr>
                        <th>Paket</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($row as $key => $rowDetail) : ?>
                        <tr>
                            <td><?php echo $rowDetail['service_name'] ?></td>
                            <td><?php echo $rowDetail['qty'] ?></td>
                            <td><?php echo "Rp." . number_format($rowDetail['price'])  ?></td>
                            <td><?php echo "Rp." . number_format($rowDetail['subtotal'])  ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- <div class="total">
                <span>Total :</span>
                <span><?= "Rp." . number_format($row[0]['total_harga']) ?></span>
            </div>
            <div class="payment">
                <span>Bayar :</span>
                <span><?= "Rp." . number_format($row[0]['nominal_bayar']) ?></span>
            </div>
            <div class="change">
                <span>Kembali :</span>
                <span><?= "Rp." . number_format($row[0]['kembalian']) ?></span>
            </div> -->
        </div>
        <div class="struck-footer">
            <p>Terima Kasih Atas Kunjungan Anda!</p>
            <p>Selamat Berbelanja Kembali</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print()
        }
    </script>
</body>

</html>