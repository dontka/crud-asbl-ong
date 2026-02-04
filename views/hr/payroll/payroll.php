<?php
$pageTitle = $pageTitle ?? 'Gestion de la Paie';
?>

<div class="main-content">
   
    <!-- Payroll List -->
    <div class="chart-card" style="margin: var(--spacing-xl);">

     <!-- Header -->
    <div class="dashboard-nav">
        <div class="nav-container">
            <div class="nav-left">
                <h1><i class="fas fa-wallet" style="margin-right: 0.5rem; color: var(--primary);"></i>Gestion de la Paie</h1>
            </div>
            <div class="nav-actions">
                <form method="GET" style="display: flex; gap: var(--spacing-md); align-items: center;">
                    <input type="month" name="month" value="<?php echo htmlspecialchars($currentMonth); ?>"
                        style="padding: var(--spacing-sm); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                    <button type="submit" class="nav-btn">
                        <i class="fas fa-search"></i> Rechercher
                    </button>
                </form>
                <form method="POST" action="/hr/payroll?action=generate&month=<?php echo htmlspecialchars($currentMonth); ?>" style="display: inline;">
                    <button type="submit" class="nav-btn btn-primary" onclick="return confirm('Générer les fiches de paie pour ce mois ?')">
                        <i class="fas fa-plus"></i> Générer Masse
                    </button>
                </form>
                <a href="/hr/payroll/create" class="nav-btn btn-primary">
                    <i class="fas fa-file-alt"></i> Nouvelle Fiche
                </a>
            </div>
        </div>
    </div>

    
        <div class="chart-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3><i class="fas fa-list" style="margin-right: 0.5rem;"></i>Fiches de Paie - <?php echo htmlspecialchars($currentMonth); ?></h3>
            <div style="display: flex; gap: var(--spacing-md); align-items: center; font-size: var(--font-size-sm);">
                <label style="display: flex; gap: var(--spacing-sm); align-items: center; color: var(--gray-600);">
                    Lignes par page:
                    <select id="limitSelect" style="padding: 4px 8px; border: 1px solid var(--gray-300); border-radius: var(--border-radius-sm); cursor: pointer;">
                        <option value="10" <?php echo ($pagination['limit'] ?? 10) == 10 ? 'selected' : ''; ?>>10</option>
                        <option value="20" <?php echo ($pagination['limit'] ?? 10) == 20 ? 'selected' : ''; ?>>20</option>
                        <option value="50" <?php echo ($pagination['limit'] ?? 10) == 50 ? 'selected' : ''; ?>>50</option>
                    </select>
                </label>
                <span style="color: var(--gray-500);">Page <?php echo $pagination['page'] ?? 1; ?> / <?php echo $pagination['totalPages'] ?? 1; ?></span>
            </div>
        </div>
        <div class="chart-content">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: var(--gray-50);">
                        <tr>
                            <th style="padding: var(--spacing-md); text-align: left; border-bottom: 2px solid var(--gray-200); font-weight: 600;">Employé</th>
                            <th style="padding: var(--spacing-md); text-align: right; border-bottom: 2px solid var(--gray-200); font-weight: 600;">Salaire Brut</th>
                            <th style="padding: var(--spacing-md); text-align: right; border-bottom: 2px solid var(--gray-200); font-weight: 600;">Primes</th>
                            <th style="padding: var(--spacing-md); text-align: right; border-bottom: 2px solid var(--gray-200); font-weight: 600;">Cotisations</th>
                            <th style="padding: var(--spacing-md); text-align: right; border-bottom: 2px solid var(--gray-200); font-weight: 600;">Taxes</th>
                            <th style="padding: var(--spacing-md); text-align: right; border-bottom: 2px solid var(--gray-200); font-weight: 600;">Net</th>
                            <th style="padding: var(--spacing-md); text-align: center; border-bottom: 2px solid var(--gray-200); font-weight: 600;">Statut</th>
                            <th style="padding: var(--spacing-md); text-align: center; border-bottom: 2px solid var(--gray-200); font-weight: 600;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($payrolls)): ?>
                            <tr>
                                <td colspan="8" style="padding: var(--spacing-xl); text-align: center; color: var(--gray-500);">
                                    <p>Aucune fiche de paie pour ce mois. <a href="/hr/payroll?action=generate&month=<?php echo htmlspecialchars($currentMonth); ?>" style="color: var(--primary); text-decoration: none;">Générer les fiches</a></p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($payrolls as $p): ?>
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: var(--spacing-md);"><strong><?php echo htmlspecialchars($p['employee_name']); ?></strong></td>
                                    <td style="padding: var(--spacing-md); text-align: right;">€<?php echo number_format($p['salary_gross'] ?? 0, 2, ',', ' '); ?></td>
                                    <td style="padding: var(--spacing-md); text-align: right;">€<?php echo number_format(($p['bonuses'] ?? 0) + ($p['overtime_pay'] ?? 0), 2, ',', ' '); ?></td>
                                    <td style="padding: var(--spacing-md); text-align: right;">€<?php echo number_format($p['social_contributions'] ?? 0, 2, ',', ' '); ?></td>
                                    <td style="padding: var(--spacing-md); text-align: right;">€<?php echo number_format($p['taxes'] ?? 0, 2, ',', ' '); ?></td>
                                    <td style="padding: var(--spacing-md); text-align: right; font-weight: 600; color: var(--success);">€<?php echo number_format($p['salary_net'] ?? 0, 2, ',', ' '); ?></td>
                                    <td style="padding: var(--spacing-md); text-align: center;">
                                        <span style="padding: 4px 8px; border-radius: var(--border-radius-sm); font-size: var(--font-size-sm);
                                            <?php
                                            $status = $p['status'] ?? 'draft';
                                            if ($status === 'paid') echo 'background: #d4edda; color: #155724;';
                                            elseif ($status === 'validated') echo 'background: #cfe2ff; color: #084298;';
                                            else echo 'background: #fff3cd; color: #856404;';
                                            ?>">
                                            <?php 
                                            $statusLabels = ['draft' => 'Brouillon', 'validated' => 'Validé', 'paid' => 'Payé'];
                                            echo $statusLabels[$status] ?? ucfirst($status);
                                            ?>
                                        </span>
                                    </td>
                                    <td style="padding: var(--spacing-md); text-align: center;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;">
                                            <a href="/hr/payroll/<?php echo $p['id']; ?>/pdf" title="Télécharger PDF" style="padding: 6px 10px; background: #e74c3c; color: white; border-radius: 4px; text-decoration: none; font-size: 12px;">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                            <a href="/hr/payroll/<?php echo $p['id']; ?>/edit" title="Éditer" style="padding: 6px 10px; background: var(--primary); color: white; border-radius: 4px; text-decoration: none; font-size: 12px;">
                                                <i class="fas fa-edit"></i> Éditer
                                            </a>
                                            <a href="/hr/payroll/<?php echo $p['id']; ?>/delete" title="Supprimer" style="padding: 6px 10px; background: var(--error); color: white; border-radius: 4px; text-decoration: none; font-size: 12px;" onclick="return confirm('Confirmer la suppression ?')">
                                                <i class="fas fa-trash"></i> Suppr.
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Controls -->
            <?php if (($pagination['totalPages'] ?? 1) > 1): ?>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: var(--spacing-lg); padding-top: var(--spacing-lg); border-top: 1px solid var(--gray-200);">
                <span style="color: var(--gray-600); font-size: var(--font-size-sm);">
                    Affichage <?php echo min($pagination['offset'] + 1, $pagination['totalRecords']); ?> à <?php echo min($pagination['offset'] + $pagination['limit'], $pagination['totalRecords']); ?> sur <?php echo $pagination['totalRecords']; ?> fiches
                </span>
                
                <div style="display: flex; gap: var(--spacing-md);">
                    <?php if ($pagination['page'] > 1): ?>
                        <a href="/hr/payroll?month=<?php echo htmlspecialchars($currentMonth); ?>&page=1&limit=<?php echo $pagination['limit']; ?>" 
                           class="nav-btn" title="Première page" style="padding: 6px 12px;">
                            <i class="fas fa-chevron-left"></i> Première
                        </a>
                        <a href="/hr/payroll?month=<?php echo htmlspecialchars($currentMonth); ?>&page=<?php echo $pagination['page'] - 1; ?>&limit=<?php echo $pagination['limit']; ?>" 
                           class="nav-btn" title="Page précédente" style="padding: 6px 12px;">
                            <i class="fas fa-chevron-left"></i> Précédent
                        </a>
                    <?php endif; ?>
                    
                    <!-- Page numbers -->
                    <div style="display: flex; gap: 4px; align-items: center;">
                        <?php
                        $startPage = max(1, $pagination['page'] - 2);
                        $endPage = min($pagination['totalPages'], $pagination['page'] + 2);
                        
                        if ($startPage > 1): ?>
                            <a href="/hr/payroll?month=<?php echo htmlspecialchars($currentMonth); ?>&page=1&limit=<?php echo $pagination['limit']; ?>" 
                               style="padding: 6px 10px; border: 1px solid var(--gray-300); border-radius: var(--border-radius-sm); text-decoration: none; color: var(--primary);">
                                1
                            </a>
                            <?php if ($startPage > 2): ?>
                                <span style="color: var(--gray-400);">...</span>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <?php if ($i == $pagination['page']): ?>
                                <span style="padding: 6px 10px; background: var(--primary); color: white; border-radius: var(--border-radius-sm); font-weight: 600;">
                                    <?php echo $i; ?>
                                </span>
                            <?php else: ?>
                                <a href="/hr/payroll?month=<?php echo htmlspecialchars($currentMonth); ?>&page=<?php echo $i; ?>&limit=<?php echo $pagination['limit']; ?>" 
                                   style="padding: 6px 10px; border: 1px solid var(--gray-300); border-radius: var(--border-radius-sm); text-decoration: none; color: var(--primary);">
                                    <?php echo $i; ?>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>
                        
                        <?php if ($endPage < $pagination['totalPages']): ?>
                            <?php if ($endPage < $pagination['totalPages'] - 1): ?>
                                <span style="color: var(--gray-400);">...</span>
                            <?php endif; ?>
                            <a href="/hr/payroll?month=<?php echo htmlspecialchars($currentMonth); ?>&page=<?php echo $pagination['totalPages']; ?>&limit=<?php echo $pagination['limit']; ?>" 
                               style="padding: 6px 10px; border: 1px solid var(--gray-300); border-radius: var(--border-radius-sm); text-decoration: none; color: var(--primary);">
                                <?php echo $pagination['totalPages']; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($pagination['page'] < $pagination['totalPages']): ?>
                        <a href="/hr/payroll?month=<?php echo htmlspecialchars($currentMonth); ?>&page=<?php echo $pagination['page'] + 1; ?>&limit=<?php echo $pagination['limit']; ?>" 
                           class="nav-btn" title="Page suivante" style="padding: 6px 12px;">
                            Suivant <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="/hr/payroll?month=<?php echo htmlspecialchars($currentMonth); ?>&page=<?php echo $pagination['totalPages']; ?>&limit=<?php echo $pagination['limit']; ?>" 
                           class="nav-btn" title="Dernière page" style="padding: 6px 12px;">
                            Dernière <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>



    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--spacing-lg); margin: var(--spacing-xl);">
        <div class="chart-card" style="background: linear-gradient(135deg, rgba(123, 97, 255, 0.1), rgba(155, 137, 255, 0.05));">
            <div class="chart-content">
                <p style="color: var(--gray-600); font-size: var(--font-size-sm); margin: 0 0 var(--spacing-xs) 0;">Employés Traités</p>
                <h2 style="color: var(--primary); font-size: var(--font-size-4xl); margin: 0;"><?php echo htmlspecialchars($stats['total_employees'] ?? 0); ?></h2>
            </div>
        </div>

        <div class="chart-card" style="background: linear-gradient(135deg, rgba(0, 196, 204, 0.1), rgba(0, 212, 170, 0.05));">
            <div class="chart-content">
                <p style="color: var(--gray-600); font-size: var(--font-size-sm); margin: 0 0 var(--spacing-xs) 0;">Masse Salariale</p>
                <h2 style="color: var(--secondary); font-size: var(--font-size-3xl); margin: 0;">€<?php echo number_format($stats['total_salary_net'] ?? 0, 0, ',', ' '); ?></h2>
            </div>
        </div>

        <div class="chart-card" style="background: linear-gradient(135deg, rgba(0, 212, 170, 0.1), rgba(255, 107, 157, 0.05));">
            <div class="chart-content">
                <p style="color: var(--gray-600); font-size: var(--font-size-sm); margin: 0 0 var(--spacing-xs) 0;">Salaire Moyen</p>
                <h2 style="color: var(--success); font-size: var(--font-size-3xl); margin: 0;">€<?php echo number_format($stats['avg_salary_net'] ?? 0, 0, ',', ' '); ?></h2>
            </div>
        </div>

        <div class="chart-card" style="background: linear-gradient(135deg, rgba(255, 211, 63, 0.1), rgba(255, 107, 157, 0.05));">
            <div class="chart-content">
                <p style="color: var(--gray-600); font-size: var(--font-size-sm); margin: 0 0 var(--spacing-xs) 0;">Cotisations Totales</p>
                <h2 style="color: var(--warning); font-size: var(--font-size-3xl); margin: 0;">€<?php echo number_format($stats['total_social_contributions'] ?? 0, 0, ',', ' '); ?></h2>
            </div>
        </div>
    </div>


</div>

<!-- KPI Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--spacing-lg); margin: var(--spacing-xl);">
    <!-- Total Employees -->
    <div class="chart-card" style="background: linear-gradient(135deg, rgba(123, 97, 255, 0.1), rgba(155, 137, 255, 0.05));">
        <div class="chart-content">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: var(--gray-600); font-size: var(--font-size-sm); margin: 0 0 var(--spacing-xs) 0;">Employés Actifs</p>
                    <h2 style="color: var(--primary); font-size: var(--font-size-4xl); margin: 0;"><?php echo htmlspecialchars($totalEmployees); ?></h2>
                </div>
                <i class="fas fa-users" style="font-size: 2rem; color: rgba(123, 97, 255, 0.3);"></i>
            </div>
        </div>
    </div>

    <!-- Total Payroll -->
    <div class="chart-card" style="background: linear-gradient(135deg, rgba(0, 196, 204, 0.1), rgba(0, 212, 170, 0.05));">
        <div class="chart-content">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: var(--gray-600); font-size: var(--font-size-sm); margin: 0 0 var(--spacing-xs) 0;">Masse Salariale</p>
                    <h2 style="color: var(--secondary); font-size: var(--font-size-3xl); margin: 0;">€<?php echo number_format($totalPayroll, 0, ',', ' '); ?></h2>
                </div>
                <i class="fas fa-euro-sign" style="font-size: 2rem; color: rgba(0, 196, 204, 0.3);"></i>
            </div>
        </div>
    </div>

    <!-- Average Salary -->
    <div class="chart-card" style="background: linear-gradient(135deg, rgba(0, 212, 170, 0.1), rgba(255, 107, 157, 0.05));">
        <div class="chart-content">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: var(--gray-600); font-size: var(--font-size-sm); margin: 0 0 var(--spacing-xs) 0;">Salaire Moyen</p>
                    <h2 style="color: var(--success); font-size: var(--font-size-3xl); margin: 0;">€<?php echo number_format($averageSalary, 0, ',', ' '); ?></h2>
                </div>
                <i class="fas fa-chart-line" style="font-size: 2rem; color: rgba(0, 212, 170, 0.3);"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: var(--spacing-lg); margin: var(--spacing-xl);">

    <!-- Contract Types Chart -->
    <div class="chart-card">
        <div class="chart-header">
            <h3><i class="fas fa-file-contract" style="margin-right: 0.5rem;"></i>Types de Contrats</h3>
        </div>
        <div class="chart-content" style="text-align: center;">
            <canvas id="contractTypesChart" style="max-height: 300px;"></canvas>
            <div style="margin-top: var(--spacing-lg); display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-md);">
                <?php foreach ($contractTypes as $type => $count): ?>
                    <div style="padding: var(--spacing-md); border-radius: var(--border-radius); background: var(--gray-50);">
                        <p style="color: var(--gray-600); font-size: var(--font-size-sm); margin: 0 0 var(--spacing-xs) 0;"><?php echo htmlspecialchars($type); ?></p>
                        <p style="font-size: var(--font-size-xl); font-weight: 600; color: var(--primary); margin: 0;"><?php echo htmlspecialchars($count); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Contract Status Chart -->
    <div class="chart-card">
        <div class="chart-header">
            <h3><i class="fas fa-check-double" style="margin-right: 0.5rem;"></i>Statuts des Contrats</h3>
        </div>
        <div class="chart-content" style="text-align: center;">
            <canvas id="contractStatusChart" style="max-height: 300px;"></canvas>
            <div style="margin-top: var(--spacing-lg); display: grid; grid-template-columns: 1fr; gap: var(--spacing-md);">
                <?php
                $statusLabels = ['active' => 'Actif', 'completed' => 'Terminé', 'suspended' => 'Suspendu'];
                foreach ($contractStatuses as $status => $count):
                    $label = $statusLabels[$status] ?? $status;
                ?>
                    <div style="padding: var(--spacing-md); border-radius: var(--border-radius); background: var(--gray-50); display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: var(--gray-600);"><?php echo htmlspecialchars($label); ?></span>
                        <span style="font-size: var(--font-size-lg); font-weight: 600; color: var(--secondary);"><?php echo htmlspecialchars($count); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Salary Distribution and Monthly Trend -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: var(--spacing-lg); margin: var(--spacing-xl);">

    <!-- Salary Ranges -->
    <div class="chart-card">
        <div class="chart-header">
            <h3><i class="fas fa-bars" style="margin-right: 0.5rem;"></i>Distribution des Salaires</h3>
        </div>
        <div class="chart-content">
            <canvas id="salaryRangeChart" style="max-height: 300px;"></canvas>
        </div>
    </div>

    <!-- Monthly Trend -->
    <div class="chart-card">
        <div class="chart-header">
            <h3><i class="fas fa-chart-area" style="margin-right: 0.5rem;"></i>Tendance Mensuelle</h3>
        </div>
        <div class="chart-content">
            <canvas id="monthlyTrendChart" style="max-height: 300px;"></canvas>
        </div>
    </div>
</div>

<!-- Summary Table -->
<div class="chart-card" style="margin: var(--spacing-xl);">
    <div class="chart-header">
        <h3><i class="fas fa-table" style="margin-right: 0.5rem;"></i>Résumé Financier</h3>
    </div>
    <div class="chart-content">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr style="border-bottom: 2px solid var(--gray-200);">
                    <th style="padding: var(--spacing-md); text-align: left; font-weight: 600; color: var(--gray-700);">Métrique</th>
                    <th style="padding: var(--spacing-md); text-align: right; font-weight: 600; color: var(--gray-700);">Valeur</th>
                </tr>
                <tr style="border-bottom: 1px solid var(--gray-200);">
                    <td style="padding: var(--spacing-md);">Nombre d'Employés</td>
                    <td style="padding: var(--spacing-md); text-align: right; font-weight: 600;"><?php echo htmlspecialchars($totalEmployees); ?></td>
                </tr>
                <tr style="border-bottom: 1px solid var(--gray-200);">
                    <td style="padding: var(--spacing-md);">Masse Salariale Totale</td>
                    <td style="padding: var(--spacing-md); text-align: right; font-weight: 600;">€<?php echo number_format($totalPayroll, 2, ',', ' '); ?></td>
                </tr>
                <tr style="border-bottom: 1px solid var(--gray-200);">
                    <td style="padding: var(--spacing-md);">Salaire Moyen</td>
                    <td style="padding: var(--spacing-md); text-align: right; font-weight: 600;">€<?php echo number_format($averageSalary, 2, ',', ' '); ?></td>
                </tr>
                <tr>
                    <td style="padding: var(--spacing-md); background: var(--gray-50);">Coût Mensuel Estimé</td>
                    <td style="padding: var(--spacing-md); text-align: right; font-weight: 600; background: var(--gray-50); color: var(--primary);">€<?php echo number_format($totalPayroll * 1.42, 2, ',', ' '); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
    // Chart configuration
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'bottom'
            }
        }
    };

    // Contract Types Chart
    const contractTypesCtx = document.getElementById('contractTypesChart').getContext('2d');
    new Chart(contractTypesCtx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode(array_keys($contractTypes)); ?>,
            datasets: [{
                data: <?php echo json_encode(array_values($contractTypes)); ?>,
                backgroundColor: [
                    'rgba(123, 97, 255, 0.8)',
                    'rgba(0, 196, 204, 0.8)',
                    'rgba(255, 107, 157, 0.8)',
                    'rgba(255, 211, 63, 0.8)'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: chartOptions
    });

    // Contract Status Chart
    const contractStatusCtx = document.getElementById('contractStatusChart').getContext('2d');
    new Chart(contractStatusCtx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode(array_map(function ($k) {
                        $m = ['active' => 'Actif', 'completed' => 'Terminé', 'suspended' => 'Suspendu'];
                        return $m[$k] ?? $k;
                    }, array_keys($contractStatuses))); ?>,
            datasets: [{
                data: <?php echo json_encode(array_values($contractStatuses)); ?>,
                backgroundColor: [
                    'rgba(0, 212, 170, 0.8)',
                    'rgba(255, 71, 87, 0.8)',
                    'rgba(255, 211, 63, 0.8)'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: chartOptions
    });

    // Salary Range Chart
    const salaryRangeCtx = document.getElementById('salaryRangeChart').getContext('2d');
    new Chart(salaryRangeCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($salaryRanges)); ?>,
            datasets: [{
                label: 'Nombre d\'Employés',
                data: <?php echo json_encode(array_values($salaryRanges)); ?>,
                backgroundColor: 'rgba(123, 97, 255, 0.8)',
                borderColor: 'rgba(123, 97, 255, 1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            ...chartOptions,
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });

    // Monthly Trend Chart
    const monthlyTrendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
    new Chart(monthlyTrendCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_keys($monthlyTrend)); ?>,
            datasets: [{
                label: 'Masse Salariale (€)',
                data: <?php echo json_encode(array_values($monthlyTrend)); ?>,
                borderColor: 'rgba(0, 196, 204, 1)',
                backgroundColor: 'rgba(0, 196, 204, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(0, 196, 204, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            ...chartOptions,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<script>
    // Handle limit change
    document.getElementById('limitSelect')?.addEventListener('change', function() {
        const limit = this.value;
        const month = new URLSearchParams(window.location.search).get('month') || '<?php echo date('Y-m'); ?>';
        window.location.href = `/hr/payroll?month=${month}&page=1&limit=${limit}`;
    });
</script>

<style>
    @media print {
        .nav-actions {
            display: none;
        }

        .chart-card {
            page-break-inside: avoid;
        }
    }
</style>