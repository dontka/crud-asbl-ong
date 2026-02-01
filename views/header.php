<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' . APP_NAME : APP_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <script src="<?php echo BASE_URL; ?>/assets/js/main.js" defer></script>
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <div class="navbar-brand">
                <a href="<?php echo BASE_URL; ?>/dashboard.php"><?php echo APP_NAME; ?></a>
            </div>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/dashboard.php" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/members.php" class="nav-link">Membres</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/projects.php" class="nav-link">Projets</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/events.php" class="nav-link">Événements</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/donations.php" class="nav-link">Dons</a>
                    </li>
                    <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['role'], ['admin', 'moderator'])): ?>
                        <li class="nav-item">
                            <a href="<?php echo BASE_URL; ?>/users.php" class="nav-link">Utilisateurs</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle"><?php echo htmlspecialchars($_SESSION['user']['username']); ?></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo BASE_URL; ?>/profile.php">Profil</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/logout.php">Déconnexion</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/login.php" class="nav-link">Connexion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="main-content">
        <div class="container">
            <?php if (isset($flash) && $flash): ?>
                <div class="alert alert-<?php echo $flash['type']; ?>" role="alert">
                    <?php echo htmlspecialchars($flash['message']); ?>
                </div>
            <?php endif; ?>