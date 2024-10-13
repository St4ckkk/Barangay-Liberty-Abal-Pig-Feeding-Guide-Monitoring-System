<?php

$base_url = '/Barangay-Liberty-Abal-Pig-Feeding-Guide-Monitoring-System/admin/schedule';
$base_url2 = '/Barangay-Liberty-Abal-Pig-Feeding-Guide-Monitoring-System/admin/core/';
$base_url3 = '/Barangay-Liberty-Abal-Pig-Feeding-Guide-Monitoring-System/admin/';
$base_url4 = '/Barangay-Liberty-Abal-Pig-Feeding-Guide-Monitoring-System/admin/schedule/';
$current_page = basename($_SERVER['PHP_SELF']);
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : null;

// Correct the path to notificationController.php
require_once __DIR__ . '/../core/notificationController.php';

$notificationController = new notificationController();
$currentTime = date('Y-m-d H:i:s');

$notifications = ($userRole === 'worker') ? $notificationController->getNotification() : [];

?>

<header id="header" class="header fixed-top d-flex align-items-center" style="background-color:#418091; padding: 10px 20px;">
  <i class="bi bi-list toggle-sidebar-btn me-3" style="color: white; font-size: 1.5rem; cursor: pointer;"></i>
  <div class="d-flex align-items-center justify-content-between flex-grow-1">
    <a href="index.html" class="logo d-flex align-items-center" style="text-decoration: none;">
      <span class="d-lg-block" style="color: white; font-size: 1.2rem; font-weight: bold;">PIG FEEDING GUIDE AND MONITORING SYSTEM</span>
    </a>
    <nav class="header-nav">
      <ul class="d-flex align-items-center m-0">
        <li class="nav-item dropdown">
          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell text-white"></i>
            <span class="badge bg-primary badge-number"><?= count($notifications); ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" style="color: #000;">
            <li class="dropdown-header" style="background: #418091;">
              <span class="messageCount"><?= count($notifications) ?> new notifications</span>
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <?php if (empty($notifications)): ?>
              <li class="notification-item">
                <div>No new notifications</div>
              </li>
            <?php else: ?>
              <?php foreach ($notifications as $notification): ?>
                <li class="notification-item">
                  <div>
                    <?php
                    // Determine the link based on the type of notification
                    $notificationType = $notification['actionType']; // Assuming 'type' field exists
                    $link = '';

                    switch ($notificationType) {
                      case 'slaughter':
                        $link = $base_url4 . 'slaughter.php?id=' . urlencode($notification['id']);
                        break;
                      case 'feeding':
                        $link = $base_url4 . 'feeding.php?id=' . urlencode($notification['id']);
                        break;
                      case 'cleaning':
                        $link = $base_url4 . 'cleaning.php?id=' . urlencode($notification['id']);
                        break;
                      case 'farrowing':
                        $link = $base_url4 . 'farrowing.php?id=' . urlencode($notification['id']);
                        break;
                      default:
                        $link = $base_url4 . 'notification.php?id=' . urlencode($notification['id']);
                        break;
                    }
                    ?>
                    <a href="<?= $link ?>" style="color: black; text-decoration: none;">
                      <strong><?= htmlspecialchars($notification['title']); ?></strong>
                      <p style="color: black; margin: 0;"><?= htmlspecialchars($notification['message']); ?></p>
                    </a>
                  </div>
                </li>

                <li>
                  <hr class="dropdown-divider">
                </li>
              <?php endforeach; ?>
            <?php endif; ?>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown" style="color: white;">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle" style="width: 30px; height: 30px;">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?= isset($_SESSION['u']) ? htmlspecialchars($_SESSION['u']) : 'Guest'; ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="./logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span style="color: #444444;">Sign Out</span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</header>