<?php
$pageTitle = $pageTitle ?? 'Gestion des Évaluations';
$stats = $stats ?? [];
$departments = $departments ?? [];
$selectedDepartment = $selectedDepartment ?? null;
$selectedYear = $selectedYear ?? date('Y');
$evaluationStatus = $evaluationStatus ?? null;
$years = $years ?? [date('Y')];
$evaluations = $evaluations ?? [];
$allEmployees = $allEmployees ?? [];
$employeesByDept = $employeesByDept ?? [];
?>

<div class="main-content">
    <!-- Header -->
    <div class="dashboard-nav">
        <div class="nav-container">
            <div class="nav-left">
                <h1><i class="fas fa-clipboard-check" style="margin-right: 0.5rem; color: var(--primary);"></i>Gestion des Évaluations</h1>
            </div>
            <div class="nav-actions">
                <button onclick="openEvalModal()" class="nav-btn btn-primary" style="border: none; cursor: pointer;">
                    <i class="fas fa-plus"></i> Nouvelle Évaluation
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--spacing-lg); margin: var(--spacing-xl);">
        <div class="chart-card">
            <div class="chart-header">
                <h3 style="margin: 0;"><i class="fas fa-users" style="margin-right: 0.5rem; color: var(--primary);"></i>Total Employés</h3>
            </div>
            <div class="chart-content">
                <p style="font-size: 2rem; font-weight: bold; color: var(--primary); margin: 0;">
                    <?php echo $stats['total_employees'] ?? 0; ?>
                </p>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h3 style="margin: 0;"><i class="fas fa-file-check" style="margin-right: 0.5rem; color: var(--secondary);"></i>Évaluations</h3>
            </div>
            <div class="chart-content">
                <p style="font-size: 2rem; font-weight: bold; color: var(--secondary); margin: 0;">
                    <?php echo $stats['total_evaluations'] ?? 0; ?>
                </p>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h3 style="margin: 0;"><i class="fas fa-sitemap" style="margin-right: 0.5rem; color: var(--warning);"></i>Services</h3>
            </div>
            <div class="chart-content">
                <p style="font-size: 2rem; font-weight: bold; color: var(--warning); margin: 0;">
                    <?php echo $stats['departments'] ?? 0; ?>
                </p>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h3 style="margin: 0;"><i class="fas fa-star" style="margin-right: 0.5rem; color: var(--success);"></i>Note Moyenne</h3>
            </div>
            <div class="chart-content">
                <p style="font-size: 2rem; font-weight: bold; color: var(--success); margin: 0;">
                    <?php echo number_format($stats['average_score'] ?? 0, 2); ?>/10
                </p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="chart-card" style="margin: var(--spacing-xl);">
        <div class="chart-header" style="border-bottom: 2px solid var(--gray-100); padding-bottom: var(--spacing-md);">
            <h3><i class="fas fa-filter" style="margin-right: 0.5rem;"></i>Filtres</h3>
        </div>
        <div class="chart-content">
            <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--spacing-md);">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--gray-700);">Service</label>
                    <select name="department" onchange="this.form.submit();" style="width: 100%; padding: var(--spacing-sm); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                        <option value="">Tous les services</option>
                        <?php foreach ($departments as $dept => $count): ?>
                            <option value="<?php echo htmlspecialchars($dept); ?>" <?php echo $selectedDepartment === $dept ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($dept); ?> (<?php echo $count; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--gray-700);">Année</label>
                    <select name="year" onchange="this.form.submit();" style="width: 100%; padding: var(--spacing-sm); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                        <?php foreach ($years as $year): ?>
                            <option value="<?php echo $year; ?>" <?php echo $selectedYear == $year ? 'selected' : ''; ?>>
                                <?php echo $year; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--gray-700);">Statut</label>
                    <select name="status" onchange="this.form.submit();" style="width: 100%; padding: var(--spacing-sm); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                        <option value="">Tous les statuts</option>
                        <option value="draft" <?php echo $evaluationStatus === 'draft' ? 'selected' : ''; ?>>Brouillon</option>
                        <option value="submitted" <?php echo $evaluationStatus === 'submitted' ? 'selected' : ''; ?>>Soumis</option>
                        <option value="reviewed" <?php echo $evaluationStatus === 'reviewed' ? 'selected' : ''; ?>>Examiné</option>
                        <option value="finalized" <?php echo $evaluationStatus === 'finalized' ? 'selected' : ''; ?>>Finalisé</option>
                    </select>
                </div>

                <div style="display: flex; align-items: flex-end;">
                    <a href="/hr/evaluations" class="nav-btn" style="background: var(--gray-100); color: var(--gray-700); padding: var(--spacing-sm); text-decoration: none; border-radius: var(--border-radius); border: 1px solid var(--gray-300); width: 100%; text-align: center;">
                        <i class="fas fa-redo"></i> Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Evaluations by Department -->
    <?php if (!empty($evaluations)): ?>
        <div class="chart-card" style="margin: var(--spacing-xl);">
            <div class="chart-header" style="border-bottom: 2px solid var(--gray-100); padding-bottom: var(--spacing-md);">
                <h3><i class="fas fa-list" style="margin-right: 0.5rem;"></i>Évaluations (<?php echo count($evaluations); ?>)</h3>
            </div>
            <div class="chart-content">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--gray-200);">
                                <th style="padding: var(--spacing-md); text-align: left; font-weight: 600;">Employé</th>
                                <th style="padding: var(--spacing-md); text-align: left; font-weight: 600;">Service</th>
                                <th style="padding: var(--spacing-md); text-align: left; font-weight: 600;">Évaluateur</th>
                                <th style="padding: var(--spacing-md); text-align: center; font-weight: 600;">Date</th>
                                <th style="padding: var(--spacing-md); text-align: center; font-weight: 600;">Note</th>
                                <th style="padding: var(--spacing-md); text-align: center; font-weight: 600;">Statut</th>
                                <th style="padding: var(--spacing-md); text-align: center; font-weight: 600;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($evaluations as $evaluation): ?>
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: var(--spacing-md);">
                                        <strong><?php echo htmlspecialchars($evaluation['employee_name'] ?? 'N/A'); ?></strong>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <?php echo htmlspecialchars($evaluation['department'] ?? 'N/A'); ?>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <?php echo htmlspecialchars($evaluation['evaluator_name'] ?? '-'); ?>
                                    </td>
                                    <td style="padding: var(--spacing-md); text-align: center;">
                                        <?php echo $evaluation['evaluation_date'] ? date('d/m/Y', strtotime($evaluation['evaluation_date'])) : '-'; ?>
                                    </td>
                                    <td style="padding: var(--spacing-md); text-align: center;">
                                        <strong style="font-size: 1.1rem;">
                                            <?php if (!empty($evaluation['overall_score'])): ?>
                                                <span style="color: var(--primary);"><?php echo $evaluation['overall_score']; ?>/10</span>
                                            <?php else: ?>
                                                <span style="color: var(--gray-400);">-</span>
                                            <?php endif; ?>
                                        </strong>
                                    </td>
                                    <td style="padding: var(--spacing-md); text-align: center;">
                                        <?php
                                        $status = $evaluation['status'] ?? 'draft';
                                        $statusColors = [
                                            'draft' => ['bg' => '#fff3cd', 'color' => '#856404'],
                                            'submitted' => ['bg' => '#d1ecf1', 'color' => '#0c5460'],
                                            'reviewed' => ['bg' => '#e2e3e5', 'color' => '#383d41'],
                                            'finalized' => ['bg' => '#d4edda', 'color' => '#155724']
                                        ];
                                        $colors = $statusColors[$status] ?? ['bg' => '#e2e3e5', 'color' => '#383d41'];
                                        ?>
                                        <span style="display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 0.875rem; background-color: <?php echo $colors['bg']; ?>; color: <?php echo $colors['color']; ?>;">
                                            <?php echo ucfirst(str_replace('_', ' ', $status)); ?>
                                        </span>
                                    </td>
                                    <td style="padding: var(--spacing-md); text-align: center;">
                                        <button onclick="openEvalModal(null, <?php echo $evaluation['id']; ?>)" class="btn-link" style="margin-right: 8px; background: none; border: none; cursor: pointer;" title="Éditer">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="/hr/evaluation/<?php echo $evaluation['id']; ?>/view" class="btn-link" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="chart-card" style="margin: var(--spacing-xl);">
            <div class="chart-content" style="text-align: center; padding: var(--spacing-xl);">
                <i class="fas fa-inbox" style="font-size: 3rem; color: var(--gray-300); margin-bottom: var(--spacing-md);"></i>
                <p style="color: var(--gray-500); font-size: 1.1rem;">Aucune évaluation trouvée pour les critères sélectionnés.</p>
                <p style="color: var(--gray-400); margin-bottom: var(--spacing-lg);">Créez une nouvelle évaluation pour commencer.</p>
                <button onclick="openEvalModal()" class="nav-btn btn-primary" style="border: none; cursor: pointer;">
                    <i class="fas fa-plus"></i> Créer une Évaluation
                </button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Employees to Evaluate by Department -->
    <div class="chart-card" style="margin: var(--spacing-xl);">
        <div class="chart-header" style="border-bottom: 2px solid var(--gray-100); padding-bottom: var(--spacing-md);">
            <h3><i class="fas fa-users-check" style="margin-right: 0.5rem;"></i>Employés à Évaluer par Service</h3>
        </div>
        <div class="chart-content">
            <?php if (!empty($employeesByDept)): ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-lg);">
                    <?php foreach ($employeesByDept as $dept => $employees): ?>
                        <div style="border: 1px solid var(--gray-200); border-radius: var(--border-radius); padding: var(--spacing-md);">
                            <h4 style="margin: 0 0 var(--spacing-md) 0; padding-bottom: var(--spacing-sm); border-bottom: 2px solid var(--primary); color: var(--primary);">
                                <?php echo htmlspecialchars($dept); ?> (<?php echo count($employees); ?>)
                            </h4>
                            <ul style="list-style: none; margin: 0; padding: 0;">
                                <?php foreach ($employees as $emp): ?>
                                    <li style="padding: 8px 0; border-bottom: 1px solid var(--gray-100); display: flex; justify-content: space-between; align-items: center;">
                                        <span>
                                            <?php echo htmlspecialchars($emp['first_name'] ?? '' . ' ' . $emp['last_name'] ?? ''); ?>
                                        </span>
                                        <button onclick="openEvalModal(<?php echo $emp['id']; ?>)" class="nav-btn" style="padding: 4px 8px; font-size: 0.875rem; background: var(--primary); color: white; border: none; cursor: pointer; border-radius: 4px;">
                                            <i class="fas fa-plus"></i> Évaluer
                                        </button>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="text-align: center; color: var(--gray-500);">Aucun employé actif disponible.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

</div>

<!-- Modal for Creating Evaluation -->
<div id="evaluationModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); z-index: 1000; padding: 20px;">
    <div class="modal-content" style="background: white; border-radius: 8px; padding: 30px; max-width: 600px; margin: auto; max-height: 90vh; overflow-y: auto; margin-top: 50px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0;">Créer une Évaluation</h2>
            <button onclick="closeEvalModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--gray-500);">&times;</button>
        </div>

        <form id="evalForm" method="POST" action="/hr/evaluations" style="display: grid; gap: 15px;">
            <!-- Employee Selection -->
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--gray-700);">Employé <span style="color: var(--error);">*</span></label>
                <select id="employeeSelect" name="employee_id" required style="width: 100%; padding: 10px; border: 1px solid var(--gray-300); border-radius: 4px;">
                    <option value="">Sélectionner un employé</option>
                    <?php foreach ($allEmployees as $emp): ?>
                        <option value="<?php echo $emp['id']; ?>">
                            <?php echo htmlspecialchars($emp['first_name'] . ' ' . $emp['last_name'] . ' - ' . ($emp['department'] ?? '')); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Evaluation Date -->
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--gray-700);">Date d'évaluation <span style="color: var(--error);">*</span></label>
                <input type="date" name="evaluation_date" value="<?php echo date('Y-m-d'); ?>" required style="width: 100%; padding: 10px; border: 1px solid var(--gray-300); border-radius: 4px;">
            </div>

            <!-- Evaluation Year -->
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--gray-700);">Année d'évaluation <span style="color: var(--error);">*</span></label>
                <input type="number" name="evaluation_year" value="<?php echo date('Y'); ?>" required style="width: 100%; padding: 10px; border: 1px solid var(--gray-300); border-radius: 4px;">
            </div>

            <!-- Scores Grid -->
            <fieldset style="border: 1px solid var(--gray-200); padding: 15px; border-radius: 4px;">
                <legend style="padding: 0 10px; font-weight: 600;">Scores (0-10)</legend>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-size: 0.9rem; color: var(--gray-700);">Connaissances</label>
                        <input type="number" name="job_knowledge" min="0" max="10" step="0.5" style="width: 100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-size: 0.9rem; color: var(--gray-700);">Performance</label>
                        <input type="number" name="performance" min="0" max="10" step="0.5" style="width: 100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-size: 0.9rem; color: var(--gray-700);">Travail d'équipe</label>
                        <input type="number" name="teamwork" min="0" max="10" step="0.5" style="width: 100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-size: 0.9rem; color: var(--gray-700);">Communication</label>
                        <input type="number" name="communication" min="0" max="10" step="0.5" style="width: 100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-size: 0.9rem; color: var(--gray-700);">Initiative</label>
                        <input type="number" name="initiative" min="0" max="10" step="0.5" style="width: 100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-size: 0.9rem; color: var(--gray-700);">Présence</label>
                        <input type="number" name="attendance" min="0" max="10" step="0.5" style="width: 100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px;">
                    </div>
                </div>
            </fieldset>

            <!-- Overall Score -->
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--gray-700);">Note générale (0-10)</label>
                <input type="number" name="overall_score" min="0" max="10" step="0.5" style="width: 100%; padding: 10px; border: 1px solid var(--gray-300); border-radius: 4px;">
            </div>

            <!-- General Comments -->
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--gray-700);">Commentaires généraux</label>
                <textarea name="general_comments" rows="4" style="width: 100%; padding: 10px; border: 1px solid var(--gray-300); border-radius: 4px; resize: vertical;"></textarea>
            </div>

            <!-- Status -->
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--gray-700);">Statut</label>
                <select name="status" style="width: 100%; padding: 10px; border: 1px solid var(--gray-300); border-radius: 4px;">
                    <option value="draft">Brouillon</option>
                    <option value="submitted">Soumis</option>
                    <option value="reviewed">Examiné</option>
                    <option value="finalized">Finalisé</option>
                </select>
            </div>

            <!-- Buttons -->
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="submit" class="nav-btn btn-primary" style="flex: 1;">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
                <button type="button" onclick="closeEvalModal()" class="nav-btn" style="flex: 1; background: var(--gray-200); color: var(--gray-700);">
                    <i class="fas fa-times"></i> Annuler
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .btn-link {
        color: var(--primary);
        text-decoration: none;
        cursor: pointer;
        transition: color 0.2s;
    }
    .btn-link:hover {
        color: var(--primary-light);
    }
    
    .modal {
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    function openEvalModal(employeeId = null) {
        const modal = document.getElementById('evaluationModal');
        const select = document.getElementById('employeeSelect');
        
        if (employeeId) {
            select.value = employeeId;
        }
        
        modal.style.display = 'block';
    }
    
    function closeEvalModal() {
        const modal = document.getElementById('evaluationModal');
        modal.style.display = 'none';
        // Reset form
        document.getElementById('evalForm').reset();
        document.getElementById('employeeSelect').value = '';
    }
    
    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('evaluationModal');
        if (event.target === modal) {
            closeEvalModal();
        }
    });
</script>