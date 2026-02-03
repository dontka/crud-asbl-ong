<?php
// install.php - Assistant d'installation web CRUD ASBL-ONG

session_start();

// Vérifie si le site est déjà installé
$lockFile = __DIR__ . '/installed.lock';
if (file_exists($lockFile)) {
    echo '<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><title>Déjà installé</title></head><body>';
    echo '<h2>Le site est déjà installé.</h2><p>Pour accéder au site, <a href="index.php">cliquez ici</a>.</p>';
    echo '</body></html>';
    exit;
}

// step: 1 = form, 2 = check/connect, 3 = confirm action when DB exists
$step = isset($_POST['step']) ? intval($_POST['step']) : 1;
$error = '';
$success = false;

// Restore inputs from session if present
if (isset($_SESSION['install_input']) && !empty($_SESSION['install_input'])) {
    $saved = $_SESSION['install_input'];
} else {
    $saved = [];
}

function render_form($step, $error = '')
{
    // Step 1: connection form
    if ($step === 1) {
        if ($error) {
            echo '<div class="alert alert-error">' . htmlspecialchars($error) . '</div>';
        }
        echo '<div class="step-indicator">Étape 1 — Informations de connexion à la base</div>';
        echo '<form method="post" data-validate class="needs-validation">
            <input type="hidden" name="step" value="2">
            <div class="form-group">
                <label class="form-label">Hôte MySQL</label>
                <input class="form-control" name="db_host" value="' . htmlspecialchars($saved['db_host'] ?? 'localhost') . '" required>
            </div>
            <div class="form-group">
                <label class="form-label">Utilisateur MySQL</label>
                <input class="form-control" name="db_user" value="' . htmlspecialchars($saved['db_user'] ?? 'root') . '" required>
            </div>
            <div class="form-group">
                <label class="form-label">Mot de passe MySQL</label>
                <input class="form-control" name="db_pass" type="password">
            </div>
            <div class="form-group">
                <label class="form-label">Nom de la base</label>
                <input class="form-control" name="db_name" value="' . htmlspecialchars($saved['db_name'] ?? 'crud_asbl_ong') . '" required>
            </div>
            <hr>
            <div class="form-group">
                <label class="form-label">Email administrateur</label>
                <input class="form-control" name="admin_email" type="email" value="' . htmlspecialchars($saved['admin_email'] ?? '') . '" required>
            </div>
            <div class="form-group">
                <label class="form-label">Mot de passe administrateur</label>
                <input class="form-control" name="admin_password" type="password" required>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Suivant</button>
            </div>
        </form>';
    }

    // Step 3: confirmation when DB exists with tables
    if ($step === 3) {
        echo '<div class="alert alert-warning"><strong>Attention :</strong> La base de données existe déjà et contient des tables. Vous pouvez annuler l\'installation ou réinitialiser la base (toutes les données seront perdues).</div>';
        echo '<form method="post" class="mt-3">';
        echo '<input type="hidden" name="step" value="3">';
        echo '<div class="form-group"><label class="form-label">Confirmez le mot de passe administrateur pour réinitialiser la base</label><input class="form-control" name="admin_password" type="password" required></div>';
        echo '<div class="d-flex" style="gap:1rem">';
        echo '<button class="btn btn-danger" name="confirm_action" value="reset" type="submit">Réinitialiser la base (DROP)</button>';
        echo '<button class="btn btn-outline-secondary" name="confirm_action" value="abort" type="submit">Annuler</button>';
        echo '</div>';
        echo '</form>';
    }
}

function import_sql($pdo, $file, $admin_email, $admin_password)
{
    $sql = file_get_contents($file);

    // Split SQL into statements and execute one by one to avoid multi-statement syntax issues
    $statements = array_filter(array_map('trim', explode(";", $sql)));

    // Defer index/constraint statements until tables are created
    $deferred = [];
    foreach ($statements as $stmt) {
        if ($stmt === '') continue;

        // Remove leading block comments (/* ... */) and leading -- comments
        $clean = preg_replace('!^(/\*.*?\*/\s*)+!s', '', $stmt);
        // Remove any leading lines that are only -- comments
        $clean = preg_replace('/^(\s*--.*\r?\n)+/m', '', $clean);

        $clean = trim($clean);
        if ($clean === '') continue;

        $lower = strtolower(ltrim($clean));
        if (strpos($lower, 'create index') === 0 || strpos($lower, 'create unique index') === 0 || (strpos($lower, 'alter table') !== false && (strpos($lower, 'add index') !== false || strpos($lower, 'add constraint') !== false))) {
            $deferred[] = $clean;
            continue;
        }

        try {
            $pdo->exec($clean);
        } catch (Exception $e) {
            throw new Exception("SQL error executing statement: " . substr($clean, 0, 200) . "... — " . $e->getMessage());
        }
    }

    // Execute deferred statements (indexes/constraints) after tables are created
    foreach ($deferred as $stmt) {
        $stmt = trim($stmt);
        if ($stmt === '') continue;
        try {
            $pdo->exec($stmt);
        } catch (Exception $e) {
            throw new Exception("SQL error executing deferred statement: " . substr($stmt, 0, 200) . "... — " . $e->getMessage());
        }
    }

    // If we imported test data, update admin credentials safely
    if (strpos(basename($file), 'test_data.sql') !== false) {
        try {
            $hash = password_hash($admin_password, PASSWORD_BCRYPT);
            $update = $pdo->prepare("UPDATE users SET password = :pwd, email = :email WHERE username = 'admin'");
            $update->execute([':pwd' => $hash, ':email' => $admin_email]);
        } catch (Exception $e) {
            throw new Exception('Failed to update admin credentials: ' . $e->getMessage());
        }
    }
}

if ($step === 2) {
    $db_host = $_POST['db_host'];
    $db_user = $_POST['db_user'];
    $db_pass = $_POST['db_pass'];
    $db_name = $_POST['db_name'];
    $admin_email = $_POST['admin_email'];
    $admin_password = $_POST['admin_password'];

    // Save inputs to session to reuse if confirmation is needed
    $_SESSION['install_input'] = [
        'db_host' => $db_host,
        'db_user' => $db_user,
        'db_pass' => $db_pass,
        'db_name' => $db_name,
        'admin_email' => $admin_email,
        // Do NOT save admin password in session in plain text in real apps
    ];

    try {
        $pdo = new PDO("mysql:host=$db_host", $db_user, $db_pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        // Check if database already exists
        $stmt = $pdo->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :db");
        $stmt->execute([':db' => $db_name]);
        $dbExists = (bool)$stmt->fetchColumn();

        if ($dbExists) {
            // Check if DB contains any tables
            $stmt2 = $pdo->prepare("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = :db LIMIT 1");
            $stmt2->execute([':db' => $db_name]);
            $hasTables = (bool)$stmt2->fetchColumn();

            if ($hasTables) {
                // Ask user to confirm action (abort or reset)
                $step = 3;
            } else {
                // DB exists but empty - import
                $pdo->exec("USE `$db_name`;");
                import_sql($pdo, __DIR__ . '/database/schema.sql', $admin_email, $admin_password);
                import_sql($pdo, __DIR__ . '/database/test_data.sql', $admin_email, $admin_password);
                file_put_contents($lockFile, 'INSTALLED: ' . date('c'));
                $success = true;
            }
        } else {
            // Create DB and import
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            $pdo->exec("USE `$db_name`;");
            import_sql($pdo, __DIR__ . '/database/schema.sql', $admin_email, $admin_password);
            import_sql($pdo, __DIR__ . '/database/test_data.sql', $admin_email, $admin_password);
            file_put_contents($lockFile, 'INSTALLED: ' . date('c'));
            $success = true;
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
        $step = 1;
    }
}

// Handle confirmation step: user chose to reset or abort
if ($step === 3 && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_action'])) {
    $action = $_POST['confirm_action'];
    $input = $_SESSION['install_input'] ?? [];
    $db_host = $input['db_host'] ?? '';
    $db_user = $input['db_user'] ?? '';
    $db_pass = $input['db_pass'] ?? '';
    $db_name = $input['db_name'] ?? '';
    $admin_email = $input['admin_email'] ?? '';
    $admin_password = $_POST['admin_password'] ?? '';

    if ($action === 'abort') {
        $error = 'Installation annulée : la base existe déjà.';
        $step = 1;
    } elseif ($action === 'reset') {
        try {
            $pdo = new PDO("mysql:host=$db_host", $db_user, $db_pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            // Drop and recreate database
            $pdo->exec("DROP DATABASE IF EXISTS `$db_name`;");
            $pdo->exec("CREATE DATABASE `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            $pdo->exec("USE `$db_name`;");
            import_sql($pdo, __DIR__ . '/database/schema.sql', $admin_email, $admin_password);
            import_sql($pdo, __DIR__ . '/database/test_data.sql', $admin_email, $admin_password);
            file_put_contents($lockFile, 'INSTALLED: ' . date('c'));
            $success = true;
        } catch (Exception $e) {
            $error = 'Échec lors de la réinitialisation : ' . $e->getMessage();
            $step = 1;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Installation CRUD ASBL-ONG</title>
    <link rel="stylesheet" href="assets/css/style.min.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        .install-wrap {
            max-width: 820px;
            margin: 2rem auto;
            padding: 1rem;
        }

        .step-indicator {
            margin-bottom: 1rem;
            font-weight: 700;
            color: var(--gray-600)
        }

        .small-muted {
            font-size: 0.9rem;
            color: var(--gray-500)
        }
    </style>
</head>

<body>
    <div class="container install-wrap">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Assistant d'installation</h3>
            </div>
            <div class="card-body">
                <?php
                if ($success) {
                    echo '<div class="alert alert-success"><strong>Installation terminée !</strong> La base de données et le compte administrateur ont été créés. <a href="index.php">Accéder au site</a></div>';
                } else {
                    render_form($step, $error);
                }
                ?>
            </div>
            <div class="card-footer text-center small-muted">Besoin d'aide ? Consultez la documentation ou contactez l'administrateur système.</div>
        </div>
    </div>

    <script src="assets/js/main.min.js"></script>
</body>

</html>