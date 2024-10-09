<?php
$base_url = '/Barangay-Liberty-Abal-Pig-Feeding-Guide-Monitoring-System/admin/';
$base_url2 = '/Barangay-Liberty-Abal-Pig-Feeding-Guide-Monitoring-System/admin/manage-pigs/';

$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <div class="sidebar-logo">
        <a href="<?php echo $base_url; ?>" class="logo">
            <img src="<?php echo $base_url; ?>assets/img/pig-logo.png">
        </a>
        <div class="welcome-message">
            <p>Welcome, Admin</p>
        </div>
    </div>

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>dashboard.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo ($current_page == 'pigsList.php') ? 'active' : ''; ?>" href="<?php echo $base_url2; ?>pigsList.php">
                <i class="bi bi-piggy-bank"></i>
                <span>Manage Pigs</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?php echo ($current_page == 'manageBreeds.php') ? 'active' : ''; ?>" href="<?php echo $base_url3; ?>manageBreeds.php"> <!-- New link for manage breeds -->
                <i class="bi bi-piggy-bank"></i> 
                <span>Manage Breeds</span>
            </a>
        </li>



        <li class="nav-item">
            <a class="nav-link <?php echo ($current_page == 'feedingSchedule.php') ? 'active' : ''; ?>" href="<?php echo $base_url2; ?>feedingSchedule.php"> <!-- New link for feeding schedule -->
                <i class="bi bi-clock"></i>
                <span>Feeding Schedule</span>
            </a>
        </li>

    </ul>





</aside><!-- End Sidebar-->