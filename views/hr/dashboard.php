<?php
$pageTitle = $pageTitle ?? 'Tableau de Bord RH';
$totalEmployees = $totalEmployees ?? 0;
$onLeaveToday = $onLeaveToday ?? 0;
$pendingApprovals = $pendingApprovals ?? 0;
$upcomingEvaluations = $upcomingEvaluations ?? 0;
$recentAbsences = $recentAbsences ?? [];
$departments = $departments ?? [];
?>

<div class="main-content">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-container">
            <h1>Bienvenue au Module RH</h1>
            <p>Gestion complète des Ressources Humaines et du Personnel</p>
            <div class="hero-stats">
                <div class="hero-stat">
                    <span><?php echo $totalEmployees; ?></span>
                    <span>Employés Actifs</span>
                </div>
                <div class="hero-stat">
                    <span><?php echo $onLeaveToday; ?></span>
                    <span>En Congé Aujourd'hui</span>
                </div>
                <div class="hero-stat">
                    <span><?php echo $pendingApprovals; ?></span>
                    <span>En Attente d'Approbation</span>
                </div>
                <div class="hero-stat">
                    <span><?php echo $upcomingEvaluations; ?></span>
                    <span>Évaluations Prévues</span>
                </div>
            </div>
        </div>
    </div>

    <!-- KPIs Section -->
    <div class="kpis-section">
        <div class="kpi-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--spacing-lg); margin: var(--spacing-xl);">
            <!-- Employees KPI -->
            <div class="kpi-card members">
                <div class="kpi-header">
                    <div class="kpi-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <div class="kpi-content">
                            <h2><?php echo $totalEmployees; ?></h2>
                            <p>Employés Actifs</p>
                        </div>
                    </div>
                </div>
                <div class="kpi-details">
                    <span class="detail-item"><a href="/hr/employees">Voir tous</a></span>
                </div>
            </div>

            <!-- Absences KPI -->
            <div class="kpi-card finance">
                <div class="kpi-header">
                    <div class="kpi-icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <div>
                        <div class="kpi-content">
                            <h2><?php echo $onLeaveToday; ?></h2>
                            <p>Actuellement en Congé</p>
                        </div>
                    </div>
                </div>
                <div class="kpi-details">
                    <span class="detail-item"><a href="/hr/absences">Gestion</a></span>
                </div>
            </div>

            <!-- Pending Approvals KPI -->
            <div class="kpi-card projects">
                <div class="kpi-header">
                    <div class="kpi-icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div>
                        <div class="kpi-content">
                            <h2><?php echo $pendingApprovals; ?></h2>
                            <p>En Attente d'Approbation</p>
                        </div>
                    </div>
                </div>
                <div class="kpi-details">
                    <span class="detail-item"><a href="/hr/absences?status=pending">À traiter</a></span>
                </div>
            </div>

            <!-- Evaluations KPI -->
            <div class="kpi-card crm">
                <div class="kpi-header">
                    <div class="kpi-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <div class="kpi-content">
                            <h2><?php echo $upcomingEvaluations; ?></h2>
                            <p>Évaluations Prévues</p>
                        </div>
                    </div>
                </div>
                <div class="kpi-details">
                    <span class="detail-item"><a href="/hr/evaluations">Voir</a></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="content-container" style="grid-template-columns: 2fr 1fr; gap: var(--spacing-xl);">
        <!-- Recent Activities -->
        <div class="chart-card">
            <div class="chart-header">
                <h3>Activités Récentes</h3>
            </div>
            <div class="chart-content">
                <div style="display: grid; gap: var(--spacing-lg);">
                    <!-- Recent Absences -->
                    <div>
                        <h4 style="margin-bottom: var(--spacing-md); color: var(--gray-900);">Dernières Absences</h4>
                        <div style="max-height: 250px; overflow-y: auto;">
                            <?php if (!empty($recentAbsences)): ?>
                                <?php foreach ($recentAbsences as $absence): ?>
                                    <div style="padding: var(--spacing-sm); border-left: 3px solid var(--primary); margin-bottom: var(--spacing-sm); background: var(--gray-50); border-radius: var(--border-radius-sm);">
                                        <strong><?php echo htmlspecialchars(($absence['first_name'] ?? 'N/A') . ' ' . ($absence['last_name'] ?? 'N/A')); ?></strong>
                                        <br>
                                        <small class="text-muted"><?php echo htmlspecialchars($absence['absence_type'] ?? 'N/A'); ?> - <?php echo isset($absence['start_date']) ? date('d/m/Y', strtotime($absence['start_date'])) : 'N/A'; ?></small>
                                        <br>
                                        <span class="badge badge-<?php echo htmlspecialchars($absence['status'] ?? 'pending'); ?>"><?php echo ucfirst($absence['status'] ?? 'pending'); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted">Aucune absence enregistrée</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="chart-card">
            <div class="chart-header">
                <h3>Actions Rapides</h3>
            </div>
            <div class="chart-content">
                <div style="display: flex; flex-direction: column; gap: var(--spacing-md);">
                    <a href="/hr/create" class="btn btn-primary" style="text-align: center;">
                        <i class="fas fa-plus"></i> Ajouter un Employé
                    </a>
                    <a href="/hr/absences?status=pending" class="btn btn-outline-primary" style="text-align: center;">
                        <i class="fas fa-check"></i> Approuver les Absences
                    </a>
                    <a href="/hr/evaluations" class="btn btn-outline-primary" style="text-align: center;">
                        <i class="fas fa-star"></i> Gestion des Évaluations
                    </a>
                    <a href="/hr/contracts" class="btn btn-outline-primary" style="text-align: center;">
                        <i class="fas fa-file-contract"></i> Gestion des Contrats
                    </a>
                    <a href="/hr/trainings" class="btn btn-outline-primary" style="text-align: center;">
                        <i class="fas fa-book"></i> Formations
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Departments Overview -->
    <div class="chart-card" style="margin-top: var(--spacing-xl);">
        <div class="chart-header">
            <h3>Aperçu par Département</h3>
        </div>
        <div class="chart-content">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--spacing-lg);">
                <?php if (!empty($departments)): ?>
                    <?php foreach ($departments as $dept): ?>
                        <div style="padding: var(--spacing-lg); background: var(--gray-50); border-radius: var(--border-radius); text-align: center; border-left: 4px solid var(--secondary);">
                            <h4 style="margin-bottom: var(--spacing-sm);"><?php echo htmlspecialchars($dept); ?></h4>
                            <p style="margin: 0; color: var(--primary); font-weight: 600; font-size: var(--font-size-lg);">
                                <?php
                                $count = count(array_filter($departments, function ($d) use ($dept) {
                                    return $d === $dept;
                                }));
                                // This is a simplified count, in reality you'd query the DB
                                echo '...';
                                ?>
                            </p>
                            <a href="/hr?department=<?php echo urlencode($dept); ?>" style="font-size: var(--font-size-sm); color: var(--primary); text-decoration: none; margin-top: var(--spacing-sm); display: inline-block;">
                                Voir les employés →
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">Aucun département</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>