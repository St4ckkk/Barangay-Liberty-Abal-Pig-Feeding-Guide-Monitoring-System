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
            <span class="badge bg-primary badge-number"></span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              <span class="messageCount"></span>
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <div>
                <h4><span id="messageTitle"></span></h4>
                <p><span id="messageBody"></span></p>
                <p><span id="messageAgo"></span></p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>
          </ul><!-- End Notification Dropdown Items -->
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown" style="color: white;">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle" style="width: 30px; height: 30px;">
            <span class="d-none d-md-block dropdown-toggle ps-2"> <?= isset($_SESSION['u']) ? htmlspecialchars($_SESSION['u']) : 'Guest'; ?></span>
          </a>
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
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</header>