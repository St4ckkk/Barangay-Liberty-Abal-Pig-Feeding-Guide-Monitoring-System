<?php
require_once '../core/notificationController.php';
require_once '../core/settingsController.php';
require_once '../core/inventoryController.php';

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

$notificationController = new NotificationController();
$notificationData = [];
$notificationId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($notificationId) {
    $notificationData = $notificationController->getNotificationById($notificationId);


    if (!$notificationData) {
        echo "Notification not found.";
        exit;
    }
} else {
    echo "No notification ID provided.";
    exit;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Notification</title>
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
    <link href="../assets/css/global.css" rel="stylesheet">
    <style>
        .btn {
            width: 60px;
            padding: 2px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <?php
    include_once '../partials/navbar.php';
    include_once '../partials/sidebar.php';
    ?>

    <main id="main" class="main" style="margin-top: 100px;">
        <div class="pagetitle">
            <h1>Schedule</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Schedule</li>
                    <li class="breadcrumb-item active">Schedule</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header mb-2">
                            <span>Schedule</span>
                        </div>
                        <div class="card-body">
                            <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                <div class="datatable-container">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Feeding Frequency</th>
                                                <th>Morning Feeding Time</th>
                                                <th>Noon Feeding Time</th>
                                                <th>Evening Feeding Time</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($notificationData): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($notificationData['feeding_frequency']); ?></td>
                                                    <td><?= formatTime($notificationData['morning_feeding_time']); ?></td>
                                                    <td><?= formatTime($notificationData['noon_feeding_time']); ?></td>
                                                    <td><?= formatTime($notificationData['evening_feeding_time']); ?></td>
                                                    <td>
                                                        <a href="edit_notification.php?id=<?= $notificationData['id']; ?>" class="btn btn-primary">Edit</a>
                                                        <a href="delete_notification.php?id=<?= $notificationData['id']; ?>" class="btn btn-danger">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6">No Notification Found</td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php
                                            // Function to format time from 24-hour to 12-hour AM/PM format
                                            function formatTime($time)
                                            {
                                                if ($time) {
                                                    // Convert time string to a DateTime object
                                                    $dateTime = DateTime::createFromFormat('H:i:s', $time);
                                                    return $dateTime ? $dateTime->format('h:i A') : 'N/A';
                                                }
                                                return 'N/A';
                                            }
                                            ?>

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>