<?php
require_once '../core/userController.php';
require_once '../core/projectController.php';
require_once '../core/youthController.php';
require_once '../core/Database.php';
$notificationCount = (new projectController())->getNotificationCount();
$youthController = new youthController();
$db = new Database();
$conn = $db->getConnection();

$youthId = isset($_GET['response_id']) ? (int)$_GET['response_id'] : 0;

$youthProfile = [];
if ($youthId) {
    $stmt_youth = $conn->prepare("SELECT * FROM survey_responses WHERE response_id = :response_id");
    $stmt_youth->bindParam(':response_id', $youthId);
    $stmt_youth->execute();
    $youthProfile = $stmt_youth->fetch(PDO::FETCH_ASSOC);
    print_r($youthProfile);
}
$success = '';
$error = '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Manage Youth</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="../assets/css/globalss.css" rel="stylesheet">
</head>

<body>
    <?php
    include_once '../partials/navbar.php';
    include_once '../partials/sidebar.php';
    ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Youth Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
        </div>

        <section class="section profile">
            <div class="row">

                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <img src="../assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                            <h2><?php echo $youthProfile['firstname'] ?? 'Position not specified'; ?></h2>
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