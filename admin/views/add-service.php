<?php
session_start();
include '../config/db.php';
include '../controller/action_service.php'
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
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header fs-1"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> service</div>

                                    <div class="card-body">
                                        <?php if (isset($_GET['success-delete'])): ?>
                                            <div id="alert" class="alert alert-success" role="alert">Deleted Success</div>
                                        <?php endif; ?>
                                        <form action='../controller/action_service.php?edit=<?php echo isset($_GET['edit']) ? $dataServiceId['id'] : ''; ?>' method="POST" enctype="multipart/form-data">
                                            <div class="mb-3 row">
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">Nama Paket</label>
                                                    <input type="text" name="service_name" class="form-control" placeholder="Input Your Name" value="<?php echo isset($_GET['edit']) ? $dataServiceId['service_name'] : '' ?>" required>

                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">Harga</label>
                                                    <input type="text" class="form-control" value="<?= isset($_GET['edit']) ? $dataServiceId['price'] : '' ?>" name="price">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-sm">
                                                    <label for="" class="form-label">Deskripsi</label>
                                                    <textarea name="description" class="form-control" rows="10" id=""><?= isset($_GET['edit']) ? $dataServiceId['description'] : '' ?></textarea>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <button class="btn btn-primary w-100" name="<?php echo isset($_GET['edit']) ? 'edit-service' : 'add-service' ?>" type="submit"><?php echo isset($_GET['edit']) ? '
                                                    Edit' : '
                                                    Add' ?></button>
                                                </div>
                                            </div>
                                        </form>
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