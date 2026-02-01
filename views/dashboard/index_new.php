<?php $pageTitle = 'Dashboard Complet - ASBL-ONG'; ?>
<?php include VIEWS_PATH . 'header.php'; ?>

<!-- Inclure les bibliothèques nécessaires -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<div class="complete-dashboard">
    <!-- Top Navigation Bar -->
    <div class="dashboard-nav">
        <div class="nav-left">
            <h1><i class="fas fa-tachometer-alt"></i> Dashboard Complet</h1>
            <span class="nav-date"><?php echo date('l, F j, Y'); ?></span>
        </div>
        <div class="nav-right">
            <div class="nav-actions">
                <button class="nav-btn refresh-btn" onclick="refreshDashboard()">
                    <i class="fas fa-sync-alt"></i> Actualiser
                </button>
                <div class="time-range-selector">
                    <select id="timeRange" onchange="changeTimeRange(this.value)">
                        <option value="7d">7 jours</option>
                        <option value="30d" selected>30 jours</option>
                        <option value="90d">90 jours</option>
                        <option value="1y">1 an</option>
                    </select>
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
        <!-- Charts Section -->
        <div class="charts-section">
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

<!-- Styles CSS complets pour le dashboard professionnel -->
<style>
.complete-dashboard {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px;
}

.dashboard-nav {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 20px 30px;
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.nav-left h1 {
    margin: 0;
    color: #2c3e50;
    font-size: 1.8rem;
    font-weight: 600;
}

.nav-left h1 i {
    margin-right: 10px;
    color: #667eea;
}

.nav-date {
    color: #7f8c8d;
    font-size: 0.9rem;
    margin-left: 20px;
}

.nav-actions {
    display: flex;
    align-items: center;
    gap: 15px;
}

.nav-btn {
    background: #667eea;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.3s;
}

.nav-btn:hover {
    background: #5a6fd8;
    transform: translateY(-2px);
}

.time-range-selector select {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    background: white;
    font-size: 0.9rem;
}

.kpis-section {
    margin-bottom: 30px;
}

.kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.kpi-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}

.kpi-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.kpi-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.kpi-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
}

.kpi-icon {
    font-size: 2.5rem;
    opacity: 0.8;
}

.kpi-trend {
    text-align: right;
}

.trend-value {
    display: block;
    font-size: 0.9rem;
    font-weight: bold;
    margin-bottom: 2px;
}

.trend-value.positive { color: #27ae60; }
.trend-value.negative { color: #e74c3c; }
.trend-value.neutral { color: #f39c12; }

.trend-period {
    font-size: 0.7rem;
    color: #7f8c8d;
}

.kpi-content h2 {
    margin: 0;
    font-size: 2.2rem;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 5px;
}

.kpi-content p {
    margin: 0;
    color: #7f8c8d;
    font-size: 0.9rem;
    margin-bottom: 10px;
}

.kpi-details {
    display: flex;
    gap: 15px;
}

.detail-item {
    font-size: 0.8rem;
    color: #34495e;
    background: rgba(102, 126, 234, 0.1);
    padding: 4px 8px;
    border-radius: 4px;
}

/* Couleurs spécifiques pour chaque KPI */
.kpi-card.members .kpi-icon { color: #3498db; }
.kpi-card.finance .kpi-icon { color: #27ae60; }
.kpi-card.projects .kpi-icon { color: #9b59b6; }
.kpi-card.events .kpi-icon { color: #e67e22; }
.kpi-card.hr .kpi-icon { color: #1abc9c; }
.kpi-card.finance-advanced .kpi-icon { color: #f1c40f; }
.kpi-card.crm .kpi-icon { color: #e74c3c; }
.kpi-card.documents .kpi-icon { color: #95a5a6; }

.main-content {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 30px;
}

.charts-section {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.chart-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 20px;
}

.chart-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.chart-card.large {
    grid-column: 1 / -1;
}

.chart-header {
    padding: 20px 25px;
    background: rgba(255, 255, 255, 0.8);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chart-header h3 {
    margin: 0;
    color: #2c3e50;
    font-size: 1.1rem;
    font-weight: 600;
}

.chart-header h3 i {
    margin-right: 8px;
    color: #667eea;
}

.chart-controls {
    display: flex;
    gap: 8px;
}

.chart-filter {
    padding: 6px 12px;
    border: 1px solid #ddd;
    background: white;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.8rem;
    transition: all 0.2s;
}

.chart-filter.active {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.chart-content {
    padding: 25px;
    height: 300px;
    position: relative;
}

.realtime-metrics {
    display: flex;
    flex-direction: column;
    gap: 20px;
    height: 100%;
    justify-content: center;
}

.metric-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 10px;
}

.metric-label {
    font-weight: 500;
    color: #2c3e50;
}

.metric-value {
    font-size: 1.5rem;
    font-weight: bold;
    color: #667eea;
}

.sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.sidebar-widget {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.widget-header {
    padding: 15px 20px;
    background: rgba(255, 255, 255, 0.8);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.widget-header h4 {
    margin: 0;
    color: #2c3e50;
    font-size: 1rem;
    font-weight: 600;
}

.widget-header h4 i {
    margin-right: 8px;
    color: #667eea;
}

.alert-count {
    background: #e74c3c;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: bold;
}

.widget-content {
    padding: 0;
}

#calendar {
    height: 300px;
    padding: 10px;
}

/* Alertes */
.alert-item {
    display: flex;
    align-items: flex-start;
    padding: 15px 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    transition: background 0.2s;
}

.alert-item:hover {
    background: rgba(102, 126, 234, 0.05);
}

.alert-item:last-child {
    border-bottom: none;
}

.alert-icon {
    margin-right: 12px;
    margin-top: 2px;
}

.alert-icon i {
    font-size: 1.1rem;
}

.alert-item.warning .alert-icon i { color: #f39c12; }
.alert-item.danger .alert-icon i { color: #e74c3c; }
.alert-item.info .alert-icon i { color: #3498db; }
.alert-item.success .alert-icon i { color: #27ae60; }

.alert-message {
    display: block;
    font-weight: 500;
    color: #2c3e50;
    margin-bottom: 2px;
}

.alert-time {
    font-size: 0.7rem;
    color: #7f8c8d;
}

/* Tâches */
.task-item {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    transition: background 0.2s;
}

.task-item:hover {
    background: rgba(102, 126, 234, 0.05);
}

.task-item:last-child {
    border-bottom: none;
}

.task-status {
    margin-right: 12px;
}

.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
}

.status-indicator.in-progress { background: #f39c12; }
.status-indicator.pending { background: #95a5a6; }
.status-indicator.completed { background: #27ae60; }

.task-title {
    display: block;
    font-weight: 500;
    color: #2c3e50;
    margin-bottom: 2px;
}

.task-meta {
    font-size: 0.7rem;
    color: #7f8c8d;
}

.task-actions {
    margin-left: auto;
}

.task-action-btn {
    background: none;
    border: none;
    color: #7f8c8d;
    cursor: pointer;
    padding: 5px;
    border-radius: 4px;
    transition: all 0.2s;
}

.task-action-btn:hover {
    background: rgba(39, 174, 96, 0.1);
    color: #27ae60;
}

.add-task-btn {
    background: #667eea;
    color: white;
    border: none;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    transition: all 0.2s;
}

.add-task-btn:hover {
    background: #5a6fd8;
    transform: scale(1.1);
}

/* Accès rapide */
.quick-access-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 8px;
    padding: 15px;
}

.quick-link {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 12px 8px;
    text-decoration: none;
    color: #7f8c8d;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    transition: all 0.3s;
    text-align: center;
}

.quick-link:hover {
    background: #667eea;
    color: white;
    border-color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.quick-link i {
    font-size: 1.2rem;
    margin-bottom: 4px;
}

.quick-link span {
    font-size: 0.7rem;
    font-weight: 500;
}

/* Métriques système */
.system-metrics {
    padding: 15px;
}

.metric {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.metric:last-child {
    margin-bottom: 0;
}

.metric-label {
    width: 60px;
    font-size: 0.8rem;
    color: #2c3e50;
    font-weight: 500;
}

.metric-bar {
    flex: 1;
    height: 8px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    margin: 0 10px;
    overflow: hidden;
}

.metric-fill {
    height: 100%;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 4px;
    transition: width 0.3s;
}

.metric-value {
    width: 35px;
    text-align: right;
    font-size: 0.8rem;
    color: #2c3e50;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 1200px) {
    .main-content {
        grid-template-columns: 1fr;
    }

    .sidebar {
        order: -1;
    }
}

@media (max-width: 768px) {
    .complete-dashboard {
        padding: 10px;
    }

    .kpi-grid {
        grid-template-columns: 1fr;
    }

    .chart-row {
        grid-template-columns: 1fr;
    }

    .dashboard-nav {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }

    .nav-actions {
        justify-content: center;
    }
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.kpi-card, .chart-card, .sidebar-widget {
    animation: fadeInUp 0.6s ease-out;
}

.kpi-card:nth-child(1) { animation-delay: 0.1s; }
.kpi-card:nth-child(2) { animation-delay: 0.2s; }
.kpi-card:nth-child(3) { animation-delay: 0.3s; }
.kpi-card:nth-child(4) { animation-delay: 0.4s; }
.kpi-card:nth-child(5) { animation-delay: 0.5s; }
.kpi-card:nth-child(6) { animation-delay: 0.6s; }
.kpi-card:nth-child(7) { animation-delay: 0.7s; }
.kpi-card:nth-child(8) { animation-delay: 0.8s; }
</style>

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
            legend: { display: false }
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

        switch(type) {
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
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,0.05)' }
            },
            x: {
                grid: { color: 'rgba(0,0,0,0.05)' }
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
            legend: { display: false }
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
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,0.05)' }
            },
            x: {
                grid: { color: 'rgba(0,0,0,0.05)' }
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
        events: [
            {
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
});
</script>

<?php include VIEWS_PATH . 'footer.php'; ?>