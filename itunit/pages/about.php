
<?php
session_start();

$activePage = 'about';

$username = $_SESSION['username'] ?? 'MIS Administrator';
$role = $_SESSION['role'] ?? 'Administrator';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>About MIS Unit</title>

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
                <h2>About MIS Unit</h2>
                <p>Learn more about our unit and responsibilities</p>
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


        <!-- PAGE BANNER -->
        <section class="page-banner about-banner">

            <div>
                <span class="banner-label">
                    ABOUT OUR UNIT
                </span>

                <h1>
                    Management Information Systems
                </h1>

                <p>
                    Supporting organisational efficiency through
                    technology, innovation and information management.
                </p>
            </div>

            <i class="fas fa-building banner-icon"></i>

        </section>


        <!-- INTRODUCTION -->
        <section class="info-section">

            <div class="section-heading">
                <h2>Who We Are</h2>
                <span></span>
            </div>

            <div class="introduction-card">

                <div class="intro-icon">
                    <i class="fas fa-network-wired"></i>
                </div>

                <div>
                    <h3>Introduction to MIS Unit</h3>

                    <p>
                        The Management Information Systems (MIS) Unit
                        plays an important role in supporting the
                        organisation's information technology
                        infrastructure and digital operations.

                        The Unit is responsible for providing
                        technical support, maintaining IT systems,
                        managing information resources, supporting
                        network operations and facilitating the
                        development of digital solutions.

                        Through effective use of technology, the
                        MIS Unit aims to improve productivity,
                        information accessibility and service delivery.
                    </p>
                </div>

            </div>

        </section>


        <!-- VISION AND MISSION -->
        <section class="vision-mission">

            <div class="info-card vision-card">

                <div class="card-icon">
                    <i class="fas fa-eye"></i>
                </div>

                <h3>Our Vision</h3>

                <p>
                    To promote an efficient, reliable and innovative
                    information technology environment that supports
                    organisational goals and effective service delivery.
                </p>

            </div>


            <div class="info-card mission-card">

                <div class="card-icon">
                    <i class="fas fa-bullseye"></i>
                </div>

                <h3>Our Mission</h3>

                <p>
                    To provide quality IT support, maintain reliable
                    information systems, manage technology resources
                    and deliver effective digital solutions to support
                    the organisation and its staff.
                </p>

            </div>

        </section>


        <!-- OBJECTIVES -->
        <section class="info-section">

            <div class="section-heading">
                <h2>Our Objectives</h2>
                <span></span>
            </div>

            <div class="objectives-grid">

                <div class="objective-card">
                    <i class="fas fa-server"></i>
                    <h3>System Reliability</h3>
                    <p>
                        Maintain reliable IT systems and infrastructure
                        to support daily operations.
                    </p>
                </div>

                <div class="objective-card">
                    <i class="fas fa-headset"></i>
                    <h3>Technical Support</h3>
                    <p>
                        Provide timely technical assistance and
                        troubleshooting services to staff.
                    </p>
                </div>

                <div class="objective-card">
                    <i class="fas fa-database"></i>
                    <h3>Information Management</h3>
                    <p>
                        Support effective management, storage
                        and accessibility of organisational data.
                    </p>
                </div>

                <div class="objective-card">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Information Security</h3>
                    <p>
                        Promote secure use of technology,
                        systems and organisational information.
                    </p>
                </div>

                <div class="objective-card">
                    <i class="fas fa-lightbulb"></i>
                    <h3>Digital Innovation</h3>
                    <p>
                        Encourage digital transformation through
                        improved systems and technological solutions.
                    </p>
                </div>

                <div class="objective-card">
                    <i class="fas fa-chart-line"></i>
                    <h3>Service Improvement</h3>
                    <p>
                        Improve efficiency and productivity through
                        effective use of information systems.
                    </p>
                </div>

            </div>

        </section>


        <!-- KEY FUNCTIONS -->
        <section class="info-section">

            <div class="section-heading">
                <h2>Key Functions of the MIS Unit</h2>
                <span></span>
            </div>

            <div class="functions-list">

                <div>
                    <i class="fas fa-check-circle"></i>
                    IT infrastructure and network administration
                </div>

                <div>
                    <i class="fas fa-check-circle"></i>
                    Computer hardware and software maintenance
                </div>

                <div>
                    <i class="fas fa-check-circle"></i>
                    Database and information system management
                </div>

                <div>
                    <i class="fas fa-check-circle"></i>
                    Technical support and troubleshooting
                </div>

                <div>
                    <i class="fas fa-check-circle"></i>
                    IT asset management and monitoring
                </div>

                <div>
                    <i class="fas fa-check-circle"></i>
                    Website and application development
                </div>

                <div>
                    <i class="fas fa-check-circle"></i>
                    User support and technology guidance
                </div>

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
