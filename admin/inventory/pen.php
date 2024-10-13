<?php
require_once '../core/inventoryController.php';
$inventories = new inventoryController();
require_once '../core/notificationController.php';
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}
$notificationController = new notificationController();
$currentTime = date('Y-m-d H:i:s');
$notifications = $notificationController->getNotification();


$pens = $inventories->getPigPens();
$success = '';
$error = '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Manage Pigs</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="../assets/img/pig-logo.png" rel="icon">
    <link href="../assets/img/SK-logo.png" rel="apple-touch-icon">

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
        .pen-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 2fr));
            gap: 20px;
            margin-top: 20px;
        }

        .pen-card {
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #ddd;
        }

        .pen-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .pen-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .sk-logo {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
            object-fit: contain;
        }

        .pen-status-capacity {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            font-weight: 500;
            color: #555;
            background-color: #f7f7f7;
            border-radius: 10px;
            padding: 10px;
            margin-top: 10px;
        }


        .button-group {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            padding: 5px;
            width: 80px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            border: none;
            color: white;
        }

        .btn-add {
            background-color: #4CAF50;
        }

        .btn-edit {
            background-color: #0d6efd;
        }

        .btn-edit:hover {
            background-color: #0d6efd;
        }

        .btn-add:hover {
            background-color: #45a049;
            color: #000;
        }

        .btn-delete {
            background-color: #f44336;
        }

        .btn-delete:hover {
            background-color: #da190b;
        }

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
            <h1>Manage Pens</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Inventory</li>
                    <li class="breadcrumb-item active">Pigs Management</li>
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
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">Pig Pens</div>
                        <div class="card-body">
                            <div class="pen-grid">
                                <?php if (!empty($pens)) : ?>
                                    <?php foreach ($pens as $pen): ?>
                                        <div class="pen-card">
                                            <img src="../assets/img/pigpen.png" alt="Pen Image" class="sk-logo">
                                            <div class="pen-name">#<?php echo htmlspecialchars($pen['penno']); ?></div>
                                            <div class="pen-status-capacity" style="display: flex; justify-content: space-between; align-items: center;">
                                                <span>Status: <?php echo htmlspecialchars($pen['penstatus']); ?></span>
                                                <span>Capacity: <?php echo htmlspecialchars($pen['pigcount']); ?></span>
                                            </div>
                                            <div class="button-group">
                                                <a href="pigs.php?penId=<?php echo urlencode($pen['penId']); ?>">
                                                    <button class="btn btn-add">View</button>
                                                </a>
                                                <button class="btn btn-edit" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($pen)); ?>)">Edit</button>
                                                <button class="btn btn-delete" onclick="openDeleteModal(<?php echo $pen['penId']; ?>)">Delete</button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="span">
                                        <p>No pens found</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header mb-2">
                            <i class="bi bi-plus-circle"></i> Add Pig Pens
                        </div>
                        <div class="card-body">
                            <form action="addPigPen.php" method="post">
                                <div class="mb-3">
                                    <label for="feedName" class="form-label">Pen #</label>
                                    <input type="text" class="form-control" id="feedName" name="penno" placeholder="Enter Pen number" required>
                                </div>
                                <div class="mb-3">
                                    <label for="feedDescription" class="form-label">Capacity</label>
                                    <input type="number" name="penpigcount" id="" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="quantityPerSack" class="form-label">Pen Status</label>
                                    <select name="penstatus" id="" class="form-control">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
        </section>
    </main>
    <!-- Edit Modal -->
    <div class="modal fade" id="editPenModal" tabindex="-1" aria-labelledby="editPenModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPenModalLabel">Edit Pig Pen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPenForm" action="editPigPen.php" method="post">
                        <input type="hidden" name="penId" id="editPenId">
                        <div class="mb-3">
                            <label for="editPenNo" class="form-label">Pen #</label>
                            <input type="text" class="form-control" id="editPenNo" name="penno" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCapacity" class="form-label">Capacity</label>
                            <input type="number" class="form-control" id="editCapacity" name="penpigcount" required>
                        </div>
                        <div class="mb-3">
                            <label for="editStatus" class="form-label">Pen Status</label>
                            <select name="penstatus" id="editStatus" class="form-control" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deletePenModal" tabindex="-1" aria-labelledby="deletePenModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePenModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this pen?</p>
                    <form id="deletePenForm" action="deletePen.php" method="post">
                        <input type="hidden" name="penId" id="deletePenId">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        function openEditModal(pen) {
            document.getElementById('editPenId').value = pen.penId;
            document.getElementById('editPenNo').value = pen.penno;
            document.getElementById('editCapacity').value = pen.pigcount;
            document.getElementById('editStatus').value = pen.penstatus;
            var editModal = new bootstrap.Modal(document.getElementById('editPenModal'));
            editModal.show();
        }

        function openDeleteModal(penId) {
            document.getElementById('deletePenId').value = penId;
            var deleteModal = new bootstrap.Modal(document.getElementById('deletePenModal'));
            deleteModal.show();
        }
    </script>

    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>