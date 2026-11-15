
<?php
// MIS UNIT DASHBOARD

session_start();
require_once __DIR__ . '/config/database.php';

// Uncomment when login authentication is ready.
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

$username = $_SESSION['username'] ?? 'MIS Administrator';
$role = $_SESSION['role'] ?? 'Administrator';

$totalAssets = (int)$pdo->query("SELECT COUNT(*) FROM inventory")->fetchColumn();
$totalProjects = 0;
$totalServices = 0;
$totalReports = 0;
?>


<!DOCTYPE html>
<html lang="en">

 <head>
    <meta charset = "UTF-8">
    <meta name="viewpoint" content="widt=device-width, initial-scale=1.0">
    <title> Management Information System Unit | Dashboard</title>
   
    <link rel="stylesheet" href="css/dashboard.css">

     <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
 </head>
<body>
 
<div class="container">

<!-- SIDEBAR -->

<aside class=""sidebar">

<div class = "logo">
    <img src="images\logo.webp" alt="MTA Logo">
    <h3>MIS UNIT</h3>
    <p>Information Portal </h3>
</div>

   <ul class="menu">

            <li class="active">
                <a href="index.php">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="pages/about.php">
                    <i class="fas fa-circle-info"></i>
                    About MIS
                </a>
            </li>

            <li>
                <a href="pages/services.php">
                    <i class="fas fa-headset"></i>
                    IT Services
                </a>
            </li>

            <li>
                <a href="pages/inventory.php">
                    <i class="fas fa-computer"></i>
                    IT Inventory
                </a>
            </li>

            <li>
                <a href="pages/projects.php">
                    <i class="fas fa-folder-open"></i>
                    Projects
                </a>
            </li>

            <li>
                <a href="pages/reports.php">
                    <i class="fas fa-file-alt"></i>
                    Reports
                </a>
            </li>

            <li>
                <a href="pages/announcements.php">
                    <i class="fas fa-bullhorn"></i>
                    Announcements
                </a>
            </li>

            <li>
                <a href="pages/contacts.php">
                    <i class="fas fa-address-book"></i>
                    Contacts
                </a>
            </li>

        </ul>

        <div class="sidebar-bottom">
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </div>

    </aside>

    <!-- MAIN CONTENT -->

<main class="main content">

<!-- TOP HEADER -->

<header class="topbar">

,<div>
    <h2>Dashboard</h2>
    <p>Management Information System Unit</p>
</div>

<div class="user-profile">
    <i class="fas fa-user-circle"></i>

  <div>
                    <strong>
                        <?php echo htmlspecialchars($username); ?>
                    </strong>

                    <small>
                        <?php echo htmlspecialchars($role); ?>
                    </small>
                </div>
            </div>

        </header>

        <!--WELCOME SECTION-->

<section class="welcome">

<div>         
<h2> Welcome to MIS Unit Portal </h2>

<p> Your central platform for accessing Management Information, IT services, projects and resources.</p>

</div>

            <i class="fas fa-laptop-code"></i>

        </section>


        <!-- STATISTICS -->
        <section class="stats">

            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-desktop"></i>
                </div>

                <div>
                    <h3><?php echo $totalAssets; ?></h3>
                    <p>Total IT Assets</p>
                </div>
            </div>


            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-folder-open"></i>
                </div>

                <div>
                    <h3><?php echo $totalProjects; ?></h3>
                    <p>IT Projects</p>
                </div>
            </div>


            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-headset"></i>
                </div>

                <div>
                    <h3><?php echo $totalServices; ?></h3>
                    <p>IT Services</p>
                </div>
            </div>


            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-file-alt"></i>
                </div>

                <div>
                    <h3><?php echo $totalReports; ?></h3>
                    <p>Available Reports</p>
                </div>
            </div>

        </section>


        <!-- DASHBOARD CONTENT -->
        <section class="content-grid">

            <div class="content-box">

                <h3>
                    <i class="fas fa-bullhorn"></i>
                    Latest Announcements
                </h3>

                <div class="announcement">
                    <h4>IT System Updates</h4>
                    <p>
                        Important updates and information from
                        the MIS Unit.
                    </p>
                    <small>Latest notice</small>
                </div>

                <div class="announcement">
                    <h4>System Maintenance</h4>
                    <p>
                        Staff are advised to follow official
                        maintenance notifications.
                    </p>
                    <small>Maintenance notice</small>
                </div>

                <a href="pages/announcements.php" class="view-link">
                    View All Announcements →
                </a>

            </div>


            <div class="content-box">

                <h3>
                    <i class="fas fa-info-circle"></i>
                    About MIS Unit
                </h3>

                <p>
                    The Management Information Systems Unit
                    supports the organisation through information
                    technology services, system administration,
                    technical support, database management,
                    network maintenance and digital development.
                </p>

                <a href="pages/about.php" class="view-link">
                    Learn More →
                </a>

            </div>

        </section>


        <!-- QUICK ACCESS -->
        <section class="content-box quick-access">

            <h3>Quick Access</h3>

            <div class="quick-links">

                <a href="pages/inventory.php">
                    <i class="fas fa-computer"></i>
                    <span>IT Inventory</span>
                </a>

                <a href="pages/projects.php">
                    <i class="fas fa-code"></i>
                    <span>IT Projects</span>
                </a>

                <a href="pages/reports.php">
                    <i class="fas fa-file-pdf"></i>
                    <span>Reports</span>
                </a>

                <a href="pages/services.php">
                    <i class="fas fa-tools"></i>
                    <span>IT Services</span>
                </a>

            </div>

        </section>


        <!-- FOOTER -->
        <footer>
            <p>
                &copy; <?php echo date("Y"); ?>
                Management Information Systems Unit.
                All Rights Reserved.
            </p>
        </footer>

    </main>

</div>


</body>

</html>