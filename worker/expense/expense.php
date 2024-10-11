<?php
require_once '../core/Database.php';
require_once '../core/expenseController.php';
require_once '../core/notificationController.php';
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}
$notificationController = new notificationController();


$currentTime = date('Y-m-d H:i:s');


$notifications = $notificationController->getNotification();



$expenses = (new expenseController())->getAllExpenses();
$success = '';
$error = '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Expense Report - Barangay Liberty Abal Piggery</title>
    <meta content="Expense report for Barangay Liberty Abal Piggery" name="description">
    <meta content="pig, expense, report, barangay liberty abal" name="keywords">

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
</head>

<body>
    <?php
    include_once '../partials/navbar.php';
    include_once '../partials/sidebar.php';
    ?>

    <main id="main" class="main" style="margin-top: 100px;">
        <div class="pagetitle">
            <h1>Manage Expenses</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Manage</li>
                    <li class="breadcrumb-item active">Expenses</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }

            if (isset($_SESSION['success'])) {
                echo '<div class="alert alert-success" role="alert">' . $_SESSION['success'] . '</div>';
                unset($_SESSION['success']);
            }
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header mb-2">
                            <span>Expenses</span>
                        </div>
                        <div class="card-body">
                            <div class="float-end">
                                <a href="expense_report.php" class="btn btn-primary float-end mb-3">
                                    Generate PDF Report <i class="bi bi-file-earmark-pdf"></i>
                                </a>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Expense Name</th>
                                        <th scope="col">Expense Type</th>
                                        <th scope="col">Expense Cost</th>
                                        <th scope="col">Expense Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($expenses)) : ?>
                                        <?php foreach ($expenses as $expense) : ?>
                                            <tr>
                                                <td><?= htmlspecialchars($expense['expenseName']) ?></td>
                                                <td><?= htmlspecialchars($expense['expenseType']) ?></td>
                                                <td>₱<?= number_format($expense['total'], 2) ?></td>
                                                <td><?= date('M d, Y', strtotime($expense['expenseDate'])) ?></td>
                                                <td>
                                                    <a href="editDisinfectionGuidelines.php?id=<?= $expense['expenseId'] ?>" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                                    <a href="deleteDisinfectionGuidelines.php?id=<?= $expense['expenseId'] ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5">No expenses found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../assets/vendor/quill/quill.min.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <script src="../assets/js/main.js"></script>
</body>

</html>