<?php
require_once '../core/pigController.php';

$pigController = new pigsController();
$pigs = $pigController->getAllPigs();
$breeds = $pigController->getAllBreeds();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Pig Feeding Guide and Monitoring Dashboard</title>
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

    <style>
        .card-icon {
            font-size: 32px;
            line-height: 0;
            width: 64px;
            height: 64px;
            flex-shrink: 0;
            flex-grow: 0;
            color: #fff;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .card-equal-height {
            display: flex;
            flex-direction: column;
        }

        .card-equal-height .card-body {
            flex: 1;
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
            <h1>List Of Pigs</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Manage Pigs</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">List of Pigs</h5>
                            <button type="button" class="btn btn-success float-end mb-3" data-bs-toggle="modal" data-bs-target="#addPigModal">
                                Add Pig
                            </button>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">ETN</th>
                                        <th scope="col">Breed</th>
                                        <th scope="col">Birth date</th>
                                        <th scope="col">Weight</th>
                                        <th scope="col">Health Status</th>
                                        <th scope="col">Pen #</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pigs as $pig) : ?>
                                        <tr>
                                            <td><?= $pig['ear_tag_number'] ?></td>
                                            <td><?= $pig['name'] ?></td>
                                            <td><?= $pig['birth_date'] ?></td>
                                            <td><?= $pig['weight'] ?></td>
                                            <td><?= $pig['health_status'] ?></td>
                                            <td><?= $pig['pen_number'] ?></td>
                                            <td><?= $pig['gender'] ?></td>
                                            <td>
                                                <a href="editPig.php?id=<?= $pig['id'] ?>" class="btn btn-primary">Edit</a>
                                                <a href="deletePig.php?id=<?= $pig['id'] ?>" class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <!-- Modal -->
            <div class="modal fade" id="addPigModal" tabindex="-1" aria-labelledby="addPigModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPigModalLabel">Add New Pig</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="addPig.php" method="POST">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="earTagNumber" class="form-label">ETN</label>
                                        <input type="text" class="form-control" id="earTagNumber" name="ear_tag_number" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="breed" class="form-label">Breed</label>
                                        <select name="breed" id="breed" class="form-control">
                                            <option value="">Select a breed</option> 
                                            <?php foreach ($breeds as $breed): ?> 
                                                <option value="<?php echo $breed['id']; ?>"><?php echo htmlspecialchars($breed['name']); ?></option> <!-- Display breed name -->
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="birthDate" class="form-label">Birth Date</label>
                                        <input type="date" class="form-control" id="birthDate" name="birth_date" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="weight" class="form-label">Weight</label>
                                        <input type="number" class="form-control" id="weight" name="weight" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="healthStatus" class="form-label">Health Status</label>
                                        <input type="text" class="form-control" id="healthStatus" name="health_status" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="penNumber" class="form-label">Pen #</label>
                                        <input type="text" class="form-control" id="penNumber" name="pen_number" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-select" id="gender" name="gender" required>
                                            <option value="" disabled selected>Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Pig</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </section>

    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../assets/vendor/quill/quill.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <script src="../assets/js/main.js"></script>
</body>

</html>