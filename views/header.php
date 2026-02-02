<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' . APP_NAME : APP_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/main.js" defer></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/dashboard.js" defer></script>
</head>

<body>
    <!-- Loading indicator -->
    <div id="loading-indicator" class="loading-indicator" style="display: none;">
        <div class="spinner"></div>
    </div>

    <!-- Floating Sidebar -->
    <?php include 'sidebar.php'; ?>

    <header class="header">
        <nav class="navbar">
            <div class="navbar-brand">
                <a href="<?php echo BASE_URL; ?>/dashboard">
                    ASBL-ONG
                </a>
            </div>

            <!-- Search Bar -->
            <div class="navbar-search">
                <form action="<?php echo BASE_URL; ?>/search" method="GET" class="search-form">
                    <div class="search-input-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="q" class="search-input" placeholder="Rechercher des membres, projets, événements..." autocomplete="off">
                    </div>
                </form>
            </div>
            <!--   -->
            <div class="nav-actions">
                <button class="nav-btn theme-toggle" onclick="toggleTheme()" title="Basculer le thème">
                    <i class="fas fa-moon"></i>
                </button>
                <button class="nav-btn refresh-btn" onclick="refreshDashboard()">
                    <i class="fas fa-sync-alt"></i> Actualiser
                </button>
                <div class=" time-range-selector" style=" ">

                    <select id="timeRange" class="" onchange="changeTimeRange(this.value)">

                        <option value="7d">7 jours</option>
                        <option value="30d" selected>30 jours</option>
                        <option value="90d">90 jours</option>
                        <option value="1y">1 an</option>

                    </select>

                </div>
            </div>
            <!--   -->
            <!-- Mobile menu toggle -->
            <button class="navbar-toggler" type="button" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/dashboard" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/members" class="nav-link">
                            <i class="fas fa-users"></i>
                            Membres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/projects" class="nav-link">
                            <i class="fas fa-project-diagram"></i>
                            Projets
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/events" class="nav-link">
                            <i class="fas fa-calendar-alt"></i>
                            Événements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/donations" class="nav-link">
                            <i class="fas fa-hand-holding-heart"></i>
                            Dons
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/documentation" class="nav-link">
                            <i class="fas fa-book"></i>
                            Documentation
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['role'], ['admin', 'moderator'])): ?>
                        <li class="nav-item">
                            <a href="<?php echo BASE_URL; ?>/users" class="nav-link">
                                <i class="fas fa-user-shield"></i>
                                Utilisateurs
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle">
                            <i class="fas fa-user-circle"></i>
                            <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
                            <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo BASE_URL; ?>/profile.php">
                                    <i class="fas fa-user-edit"></i>
                                    Mon Profil
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>/logout" class="text-danger">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Déconnexion
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/login" class="nav-link">
                            <i class="fas fa-sign-in-alt"></i>
                            Connexion
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- Breadcrumbs -->
        <?php if (isset($breadcrumbs) && !empty($breadcrumbs)): ?>
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo BASE_URL; ?>/dashboard.php">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <?php foreach ($breadcrumbs as $breadcrumb): ?>
                        <?php if (isset($breadcrumb['url'])): ?>
                            <li class="breadcrumb-item">
                                <a href="<?php echo $breadcrumb['url']; ?>"><?php echo htmlspecialchars($breadcrumb['label']); ?></a>
                            </li>
                        <?php else: ?>
                            <li class="breadcrumb-item active"><?php echo htmlspecialchars($breadcrumb['label']); ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </nav>
        <?php endif; ?>
    </header>

    <?php if (isset($flash) && $flash): ?>
        <div class="alert alert-<?php echo $flash['type']; ?>" role="alert">
            <?php echo htmlspecialchars($flash['message']); ?>
        </div>
    <?php endif; ?>