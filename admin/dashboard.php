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

  <link href="assets/css/style.css" rel="stylesheet">

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

            <!-- Pigs Count Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card card-equal-height">
                <div class="card-body">
                  <h5 class="card-title">Total Pigs <span>| Today</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-piggy-bank"></i>
                    </div>
                    <div class="ps-3">
                      <h6>145</h6>
                      <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Feed Consumption Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card card-equal-height">
                <div class="card-body">
                  <h5 class="card-title">Feed Consumption <span>| This Week</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6>3,264 kg</h6>
                      <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Average Weight Card -->
            <div class="col-xxl-4 col-xl-12">
              <div class="card info-card customers-card card-equal-height">
                <div class="card-body">
                  <h5 class="card-title">Average Weight <span>| This Month</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-scale"></i>
                    </div>
                    <div class="ps-3">
                      <h6>85 kg</h6>
                      <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Feeding Schedule -->
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Feeding Schedule</h5>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">Time</th>
                        <th scope="col">Feed Type</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Pen</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>06:00 AM</td>
                        <td>Starter Feed</td>
                        <td>50 kg</td>
                        <td>A1, A2, A3</td>
                      </tr>
                      <tr>
                        <td>12:00 PM</td>
                        <td>Grower Feed</td>
                        <td>75 kg</td>
                        <td>B1, B2, B3</td>
                      </tr>
                      <tr>
                        <td>06:00 PM</td>
                        <td>Finisher Feed</td>
                        <td>100 kg</td>
                        <td>C1, C2, C3</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <!-- Weight Trend Chart -->
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Weight Trend</h5>
                  <div id="weightChart"></div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="col-lg-4">
          <div class="card">
            <div class="card-body pb-0">
              <h5 class="card-title">Feed Stock <span>| Today</span></h5>
              <div id="feedStock" style="min-height: 400px;" class="echart"></div>
            </div>
          </div>

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