
<?php
session_start();

$activePage = 'services';

$username = $_SESSION['username'] ?? 'MIS Administrator';
$role = $_SESSION['role'] ?? 'Administrator';

// IT services provided by the MIS Unit
$services = [

    [
        'icon' => 'fa-headset',
        'title' => 'Technical Support',
        'description' => 'Providing technical assistance to staff experiencing computer, software, hardware and other IT-related issues.',
        'category' => 'USER SUPPORT'
    ],

    [
        'icon' => 'fa-network-wired',
        'title' => 'Network Administration',
        'description' => 'Supporting network connectivity, troubleshooting network problems and maintaining reliable communication infrastructure.',
        'category' => 'NETWORK'
    ],

    [
        'icon' => 'fa-desktop',
        'title' => 'Hardware Maintenance',
        'description' => 'Installation, configuration, maintenance and troubleshooting of desktop computers, laptops, printers and other IT equipment.',
        'category' => 'HARDWARE'
    ],

    [
        'icon' => 'fa-laptop-code',
        'title' => 'Software Installation',
        'description' => 'Installing, configuring and maintaining operating systems, Microsoft Office packages and other approved applications.',
        'category' => 'SOFTWARE'
    ],

    [
        'icon' => 'fa-database',
        'title' => 'Database Management',
        'description' => 'Supporting database development, data storage, database maintenance and information management.',
        'category' => 'DATABASE'
    ],

    [
        'icon' => 'fa-globe',
        'title' => 'Website Development',
        'description' => 'Developing, maintaining and supporting organisational websites and web-based information systems.',
        'category' => 'WEB DEVELOPMENT'
    ],

    [
        'icon' => 'fa-envelope',
        'title' => 'Email and Microsoft Services',
        'description' => 'Assisting staff with Outlook, Microsoft 365, email configuration and other Microsoft services.',
        'category' => 'MICROSOFT SERVICES'
    ],

    [
        'icon' => 'fa-print',
        'title' => 'Printer and Scanner Support',
        'description' => 'Configuring printers and scanners, installing drivers and resolving printing and scanning issues.',
        'category' => 'PERIPHERALS'
    ],

    [
        'icon' => 'fa-shield-alt',
        'title' => 'IT Security Support',
        'description' => 'Supporting secure IT practices, antivirus protection, system updates and responsible use of organisational technology.',
        'category' => 'SECURITY'
    ],

    [
        'icon' => 'fa-server',
        'title' => 'System Administration',
        'description' => 'Supporting system configuration, user accounts, access permissions and the maintenance of IT resources.',
        'category' => 'SYSTEMS'
    ],

    [
        'icon' => 'fa-boxes-stacked',
        'title' => 'IT Asset Management',
        'description' => 'Recording, monitoring and maintaining records of computers, peripherals and other organisational IT equipment.',
        'category' => 'ASSET MANAGEMENT'
    ],

    [
        'icon' => 'fa-cloud',
        'title' => 'Data and File Management',
        'description' => 'Assisting with organisational file storage, backup procedures, data access and information organisation.',
        'category' => 'DATA MANAGEMENT'
    ]

];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>IT Services | MIS Unit</title>

    <link rel="stylesheet" href="../css/pages.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

<div class="container">

    <?php include '../includes/inner_sidebar.php'; ?>

    <main class="main-content">

        <!-- HEADER -->
        <header class="topbar">

            <div>
                <h2>IT Services</h2>
                <p>Technology services and technical support</p>
            </div>

            <div class="user-profile">

                <i class="fas fa-user-circle"></i>

                <div>
                    <strong>
                        <?= htmlspecialchars($username) ?>
                    </strong>

                    <small>
                        <?= htmlspecialchars($role) ?>
                    </small>
                </div>

            </div>

        </header>


        <!-- SERVICE BANNER -->
        <section class="page-banner services-banner">

            <div>

                <span class="banner-label">
                    OUR SERVICES
                </span>

                <h1>
                    Technology Solutions and IT Support
                </h1>

                <p>
                    Explore the range of information technology
                    services provided by the Management Information
                    Systems Unit to support staff and organisational
                    operations.
                </p>

            </div>

            <i class="fas fa-computer banner-icon"></i>

        </section>


        <!-- INTRODUCTION -->
        <section class="services-intro">

            <h2>How We Support the Organisation</h2>

            <p>
                The MIS Unit provides a range of IT services aimed
                at ensuring that staff have access to reliable
                technology, systems and technical assistance.

                Our services support the effective use of
                information technology in everyday organisational
                activities.
            </p>

        </section>


        <!-- SERVICES COUNT -->
        <div class="service-summary">

            <div>
                <i class="fas fa-list-check"></i>

                <div>
                    <h3><?= count($services) ?></h3>
                    <p>IT Service Areas</p>
                </div>
            </div>

            <div>
                <i class="fas fa-laptop"></i>

                <div>
                    <h3>IT</h3>
                    <p>Technical Assistance</p>
                </div>
            </div>

            <div>
                <i class="fas fa-users"></i>

                <div>
                    <h3>Staff</h3>
                    <p>Service Users</p>
                </div>
            </div>

        </div>


        <!-- SERVICES GRID -->
        <section class="info-section">

            <div class="section-heading">

                <h2>Our IT Services</h2>

                <span></span>

            </div>


            <div class="services-grid">

                <?php foreach ($services as $service): ?>

                    <div class="service-card">

                        <div class="service-icon">

                            <i class="fas <?= htmlspecialchars($service['icon']) ?>"></i>

                        </div>

                        <span class="service-category">
                            <?= htmlspecialchars($service['category']) ?>
                        </span>

                        <h3>
                            <?= htmlspecialchars($service['title']) ?>
                        </h3>

                        <p>
                            <?= htmlspecialchars($service['description']) ?>
                        </p>

                        <div class="service-footer">
                            <i class="fas fa-check-circle"></i>
                            MIS Unit Service
                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </section>


        <!-- SUPPORT INFORMATION -->
        <section class="support-banner">

            <div class="support-icon">
                <i class="fas fa-circle-question"></i>
            </div>

            <div>

                <h2>Need Technical Assistance?</h2>

                <p>
                    For IT-related assistance, please contact
                    the MIS Unit through the official support
                    channels provided by your organisation.
                </p>

            </div>

        </section>


        <!-- FOOTER -->
        <footer>

            &copy; <?= date('Y') ?>
            Management Information Systems Unit.
            All Rights Reserved.

        </footer>

    </main>

</div>

</body>
</html>
