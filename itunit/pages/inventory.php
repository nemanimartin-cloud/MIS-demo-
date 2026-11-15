
<?php
session_start();

require_once "../config/database.php";

$activePage = "inventory";
$username = $_SESSION['username'] ?? 'User';
$role = $_SESSION['role'] ?? 'Staff';

// Security token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_token'];

$message = "";
$error = "";

// Escape output
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

// Equipment types
$equipmentTypes = [
    "Desktop",
    "Laptop",
    "Printer",
    "Scanner",
    "Server",
    "Network Equipment",
    "Other"
];

// Get existing record for editing
$editRecord = null;

if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM inventory WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $editRecord = $stmt->fetch();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Verify CSRF token
    if (
        !isset($_POST['csrf_token']) ||
        !hash_equals($csrfToken, $_POST['csrf_token'])
    ) {
        $error = "Invalid request. Please refresh the page and try again.";
    } else {

        $action = $_POST['action'] ?? '';

        // DELETE RECORD
        if ($action === "delete") {

            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            if ($id) {
                $stmt = $pdo->prepare("DELETE FROM inventory WHERE id = ?");
                $stmt->execute([$id]);

                $_SESSION['inventory_message'] = "Equipment record deleted successfully.";
                header("Location: inventory.php");
                exit;
            } else {
                $error = "Invalid equipment record.";
            }
        }

        // ADD OR UPDATE RECORD
        elseif ($action === "save") {

            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

            $equipmentType = trim($_POST['equipment_type'] ?? '');
            $user = trim($_POST['user'] ?? '');
            $division = trim($_POST['division'] ?? '');
            $machineName = trim($_POST['machine_name'] ?? '');
            $brand = trim($_POST['brand'] ?? '');
            $model = trim($_POST['model'] ?? '');
            $serialNo = trim($_POST['serial_no'] ?? '');
            $exp = trim($_POST['exp'] ?? '');
            $portNo = trim($_POST['port_no'] ?? '');
            $mouseBrand = trim($_POST['mouse_brand'] ?? '');
            $keyboardBrand = trim($_POST['keyboard_brand'] ?? '');
            $version = trim($_POST['version'] ?? '');

            // Basic validation
            if ($equipmentType === '' || $machineName === '') {
                $error = "Equipment Type and Machine Name are required.";
            } elseif (!in_array($equipmentType, $equipmentTypes, true)) {
                $error = "Please select a valid equipment type.";
            } elseif ($exp !== '' &&
                !preg_match('/^\d{4}-\d{2}-\d{2}$/', $exp)) {
                $error = "Please enter a valid expiry date.";
            } else {

                $expValue = $exp !== '' ? $exp : null;

                try {

                    if ($id > 0) {

                        // UPDATE
                        $sql = "UPDATE inventory SET
                            equipment_type = ?,
                            `user` = ?,
                            division = ?,
                            machine_name = ?,
                            brand = ?,
                            model = ?,
                            serial_no = ?,
                            exp = ?,
                            port_no = ?,
                            mouse_brand = ?,
                            keyboard_brand = ?,
                            version = ?
                            WHERE id = ?";

                        $stmt = $pdo->prepare($sql);

                        $stmt->execute([
                            $equipmentType,
                            $user,
                            $division,
                            $machineName,
                            $brand,
                            $model,
                            $serialNo,
                            $expValue,
                            $portNo,
                            $mouseBrand,
                            $keyboardBrand,
                            $version,
                            $id
                        ]);

                        $_SESSION['inventory_message'] = "Equipment record updated successfully.";

                    } else {

                        // INSERT
                        $sql = "INSERT INTO inventory (
                            equipment_type,
                            `user`,
                            division,
                            machine_name,
                            brand,
                            model,
                            serial_no,
                            exp,
                            port_no,
                            mouse_brand,
                            keyboard_brand,
                            version
                        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                        $stmt = $pdo->prepare($sql);

                        $stmt->execute([
                            $equipmentType,
                            $user,
                            $division,
                            $machineName,
                            $brand,
                            $model,
                            $serialNo,
                            $expValue,
                            $portNo,
                            $mouseBrand,
                            $keyboardBrand,
                            $version
                        ]);

                        $_SESSION['inventory_message'] = "New equipment registered successfully.";
                    }

                    header("Location: inventory.php");
                    exit;

                } catch (PDOException $e) {
                    $error = "Unable to save the equipment record. Please check the database fields.";
                }
            }
        }
    }
}

// Display success message
if (isset($_SESSION['inventory_message'])) {
    $message = $_SESSION['inventory_message'];
    unset($_SESSION['inventory_message']);
}

// SEARCH AND FILTER
$search = trim($_GET['search'] ?? '');
$typeFilter = trim($_GET['type'] ?? '');
$divisionFilter = trim($_GET['division'] ?? '');

$sql = "SELECT * FROM inventory WHERE 1=1";
$params = [];

if ($search !== '') {
    $sql .= " AND (
        `user` LIKE ?
        OR machine_name LIKE ?
        OR brand LIKE ?
        OR model LIKE ?
        OR serial_no LIKE ?
        OR division LIKE ?
    )";

    $searchValue = "%$search%";

    array_push(
        $params,
        $searchValue,
        $searchValue,
        $searchValue,
        $searchValue,
        $searchValue,
        $searchValue
    );
}

if ($typeFilter !== '') {
    $sql .= " AND equipment_type = ?";
    $params[] = $typeFilter;
}

if ($divisionFilter !== '') {
    $sql .= " AND division = ?";
    $params[] = $divisionFilter;
}

$sql .= " ORDER BY id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$records = $stmt->fetchAll();

// Dashboard statistics
$totalRecords = (int)$pdo->query(
    "SELECT COUNT(*) FROM inventory"
)->fetchColumn();

$totalTypes = (int)$pdo->query(
    "SELECT COUNT(DISTINCT equipment_type) FROM inventory"
)->fetchColumn();

$totalDivisions = (int)$pdo->query(
    "SELECT COUNT(DISTINCT division)
     FROM inventory
     WHERE division IS NOT NULL AND division != ''"
)->fetchColumn();

// Division filter options
$divisionList = $pdo->query(
    "SELECT DISTINCT division
     FROM inventory
     WHERE division IS NOT NULL AND division != ''
     ORDER BY division ASC"
)->fetchAll(PDO::FETCH_COLUMN);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>IT Inventory Management | MIS Unit</title>

    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/pages.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .inventory-content {
            padding: 25px;
        }

        .inventory-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }

        .inventory-heading h2 {
            margin: 0;
            color: #14532d;
        }

        .inventory-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 18px;
            margin-bottom: 25px;
        }

        .inventory-stat {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            border-left: 5px solid #008000;
        }

        .inventory-stat h3 {
            margin: 0 0 8px;
            font-size: 14px;
            color: #666;
        }

        .inventory-stat strong {
            font-size: 27px;
            color: #14532d;
        }

        .inventory-card {
            background: #fff;
            padding: 22px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            margin-bottom: 25px;
        }

        .inventory-card h3 {
            margin-top: 0;
            color: #14532d;
        }

        .inventory-form-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .inventory-form-grid label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #333;
        }

        .inventory-form-grid input,
        .inventory-form-grid select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .inventory-form-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .inventory-btn {
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
        }

        .inventory-btn-primary {
            background: #008000;
            color: white;
        }

        .inventory-btn-secondary {
            background: #64748b;
            color: white;
        }

        .inventory-btn-edit {
            background: #2563eb;
            color: white;
        }

        .inventory-btn-delete {
            background: #dc2626;
            color: white;
        }

        .inventory-alert {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 18px;
        }

        .inventory-success {
            background: #dcfce7;
            color: #166534;
        }

        .inventory-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .inventory-filters {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .inventory-filters input,
        .inventory-filters select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .inventory-table-wrapper {
            overflow-x: auto;
        }

        .inventory-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1500px;
        }

        .inventory-table th {
            background: #14532d;
            color: white;
            padding: 12px 10px;
            text-align: left;
            white-space: nowrap;
        }

        .inventory-table td {
            padding: 11px 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }

        .inventory-table tr:hover {
            background: #f0fdf4;
        }

        .inventory-actions {
            display: flex;
            gap: 6px;
        }

        .inventory-actions form {
            margin: 0;
        }

        .inventory-empty {
            text-align: center;
            padding: 30px;
            color: #777;
        }

        @media(max-width: 900px) {
            .inventory-form-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media(max-width: 600px) {
            .inventory-content {
                padding: 12px;
            }

            .inventory-form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<?php include "../includes/inner_sidebar.php"; ?>

<div class="main-content">
    <div class="inventory-content">

        <div class="inventory-heading">
            <div>
                <h2><i class="fas fa-computer"></i> IT Inventory Management</h2>
                <p>Management Information Systems Unit</p>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="inventory-alert inventory-success">
                <i class="fas fa-check-circle"></i>
                <?= e($message) ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="inventory-alert inventory-error">
                <i class="fas fa-exclamation-circle"></i>
                <?= e($error) ?>
            </div>
        <?php endif; ?>

        <!-- STATISTICS -->
        <div class="inventory-stats">

            <div class="inventory-stat">
                <h3>Total Equipment Records</h3>
                <strong><?= $totalRecords ?></strong>
            </div>

            <div class="inventory-stat">
                <h3>Equipment Types</h3>
                <strong><?= $totalTypes ?></strong>
            </div>

            <div class="inventory-stat">
                <h3>Divisions</h3>
                <strong><?= $totalDivisions ?></strong>
            </div>

        </div>

        <!-- ADD / EDIT FORM -->
        <!--
        <div class="inventory-card">

            <h3>
                <i class="fas fa-<?= $editRecord ? 'pen-to-square' : 'plus-circle' ?>"></i>
                <?= $editRecord ? 'Update Equipment Details' : 'Register New Equipment' ?>
            </h3>

            <form method="POST" action="inventory.php">

                <input type="hidden" name="csrf_token"
                       value="<?= e($csrfToken) ?>">

                <input type="hidden" name="action" value="save">

                <input type="hidden" name="id"
                       value="<?= e($editRecord['id'] ?? '') ?>">

                <div class="inventory-form-grid">

                    <div>
                        <label>Equipment Type *</label>
                        <select name="equipment_type" required>
                            <option value="">Select Equipment Type</option>

                            <?php foreach ($equipmentTypes as $type): ?>
                                <option value="<?= e($type) ?>"
                                    <?= (($editRecord['equipment_type'] ?? '') === $type) ? 'selected' : '' ?>>
                                    <?= e($type) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label>User</label>
                        <input type="text" name="user"
                               value="<?= e($editRecord['user'] ?? '') ?>"
                               placeholder="Enter user name">
                    </div>

                    <div>
                        <label>Division</label>
                        <input type="text" name="division"
                               value="<?= e($editRecord['division'] ?? '') ?>"
                               placeholder="Enter division">
                    </div>

                    <div>
                        <label>Machine Name *</label>
                        <input type="text" name="machine_name" required
                               value="<?= e($editRecord['machine_name'] ?? '') ?>"
                               placeholder="Enter machine name">
                    </div>

                    <div>
                        <label>Brand</label>
                        <input type="text" name="brand"
                               value="<?= e($editRecord['brand'] ?? '') ?>"
                               placeholder="e.g. HP, Dell, Lenovo">
                    </div>

                    <div>
                        <label>Model</label>
                        <input type="text" name="model"
                               value="<?= e($editRecord['model'] ?? '') ?>"
                               placeholder="Enter model">
                    </div>

                    <div>
                        <label>Serial No.</label>
                        <input type="text" name="serial_no"
                               value="<?= e($editRecord['serial_no'] ?? '') ?>"
                               placeholder="Enter serial number">
                    </div>

                    <div>
                        <label>EXP (Expiry Date)</label>
                        <input type="date" name="exp"
                               value="<?= e($editRecord['exp'] ?? '') ?>">
                    </div>

                    <div>
                        <label>Port No.</label>
                        <input type="text" name="port_no"
                               value="<?= e($editRecord['port_no'] ?? '') ?>"
                               placeholder="Enter port number">
                    </div>

                    <div>
                        <label>Mouse (Brand)</label>
                        <input type="text" name="mouse_brand"
                               value="<?= e($editRecord['mouse_brand'] ?? '') ?>"
                               placeholder="Enter mouse brand">
                    </div>

                    <div>
                        <label>Keyboard (Brand)</label>
                        <input type="text" name="keyboard_brand"
                               value="<?= e($editRecord['keyboard_brand'] ?? '') ?>"
                               placeholder="Enter keyboard brand">
                    </div>

                    <div>
                        <label>Version</label>
                        <input type="text" name="version"
                               value="<?= e($editRecord['version'] ?? '') ?>"
                               placeholder="e.g. Windows 11">
                    </div>

                </div>

                <div class="inventory-form-actions">

                    <button type="submit"
                            class="inventory-btn inventory-btn-primary">
                        <i class="fas fa-save"></i>
                        <?= $editRecord ? 'Update Record' : 'Save Equipment' ?>
                    </button>

                    <?php if ($editRecord): ?>
                        <a href="inventory.php"
                           class="inventory-btn inventory-btn-secondary">
                            Cancel
                        </a>
                    <?php endif; ?>

                </div>

            </form>
        </div>
                    -->

                    
        <!-- INVENTORY REGISTER -->
         
        <div class="inventory-card">

            <h3><i class="fas fa-list"></i> Equipment Register</h3>

            <!-- SEARCH AND FILTER -->
            <form method="GET" class="inventory-filters">

                <input type="text" name="search"
                       placeholder="Search user, machine, brand, serial..."
                       value="<?= e($search) ?>">

                <select name="type">
                    <option value="">All Equipment Types</option>

                    <?php foreach ($equipmentTypes as $type): ?>
                        <option value="<?= e($type) ?>"
                            <?= $typeFilter === $type ? 'selected' : '' ?>>
                            <?= e($type) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="division">
                    <option value="">All Divisions</option>

                    <?php foreach ($divisionList as $division): ?>
                        <option value="<?= e($division) ?>"
                            <?= $divisionFilter === $division ? 'selected' : '' ?>>
                            <?= e($division) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit"
                        class="inventory-btn inventory-btn-primary">
                    <i class="fas fa-search"></i> Search
                </button>

                <a href="inventory.php"
                   class="inventory-btn inventory-btn-secondary">
                    Reset
                </a>

            </form>

            <div class="inventory-table-wrapper">

                <table class="inventory-table">

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Equipment Type</th>
                            <th>User</th>
                            <th>Division</th>
                            <th>Machine Name</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Serial No.</th>
                            <th>EXP</th>
                            <th>Port No.</th>
                            <th>Mouse (Brand)</th>
                            <th>Keyboard (Brand)</th>
                            <th>Version</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if (count($records) > 0): ?>

                        <?php foreach ($records as $record): ?>

                            <tr>
                                <td><?= e($record['id']) ?></td>
                                <td><?= e($record['equipment_type']) ?></td>
                                <td><?= e($record['user']) ?></td>
                                <td><?= e($record['division']) ?></td>
                                <td><?= e($record['machine_name']) ?></td>
                                <td><?= e($record['brand']) ?></td>
                                <td><?= e($record['model']) ?></td>
                                <td><?= e($record['serial_no']) ?></td>
                                <td>
                                    <?= $record['exp'] ? e($record['exp']) : '-' ?>
                                </td>
                                <td><?= e($record['port_no']) ?></td>
                                <td><?= e($record['mouse_brand']) ?></td>
                                <td><?= e($record['keyboard_brand']) ?></td>
                                <td><?= e($record['version']) ?></td>

                                <td>
                                    <div class="inventory-actions">

                                        <a href="inventory.php?edit=<?= (int)$record['id'] ?>"
                                           class="inventory-btn inventory-btn-edit"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form method="POST"
                                              action="inventory.php"
                                              onsubmit="return confirm('Are you sure you want to delete this equipment record?');">

                                            <input type="hidden" name="csrf_token"
                                                   value="<?= e($csrfToken) ?>">

                                            <input type="hidden" name="action"
                                                   value="delete">

                                            <input type="hidden" name="id"
                                                   value="<?= (int)$record['id'] ?>">

                                            <button type="submit"
                                                    class="inventory-btn inventory-btn-delete"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                        </form>

                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="14" class="inventory-empty">
                                <i class="fas fa-box-open"></i>
                                <p>No equipment records found.</p>
                            </td>
                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

            <p style="margin-top:15px;color:#666;">
                Showing <?= count($records) ?> equipment record(s).
            </p>

        </div>

    </div>
</div>

</body>
</html>
