<?php
require_once '../core/Database.php';
require_once '../core/inventoryController.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

// Fetch the sows data from the database
$sows = (new inventoryController())->getSows();
$pigpen = (new inventoryController())->getPigPens();
$success = '';
$error = '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Sows Management</title>
    <meta content="Dashboard for sow management" name="description">
    <meta content="sow, management, dashboard" name="keywords">

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
            <h1>Sows Management</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Settings</li>
                    <li class="breadcrumb-item active">Sows Management</li>
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
                            <span>Sows List</span>
                        </div>
                        <div class="card-body">
                            <div class="float-end">
                                <button type="button" class="btn btn-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#addSow">
                                    Add <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <th scope="col">Sow ID</th>
                                    <th scope="col">Pen #</th>
                                    <th scope="col">Breed</th>
                                    <th scope="col">Birth Date</th>
                                    <th scope="col">Weight (kg)</th>
                                    <th scope="col">Acquisition Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </thead>
                                <tbody>
                                    <?php if (!empty($sows)) : ?>
                                        <?php foreach ($sows as $sow) : ?>
                                            <tr>
                                                <td><?= htmlspecialchars($sow['sow_id']) ?></td>
                                                <td><?= htmlspecialchars($sow['penno']) ?></td>
                                                <td><?= htmlspecialchars($sow['breed']) ?></td>
                                                <td><?= htmlspecialchars($sow['birth_date']) ?></td>
                                                <td><?= htmlspecialchars($sow['weight_kg']) ?></td>
                                                <td><?= htmlspecialchars($sow['acquisition_date']) ?></td>
                                                <td><?= htmlspecialchars($sow['status']) ?></td>
                                                <td>
                                                    <a href="editSow.php?sow_id=<?= htmlspecialchars($sow['sow_id']) ?>" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                                    <a href="deleteSow.php?sow_id=<?= htmlspecialchars($sow['sow_id']) ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                                </td>
                                            <tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="7">No Sows found.</td>
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

    <!-- Add Sow Modal -->
    <div class="modal fade" id="addSow" tabindex="-1" aria-labelledby="addSowLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSowLabel">Add Sow</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="addSow.php" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="sow_id" class="form-label">Sow ID</label>
                                <input type="text" class="form-control" name="sow_id" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="penId" class="form-label">Pen no</label>
                                <select name="penno" id="" class="form-control">
                                    <option value="" disabled selected>Select Pen</option>
                                    <?php foreach ($pigpen as $pen) : ?>
                                        <option value="<?= $pen['penId'] ?>"><?= $pen['penno'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="breed" class="form-label">Breed</label>
                                <input type="text" class="form-control" name="breed" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="birth_date" class="form-label">Birth Date</label>
                                <input type="date" class="form-control" name="birth_date" required>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="weight_kg" class="form-label">Weight (kg)</label>
                                <input type="number" class="form-control" name="weight_kg" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="birth_date" class="form-label">Acquisition Date</label>
                                <input type="date" class="form-control" name="acquisition_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" name="status" required>
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Culled">Culled</option>
                                    <option value="Deceased">Deceased</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Sow</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>