
<header id="header" class="header fixed-top d-flex align-items-center">
  <div class="d-flex align-items-center justify-content-between">
    <a href="index.html" class="logo d-flex align-items-center">
      <span class="d-none d-lg-block">SKeynected</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <div class="search-bar">
    <form class="search-form d-flex align-items-center" method="POST" action="#">
      <input type="text" name="query" placeholder="Search" title="Enter search keyword">
      <button type="submit" title="Search"><i class="bi bi-search"></i></button>
    </form>
  </div><!-- End Search Bar -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
      <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle" href="#">
          <i class="bi bi-search"></i>
        </a>
      </li>
      <li class="nav-item dropdown pe-2">
        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" aria-expanded="false" id="bell-icon">
          <i class="bi bi-bell"></i>
          <span class="badge bg-primary badge-number" id="notification-count"><?php echo $notificationCount; ?></span>
        </a>

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
          <li class="dropdown-header">
            You have <?php echo $notificationCount; ?> new notifications
            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <?php foreach ($notifications as $notification): ?>
            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4><?php echo htmlspecialchars($notification['project_name']); ?></h4>
                <p>Your hearing is scheduled for:</p>
                <p><strong><?php echo date('j F Y', strtotime($notification['hearing_schedule'])); ?></strong></p>
              </div>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
          <?php endforeach; ?>
        </ul>
      </li>
      <a class="nav-link nav-profile d-flex align-items-center pe-3" href="#" data-bs-toggle="dropdown">
        <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
        <span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span>
      </a><!-- End Profile Image Icon -->
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li class="dropdown-header">
          <h6>Kevin Anderson</h6>
          <span style="color: #444444;">Web Designer</span>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li>
          <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
            <i class="bi bi-person"></i>
            <span style="color: #444444;">My Profile</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
            <i class="bi bi-gear"></i>
            <span style="color: #444444;">Account Settings</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
            <i class="bi bi-question-circle"></i>
            <span style="color: #444444;">Need Help?</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="#">
            <i class="bi bi-box-arrow-right"></i>
            <span style="color: #444444;">Sign Out</span>
          </a>
        </li>

      </ul><!-- End Profile Dropdown Items -->
    </ul>
  </nav>
</header>

<script>
  document.getElementById('bell-icon').addEventListener('click', function() {
    var notificationCountElement = document.getElementById('notification-count');

    notificationCountElement.textContent = '0';


    fetch('reset-notif.php', {
      method: 'POST',
    }).then(response => {
      // Handle response if needed
    }).catch(error => console.error('Error:', error));
  });
</script>