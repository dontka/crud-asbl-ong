<?php
$pageTitle = $pageTitle ?? 'Fiche de Paie';
$isEdit = isset($payroll) && $payroll;
?>

<div class="main-content">
  
    

    <!-- Form Container -->
    <div style="margin: var(--spacing-xl); max-width: 900px;">
          
        <div class="chart-card">

        <!-- Header -->
        <div class="dashboard-nav">
        <div class="nav-container">
            <div class="nav-left">
                <h1><?php echo $isEdit ? 'Éditer' : 'Créer'; ?> Fiche de Paie</h1>
            </div>
            <div class="nav-actions">
                <a href="/hr/payroll" class="nav-btn">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>
            <div class="chart-header" style="border-bottom: 2px solid var(--gray-100); padding-bottom: var(--spacing-md);">
                <h3>Détails de la Fiche de Paie <?php echo $isEdit ? '#' . htmlspecialchars($payroll['id']) : ''; ?></h3>
            </div>
            <div class="chart-content">
                <form method="POST" style="display: grid; gap: var(--spacing-lg);">

                    <!-- Employee Selection -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);">
                        <div>
                            <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--gray-700);">
                                <i class="fas fa-user" style="margin-right: 0.5rem; color: var(--primary);"></i>Employé
                            </label>
                            <select name="employee_id" required style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                                <option value="">Sélectionner un employé</option>
                                <?php foreach ($employees as $emp): ?>
                                    <option value="<?php echo $emp['id']; ?>"
                                        <?php echo ($emp['id'] == ($payroll['employee_id'] ?? null)) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars(($emp['first_name'] ?? '') . ' ' . ($emp['last_name'] ?? '')); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--gray-700);">
                                <i class="fas fa-calendar" style="margin-right: 0.5rem; color: var(--secondary);"></i>Mois
                            </label>
                            <input type="month" name="payroll_month" value="<?php echo htmlspecialchars(substr($payroll['payroll_month'] ?? date('Y-m'), 0, 7)); ?>" required
                                style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                        </div>
                    </div>

                    <!-- Salary Section -->
                    <div style="border: 2px solid var(--gray-100); border-radius: var(--border-radius); padding: var(--spacing-lg);">
                        <h4 style="color: var(--primary); margin-top: 0;">💰 Rémunération</h4>

                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: var(--spacing-md);">
                            <div>
                                <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 600;">Salaire Brut</label>
                                <input type="number" name="salary_gross" value="<?php echo htmlspecialchars($payroll['salary_gross'] ?? 0); ?>" step="0.01" required
                                    onchange="calculatePayroll()"
                                    style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 600;">Primes</label>
                                <input type="number" name="bonuses" value="<?php echo htmlspecialchars($payroll['bonuses'] ?? 0); ?>" step="0.01"
                                    onchange="calculatePayroll()"
                                    style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 600;">Heures Supplémentaires</label>
                                <input type="number" name="overtime_hours" value="<?php echo htmlspecialchars($payroll['overtime_hours'] ?? 0); ?>" step="0.01"
                                    onchange="calculatePayroll()"
                                    style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                            </div>
                        </div>
                    </div>

                    <!-- Deductions Section -->
                    <div style="border: 2px solid var(--gray-100); border-radius: var(--border-radius); padding: var(--spacing-lg);">
                        <h4 style="color: var(--error); margin-top: 0;">📉 Retenues</h4>

                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: var(--spacing-md);">
                            <div>
                                <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 600;">Cotisations Sociales</label>
                                <input type="number" name="social_contributions" value="<?php echo htmlspecialchars($payroll['social_contributions'] ?? 0); ?>" step="0.01"
                                    onchange="calculatePayroll()"
                                    style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 600;">Taxes</label>
                                <input type="number" name="taxes" value="<?php echo htmlspecialchars($payroll['taxes'] ?? 0); ?>" step="0.01"
                                    onchange="calculatePayroll()"
                                    style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 600;">Autres Retenues</label>
                                <input type="number" name="deductions" value="<?php echo htmlspecialchars($payroll['deductions'] ?? 0); ?>" step="0.01"
                                    onchange="calculatePayroll()"
                                    style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                            </div>
                        </div>
                    </div>

                    <!-- Net Salary Display -->
                    <div style="background: linear-gradient(135deg, rgba(0, 212, 170, 0.1), rgba(0, 196, 204, 0.05)); border: 2px solid rgba(0, 212, 170, 0.3); border-radius: var(--border-radius); padding: var(--spacing-lg); text-align: center;">
                        <p style="color: var(--gray-600); margin: 0 0 var(--spacing-xs) 0;">Salaire Net À Payer</p>
                        <h2 style="color: var(--success); font-size: 2rem; margin: 0;" id="netSalaryDisplay">€<?php echo number_format($payroll['salary_net'] ?? 0, 2, ',', ' '); ?></h2>
                    </div>

                    <!-- Status and Payment Date -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);">
                        <div>
                            <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600;">Statut</label>
                            <select name="status" style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                                <option value="draft" <?php echo ($payroll['status'] ?? 'draft') === 'draft' ? 'selected' : ''; ?>>Brouillon</option>
                                <option value="validated" <?php echo ($payroll['status'] ?? '') === 'validated' ? 'selected' : ''; ?>>Validé</option>
                                <option value="paid" <?php echo ($payroll['status'] ?? '') === 'paid' ? 'selected' : ''; ?>>Payé</option>
                            </select>
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600;">Date de Paiement</label>
                            <input type="date" name="payment_date" value="<?php echo htmlspecialchars($payroll['payment_date'] ?? ''); ?>"
                                style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600;">Notes</label>
                        <textarea name="notes" placeholder="Remarques ou observations..."
                            style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius); min-height: 100px; font-family: inherit;"><?php echo htmlspecialchars($payroll['notes'] ?? ''); ?></textarea>
                    </div>

                    <!-- Hidden field for salary_net -->
                    <input type="hidden" name="salary_net" value="0">

                    <!-- Action Buttons -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-md); padding-top: var(--spacing-md); border-top: 1px solid var(--gray-200);">
                        <a href="/hr/payroll" class="nav-btn" style="text-align: center; padding: var(--spacing-md); background: var(--gray-100); color: var(--gray-700); border: 1px solid var(--gray-300);">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                        <button type="submit" class="nav-btn btn-primary" style="padding: var(--spacing-md); background: linear-gradient(135deg, var(--primary), var(--primary-light)); border: none; color: white; font-weight: 600;">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function calculatePayroll() {
        const salary_gross = parseFloat(document.querySelector('input[name="salary_gross"]').value) || 0;
        const bonuses = parseFloat(document.querySelector('input[name="bonuses"]').value) || 0;
        const deductions = parseFloat(document.querySelector('input[name="deductions"]').value) || 0;
        const social_contributions = parseFloat(document.querySelector('input[name="social_contributions"]').value) || 0;
        const taxes = parseFloat(document.querySelector('input[name="taxes"]').value) || 0;

        const total_gross = salary_gross + bonuses;
        const total_deductions = deductions + social_contributions + taxes;
        const net = total_gross - total_deductions;

        document.getElementById('netSalaryDisplay').textContent = '€' + net.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, ' ');

        // Also update hidden input if needed
        const netInput = document.querySelector('input[name="salary_net"]');
        if (netInput) {
            netInput.value = Math.max(0, net);
        }
    }

    // Calculate on page load
    window.addEventListener('load', calculatePayroll);
</script>