
<?php
$activePage = $activePage ?? '';
?>

<aside class="sidebar">

    <div class="logo">
        <img src="../images/logo.webp" alt="MIS Logo">
        <h3>MIS Unit</h3>
        <p>Information Portal</p>
    </div>

    <ul class="menu">

        <li>
            <a href="../index.php">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
        </li>

        <li class="<?= $activePage == 'about' ? 'active' : '' ?>">
            <a href="about.php">
                <i class="fas fa-circle-info"></i>
                About MIS
            </a>
        </li>

        <li class="<?= $activePage == 'services' ? 'active' : '' ?>">
            <a href="services.php">
                <i class="fas fa-headset"></i>
                IT Services
            </a>
        </li>

        <li>
            <a href="inventory.php">
                <i class="fas fa-computer"></i>
                IT Inventory
            </a>
        </li>

        <li>
            <a href="projects.php">
                <i class="fas fa-folder-open"></i>
                Projects
            </a>
        </li>

        <li>
            <a href="reports.php">
                <i class="fas fa-file-alt"></i>
                Reports
            </a>
        </li>

        <li>
            <a href="announcements.php">
                <i class="fas fa-bullhorn"></i>
                Announcements
            </a>
        </li>

        <li>
            <a href="contacts.php">
                <i class="fas fa-address-book"></i>
                Contacts
            </a>
        </li>

    </ul>

    <div class="sidebar-bottom">
        <a href="../logout.php">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>
    </div>

</aside>
