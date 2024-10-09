<?php
require_once '../core/userController.php';
require_once '../core/projectController.php';
require_once '../core/youthController.php';

$notificationCount = (new projectController())->getNotificationCount();
$youthController = new youthController();
$barangay_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($barangay_id) {
    $youthProfiles = $youthController->getAllYouthProfiles($barangay_id);
    $barangay = (new youthController())->getBarangayByID($barangay_id);
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

    <style>
        .youth-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .youth-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .youth-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            float: left;
            margin-right: 15px;
        }

        .youth-name {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .youth-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            font-size: 12px;
            text-transform: uppercase;
            margin-top: 70px;
            color: #666;
        }

        .youth-detail {
            /* flex-basis: 50%; */
            margin-bottom: 5px;
        }

        .detail-label {
            font-weight: bold;
            color: #999;
            text-transform: uppercase;
            display: block;
        }

        .detail-value {
            display: flex;
            align-items: center;
        }

        .detail-value i {
            margin-right: 5px;
            font-size: 14px;
        }

        .warning {
            color: #ff4444;
        }

        .score {
            color: #4CAF50;
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
            <h1><?= $barangay['name'] ?> Youth</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Manage Youth</li>
                </ol>
            </nav>
        </div>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <section class="section">       
            <div class="row">
                <?php foreach ($youthProfiles as $youth): ?>
                    <div class="col-md-4">
                        <div class="youth-card">
                            <a href="youthProfile.php?id=<?php echo urlencode($youth['response_id']); ?>">
                                <img src="<?php echo $youth['profile_picture'] ?? '../assets/img/profile.png'; ?>" alt="<?php echo $youth['firstname']; ?>" class="youth-img">
                                <div class="youth-name"><?php echo $youth['firstname'] . ' ' . $youth['lastname']; ?></div>
                                <div class="youth-details">
                                    <div class="youth-detail">
                                        <span class="detail-label">Gender</span>
                                        <span class="detail-value"><i class="bi bi-gender-ambiguous"></i><?php echo $youth['sex']; ?></span>
                                    </div>
                                    <div class="youth-detail">
                                        <span class="detail-label">Birth Date</span>
                                        <span class="detail-value"><i class="bi bi-calendar"></i><?php echo date('jS M y', strtotime($youth['dob'])); ?></span>
                                    </div>

                                    <div class="youth-detail">
                                        <span class="detail-label">Age</span>
                                        <span class="detail-value"><i class="bi bi-person"></i><?php echo $youth['age']; ?></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>