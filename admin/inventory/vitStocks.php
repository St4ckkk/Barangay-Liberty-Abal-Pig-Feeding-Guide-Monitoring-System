<?php
require_once '../core/inventoryController.php';
$inventories = new inventoryController();
require_once '../core/notificationController.php';
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}
$notificationController = new notificationController();
$currentTime = date('Y-m-d H:i:s');
$notifications = $notificationController->getNotification();


$pens = $inventories->getPigPens();
$success = '';
$error = '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Vitamins/Medicines Stocks</title>
    <meta content="Dashboard for pig feeding guide and monitoring" name="description">
    <meta content="pig, feeding, monitoring, dashboard" name="keywords">

    <link href="../assets/img/pig-logo.png" rel="icon">
    <link href="../assets/img/pig-logo.png" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <link href="../assets/css/style.css" rel="stylesheet">

    <style>

    </style>
</head>

<body>
    <?php
    include_once '../partials/navbar.php';
    include_once '../partials/sidebar.php';
    ?>

    <main id="main" class="main" style="margin-top: 100px;">
        <div class="pagetitle">
            <h1>Vitamins & Medicines Stocks</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Inventory</li>
                    <li class="breadcrumb-item active">Vitamins & Medicines</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header mb-2">
                            Vitamins & Medicines Stocks
                        </div>
                        <div class="card-body">
                            <div class="float-end">
                                <button type="button" class="btn btn-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#addVit">
                                    Add <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <th scope="col">Type</th>
                                    <th scope="">Name</th>
                                    <th scope="col">Dosage</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Expiration</th>
                                    <th scope="col">Actions</th>
                                </thead>
                            </table>
                            <tbody>
                            </tbody>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" id="addVit" tabindex="-1" aria-labelledby="addPigModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPigModalLabel">Add Vitamins / Medicines</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="addBreed.php" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="breedName" class="form-label">Type</label>
                                    <select name="type" id="" class="form-control">
                                        <option value="medicine">Medicine</option>
                                        <option value="vitamins">Vitamins</option>
                                    </select>
                                    <label for="breed" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name">
                                    <label for="" class="form-label">Quantity</label>
                                    <input type="number" name="qty" id="" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label">Dosage</label>
                                    <input type="number" name="dosage" id="" class="form-control">
                                    <label for="" class="form-label">Expiration</label>
                                    <input type="date" name="expDate" id="" class="form-control">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="" class="form-label">Description</label>
                                    <textarea name="description" id="" class="form-control"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../assets/vendor/quill/quill.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <script src="../assets/js/main.js"></script>
</body>

</html>