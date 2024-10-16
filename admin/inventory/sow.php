    <?php
    require_once '../core/inventoryController.php';
    require_once '../core/notificationController.php';

    $notificationController = new notificationController();
    $currentTime = date('Y-m-d H:i:s');
    $notifications = $notificationController->getNotification();
    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
        header('Location: index.php');
        exit();
    }


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
    <style>
        .table td {
            font-size: 12px;
        }
    </style>

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
                                        <th scope="col">Pen #</th>
                                        <th scope="col">ETN</th>
                                        <th scope="col">Breed</th>
                                        <th scope="col">Age</th>
                                        <th scope="col">Weight (kg)</th>
                                        <th scope="col">Acquisition Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($sows)) : ?>
                                            <?php foreach ($sows as $sow) : ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($sow['penno']) ?></td>
                                                    <td><?= htmlspecialchars($sow['ear_tag_number']) ?></td>
                                                    <td><?= htmlspecialchars($sow['breed']) ?></td>
                                                    <td><?= htmlspecialchars($sow['age']) ?></td>
                                                    <td><?= htmlspecialchars($sow['weight']) ?></td>
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
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status" required>
                                        <option value="" disabled selected>Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const penSelect = document.getElementById('penno');
                const pigsSelect = document.getElementById('pigsSelect');

                penSelect.addEventListener('change', function() {
                    const selectedPenId = this.value;

                    if (selectedPenId) {
                        fetch(`fetchPigs.php?pen_id=${selectedPenId}`)
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