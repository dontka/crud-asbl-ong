<?php
$pageTitle = $pageTitle ?? 'Gestion des Formations';
?>

<div class="main-content">
    <!-- Header -->
    <div class="dashboard-nav">
        <div class="nav-container">
            <div class="nav-left">
                <h1>Gestion des Formations</h1>
            </div>
            <div class="nav-right">
                <a href="/hr/create-training" class="nav-btn btn-primary">
                    <i class="fas fa-plus"></i> Nouvelle Formation
                </a>
            </div>
        </div>
    </div>

    <!-- Trainings List -->
    <div class="chart-card" style="margin: var(--spacing-xl);">
        <div class="chart-content">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--gray-200);">
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600;">Titre</th>
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600;">Formateur</th>
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600;">Début</th>
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600;">Fin</th>
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600;">Participants</th>
                            <th style="padding: var(--spacing-md); text-align: center; font-weight: 600;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($trainings ?? [])): ?>
                            <tr>
                                <td colspan="6" style="padding: var(--spacing-xl); text-align: center; color: var(--gray-500);">
                                    <p>Aucune formation enregistrée</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($trainings as $training): ?>
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: var(--spacing-md);">
                                        <strong><?php echo htmlspecialchars($training['title'] ?? 'N/A'); ?></strong>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <?php echo htmlspecialchars($training['trainer_name'] ?? '-'); ?>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <?php echo date('d/m/Y', strtotime($training['start_date'] ?? date('Y-m-d'))); ?>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <?php echo date('d/m/Y', strtotime($training['end_date'] ?? date('Y-m-d'))); ?>
                                    </td>
                                    <td style="padding: var(--spacing-md); text-align: center;">
                                        <span style="display: inline-block; padding: 4px 8px; border-radius: 4px; background-color: #e2e3e5; color: #383d41; font-size: 0.875rem;">
                                            <?php echo $training['participants_count'] ?? '0'; ?>
                                        </span>
                                    </td>
                                    <td style="padding: var(--spacing-md); text-align: center;">
                                        <a href="/hr/training/<?php echo $training['id']; ?>/edit" class="btn-link" style="margin-right: 8px;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/hr/training/<?php echo $training['id']; ?>/view" class="btn-link">
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