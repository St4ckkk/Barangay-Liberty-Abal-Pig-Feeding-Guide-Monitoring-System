<?php
require_once '../core/Database.php';
require_once '../core/settingsController.php';
require_once '../core/inventoryController.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

$feedings = (new settingsController())->getFeedingTime();
$pens = (new inventoryController())->getPigPens();
$feeds = (new settingsController())->getFeeds();
$success = '';
$error = '';

$groupedFeedings = [];

foreach ($feedings as $feeding) {
    $timeKey = date('g:i A', strtotime($feeding['schedTime']));

    if (!isset($groupedFeedings[$timeKey])) {
        $groupedFeedings[$timeKey] = [];
    }
    $groupedFeedings[$timeKey][] = $feeding;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Feeding Time</title>
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
</head>

<body>
    <?php
    include_once '../partials/navbar.php';
    include_once '../partials/sidebar.php';
    ?>

    <main id="main" class="main" style="margin-top: 100px;">
        <div class="pagetitle">
            <h1>Feeding Time</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Settings</li>
                    <li class="breadcrumb-item active">Feeding</li>
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
                            <span>Feeding Time</span>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <th scope="col">Time</th>
                                    <th scope="col">Schedule For</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </thead>
                                <tbody>
                                    <?php if (!empty($groupedFeedings)) : ?>
                                        <?php foreach ($groupedFeedings as $time => $feedingsAtTime) : ?>
                                            <tr>
                                                <td><?php echo $time; ?></td>
                                                <td>
                                                    <?php $scheduleFor = (count($feedingsAtTime) > 1) ? 'To All Pig Pens' : 'Pig Pen #' . $feedingsAtTime[0]['penno']; ?>
                                                    <?php echo $scheduleFor; ?>
                                                </td>
                                                <td><?php echo ucfirst($feedingsAtTime[0]['status']); ?></td>
                                                <td>
                                                    <button class="btn btn-primary"
                                                        onclick="openEditModal('<?php echo $feedingsAtTime[0]['schedId']; ?>', 
                                                   '<?php echo $time; ?>', 
                                                   '<?php echo $scheduleFor; ?>', 
                                                   '<?php echo $feedingsAtTime[0]['status']; ?>')">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <a href="deleteFeedingTime.php?id=<?php echo $feedingsAtTime[0]['schedId'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this feeding time?');">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5">No feeding time found.</td>
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
                            <i class="bi bi-plus-circle"></i> Add Feeding Time
                        </div>
                        <div class="card-body">
                            <form action="addFeedingTime.php" method="post">
                                <div class="mb-3">
                                    <label for="feedingTime" class="form-label">Feeding Time</label>
                                    <input type="time" class="form-control" id="feedingTime" name="schedTime" required>
                                </div>
                                <div class="mb-3">
                                    <label for="penSelect" class="form-label">Select Pen</label>
                                    <select class="form-select" id="penSelect" name="penId" required>
                                        <option value="">Select a pen</option>
                                        <option value="all">All Pens</option>
                                        <?php foreach ($pens as $pen): ?>
                                            <option value="<?php echo $pen['penId']; ?>">#<?php echo $pen['penno']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="feedingType" class="form-label">Feeds Type</label>
                                    <select class="form-select" id="feedingType" name="feedingType" required>
                                        <option value="" selected disabled>--Select feeding type--</option>
                                        <?php foreach ($feeds as $feed): ?>
                                            <option value="<?= $feed['feedsName'] ?>"><?= $feed['feedsName'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Edit Feeding Time Modal -->
        <div class="modal fade" id="editFeedingModal" tabindex="-1" aria-labelledby="editFeedingModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editFeedingModalLabel">Edit Feeding Time</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editFeedingForm" action="updateFeedingTime.php" method="post">
                            <input type="hidden" name="schedId" id="editSchedId">
                            <div class="mb-3">
                                <label for="editFeedingTime" class="form-label">Feeding Time</label>
                                <input type="time" class="form-control" id="editFeedingTime" name="schedTime" required>
                            </div>
                            <div class="mb-3">
                                <label for="editPenSelect" class="form-label">Select Pen</label>
                                <select class="form-select" id="editPenSelect" name="penId" required>
                                    <option value="">Select a pen</option>
                                    <option value="all">All Pens</option>
                                    <?php foreach ($pens as $pen): ?>
                                        <option value="<?php echo $pen['penId']; ?>">#<?php echo $pen['penno']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editFeedingType" class="form-label">Feeds Type</label>
                                <select class="form-select" id="editFeedingType" name="feedingType" required>
                                    <option value="" selected disabled>--Select feeding type--</option>
                                    <?php foreach ($feeds as $feed): ?>
                                        <option value="<?= $feed['feedsName'] ?>"><?= $feed['feedsName'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editStatus" class="form-label">Status</label>
                                <select class="form-select" id="editStatus" name="status" required>
                                    <option value="process">In Process</option>
                                    <option value="unprocess">Unprocessed</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Update</button>
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
    <script src="../assets/vendor/quill/quill.min.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <script src="../assets/js/main.js"></script>
    <script>
        function openEditModal(schedId, time, penno, feedingType, status) {
            document.getElementById('editSchedId').value = schedId;
            document.getElementById('editFeedingTime').value = convertTo24Hour(time);
            document.getElementById('editPenSelect').value = penno === 'To All Pig Pens' ? 'all' : getPenIdFromPenno(penno);
            document.getElementById('editFeedingType').value = feedingType;
            document.getElementById('editStatus').value = status;

            var editModal = new bootstrap.Modal(document.getElementById('editFeedingModal'));
            editModal.show();
        }


        function getPenIdFromPenno(penno) {
            const select = document.getElementById('editPenSelect');
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].text === `#${penno}`) {
                    return select.options[i].value;
                }
            }
            return '';
        }

        function convertTo24Hour(time12h) {
            const [time, modifier] = time12h.split(' ');
            let [hours, minutes] = time.split(':');
            if (hours === '12') {
                hours = '00';
            }
            if (modifier === 'PM') {
                hours = parseInt(hours, 10) + 12;
            }
            return `${hours}:${minutes}`;
        }
    </script>
</body>

</html>