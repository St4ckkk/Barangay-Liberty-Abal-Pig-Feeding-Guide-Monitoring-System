  <?php
  include_once './core/Database.php';
  include_once './core/indexController.php';
  include_once './core/guidelinesController.php';
  include_once './core/inventoryController.php';
  if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
  }

  $controller = new indexController();
  $guidelinesController = new guidelinesController();
  $currentTotalPigs = $controller->getTotalPigs();
  $previousTotalPigs = $controller->getPreviousTotalPigs();

  $percentageChange = $controller->calculatePercentageChange($currentTotalPigs, $previousTotalPigs);


  $changeDirection = $percentageChange > 0 ? 'increase' : 'decrease';
  $totalPen = $controller->getTotalPen();

  $feedstockController = new inventoryController();
  $feedstockData = $feedstockController->getFeedstockData();

  $guidelines = $guidelinesController->getFeedingGuidelines();
  $cleaningGuidelines = $guidelinesController->getCleaningGuidelines();

  echo "<script>var feedstockData = " . json_encode($feedstockData) . ";</script>";

  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Pig Feeding Guide and Monitoring Dashboard</title>
    <meta content="Dashboard for pig feeding guide and monitoring" name="description">
    <meta content="pig, feeding, monitoring, dashboard" name="keywords">

    <link href="assets/img/pig-logo.png" rel="icon">
    <link href="assets/img/pig-logo.png" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <link href="assets/css/global.css" rel="stylesheet">
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
        height: 100%;
      }

      .card-equal-height .card-body {
        flex: 1;
      }

      .guideline-card {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        transition: transform 0.3s ease;
        backdrop-filter: blur(5px);
      }

      .guideline-card:hover {
        transform: translateY(-5px);
      }

      .guideline-header {
        background-color: #418091;
        color: white;
        padding: 15px;
        font-size: 18px;
        font-weight: bold;
      }

      .guideline-body {
        padding: 20px;
      }

      .guideline-list {
        list-style-type: none;
        padding-left: 0;
        margin-bottom: 0;
      }

      .guideline-list li {
        margin-bottom: 10px;
        padding-left: 30px;
        position: relative;
      }

      .guideline-list li:before {
        content: '•';
        color: #418091;
        font-size: 24px;
        position: absolute;
        left: 0;
        top: -5px;
      }

      .guidelines-title {
        color: #418091;
        padding-top: 10px;
        padding-left: 10px;
      }
    </style>
  </head>

  <body>
    <?php
    include_once 'partials/navbar.php';
    include_once 'partials/sidebar.php';
    ?>

    <main id="main" class="main" style="margin-top: 100px;">
      <div class="pagetitle">
        <h1>Pig Feeding Guide and Monitoring System</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </nav>
      </div>

      <section class="section dashboard">
        <div class="row">
          <!-- Left side columns -->
          <div class="col-lg-8">
            <div class="row gy-4">
              <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">
                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>

                      <li><a class="dropdown-item" href="#">Today</a></li>
                      <li><a class="dropdown-item" href="#">This Month</a></li>
                      <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">Pigs <span>| Today</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <img src="assets/img/pig-logo.png" alt="" srcset="" width="50">
                      </div>
                      <div class="ps-3">
                        <h6><?php echo $currentTotalPigs; ?></h6>
                        <span class="text-success small pt-1 fw-bold">
                          <?php echo abs($percentageChange); ?>%
                        </span>
                        <span class="text-muted small pt-2 ps-1">
                          <?php echo $changeDirection; ?>
                        </span>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <!-- Active Pig Pens Card -->
              <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">
                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>

                      <li><a class="dropdown-item" href="#">Today</a></li>
                      <li><a class="dropdown-item" href="#">This Month</a></li>
                      <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">Pen <span>| Today</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <img src="assets/img/pigpen.png" alt="" srcset="" width="50">
                      </div>
                      <div class="ps-3">
                        <h6><?= $totalPen ?></h6>
                        <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-12">
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card d-flex">
              <div class="card flex-fill">
                <div class="card-people mt-auto">
                  <img src="assets/img/bg.jpg" alt="people" width="100%" height="150px" style="object-fit: cover;">
                  <div class="guidelines-title">
                    <h3>Feeding Guidelines</h3>
                  </div>
                  <?php if (!empty($guidelines)) : ?>
                    <?php foreach ($guidelines as $guideline) : ?>
                      <div class="guideline-body">
                        <ul class="guideline-list">
                          <li><strong>Stage:</strong> <?= htmlspecialchars($guideline['pig_stage']) ?></li>
                          <li><strong>Weight Range:</strong> <?= htmlspecialchars($guideline['weight_range']) ?></li>
                          <li><strong>Feed Type:</strong> <?= htmlspecialchars($guideline['feed_type']) ?></li>
                          <li><strong>Protein Content:</strong> <?= htmlspecialchars($guideline['protein_content']) ?>%</li>
                          <li><strong>Feeding Frequency:</strong> <?= htmlspecialchars($guideline['feeding_frequency']) ?> times/day</li>
                          <li><strong>Amount per Feeding:</strong> <?= htmlspecialchars($guideline['amount_per_feeding']) ?> kg</li>
                          <li><strong>Special Instructions:</strong> <?= htmlspecialchars($guideline['special_instructions']) ?></li>
                        </ul>
                      </div>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <div class="col-12">
                      <p class="text-center text-white">No feeding guidelines available.</p>
                    </div>
                  <?php endif; ?>
                  <div class="weather-info">
                    <div class="d-flex">
                      <div class="ml-2">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card d-flex">
              <div class="card flex-fill">
                <div class="card-people">
                  <img src="assets/img/bg.jpg" alt="people" width="100%" height="150px" style="object-fit: cover;">
                  <div class="guidelines-title">
                    <h3>Cleaning Guidelines</h3>
                  </div>
                  <?php if (!empty($cleaningGuidelines)) : ?>
                    <?php foreach ($cleaningGuidelines as $guideline) : ?>
                      <div class="guideline-body">
                        <ul class="guideline-list">
                          <li><strong>Category:</strong> <?= htmlspecialchars($guideline['category']) ?></li>
                          <li><strong>Frequency:</strong> <?= htmlspecialchars($guideline['frequency']) ?></li>
                          <li><strong>Importance:</strong> <?= htmlspecialchars($guideline['importance']) ?></li>
                          <li><strong>Equipment:</strong> <?= htmlspecialchars($guideline['equipment']) ?></li>
                          <li><strong>Safety Precautions:</strong> <?= htmlspecialchars($guideline['safety']) ?></li>
                          <li><strong>Special Instructions:</strong> <?= htmlspecialchars($guideline['description']) ?></li>
                        </ul>
                      </div>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <p>No cleaning guidelines available.</p>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

    </main><!-- End #main -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <script>
      document.addEventListener("DOMContentLoaded", () => {
        // Convert the PHP feedstock data to an array that ECharts can use
        let feedStockData = feedstockData.map(item => {
          return {
            value: item.QtyOFoodPerSack,
            name: item.feedsName
          };
        });

        // Feed Stock Chart
        var feedStockChart = echarts.init(document.querySelector("#feedStock"));
        feedStockChart.setOption({
          tooltip: {
            trigger: 'item'
          },
          legend: {
            top: '5%',
            left: 'center'
          },
          series: [{
            name: 'Feed Stock',
            type: 'pie',
            radius: ['40%', '70%'],
            avoidLabelOverlap: false,
            label: {
              show: false,
              position: 'center'
            },
            emphasis: {
              label: {
                show: true,
                fontSize: '18',
                fontWeight: 'bold'
              }
            },
            labelLine: {
              show: false
            },
            data: feedStockData // Use the dynamically fetched data
          }]
        });
      });
    </script>


  </body>

  </html>