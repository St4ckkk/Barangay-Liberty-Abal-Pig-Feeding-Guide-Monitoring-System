<?php
$base_url = '/Barangay-Liberty-Abal-Pig-Feeding-Guide-Monitoring-System/admin/';
$base_url2 = '/Barangay-Liberty-Abal-Pig-Feeding-Guide-Monitoring-System/admin/guidelines/';
$base_url_inventory = '/Barangay-Liberty-Abal-Pig-Feeding-Guide-Monitoring-System/admin/inventory/';
$base_url_settings = '/Barangay-Liberty-Abal-Pig-Feeding-Guide-Monitoring-System/admin/settings/';
$base_url_user = '/Barangay-Liberty-Abal-Pig-Feeding-Guide-Monitoring-System/admin/user/';
$base_url_expense = '/Barangay-Liberty-Abal-Pig-Feeding-Guide-Monitoring-System/admin/expense/';
$base_url_schedule = '/Barangay-Liberty-Abal-Pig-Feeding-Guide-Monitoring-System/admin/schedule/';

$current_page = basename($_SERVER['PHP_SELF']);

$guidelines_pages = ['feeding-guidelines.php', 'health-guidelines.php', 'pigs-guidelines.php', 'disinfection-guidelines.php'];
$is_guidelines_active = in_array($current_page, $guidelines_pages);

$inventory_pages = ['feedStocks.php', 'vitStocks.php', 'pen.php', 'sow.php', 'pigs.php'];
$is_inventory_active = in_array($current_page, $inventory_pages);

$settings_pages = ['feedingPeriod.php', 'biv.php', 'cleaningPeriod.php', 'harvestTime.php', 'slaughteringPeriod.php', 'farrowingPeriod.php'];
$is_settings_active = in_array($current_page, $settings_pages);
$schedule_pages = ['feedingSchedule.php', 'cleaningSchedule.php', 'cleaningSchedule.php', 'slaughteringSchedule.php', 'farrowingSchedule.php'];
$is_schedule_active = in_array($current_page, $schedule_pages);
?>

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <div class="sidebar-logo">
        <a href="<?php echo $base_url; ?>" class="logo">
            <img src="<?php echo $base_url; ?>assets/img/pig-logo.png" style="width: 100px;">
        </a>
        <div class="welcome-message">
            <p>Welcome, <?= isset($_SESSION['u']) ? htmlspecialchars($_SESSION['u']) : 'Guest'; ?></p>
        </div>
    </div>

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>" href="<?php echo $base_url; ?>dashboard.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'user.php') ? 'active' : ''; ?>" href="<?php echo $base_url_user; ?>user.php">
                    <i class="bi bi-people"></i>
                    <span>Manage User</span>
                </a>
            </li>
        <?php endif; ?>

        <!-- Guidelines Section -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo $is_guidelines_active ? '' : 'collapsed'; ?> <?php echo $is_guidelines_active ? 'active' : ''; ?>" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#" aria-expanded="<?php echo $is_guidelines_active ? 'true' : 'false'; ?>">
                    <i class="bi bi-book"></i><span>Guidelines</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse <?php echo $is_guidelines_active ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?php echo $base_url2; ?>feeding-guidelines.php" class="<?php echo ($current_page == 'feeding-guidelines.php') ? 'active' : ''; ?>">
                            <span>Feeding Guidelines</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url2; ?>disinfection-guidelines.php" class="<?php echo ($current_page == 'disinfection-guidelines.php') ? 'active' : ''; ?>">
                            <span>Cleaning Guidelines</span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

        <!-- Inventory Section -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo $is_inventory_active ? '' : 'collapsed'; ?> <?php echo $is_inventory_active ? 'active' : ''; ?>" data-bs-target="#inventory-nav" data-bs-toggle="collapse" href="#" aria-expanded="<?php echo $is_inventory_active ? 'true' : 'false'; ?>">
                    <i class="bi bi-box"></i><span>Inventory</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="inventory-nav" class="nav-content collapse <?php echo $is_inventory_active ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?php echo $base_url_inventory; ?>feedStocks.php" class="<?php echo ($current_page == 'feedStocks.php') ? 'active' : ''; ?>">
                            </i><span>Feed Stocks</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a href="<?php echo $base_url_inventory; ?>vitStocks.php" class="<?php echo ($current_page == 'vitStocks.php') ? 'active' : ''; ?>">
                            <span>Vitamins/Medicines Stocks</span>
                        </a>
                    </li> -->
                    <li>
                        <a href="<?php echo $base_url_inventory; ?>pen.php" class="<?php echo ($current_page == 'pen.php') ? 'active' : ''; ?>">
                            <span>Pig Pen</span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

        <li class="nav-item">
            <a class="nav-link <?php echo $is_schedule_active ? '' : 'collapsed'; ?> <?php echo $is_schedule_active ? 'active' : ''; ?>" data-bs-target="#schedule-nav" data-bs-toggle="collapse" href="#" aria-expanded="<?php echo $is_schedule_active ? 'true' : 'false'; ?>">
                <i class="bi bi-clock"></i><span>Schedule</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="schedule-nav" class="nav-content collapse <?php echo $is_schedule_active ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?php echo $base_url_schedule; ?>feedingSchedule.php" class="<?php echo ($current_page == 'feedingPeriod.php') ? 'active' : ''; ?>">
                        <span>Feeding Schedule</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url_schedule; ?>cleaningSchedule.php" class="<?php echo ($current_page == 'cleaningPeriod.php') ? 'active' : ''; ?>">
                        <span>Cleaning Schedule</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url_schedule; ?>slaughteringSchedule.php" class="<?php echo ($current_page == 'cleaningPeriod.php') ? 'active' : ''; ?>">
                        <span>Slaughtering Schedule</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url_schedule; ?>farrowingSchedule.php" class="<?php echo ($current_page == 'cleaningPeriod.php') ? 'active' : ''; ?>">
                        <span>Farrowing Schedule</span>
                    </a>
                </li>
            </ul>

        </li>

        <!-- Settings Section -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo $is_settings_active ? '' : 'collapsed'; ?> <?php echo $is_settings_active ? 'active' : ''; ?>" data-bs-target="#settings-nav" data-bs-toggle="collapse" href="#" aria-expanded="<?php echo $is_settings_active ? 'true' : 'false'; ?>">
                    <i class="bi bi-gear"></i><span>Settings</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="settings-nav" class="nav-content collapse <?php echo $is_settings_active ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?php echo $base_url_settings; ?>feedingPeriod.php" class="<?php echo ($current_page == 'feedingPeriod.php') ? 'active' : ''; ?>">
                            <span>Feeding Time</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url_settings; ?>cleaningPeriod.php" class="<?php echo ($current_page == 'cleaningPeriod.php') ? 'active' : ''; ?>">
                            <span>Cleaning Time</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a href="<?php echo $base_url_settings; ?>biv.php" class="<?php echo ($current_page == 'biv.php') ? 'active' : ''; ?>">
                            <span>Boosting/Injections/Vitamins</span>
                        </a>
                    </li> -->
                    <li>
                        <a href="<?php echo $base_url_settings; ?>slaughteringPeriod.php" class="<?php echo ($current_page == 'slaughteringPeriod.php') ? 'active' : ''; ?>">
                            <span>Slaughtering Period</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $base_url_settings; ?>farrowingPeriod.php" class="<?php echo ($current_page == 'farrowingPeriod.php') ? 'active' : ''; ?>">
                            <span>Farrowing Period</span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'expense.php') ? 'active' : ''; ?>" href="<?php echo $base_url_expense; ?>expense.php">
                    <i class="bi bi-cash-stack"></i>
                    <span>Manage Expense</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</aside><!-- End Sidebar -->