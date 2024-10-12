<?php
require_once '../core/Database.php';
require_once '../core/settingsController.php';
require_once '../core/inventoryController.php';
require_once '../core/notificationController.php';


if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

$cleanings = (new settingsController())->getSlaughteringPeriod();
$pens = (new inventoryController())->getPigPens();
$pigs = [];
$success = '';
$error = '';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Slaughtering Period</title>
    <meta content="Dashboard for pig feeding guide and monitoring" name="description">
    <meta content="pig, feeding, monitoring, dashboard" name="keywords">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="../assets/img/pig-logo.png" rel="icon">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="../assets/css/global.css" rel="stylesheet">

    <style>
        .tag {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            margin: 5px;
        }

        .tag .remove {
            margin-left: 5px;
            cursor: pointer;
            color: white;
        }

        .btn {
            width: 60px;
            padding: 2px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <?php include_once '../partials/navbar.php'; ?>
    <?php include_once '../partials/sidebar.php'; ?>

    <main id="main" class="main" style="margin-top: 100px;">
        <div class="pagetitle">
            <h1>Slaughtering Period</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Settings</li>
                    <li class="breadcrumb-item active">Slaughtering</li>
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
                            <span>Slaughtering Period</span>
                        </div>
                        <div class="card-body">
                            <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                <div class="datatable-top">
                                    <div class="datatable-dropdown">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#addSlaughteringModal">
                                                Add <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="datatable-search">
                                        <input class="datatable-input" placeholder="Search..." type="search" name="search" title="Search within table">
                                    </div>
                                </div>
                                <div class="datatable-container">
                                    <table class="table datatable datatable-table">
                                        <thead>
                                            <tr>
                                                <th data-sortable="true">Pen #</th>
                                                <th data-sortable="true">ETN</th>
                                                <th data-sortable="true">Age</th>
                                                <th data-sortable="true">Weight (kg)</th>
                                                <th data-sortable="true">Date</th>
                                                <th data-sortable="true">Time</th>
                                                <th data-sortable="true">Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($cleanings)) : ?>
                                                <?php foreach ($cleanings as $cleaning) : ?>
                                                    <tr>
                                                        <td>
                                                            <?= htmlspecialchars($cleaning['penno']) ?>
                                                        </td>
                                                        <td>
                                                            <?= htmlspecialchars($cleaning['ear_tag_number']) ?>
                                                        </td>
                                                        <td><?= htmlspecialchars($cleaning['age']) ?></td>
                                                        <td><?= htmlspecialchars($cleaning['weight']) ?></td>
                                                        <td><?= htmlspecialchars($cleaning['slaughtering_date']) ?></td>
                                                        <td>
                                                            <?php
                                                            echo date("g:i A", strtotime($cleaning['slaughtering_time']));
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($cleaning['status'] == 'process') {
                                                                echo '<span class="badge bg-warning">In Process</span>';
                                                            } elseif ($cleaning['status'] == 'unprocess') {
                                                                echo '<span class="badge bg-secondary">Unprocessed</span>';
                                                            } elseif ($cleaning['status'] == 'done') {
                                                                echo '<span class="badge bg-success">Completed</span>';
                                                            } else {
                                                                echo '<span class="badge bg-light">Unknown Status</span>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <a href="#" class="btn btn-primary" onclick="openEditModal('<?= $cleaning['slauId'] ?>', '<?= $cleaning['slaughtering_date'] ?>', '<?= $cleaning['slaughtering_time'] ?>', '<?= $cleaning['status'] ?>')">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                            <a href="#" class="btn btn-danger" onclick="openDeleteConfirmation('<?= $cleaning['slauId'] ?>')">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </td>

                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="7">No Cleaning Period found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="datatable-bottom">
                                    <div class="datatable-info">Showing 1 to 10 of 100 entries</div>
                                    <nav class="datatable-pagination">
                                        <ul class="datatable-pagination-list">
                                            <li class="datatable-pagination-list-item datatable-hidden datatable-disabled"><button data-page="1" class="datatable-pagination-list-item-link" aria-label="Page 1">‹</button></li>
                                            <li class="datatable-pagination-list-item datatable-active"><button data-page="1" class="datatable-pagination-list-item-link" aria-label="Page 1">1</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="2" class="datatable-pagination-list-item-link" aria-label="Page 2">2</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="3" class="datatable-pagination-list-item-link" aria-label="Page 3">3</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="4" class="datatable-pagination-list-item-link" aria-label="Page 4">4</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="5" class="datatable-pagination-list-item-link" aria-label="Page 5">5</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="6" class="datatable-pagination-list-item-link" aria-label="Page 6">6</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="7" class="datatable-pagination-list-item-link" aria-label="Page 7">7</button></li>
                                            <li class="datatable-pagination-list-item datatable-ellipsis datatable-disabled"><button class="datatable-pagination-list-item-link">…</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="10" class="datatable-pagination-list-item-link" aria-label="Page 10">10</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="2" class="datatable-pagination-list-item-link" aria-label="Page 2">›</button></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="addSlaughteringModal" tabindex="-1" aria-labelledby="addSlaughteringModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addSlaughteringModalLabel">Add Slaughtering Period</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="addSlaughteringPeriod.php" method="post">
                                    <input type="hidden" name="penId" id="penId" value="">
                                    <div class="mb-3">
                                        <label for="pigPen" class="form-label">Select Pig Pen</label>
                                        <select id="pigPen" class="form-control" onchange="fetchPigs(this.value)">
                                            <option value="">-- Select Pig Pen --</option>
                                            <?php foreach ($pens as $pen): ?>
                                                <option value="<?= $pen['penId'] ?>"><?= $pen['penno'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pigs" class="form-label">Select Pigs</label>
                                        <select id="pigs" class="form-control" multiple onchange="updateSelectedPigs()"></select>
                                    </div>
                                    <div id="selectedPigs"></div>

                                    <div class="mb-3">
                                        <label for="slaughteringDate" class="form-label">Slaughtering Date</label>
                                        <input type="date" name="slaughteringDate" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="slaughteringTime" class="form-label">Slaughtering Time</label>
                                        <input type="time" name="slaughteringTime" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Edit Slaughtering Modal -->
        <div class="modal fade" id="editSlaughteringModal" tabindex="-1" aria-labelledby="editSlaughteringModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSlaughteringModalLabel">Edit Slaughtering Period</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editSlaughteringForm" action="updateSlaughteringPeriod.php" method="post">
                            <input type="hidden" name="slauId" id="editSlauId" value="">
                            <div class="mb-3">
                                <label for="editSlaughteringDate" class="form-label">Slaughtering Date</label>
                                <input type="date" name="slaughteringDate" id="editSlaughteringDate" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="editSlaughteringTime" class="form-label">Slaughtering Time</label>
                                <input type="time" name="slaughteringTime" id="editSlaughteringTime" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control">
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

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this slaughtering period?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <a id="confirmDeleteBtn" class="btn btn-danger" href="#">Delete</a>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>aa
    <script>
        const selectedPigs = new Set();

        function fetchPigs(penId) {
            document.getElementById('penId').value = penId;
            console.log(`Fetching pigs for pen ID: ${penId}`);
            if (!penId) {
                document.getElementById('pigs').innerHTML = '';
                document.getElementById('selectedPigs').innerHTML = '';
                selectedPigs.clear();
                return;
            }
            fetch('fetchPigs.php?penId=' + penId)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(`Received data: ${JSON.stringify(data)}`);
                    if (data.error) {
                        throw new Error(data.message || 'Unknown error occurred');
                    }
                    let pigsDropdown = document.getElementById('pigs');
                    pigsDropdown.innerHTML = '';
                    if (data.length === 0) {
                        let option = document.createElement('option');
                        option.textContent = 'No pigs available in this pen';
                        pigsDropdown.appendChild(option);
                    } else {
                        data.forEach(pig => {
                            let option = document.createElement('option');
                            option.value = pig.id;
                            option.textContent = pig.name || `Pig ${pig.id}`;
                            pigsDropdown.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching pigs:', error);
                    let pigsDropdown = document.getElementById('pigs');
                    pigsDropdown.innerHTML = '<option>Error fetching pigs: ' + error.message + '</option>';
                });
        }

        function updateSelectedPigs() {
            const pigsDropdown = document.getElementById('pigs');
            const selectedPigsDiv = document.getElementById('selectedPigs');
            selectedPigsDiv.innerHTML = '';
            selectedPigs.clear();

            Array.from(pigsDropdown.selectedOptions).forEach(option => {
                selectedPigs.add(option.value);
                const tag = document.createElement('span');
                tag.className = 'tag';
                tag.textContent = option.textContent;

                const removeBtn = document.createElement('span');
                removeBtn.className = 'remove';
                removeBtn.textContent = ' x';
                removeBtn.onclick = function() {
                    selectedPigs.delete(option.value);
                    tag.remove();
                    option.selected = false;
                    updateHiddenInput();
                };
                tag.appendChild(removeBtn);
                selectedPigsDiv.appendChild(tag);
            });

            updateHiddenInput();
        }

        function updateHiddenInput() {
            const form = document.querySelector('form');
            const existingInput = form.querySelector('input[name="selectedPigs"]');
            if (existingInput) {
                form.removeChild(existingInput);
            }
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'selectedPigs';
            hiddenInput.value = Array.from(selectedPigs).join(',');
            form.appendChild(hiddenInput);
        }

        function openDeleteConfirmation(slauId) {
            document.getElementById('confirmDeleteBtn').href = 'deleteSlaughtering.php?slauId=' + slauId;

            var deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteModal.show();
        }

        function openEditModal(slauId, slaughteringDate, slaughteringTime) {
            document.getElementById('editSlauId').value = slauId;
            document.getElementById('editSlaughteringDate').value = slaughteringDate;
            document.getElementById('editSlaughteringTime').value = slaughteringTime;
            document.getElementById('status').value = status;

            var editModal = new bootstrap.Modal(document.getElementById('editSlaughteringModal'));
            editModal.show();
        }
    </script>
</body>

</html>