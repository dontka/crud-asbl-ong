<?php
$pageTitle = $pageTitle ?? 'Gestion des Évaluations';
?>

<div class="main-content">
    <!-- Header -->
    <div class="dashboard-nav">
        <div class="nav-container">
            <div class="nav-left">
                <h1>Gestion des Évaluations</h1>
            </div>
            <div class="nav-right">
                <a href="/hr/create-evaluation" class="nav-btn btn-primary">
                    <i class="fas fa-plus"></i> Nouvelle Évaluation
                </a>
            </div>
        </div>
    </div>

    <!-- Evaluations List -->
    <div class="chart-card" style="margin: var(--spacing-xl);">
        <div class="chart-content">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--gray-200);">
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600;">Employé</th>
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600;">Évaluateur</th>
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600;">Date</th>
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600;">Note Globale</th>
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600;">Statut</th>
                            <th style="padding: var(--spacing-md); text-align: center; font-weight: 600;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($evaluations ?? [])): ?>
                            <tr>
                                <td colspan="6" style="padding: var(--spacing-xl); text-align: center; color: var(--gray-500);">
                                    <p>Aucune évaluation enregistrée</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($evaluations as $evaluation): ?>
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: var(--spacing-md);">
                                        <strong><?php echo htmlspecialchars($evaluation['employee_name'] ?? 'N/A'); ?></strong>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <?php echo htmlspecialchars($evaluation['evaluator_name'] ?? '-'); ?>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <?php echo date('d/m/Y', strtotime($evaluation['evaluation_date'] ?? date('Y-m-d'))); ?>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <strong><?php echo htmlspecialchars($evaluation['overall_score'] ?? '-'); ?>/10</strong>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <span style="display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 0.875rem; background-color: #d4edda; color: #155724;">
                                            <?php echo ucfirst($evaluation['status'] ?? 'completed'); ?>
                                        </span>
                                    </td>
                                    <td style="padding: var(--spacing-md); text-align: center;">
                                        <a href="/hr/evaluation/<?php echo $evaluation['id']; ?>/edit" class="btn-link" style="margin-right: 8px;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/hr/evaluation/<?php echo $evaluation['id']; ?>/view" class="btn-link">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>