<?php

require_once '../core/settingsController.php';

$settingsController = new settingsController();

$farrowingPeriods = $settingsController->getFarrowingPeriods();
$pigpen = $settingsController->getPigPens();
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
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header mb-2">
                            <span>Farrowing Periods</span>
                        </div>
                        <div class="card-body">
                            <div class="float-end">
                                <button type="button" class="btn btn-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#addFarrowingPeriodModal">
                                    Add <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <th scope="col">Pen #</th>
                                    <th scope="col">ETN</th>
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
                                            </tr>
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
            </div>
        </section>
    </main>

    <!-- Add Farrowing Period Modal -->
    <div class="modal fade" id="addFarrowingPeriodModal" tabindex="-1" aria-labelledby="addFarrowingPeriodModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFarrowingPeriodModalLabel">Add Farrowing Period</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="addFarrowingPeriod.php" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="penno" class="form-label">Pen no</label>
                                <select name="penno" id="penno" class="form-control">
                                    <option value="" disabled selected>Select Pen</option>
                                    <?php foreach ($pigpen as $pen) : ?>
                                        <option value="<?= $pen['penId'] ?>"><?= $pen['penno'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pigs" class="form-label">Pigs</label>
                                <select name="pigs" id="pigsSelect" class="form-control" disabled>
                                    <option value="" disabled selected>Select Pig</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
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
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const penSelect = document.getElementById('penno');
            const pigsSelect = document.getElementById('pigsSelect');

            penSelect.addEventListener('change', function() {
                const selectedPenId = this.value;

                if (selectedPenId) {
                    fetch(`fetchParrowingPigs.php?pen_id=${selectedPenId}`)
                        .then(response => response.json())
                        .then(data => {
                            pigsSelect.innerHTML = '<option value="" disabled selected>Select Pig</option>';
                            data.forEach(pig => {
                                const option = document.createElement('option');
                                option.value = pig.pig_id;
                                option.textContent = `${pig.ear_tag_number} - ${pig.breed}`;
                                pigsSelect.appendChild(option);
                            });
                            pigsSelect.disabled = false;
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    pigsSelect.innerHTML = '<option value="" disabled selected>Select Pig</option>';
                    pigsSelect.disabled = true;
                }
            });
        });
    </script>
</body>

</html>