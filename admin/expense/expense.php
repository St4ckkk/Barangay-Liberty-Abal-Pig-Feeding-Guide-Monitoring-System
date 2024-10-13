<?php
require_once '../core/Database.php';
require_once '../core/expenseController.php';
require_once '../core/notificationController.php';
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}
$notificationController = new notificationController();


$currentTime = date('Y-m-d H:i:s');


$notifications = $notificationController->getNotification();



$expenses = (new expenseController())->getAllExpenses();
$success = '';
$error = '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Expense Report - Barangay Liberty Abal Piggery</title>
    <meta content="Expense report for Barangay Liberty Abal Piggery" name="description">
    <meta content="pig, expense, report, barangay liberty abal" name="keywords">

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
</head>
<style>
    .btn {
        width: 60px;
        padding: 2px;
        font-size: 12px;
    }

    .custom-btn {
        width: 150px;
        padding: 5px;
    }

    .dl {
        width: 100px;
    }
</style>

<body>
    <?php
    include_once '../partials/navbar.php';
    include_once '../partials/sidebar.php';
    ?>

    <main id="main" class="main" style="margin-top: 100px;">
        <div class="pagetitle">
            <h1>Manage Expenses</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Manage</li>
                    <li class="breadcrumb-item active">Expenses</li>
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
                            <span>Expenses</span>
                        </div>
                        <div class="card-body">
                            <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                <div class="datatable-top">
                                    <div class="datatable-dropdown">
                                        <div class="float-end">
                                            <a href="#" class="custom-btn btn btn-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                                                Generate PDF Report <i class="bi bi-file-earmark-pdf"></i>
                                            </a>
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
                                                <th data-sortable="true">Item Name</th>
                                                <th data-sortable="true">Item Type</th>
                                                <th data-sortable="true">Total Cost</th>
                                                <th data-sortable="true">Purchase Date</th>

                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($expenses)) : ?>
                                                <?php foreach ($expenses as $expense) : ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($expense['expenseName']) ?></td>
                                                        <td><?= htmlspecialchars($expense['expenseType']) ?></td>
                                                        <td>₱<?= number_format($expense['total'], 2) ?></td>
                                                        <td><?= date('M d, Y', strtotime($expense['expenseDate'])) ?></td>
                                                        <td>
                                                            <button class="btn btn-primary btn-edit" data-expense-id="<?= $expense['expenseId'] ?>"
                                                                data-expense-name="<?= htmlspecialchars($expense['expenseName']) ?>"
                                                                data-expense-type="<?= htmlspecialchars($expense['expenseType']) ?>"
                                                                data-total="<?= $expense['total'] ?>"
                                                                data-expense-date="<?= $expense['expenseDate'] ?>">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-delete" data-expense-id="<?= $expense['expenseId'] ?>">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>

                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5">No expenses found.</td>
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
            </div>
        </section>
        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Confirm Download</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to download the Expense Report PDF?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="dl btn btn-primary" id="confirmDownload">Download PDF</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Edit Expense Modal -->
    <div class="modal fade" id="editExpenseModal" tabindex="-1" aria-labelledby="editExpenseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editExpenseModalLabel">Edit Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editExpenseForm">
                    <div class="modal-body">
                        <input type="hidden" name="expenseId" id="editExpenseId">
                        <div class="mb-3">
                            <label for="editExpenseName" class="form-label">Item Name</label>
                            <input type="text" class="form-control" name="expenseName" id="editExpenseName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editExpenseType" class="form-label">Item Type</label>
                            <input type="text" class="form-control" name="expenseType" id="editExpenseType" required>
                        </div>
                        <div class="mb-3">
                            <label for="editTotalCost" class="form-label">Total Cost</label>
                            <input type="number" class="form-control" name="total" id="editTotalCost" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPurchaseDate" class="form-label">Purchase Date</label>
                            <input type="date" class="form-control" name="expenseDate" id="editPurchaseDate" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteExpenseModal" tabindex="-1" aria-labelledby="deleteExpenseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteExpenseModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this expense?
                    <input type="hidden" id="deleteExpenseId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>


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
        document.getElementById('confirmDownload').addEventListener('click', function() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('confirmationModal'));
            modal.hide();


            const link = document.createElement('a');
            link.href = 'expense_report.php'; // The URL that generates the PDF
            link.download = 'Expense_Report.pdf'; // Optional: specify a default file name
            document.body.appendChild(link); // Append link to body
            link.click(); // Programmatically click the link
            document.body.removeChild(link); // Remove link from body
        });
    </script>
    <script>
        // Edit Modal Handling
        const editExpenseButtons = document.querySelectorAll('.btn-edit'); // Add class btn-edit to your edit buttons
        editExpenseButtons.forEach(button => {
            button.addEventListener('click', function() {
                const expenseId = this.getAttribute('data-expense-id'); // Add data attribute to your edit button
                const expenseName = this.getAttribute('data-expense-name'); // Add data attribute to your edit button
                const expenseType = this.getAttribute('data-expense-type'); // Add data attribute to your edit button
                const total = this.getAttribute('data-total'); // Add data attribute to your edit button
                const expenseDate = this.getAttribute('data-expense-date'); // Add data attribute to your edit button

                // Fill the modal with existing expense data
                document.getElementById('editExpenseId').value = expenseId;
                document.getElementById('editExpenseName').value = expenseName;
                document.getElementById('editExpenseType').value = expenseType;
                document.getElementById('editTotalCost').value = total;
                document.getElementById('editPurchaseDate').value = expenseDate;

                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('editExpenseModal'));
                modal.show();
            });
        });

        // Delete Modal Handling
        const deleteExpenseButtons = document.querySelectorAll('.btn-delete'); // Add class btn-delete to your delete buttons
        deleteExpenseButtons.forEach(button => {
            button.addEventListener('click', function() {
                const expenseId = this.getAttribute('data-expense-id'); // Add data attribute to your delete button
                document.getElementById('deleteExpenseId').value = expenseId;

                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('deleteExpenseModal'));
                modal.show();
            });
        });

        // Confirm Deletion
        document.getElementById('confirmDelete').addEventListener('click', function() {
            const expenseId = document.getElementById('deleteExpenseId').value;
            window.location.href = 'deleteDisinfectionGuidelines.php?id=' + expenseId; // Redirect to your delete script
        });
    </script>


</body>

</html>