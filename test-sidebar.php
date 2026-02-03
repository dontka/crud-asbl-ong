<?php
// Test file to check sidebar display
define('BASE_URL', '');
define('APP_NAME', 'ASBL-ONG');
define('APP_VERSION', '1.0');

// Simulate session
$_SESSION['user_id'] = 1;
$_SESSION['user'] = [
    'username' => 'Test User',
    'role' => 'admin'
];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Sidebar - ASBL-ONG</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="assets/js/main.js" defer></script>
</head>

<body>
    <!-- Floating Sidebar -->
    <?php include 'views/sidebar.php'; ?>

    <header class="header" style="background: #f8f9fa; padding: 20px; border-bottom: 1px solid #ddd;">
        <h1>Test Header</h1>
    </header>

    <main style="padding: 20px;">
        <h2>Main Content</h2>
        <p>If the sidebar appears correctly on the left side with proper styling, the fix worked!</p>
    </main>
</body>

</html>