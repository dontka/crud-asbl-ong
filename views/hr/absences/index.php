<?php
$pageTitle = $pageTitle ?? 'Gestion des Absences';
?>

<div class="main-content">
    <!-- Absences List -->
    <div class="chart-card" style="margin: var(--spacing-xl);">
        <div class="chart-content">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--gray-200);">
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600;">Employé</th>
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600;">Type</th>
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600;">Début</th>
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600;">Fin</th>
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600;">Statut</th>
                            <th style="padding: var(--spacing-md); text-align: center; font-weight: 600;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($absences ?? [])): ?>
                            <tr>
                                <td colspan="6" style="padding: var(--spacing-xl); text-align: center; color: var(--gray-500);">
                                    <p>Aucune absence enregistrée</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($absences as $absence): ?>
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: var(--spacing-md);">
                                        <strong><?php echo htmlspecialchars($absence['employee_name'] ?? 'N/A'); ?></strong>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <?php echo htmlspecialchars($absence['absence_type'] ?? '-'); ?>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <?php echo date('d/m/Y', strtotime($absence['start_date'] ?? '')); ?>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <?php echo date('d/m/Y', strtotime($absence['end_date'] ?? '')); ?>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <span style="display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 0.875rem; 
                                            <?php
                                            $status = $absence['status'] ?? 'pending';
                                            if ($status === 'approved') echo 'background-color: #d4edda; color: #155724;';
                                            elseif ($status === 'rejected') echo 'background-color: #f8d7da; color: #721c24;';
                                            else echo 'background-color: #fff3cd; color: #856404;';
                                            ?>">
                                            <?php echo ucfirst($status); ?>
                                        </span>
                                    </td>
                                    <td style="padding: var(--spacing-md); text-align: center;">
                                        <?php if (($absence['status'] ?? null) === 'pending'): ?>
                                            <a href="/hr/absence/<?php echo $absence['id']; ?>/approve" class="btn-link" style="margin-right: 8px;" title="Approuver">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            <a href="/hr/absence/<?php echo $absence['id']; ?>/reject" class="btn-link" title="Rejeter">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="/hr/absence/<?php echo $absence['id']; ?>/edit" class="btn-link" style="margin-right: 8px;">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Header -->
    <div class="dashboard-nav">
        <div class="nav-container">
            <div class="nav-left">
                <h1>Gestion des Absences</h1>
            </div>
            <div class="nav-right">
                <a href="/hr/request-absence" class="nav-btn btn-primary">
                    <i class="fas fa-plus"></i> Nouvelle Absence
                </a>
            </div>
        </div>
    </div>


</div>