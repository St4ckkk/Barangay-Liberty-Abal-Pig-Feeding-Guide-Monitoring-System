<?php
require_once '../core/Database.php';
require_once '../core/inventoryController.php';
require_once '../core/notificationController.php';

$notificationController = new notificationController();
$currentTime = date('Y-m-d H:i:s');
$notifications = $notificationController->getNotification();
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

$inventories = (new inventoryController())->getFeedStocks();
$success = '';
$error = '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Feed Stocks</title>
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

        .table td {
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
            <h1>Feed Stocks</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Inventory</li>
                    <li class="breadcrumb-item active">Feeds</li>
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
                            Feeds Stocks
                        </div>
                        <div class="card-body">
                            <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                <div class="datatable-top">
                                    <div class="datatable-dropdown">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#addFeedModal">
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
                                                <th data-sortable="true">Feeds Name</th>
                                                <th data-sortable="true">Feeds Quantity</th>
                                                <th data-sortable="true">Feeds Cost</th>
                                                <th data-sortable="true">Feeds Purchase Date</th>
                                                <th data-sortable="true">Feeds Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($inventories)) : ?>
                                                <?php foreach ($inventories as $inventory) : ?>
                                                    <tr>
                                                        <td><?= $inventory['feedsName'] ?></td>
                                                        <td><?= $inventory['QtyOFoodPerSack'] ?></td>
                                                        <td><?= $inventory['feedsCost'] ?></td>
                                                        <td><?= $inventory['feed_purchase_date'] ?></td>
                                                        <td><?= $inventory['feedsDescription'] ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary editFeedBtn" data-bs-toggle="modal" data-bs-target="#editFeedModal"
                                                                data-id="<?= $inventory['id'] ?>"
                                                                data-name="<?= $inventory['feedsName'] ?>"
                                                                data-quantity="<?= $inventory['QtyOFoodPerSack'] ?>"
                                                                data-cost="<?= $inventory['feedsCost'] ?>"
                                                                data-date="<?= $inventory['feed_purchase_date'] ?>"
                                                                data-description="<?= $inventory['feedsDescription'] ?>">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger deleteFeedBtn" data-bs-toggle="modal" data-bs-target="#deleteFeedModal" data-id="<?= $inventory['id'] ?>">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>

                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6">No Feeds Stocks.</td>
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

                <div class="col-lg-4">
                    <!-- Removed the add feeds card, now it's a modal -->
                </div>
            </div>
        </section>
    </main>

    <!-- Modal for Adding Feeds -->
    <div class="modal fade" id="addFeedModal" tabindex="-1" aria-labelledby="addFeedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFeedModalLabel">Add Feeds</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="addFeeds.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="feedName" class="form-label">Feed Name</label>
                                <input type="text" class="form-control" id="feedName" name="feedName" placeholder="Enter Feed Name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="quantityPerSack" class="form-label">Quantity Per Sack</label>
                                <input type="number" class="form-control" id="quantityPerSack" name="QtyOFoodPerSack" placeholder="Enter Quantity" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="feedCost" class="form-label">Feeds Cost</label>
                                <input type="number" class="form-control" id="feedCost" name="feedCost" placeholder="Enter Feed Cost" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="feedCost" class="form-label">Purchased Date</label>
                                <input type="date" name="purchased-date" id="" class="form-control">
                            </div>
                        </div>
                        <div class="row">

                            <div class="mb-3">
                                <label for="feedDescription" class="form-label">Feed Description</label>
                                <textarea class="form-control" id="feedDescription" name="feedDescription" rows="3" placeholder="Enter Feed Description" required></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Editing Feeds -->
    <div class="modal fade" id="editFeedModal" tabindex="-1" aria-labelledby="editFeedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFeedModalLabel">Edit Feeds</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editFeedForm" action="editFeeds.php" method="POST">
                        <input type="hidden" id="editFeedId" name="feedId">
                        <div class="mb-3">
                            <label for="editFeedName" class="form-label">Feed Name</label>
                            <input type="text" class="form-control" id="editFeedName" name="feedName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editQuantityPerSack" class="form-label">Quantity Per Sack</label>
                            <input type="number" class="form-control" id="editQuantityPerSack" name="QtyOFoodPerSack" required>
                        </div>
                        <div class="mb-3">
                            <label for="editFeedCost" class="form-label">Feeds Cost</label>
                            <input type="number" class="form-control" id="editFeedCost" name="feedCost" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPurchaseDate" class="form-label">Purchased Date</label>
                            <input type="date" class="form-control" id="editPurchaseDate" name="purchasedDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="editFeedDescription" class="form-label">Feed Description</label>
                            <textarea class="form-control" id="editFeedDescription" name="feedDescription" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Deleting Feeds -->
    <div class="modal fade" id="deleteFeedModal" tabindex="-1" aria-labelledby="deleteFeedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteFeedModalLabel">Delete Feed</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this feed?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteFeedForm" action="deleteFeeds.php" method="POST">
                        <input type="hidden" id="deleteFeedId" name="feedId">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../assets/vendor/quill/quill.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <script src="../assets/js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Edit Feed Modal
            const editButtons = document.querySelectorAll('.editFeedBtn');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const feedId = this.dataset.id;
                    const feedName = this.dataset.name;
                    const quantity = this.dataset.quantity;
                    const cost = this.dataset.cost;
                    const purchaseDate = this.dataset.date;
                    const description = this.dataset.description;

                    document.getElementById('editFeedId').value = feedId;
                    document.getElementById('editFeedName').value = feedName;
                    document.getElementById('editQuantityPerSack').value = quantity;
                    document.getElementById('editFeedCost').value = cost;
                    document.getElementById('editPurchaseDate').value = purchaseDate;
                    document.getElementById('editFeedDescription').value = description;
                });
            });

            // Delete Feed Modal
            const deleteButtons = document.querySelectorAll('.deleteFeedBtn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const feedId = this.dataset.id;
                    document.getElementById('deleteFeedId').value = feedId;
                });
            });
        });
    </script>
</body>

</html>