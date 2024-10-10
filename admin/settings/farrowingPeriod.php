<?php
require_once '../core/Database.php';
require_once '../core/settingsController.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

// Fetch the farrowing data from the database
$farrowingPeriods = (new settingsController())->getFarrowingPeriods();
$success = '';
$error = '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Farrowing Period</title>
    <meta content="Dashboard for sow farrowing period monitoring" name="description">
    <meta content="sow, farrowing, monitoring, dashboard" name="keywords">

    <link href="../assets/img/pig-logo.png" rel="icon">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body>
    <?php
    include_once '../partials/navbar.php';
    include_once '../partials/sidebar.php';
    ?>

    <main id="main" class="main" style="margin-top: 100px;">
        <div class="pagetitle">
            <h1>Farrowing Period Monitoring</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Settings</li>
                    <li class="breadcrumb-item active">Farrowing Monitoring</li>
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
                            <span>Farrowing Periods</span>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <th scope="col">Sow ID</th>
                                    <th scope="col">Breeding Date</th>
                                    <th scope="col">Expected Farrowing Date</th>
                                    <th scope="col">Actual Farrowing Date</th>
                                    <th scope="col">Litter Size</th>
                                    <th scope="col">Actions</th>
                                </thead>
                                <tbody>
                                    <?php if (!empty($farrowingPeriods)) : ?>
                                        <?php foreach ($farrowingPeriods as $period) : ?>
                                            <tr>
                                                <td><?= htmlspecialchars($period['sow_id']) ?></td>
                                                <td><?= htmlspecialchars($period['breeding_date']) ?></td>
                                                <td><?= htmlspecialchars($period['expected_farrowing_date']) ?></td>
                                                <td><?= htmlspecialchars($period['actual_farrowing_date']) ?></td>
                                                <td><?= htmlspecialchars($period['litter_size']) ?></td>
                                                <td>
                                                    <a href="editFarrowingPeriod.php?id=<?= htmlspecialchars($period['id']) ?>" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                                    <a href="deleteFarrowingPeriod.php?id=<?= htmlspecialchars($period['id']) ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                                </td>
                                            <tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="6">No Farrowing Periods found.</td>
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
                            <i class="bi bi-plus-circle"></i> Add Farrowing Period
                        </div>
                        <div class="card-body">
                            <form action="addFarrowingPeriod.php" method="post">
                                <div class="mb-3">
                                    <label for="sow_id" class="form-label">Sow ID</label>
                                    <input type="text" class="form-control" name="sow_id" required>
                                </div>
                                <div class="mb-3">
                                    <label for="breeding_date" class="form-label">Breeding Date</label>
                                    <input type="date" class="form-control" name="breeding_date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="expected_farrowing_date" class="form-label">Expected Farrowing Date</label>
                                    <input type="date" class="form-control" name="expected_farrowing_date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="litter_size" class="form-label">Litter Size</label>
                                    <input type="number" class="form-control" name="litter_size">
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

    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>
