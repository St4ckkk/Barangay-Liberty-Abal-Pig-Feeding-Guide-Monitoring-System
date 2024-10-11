<?php
require_once '../core/Database.php';
require_once '../core/settingsController.php';
require_once '../core/notificationController.php';

$notificationController = new notificationController();
$currentTime = date('Y-m-d H:i:s');
$notifications = $notificationController->getNotification();
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

$cleanings = (new settingsController())->getCleaningPeriod();
$success = '';
$error = '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Cleaning Period</title>
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
            <h1>Cleaning Period</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Settings</li>
                    <li class="breadcrumb-item active">Cleaning</li>
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
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header mb-2">
                            <span>Cleaning Period</span>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <th scope="col">Start Time</th>
                                    <th scope="col">Actions</th>
                                </thead>
                                <tbody>
                                    <?php if (!empty($cleanings)) : ?>
                                        <?php foreach ($cleanings as $cleaning) : ?>
                                            <tr>
                                                <td><?= date('h:i A', strtotime($cleaning['schedTime'])) ?></td>

                                                <td>
                                                    <a href="editCleaningPeriod.php?id=<?php echo $user['schedId'] ?>" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                                    <a href="deleteCleaningPeriod.php?id=<?php echo $user['schedId'] ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                                </td>
                                            <tr>

                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5">No Cleaning Period found.</td>
                                            </tr>
                                        <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header mb-2">
                            <i class="bi bi-plus-circle"></i> Add Cleaning Period
                        </div>
                        <div class="card-body">
                            <form action="addCleaningPeriod.php" method="post">
                                <div class="mb-3">
                                    <label for="feedingTime" class="form-label">Start Time</label>
                                    <input type="time" name="schedTime" id="feedingTime" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </form>
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
    <script src="../assets/vendor/quill/quill.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <script src="../assets/js/main.js"></script>
</body>

</html>