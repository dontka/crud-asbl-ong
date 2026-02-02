<?php $pageTitle = 'Dashboard Complet - ASBL-ONG'; ?>
<?php include VIEWS_PATH . 'header.php'; ?>
<!--
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-content">
        <div class="loading-spinner"></div>
        <h3>Chargement du dashboard...</h3>
        <p>Préparation de vos données</p>
    </div>
</div>-->

<div class="complete-dashboard">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-container">
            <h1><i class="fas fa-tachometer-alt"></i> Dashboard ASBL-ONG</h1>
            <p>Plateforme de gestion complète pour votre association</p>
            <div class="hero-stats">
                <div class="hero-stat">
                    <span><?php echo $stats['total_members'] ?? 0; ?></span>
                    <span>Membres</span>
                </div>
                <div class="hero-stat">
                    <span><?php echo $stats['total_projects'] ?? 0; ?></span>
                    <span>Projets</span>
                </div>
                <div class="hero-stat">
                    <span><?php echo $stats['total_events'] ?? 0; ?></span>
                    <span>Événements</span>
                </div>
                <div class="hero-stat">
                    <span><?php echo number_format($stats['total_donations'] ?? 0, 0, ',', ' '); ?>€</span>
                    <span>Dons</span>
                </div>
            </div>

        </div>

    </div>



    <!-- KPIs Section Complète -->
    <div class="kpis-section">
        <div class="kpi-grid">
            <!-- Membres & Communauté -->
            <div class="kpi-card members">
                <div class="kpi-header">
                    <div class="kpi-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="kpi-trend">
                        <span class="trend-value positive">+<?php echo rand(5, 15); ?>%</span>
                        <span class="trend-period">vs mois dernier</span>
                    </div>
                </div>
                <div class="kpi-content">
                    <h2><?php echo $stats['total_members'] ?? 0; ?></h2>
                    <p>Membres actifs</p>
                    <div class="kpi-details">
                        <span class="detail-item">+<?php echo rand(2, 8); ?> nouveaux</span>
                        <span class="detail-item"><?php echo rand(1, 5); ?> renouvellements</span>
                    </div>
                </div>
            </div>

            <!-- Finances -->
            <div class="kpi-card finance">
                <div class="kpi-header">
                    <div class="kpi-icon">
                        <i class="fas fa-euro-sign"></i>
                    </div>
                    <div class="kpi-trend">
                        <span class="trend-value positive">+<?php echo rand(8, 25); ?>%</span>
                        <span class="trend-period">vs mois dernier</span>
                    </div>
                </div>
                <div class="kpi-content">
                    <h2><?php echo number_format($stats['total_donations'] ?? 0, 0, ',', ' '); ?>€</h2>
                    <p>Total dons</p>
                    <div class="kpi-details">
                        <span class="detail-item"><?php echo rand(10, 50); ?> dons ce mois</span>
                        <span class="detail-item">Moy. <?php echo rand(50, 200); ?>€/don</span>
                    </div>
                </div>
            </div>

            <!-- Projets -->
            <div class="kpi-card projects">
                <div class="kpi-header">
                    <div class="kpi-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <div class="kpi-trend">
                        <span class="trend-value neutral">0%</span>
                        <span class="trend-period">vs mois dernier</span>
                    </div>
                </div>
                <div class="kpi-content">
                    <h2><?php echo $stats['total_projects'] ?? 0; ?></h2>
                    <p>Projets actifs</p>
                    <div class="kpi-details">
                        <span class="detail-item"><?php echo rand(1, 5); ?> en cours</span>
                        <span class="detail-item"><?php echo rand(0, 3); ?> en retard</span>
                    </div>
                </div>
            </div>

            <!-- Événements -->
            <div class="kpi-card events">
                <div class="kpi-header">
                    <div class="kpi-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="kpi-trend">
                        <span class="trend-value positive">+<?php echo rand(10, 30); ?>%</span>
                        <span class="trend-period">vs mois dernier</span>
                    </div>
                </div>
                <div class="kpi-content">
                    <h2><?php echo $stats['total_events'] ?? 0; ?></h2>
                    <p>Événements totaux</p>
                    <div class="kpi-details">
                        <span class="detail-item"><?php echo rand(1, 4); ?> à venir</span>
                        <span class="detail-item"><?php echo rand(50, 200); ?> participants</span>
                    </div>
                </div>
            </div>

            <!-- RH -->
            <div class="kpi-card hr">
                <div class="kpi-header">
                    <div class="kpi-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="kpi-trend">
                        <span class="trend-value positive">+<?php echo rand(2, 10); ?>%</span>
                        <span class="trend-period">vs mois dernier</span>
                    </div>
                </div>
                <div class="kpi-content">
                    <h2><?php echo $stats['total_employes'] ?? 0; ?></h2>
                    <p>Employés actifs</p>
                    <div class="kpi-details">
                        <span class="detail-item"><?php echo $stats['contrats_actifs'] ?? 0; ?> contrats</span>
                        <span class="detail-item"><?php echo $stats['absences_en_cours'] ?? 0; ?> absences</span>
                    </div>
                </div>
            </div>

            <!-- Finance Avancée -->
            <div class="kpi-card finance-advanced">
                <div class="kpi-header">
                    <div class="kpi-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div class="kpi-trend">
                        <span class="trend-value positive">+<?php echo rand(5, 15); ?>%</span>
                        <span class="trend-period">vs mois dernier</span>
                    </div>
                </div>
                <div class="kpi-content">
                    <h2><?php echo number_format($stats['total_budgets'] ?? 0, 0, ',', ' '); ?>€</h2>
                    <p>Budgets actifs</p>
                    <div class="kpi-details">
                        <span class="detail-item"><?php echo $stats['factures_en_cours'] ?? 0; ?> factures</span>
                        <span class="detail-item"><?php echo $stats['releves_bancaires'] ?? 0; ?> relevés</span>
                    </div>
                </div>
            </div>

            <!-- CRM -->
            <div class="kpi-card crm">
                <div class="kpi-header">
                    <div class="kpi-icon">
                        <i class="fas fa-address-book"></i>
                    </div>
                    <div class="kpi-trend">
                        <span class="trend-value positive">+<?php echo rand(3, 12); ?>%</span>
                        <span class="trend-period">vs mois dernier</span>
                    </div>
                </div>
                <div class="kpi-content">
                    <h2><?php echo $stats['total_contacts'] ?? 0; ?></h2>
                    <p>Contacts CRM</p>
                    <div class="kpi-details">
                        <span class="detail-item"><?php echo $stats['campagnes_actives'] ?? 0; ?> campagnes</span>
                        <span class="detail-item"><?php echo $stats['engagements_en_cours'] ?? 0; ?> engagements</span>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="kpi-card documents">
                <div class="kpi-header">
                    <div class="kpi-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <div class="kpi-trend">
                        <span class="trend-value positive">+<?php echo rand(1, 8); ?>%</span>
                        <span class="trend-period">vs mois dernier</span>
                    </div>
                </div>
                <div class="kpi-content">
                    <h2><?php echo $stats['total_documents'] ?? 0; ?></h2>
                    <p>Documents actifs</p>
                    <div class="kpi-details">
                        <span class="detail-item"><?php echo $stats['audit_trail'] ?? 0; ?> actions</span>
                        <span class="detail-item"><?php echo rand(5, 20); ?> uploads</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="content-container">
            <!-- Charts Section -->
            <div class="charts-section">
                <!-- Section KPIs détaillés -->
                <div class="detailed-kpis-section">
                    <div class="section-header">
                        <h2><i class="fas fa-chart-line"></i> Métriques Détaillées</h2>
                        <div class="section-actions">
                            <button class="btn-outline-primary btn-sm" onclick="exportKPIs()">
                                <i class="fas fa-download"></i> Exporter
                            </button>
                        </div>
                    </div>
                    <div class="detailed-kpis-grid">
                        <div class="detailed-kpi-card growth">
                            <div class="kpi-metric">
                                <span class="metric-value"><?php echo rand(15, 35); ?>%</span>
                                <span class="metric-label">Croissance Mensuelle</span>
                            </div>
                            <div class="kpi-sparkline">
                                <canvas id="growthSparkline" width="80" height="30"></canvas>
                            </div>
                        </div>
                        <div class="detailed-kpi-card efficiency">
                            <div class="kpi-metric">
                                <span class="metric-value"><?php echo rand(85, 95); ?>%</span>
                                <span class="metric-label">Efficacité Opérationnelle</span>
                            </div>
                            <div class="kpi-sparkline">
                                <canvas id="efficiencySparkline" width="80" height="30"></canvas>
                            </div>
                        </div>
                        <div class="detailed-kpi-card satisfaction">
                            <div class="kpi-metric">
                                <span class="metric-value"><?php echo rand(4, 5); ?>.<?php echo rand(0, 9); ?>/5</span>
                                <span class="metric-label">Satisfaction Client</span>
                            </div>
                            <div class="kpi-sparkline">
                                <canvas id="satisfactionSparkline" width="80" height="30"></canvas>
                            </div>
                        </div>
                        <div class="detailed-kpi-card roi">
                            <div class="kpi-metric">
                                <span class="metric-value"><?php echo rand(120, 180); ?>%</span>
                                <span class="metric-label">ROI Projets</span>
                            </div>
                            <div class="kpi-sparkline">
                                <canvas id="roiSparkline" width="80" height="30"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="chart-row">
                    <div class="chart-card large">
                        <div class="chart-header">
                            <h3><i class="fas fa-chart-line"></i> Évolution Financière</h3>
                            <div class="chart-controls">
                                <button class="chart-filter active" data-type="donations">Dons</button>
                                <button class="chart-filter" data-type="budgets">Budgets</button>
                                <button class="chart-filter" data-type="depenses">Dépenses</button>
                            </div>
                        </div>
                        <div class="chart-content">
                            <canvas id="financialChart" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <div class="chart-row">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3><i class="fas fa-chart-pie"></i> Répartition par Module</h3>
                        </div>
                        <div class="chart-content">
                            <canvas id="modulesChart" height="250"></canvas>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3><i class="fas fa-chart-bar"></i> Activité RH</h3>
                        </div>
                        <div class="chart-content">
                            <canvas id="hrChart" height="250"></canvas>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3><i class="fas fa-tasks"></i> État des Projets</h3>
                        </div>
                        <div class="chart-content">
                            <canvas id="projectsChart" height="250"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Section Analytics Avancée -->
                <div class="analytics-section">
                    <div class="section-header">
                        <h2><i class="fas fa-brain"></i> Analytics Avancée</h2>
                    </div>
                    <div class="analytics-grid">
                        <div class="analytics-card">
                            <div class="analytics-header">
                                <h4>Prédictions</h4>
                                <i class="fas fa-robot"></i>
                            </div>
                            <div class="analytics-content">
                                <div class="prediction-item">
                                    <span class="prediction-label">Dons prochains mois</span>
                                    <span class="prediction-value">+<?php echo rand(8, 15); ?>%</span>
                                </div>
                                <div class="prediction-item">
                                    <span class="prediction-label">Nouveaux membres</span>
                                    <span class="prediction-value">+<?php echo rand(12, 25); ?>%</span>
                                </div>
                            </div>
                        </div>

                        <div class="analytics-card">
                            <div class="analytics-header">
                                <h4>Tendances</h4>
                                <i class="fas fa-chart-trending-up"></i>
                            </div>
                            <div class="analytics-content">
                                <div class="trend-item positive">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>Événements populaires</span>
                                </div>
                                <div class="trend-item positive">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>Engagement digital</span>
                                </div>
                                <div class="trend-item neutral">
                                    <i class="fas fa-minus"></i>
                                    <span>Coûts opérationnels</span>
                                </div>
                            </div>
                        </div>

                        <div class="analytics-card">
                            <div class="analytics-header">
                                <h4>Recommandations</h4>
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div class="analytics-content">
                                <div class="recommendation-item">
                                    <span class="rec-priority high">Élevé</span>
                                    <span class="rec-text">Augmenter budget marketing</span>
                                </div>
                                <div class="recommendation-item">
                                    <span class="rec-priority medium">Moyen</span>
                                    <span class="rec-text">Optimiser processus RH</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="chart-row">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3><i class="fas fa-users"></i> Engagement Membres</h3>
                        </div>
                        <div class="chart-content">
                            <canvas id="engagementChart" height="250"></canvas>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3><i class="fas fa-calendar-check"></i> Participation Événements</h3>
                        </div>
                        <div class="chart-content">
                            <canvas id="eventsChart" height="250"></canvas>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <h3><i class="fas fa-clock"></i> Performance Temps Réel</h3>
                        </div>
                        <div class="chart-content">
                            <div class="realtime-metrics">
                                <div class="metric-item">
                                    <span class="metric-label">Sessions actives</span>
                                    <span class="metric-value"><?php echo rand(5, 25); ?></span>
                                </div>
                                <div class="metric-item">
                                    <span class="metric-label">Pages vues/h</span>
                                    <span class="metric-value"><?php echo rand(100, 500); ?></span>
                                </div>
                                <div class="metric-item">
                                    <span class="metric-label">Actions/min</span>
                                    <span class="metric-value"><?php echo rand(10, 50); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar avec widgets avancés -->
        <div class="sidebar">
            <!-- Calendrier intégré -->
            <div class="sidebar-widget calendar-widget">
                <div class="widget-header">
                    <h4><i class="fas fa-calendar"></i> Calendrier</h4>
                </div>
                <div class="widget-content">
                    <div id="calendar"></div>
                </div>
            </div>

            <!-- Alertes intelligentes -->
            <div class="sidebar-widget alerts-widget">
                <div class="widget-header">
                    <h4><i class="fas fa-exclamation-triangle"></i> Alertes Intelligentes</h4>
                    <span class="alert-count"><?php echo count($alerts ?? []); ?></span>
                </div>
                <div class="widget-content">
                    <?php if (!empty($alerts)): ?>
                        <?php foreach ($alerts as $alert): ?>
                            <div class="alert-item <?php echo strpos($alert['message'], 'contrats') !== false ? 'warning' : (strpos($alert['message'], 'tâches') !== false ? 'danger' : 'info'); ?>">
                                <div class="alert-icon">
                                    <i class="fas fa-<?php echo strpos($alert['message'], 'contrats') !== false ? 'file-contract' : (strpos($alert['message'], 'tâches') !== false ? 'tasks' : 'exclamation-circle'); ?>"></i>
                                </div>
                                <div class="alert-content">
                                    <span class="alert-message"><?php echo htmlspecialchars($alert['message']); ?></span>
                                    <span class="alert-time"><?php echo rand(1, 24); ?>h ago</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert-item success">
                            <div class="alert-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="alert-content">
                                <span class="alert-message">Toutes les métriques sont bonnes</span>
                                <span class="alert-time">Maintenant</span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tâches prioritaires -->
            <div class="sidebar-widget tasks-widget">
                <div class="widget-header">
                    <h4><i class="fas fa-tasks"></i> Tâches Prioritaires</h4>
                    <button class="add-task-btn" onclick="addNewTask()">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="widget-content">
                    <?php if (!empty($todo_tasks)): ?>
                        <?php foreach ($todo_tasks as $task): ?>
                            <div class="task-item" data-status="<?php echo $task['statut']; ?>">
                                <div class="task-status">
                                    <span class="status-indicator <?php echo $task['statut'] == 'en_cours' ? 'in-progress' : 'pending'; ?>"></span>
                                </div>
                                <div class="task-content">
                                    <span class="task-title"><?php echo htmlspecialchars($task['titre']); ?></span>
                                    <span class="task-meta"><?php echo htmlspecialchars($task['statut']); ?> • <?php echo rand(1, 30); ?>j restant</span>
                                </div>
                                <div class="task-actions">
                                    <button class="task-action-btn" onclick="completeTask(this)">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="task-item completed">
                            <div class="task-status">
                                <span class="status-indicator completed"></span>
                            </div>
                            <div class="task-content">
                                <span class="task-title">Toutes les tâches terminées !</span>
                                <span class="task-meta">Excellent travail</span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Accès rapide étendu -->
            <div class="sidebar-widget quick-access-widget">
                <div class="widget-header">
                    <h4><i class="fas fa-rocket"></i> Accès Rapide</h4>
                </div>
                <div class="widget-content">
                    <div class="quick-access-grid">
                        <a href="<?php echo BASE_URL; ?>/hr" class="quick-link">
                            <i class="fas fa-user-tie"></i>
                            <span>RH</span>
                        </a>
                        <a href="<?php echo BASE_URL; ?>/finance" class="quick-link">
                            <i class="fas fa-coins"></i>
                            <span>Finance</span>
                        </a>
                        <a href="<?php echo BASE_URL; ?>/projects" class="quick-link">
                            <i class="fas fa-project-diagram"></i>
                            <span>Projets</span>
                        </a>
                        <a href="<?php echo BASE_URL; ?>/crm" class="quick-link">
                            <i class="fas fa-address-book"></i>
                            <span>CRM</span>
                        </a>
                        <a href="<?php echo BASE_URL; ?>/documents" class="quick-link">
                            <i class="fas fa-folder-open"></i>
                            <span>Documents</span>
                        </a>
                        <a href="<?php echo BASE_URL; ?>/support" class="quick-link">
                            <i class="fas fa-headset"></i>
                            <span>Support</span>
                        </a>
                        <a href="<?php echo BASE_URL; ?>/members" class="quick-link">
                            <i class="fas fa-users"></i>
                            <span>Membres</span>
                        </a>
                        <a href="<?php echo BASE_URL; ?>/events" class="quick-link">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Événements</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Métriques système -->
            <div class="sidebar-widget system-widget">
                <div class="widget-header">
                    <h4><i class="fas fa-server"></i> Système</h4>
                </div>
                <div class="widget-content">
                    <div class="system-metrics">
                        <div class="metric">
                            <span class="metric-label">CPU</span>
                            <div class="metric-bar">
                                <div class="metric-fill" style="width: <?php echo rand(10, 60); ?>%"></div>
                            </div>
                            <span class="metric-value"><?php echo rand(10, 60); ?>%</span>
                        </div>
                        <div class="metric">
                            <span class="metric-label">Mémoire</span>
                            <div class="metric-bar">
                                <div class="metric-fill" style="width: <?php echo rand(20, 80); ?>%"></div>
                            </div>
                            <span class="metric-value"><?php echo rand(20, 80); ?>%</span>
                        </div>
                        <div class="metric">
                            <span class="metric-label">Stockage</span>
                            <div class="metric-bar">
                                <div class="metric-fill" style="width: <?php echo rand(30, 90); ?>%"></div>
                            </div>
                            <span class="metric-value"><?php echo rand(30, 90); ?>%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Scripts pour les graphiques et fonctionnalités avancées -->
<script>
    // Données pour les graphiques depuis le backend
    const chartData = <?php echo json_encode($chart_data ?? []); ?>;

    // Données par défaut si vides
    if (!chartData.donations) {
        chartData.donations = {
            labels: ['2024-01', '2024-02', '2024-03', '2024-04', '2024-05', '2024-06'],
            data: [1200, 1900, 3000, 5000, 2000, 3000]
        };
    }
    if (!chartData.modules) {
        chartData.modules = {
            labels: ['RH', 'Finance', 'Projets', 'CRM', 'Documents', 'Support'],
            data: [<?php echo $stats['total_employes'] ?? 0; ?>, <?php echo $stats['total_budgets'] ?? 0; ?>, <?php echo $stats['total_projects'] ?? 0; ?>, <?php echo $stats['total_contacts'] ?? 0; ?>, <?php echo $stats['total_documents'] ?? 0; ?>, 0]
        };
    }
    if (!chartData.hr) {
        chartData.hr = {
            labels: ['Employés actifs', 'Contrats actifs', 'Absences', 'Pointages'],
            data: [<?php echo $stats['total_employes'] ?? 0; ?>, <?php echo $stats['contrats_actifs'] ?? 0; ?>, <?php echo $stats['absences_en_cours'] ?? 0; ?>, 150]
        };
    }
    if (!chartData.projects) {
        chartData.projects = {
            labels: ['Planification', 'Actif', 'Terminé', 'En pause'],
            data: [5, <?php echo $stats['total_projects'] ?? 0; ?>, 12, 2]
        };
    }

    // Graphique financier principal
    const financialCtx = document.getElementById('financialChart').getContext('2d');
    let financialChart = new Chart(financialCtx, {
        type: 'line',
        data: {
            labels: chartData.donations.labels,
            datasets: [{
                label: 'Dons (€)',
                data: chartData.donations.data,
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('fr-FR', {
                                style: 'currency',
                                currency: 'EUR',
                                minimumFractionDigits: 0
                            }).format(value);
                        }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // Gestion des filtres du graphique financier
    document.querySelectorAll('.chart-filter').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.chart-filter').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const type = this.dataset.type;
            let newData, newLabel;

            switch (type) {
                case 'donations':
                    newData = chartData.donations.data;
                    newLabel = 'Dons (€)';
                    break;
                case 'budgets':
                    newData = [5000, 8000, 12000, 15000, 10000, 18000];
                    newLabel = 'Budgets (€)';
                    break;
                case 'depenses':
                    newData = [3000, 4500, 6000, 7500, 4000, 5500];
                    newLabel = 'Dépenses (€)';
                    break;
            }

            financialChart.data.datasets[0].data = newData;
            financialChart.data.datasets[0].label = newLabel;
            financialChart.update();
        });
    });

    // Graphique des modules
    const modulesCtx = document.getElementById('modulesChart').getContext('2d');
    new Chart(modulesCtx, {
        type: 'doughnut',
        data: {
            labels: chartData.modules.labels,
            datasets: [{
                data: chartData.modules.data,
                backgroundColor: [
                    '#667eea', '#764ba2', '#f093fb', '#f5576c', '#4facfe', '#00f2fe'
                ],
                borderWidth: 0,
                hoverBorderWidth: 2,
                hoverBorderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            },
            cutout: '60%'
        }
    });

    // Graphique RH
    const hrCtx = document.getElementById('hrChart').getContext('2d');
    new Chart(hrCtx, {
        type: 'bar',
        data: {
            labels: chartData.hr.labels,
            datasets: [{
                label: 'RH',
                data: chartData.hr.data,
                backgroundColor: [
                    '#667eea', '#764ba2', '#f093fb', '#f5576c'
                ],
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                }
            }
        }
    });

    // Graphique projets
    const projectsCtx = document.getElementById('projectsChart').getContext('2d');
    new Chart(projectsCtx, {
        type: 'pie',
        data: {
            labels: chartData.projects.labels,
            datasets: [{
                data: chartData.projects.data,
                backgroundColor: [
                    '#95a5a6', '#667eea', '#27ae60', '#ffc107'
                ],
                borderWidth: 0,
                hoverBorderWidth: 2,
                hoverBorderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Graphique engagement membres
    const engagementCtx = document.getElementById('engagementChart').getContext('2d');
    new Chart(engagementCtx, {
        type: 'radar',
        data: {
            labels: ['Participation événements', 'Dons réguliers', 'Volontariat', 'Communication', 'Satisfaction'],
            datasets: [{
                label: 'Niveau d\'engagement',
                data: [85, 70, 60, 75, 80],
                backgroundColor: 'rgba(102, 126, 234, 0.2)',
                borderColor: '#667eea',
                borderWidth: 2,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 20
                    }
                }
            }
        }
    });

    // Graphique participation événements
    const eventsChartCtx = document.getElementById('eventsChart').getContext('2d');
    new Chart(eventsChartCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
            datasets: [{
                label: 'Participants',
                data: [45, 52, 38, 61, 55, 67],
                borderColor: '#27ae60',
                backgroundColor: 'rgba(39, 174, 96, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#27ae60',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                }
            }
        }
    });

    // Initialisation du calendrier
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            events: [{
                    title: 'Réunion CA',
                    start: '2024-02-15',
                    backgroundColor: '#667eea'
                },
                {
                    title: 'Événement solidaire',
                    start: '2024-02-20',
                    backgroundColor: '#27ae60'
                },
                {
                    title: 'Formation équipe',
                    start: '2024-02-25',
                    backgroundColor: '#f39c12'
                }
            ],
            height: 300,
            dayMaxEvents: 2,
            moreLinkClick: 'popover'
        });
        calendar.render();
    });

    // Fonctions utilitaires
    function refreshDashboard() {
        // Animation de chargement
        const btn = document.querySelector('.refresh-btn');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualisation...';
        btn.disabled = true;

        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            // Ici on pourrait recharger les données
            location.reload();
        }, 2000);
    }

    function changeTimeRange(range) {
        // Ici on pourrait changer la période des graphiques
        console.log('Changement de période:', range);
    }

    function addNewTask() {
        // Fonction pour ajouter une nouvelle tâche
        alert('Fonctionnalité d\'ajout de tâche à implémenter');
    }

    function completeTask(btn) {
        // Animation de completion
        const taskItem = btn.closest('.task-item');
        taskItem.style.transition = 'all 0.3s';
        taskItem.style.opacity = '0.5';

        setTimeout(() => {
            taskItem.remove();
        }, 300);
    }

    // Animation au chargement
    document.addEventListener('DOMContentLoaded', function() {
        // Animations d'entrée
        const cards = document.querySelectorAll('.kpi-card, .chart-card, .sidebar-widget');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // Initialiser les sparklines pour les KPIs détaillés
        initializeSparklines();
    });

    // Fonction pour initialiser les sparklines
    function initializeSparklines() {
        // Sparkline pour la croissance
        const growthCtx = document.getElementById('growthSparkline');
        if (growthCtx) {
            new Chart(growthCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
                    datasets: [{
                        data: [15, 18, 22, 19, 25, 28],
                        borderColor: '#00D4AA',
                        borderWidth: 2,
                        fill: false,
                        pointRadius: 0,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            display: false
                        }
                    },
                    elements: {
                        point: {
                            hoverRadius: 0
                        }
                    }
                }
            });
        }

        // Sparkline pour l'efficacité
        const efficiencyCtx = document.getElementById('efficiencySparkline');
        if (efficiencyCtx) {
            new Chart(efficiencyCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
                    datasets: [{
                        data: [82, 85, 88, 86, 91, 89],
                        borderColor: '#00C4CC',
                        borderWidth: 2,
                        fill: false,
                        pointRadius: 0,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            display: false
                        }
                    },
                    elements: {
                        point: {
                            hoverRadius: 0
                        }
                    }
                }
            });
        }

        // Sparkline pour la satisfaction
        const satisfactionCtx = document.getElementById('satisfactionSparkline');
        if (satisfactionCtx) {
            new Chart(satisfactionCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
                    datasets: [{
                        data: [4.1, 4.3, 4.2, 4.5, 4.4, 4.6],
                        borderColor: '#FFD23F',
                        borderWidth: 2,
                        fill: false,
                        pointRadius: 0,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            display: false
                        }
                    },
                    elements: {
                        point: {
                            hoverRadius: 0
                        }
                    }
                }
            });
        }

        // Sparkline pour le ROI
        const roiCtx = document.getElementById('roiSparkline');
        if (roiCtx) {
            new Chart(roiCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
                    datasets: [{
                        data: [110, 125, 118, 140, 135, 155],
                        borderColor: '#FF6B9D',
                        borderWidth: 2,
                        fill: false,
                        pointRadius: 0,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            display: false
                        }
                    },
                    elements: {
                        point: {
                            hoverRadius: 0
                        }
                    }
                }
            });
        }
    }

    function toggleTheme() {
        const html = document.documentElement;
        const themeIcon = document.querySelector('.theme-toggle i');

        if (html.getAttribute('data-theme') === 'dark') {
            html.removeAttribute('data-theme');
            themeIcon.className = 'fas fa-moon';
            localStorage.setItem('theme', 'light');
        } else {
            html.setAttribute('data-theme', 'dark');
            themeIcon.className = 'fas fa-sun';
            localStorage.setItem('theme', 'dark');
        }
    }

    // Load saved theme
    document.addEventListener('DOMContentLoaded', function() {
        // Hide loading overlay
        setTimeout(() => {
            const overlay = document.getElementById('loadingOverlay');
            if (overlay) {
                overlay.classList.add('hidden');
                setTimeout(() => overlay.remove(), 500);
            }
        }, 1000);

        // Animations d'entrée
        const cards = document.querySelectorAll('.kpi-card, .chart-card, .sidebar-widget, .detailed-kpi-card, .analytics-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // Initialiser les sparklines pour les KPIs détaillés
        initializeSparklines();

        const savedTheme = localStorage.getItem('theme');
        const themeIcon = document.querySelector('.theme-toggle i');

        if (savedTheme === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
            themeIcon.className = 'fas fa-sun';
        } else {
            themeIcon.className = 'fas fa-moon';
        }
    });
</script>

<?php include VIEWS_PATH . 'footer.php'; ?>