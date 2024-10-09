]<?php
    $base_url = '/Barangay-Liberty-Abal-Pig-Feeding-Guide-Monitoring-System/admin/';
    $base_url2 = '/Barangay-Liberty-Abal-Pig-Feeding-Guide-Monitoring-System/admin/guidelines/';
    $base_url_inventory = '/Barangay-Liberty-Abal-Pig-Feeding-Guide-Monitoring-System/admin/inventory/'; // Inventory base URL

    $current_page = basename($_SERVER['PHP_SELF']);

    // Define the pages under the Guidelines section
    $guidelines_pages = ['feeding-guidelines.php', 'health-guidelines.php', 'pigs-guidelines.php', 'disinfection-guidelines.php'];
    $is_guidelines_active = in_array($current_page, $guidelines_pages);

    // Define the pages under the Inventory section
    $inventory_pages = ['feedStocks.php', 'vitStocks.php', 'pigs.php']; // Add your inventory pages here
    $is_inventory_active = in_array($current_page, $inventory_pages);
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

        <!-- Guidelines Section -->
        <li class="nav-item">
            <a class="nav-link <?php echo $is_guidelines_active ? '' : 'collapsed'; ?> <?php echo $is_guidelines_active ? 'active' : ''; ?>" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#" aria-expanded="<?php echo $is_guidelines_active ? 'true' : 'false'; ?>">
                <i class="bi bi-book"></i><span>Guidelines</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse <?php echo $is_guidelines_active ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?php echo $base_url2; ?>feeding-guidelines.php" class="<?php echo ($current_page == 'feeding-guidelines.php') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i><span>Feeding Guidelines</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url2; ?>health-guidelines.php" class="<?php echo ($current_page == 'health-guidelines.php') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i><span>Health Guidelines</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url2; ?>pigs-guidelines.php" class="<?php echo ($current_page == 'pigs-guidelines.php') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i><span>Types Of Pigs</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url2; ?>disinfection-guidelines.php" class="<?php echo ($current_page == 'disinfection-guidelines.php') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i><span>Disinfection Guidelines</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Inventory Section -->
        <li class="nav-item">
            <a class="nav-link <?php echo $is_inventory_active ? '' : 'collapsed'; ?> <?php echo $is_inventory_active ? 'active' : ''; ?>" data-bs-target="#inventory-nav" data-bs-toggle="collapse" href="#" aria-expanded="<?php echo $is_inventory_active ? 'true' : 'false'; ?>">
                <i class="bi bi-box"></i><span>Inventory</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="inventory-nav" class="nav-content collapse <?php echo $is_inventory_active ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?php echo $base_url_inventory; ?>feedStocks.php" class="<?php echo ($current_page == 'inventory-list.php') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i><span>Feed Stocks</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url_inventory; ?>vitStocks.php" class="<?php echo ($current_page == 'inventory-add.php') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i><span>Vitamins/Medicines Stocks</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $base_url_inventory; ?>pigs.php" class="<?php echo ($current_page == 'inventory-report.php') ? 'active' : ''; ?>">
                        <i class="bi bi-circle"></i><span>Pigs</span>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</aside><!-- End Sidebar -->