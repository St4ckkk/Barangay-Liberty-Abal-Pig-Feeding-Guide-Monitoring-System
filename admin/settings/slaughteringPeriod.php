<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Slaughtering Period</title>
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

    </style>
</head>

<body>
    <?php
    include_once '../partials/navbar.php';
    include_once '../partials/sidebar.php';
    ?>

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
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header mb-2">
                            <span>Slaughtering Period</span>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <th scope="col">Period</th>
                                    <th scope="col">Actions</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header mb-2">
                            <i class="bi bi-plus-circle"></i> Add Slaughtering Period
                        </div>
                        <div class="card-body">
                            <form action="addSlaughteringPeriod.php" method="post">
                                <div class="mb-3">
                                    <label for="slaughteringPeriod" class="form-label">Slaughtering Period</label>
                                    <select name="slaughteringPeriod" id="slaughteringPeriod" class="form-control">
                                        <option value="" disabled selected>Select the slaughtering period</option>
                                        <option value="5.5">5 months 2 weeks</option>
                                        <option value="5.6">5 months 3 weeks</option>
                                        <option value="5.7">5 months 4 weeks (6 months)</option>
                                        <option value="6.0">6 months</option>
                                        <option value="6.1">6 months 1 week</option>
                                        <option value="6.2">6 months 2 weeks</option>
                                        <option value="6.3">6 months 3 weeks</option>
                                        <option value="6.4">6 months 4 weeks (7 months)</option>
                                    </select>
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