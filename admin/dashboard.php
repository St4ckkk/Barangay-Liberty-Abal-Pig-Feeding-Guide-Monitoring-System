  <?php
  include_once './core/Database.php';
  if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
  }




  require_once './core/notificationController.php';

  $notificationController = new notificationController();


  $currentTime = date('Y-m-d H:i:s');


  $notifications = $notificationController->getNotification();

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
        height: 300px;
        overflow-y: auto;
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
        <h1>Pig Feeding Guide and Monitoring Dashboard</h1>
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
                    <h5 class="card-title">Sales <span>| Today</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-cart"></i>
                      </div>
                      <div class="ps-3">
                        <h6>145</h6>
                        <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>

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
                    <h5 class="card-title">Sales <span>| Today</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-cart"></i>
                      </div>
                      <div class="ps-3">
                        <h6>145</h6>
                        <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                      </div>
                    </div>
                  </div>

                </div>
              </div>

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
                    <h5 class="card-title">Sales <span>| Today</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-cart"></i>
                      </div>
                      <div class="ps-3">
                        <h6>145</h6>
                        <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <!-- Feeding Guidelines -->
              <div class="col-12">
                <div class="card guideline-card">
                  <div class="card-body">
                    <h5 class="card-title">Feeding Guidelines</h5>
                    <ul>
                      <li>Provide fresh, clean water at all times</li>
                      <li>Feed pigs according to their age and weight</li>
                      <li>Starter feed: 18-20% protein for piglets up to 25 kg</li>
                      <li>Grower feed: 16-18% protein for pigs 25-50 kg</li>
                      <li>Finisher feed: 14-16% protein for pigs over 50 kg</li>
                      <li>Monitor feed intake and adjust as necessary</li>
                      <li>Implement a feeding schedule to maintain consistency</li>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- Farrowing Guidelines -->
              <div class="col-12">
                <div class="card guideline-card">
                  <div class="card-body">
                    <h5 class="card-title">Farrowing Guidelines</h5>
                    <ul>
                      <li>Prepare farrowing crates 3-5 days before expected farrowing</li>
                      <li>Ensure the farrowing area is clean, dry, and draft-free</li>
                      <li>Monitor sows closely as farrowing approaches</li>
                      <li>Assist with difficult births if necessary</li>
                      <li>Ensure piglets receive colostrum within the first 6 hours</li>
                      <li>Provide supplemental heat for piglets (35°C in the first week)</li>
                      <li>Process piglets (tail docking, teeth clipping) within 24-48 hours</li>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- Breeding Guidelines -->
              <div class="col-12">
                <div class="card guideline-card">
                  <div class="card-body">
                    <h5 class="card-title">Breeding Guidelines</h5>
                    <ul>
                      <li>Begin breeding gilts at 7-8 months of age or 135-150 kg</li>
                      <li>Aim for 2.5 litters per sow per year</li>
                      <li>Use artificial insemination or natural breeding methods</li>
                      <li>Monitor for signs of heat (estrus) every 18-24 days</li>
                      <li>Breed sows 12-24 hours after onset of standing heat</li>
                      <li>Conduct pregnancy checks 28-35 days after breeding</li>
                      <li>Provide proper nutrition for pregnant sows</li>
                    </ul>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <!-- Right side columns -->
          <div class="col-lg-4">
            <!-- Feed Stock -->
            <div class="card">
              <div class="card-body pb-0">
                <h5 class="card-title">Feed Stock <span>| Today</span></h5>
                <div id="feedStock" style="min-height: 400px;" class="echart"></div>
              </div>
            </div>

            <!-- Vitamins/Medicines Stock -->
            <div class="card">
              <div class="card-body pb-0">
                <h5 class="card-title">Vitamins/Medicines Stock</h5>
                <ul class="list-group">
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Vitamin A+D3+E
                    <span class="badge bg-primary rounded-pill">50 units</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Iron Supplement
                    <span class="badge bg-primary rounded-pill">100 units</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Antibiotic (General)
                    <span class="badge bg-warning rounded-pill">10 units</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Dewormer
                    <span class="badge bg-danger rounded-pill">5 units</span>
                  </li>
                </ul>
              </div>
            </div>

            <!-- Health Alerts -->
            <div class="card">
              <div class="card-body pb-0">
                <h5 class="card-title">Health Alerts <span>| Today</span></h5>
                <ul class="list-group">
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Pig #1024 - High Temperature
                    <span class="badge bg-danger rounded-pill">Urgent</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Pen B2 - Low Water Consumption
                    <span class="badge bg-warning rounded-pill">Warning</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    Pig #2048 - Reduced Feed Intake
                    <span class="badge bg-info rounded-pill">Monitor</span>
                  </li>
                </ul>
              </div>
            </div>

          </div><!-- End Right side columns -->

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
        // Weight Trend Chart
        var weightOptions = {
          series: [{
            name: 'Average Weight',
            data: [65, 68, 71, 74, 77, 80, 83]
          }],
          chart: {
            height: 350,
            type: 'line',
            zoom: {
              enabled: false
            }
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            curve: 'straight'
          },
          grid: {
            row: {
              colors: ['#f3f3f3', 'transparent'],
              opacity: 0.5
            },
          },
          xaxis: {
            categories: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7'],
          }
        };

        var weightChart = new ApexCharts(document.querySelector("#weightChart"), weightOptions);
        weightChart.render();

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
            data: [{
                value: 1048,
                name: 'Starter Feed'
              },
              {
                value: 735,
                name: 'Grower Feed'
              },
              {
                value: 580,
                name: 'Finisher Feed'
              }
            ]
          }]
        });
      });
    </script>

  </body>

  </html>