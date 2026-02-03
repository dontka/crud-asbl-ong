<?php
$pageTitle = $pageTitle ?? 'Fiche de Paie';
$isEdit = isset($payroll) && $payroll;
?>

<div class="main-content">
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

    <!-- Form Container -->
    <div style="margin: var(--spacing-xl); max-width: 900px;">
        <div class="chart-card">
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
                            <select name="employe_id" required style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                                <option value="">Sélectionner un employé</option>
                                <?php foreach ($employees as $emp): ?>
                                    <option value="<?php echo $emp['id']; ?>"
                                        <?php echo ($emp['id'] == ($payroll['employe_id'] ?? null)) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars(($emp['first_name'] ?? '') . ' ' . ($emp['last_name'] ?? '')); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--gray-700);">
                                <i class="fas fa-calendar" style="margin-right: 0.5rem; color: var(--secondary);"></i>Mois
                            </label>
                            <input type="month" name="mois" value="<?php echo htmlspecialchars(substr($payroll['mois'] ?? date('Y-m'), 0, 7)); ?>" required
                                style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                        </div>
                    </div>

                    <!-- Salary Section -->
                    <div style="border: 2px solid var(--gray-100); border-radius: var(--border-radius); padding: var(--spacing-lg);">
                        <h4 style="color: var(--primary); margin-top: 0;">💰 Rémunération</h4>

                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: var(--spacing-md);">
                            <div>
                                <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 600;">Salaire Base</label>
                                <input type="number" name="salaire_base" value="<?php echo htmlspecialchars($payroll['salaire_base'] ?? 0); ?>" step="0.01" required
                                    onchange="calculatePayroll()"
                                    style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 600;">Primes</label>
                                <input type="number" name="prime" value="<?php echo htmlspecialchars($payroll['prime'] ?? 0); ?>" step="0.01"
                                    onchange="calculatePayroll()"
                                    style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 600;">Gratification</label>
                                <input type="number" name="gratification" value="<?php echo htmlspecialchars($payroll['gratification'] ?? 0); ?>" step="0.01"
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
                                <input type="number" name="cotisation_sociale" value="<?php echo htmlspecialchars($payroll['cotisation_sociale'] ?? 0); ?>" step="0.01"
                                    onchange="calculatePayroll()"
                                    style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 600;">Impôt sur le Revenu</label>
                                <input type="number" name="impot_revenu" value="<?php echo htmlspecialchars($payroll['impot_revenu'] ?? 0); ?>" step="0.01"
                                    onchange="calculatePayroll()"
                                    style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 600;">Autres Retenues</label>
                                <input type="number" name="autres_retenues" value="<?php echo htmlspecialchars($payroll['autres_retenues'] ?? 0); ?>" step="0.01"
                                    onchange="calculatePayroll()"
                                    style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                            </div>
                        </div>
                    </div>

                    <!-- Net Salary Display -->
                    <div style="background: linear-gradient(135deg, rgba(0, 212, 170, 0.1), rgba(0, 196, 204, 0.05)); border: 2px solid rgba(0, 212, 170, 0.3); border-radius: var(--border-radius); padding: var(--spacing-lg); text-align: center;">
                        <p style="color: var(--gray-600); margin: 0 0 var(--spacing-xs) 0;">Salaire Net À Payer</p>
                        <h2 style="color: var(--success); font-size: 2rem; margin: 0;" id="netSalaryDisplay">€<?php echo number_format($payroll['salaire_net'] ?? 0, 2, ',', ' '); ?></h2>
                    </div>

                    <!-- Status and Payment Date -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);">
                        <div>
                            <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600;">Statut</label>
                            <select name="statut" style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                                <option value="brouillon" <?php echo ($payroll['statut'] ?? 'brouillon') === 'brouillon' ? 'selected' : ''; ?>>Brouillon</option>
                                <option value="valide" <?php echo ($payroll['statut'] ?? '') === 'valide' ? 'selected' : ''; ?>>Validé</option>
                                <option value="paye" <?php echo ($payroll['statut'] ?? '') === 'paye' ? 'selected' : ''; ?>>Payé</option>
                            </select>
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600;">Date de Paiement</label>
                            <input type="date" name="date_paiement" value="<?php echo htmlspecialchars($payroll['date_paiement'] ?? ''); ?>"
                                style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600;">Notes</label>
                        <textarea name="notes" placeholder="Remarques ou observations..."
                            style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius); min-height: 100px; font-family: inherit;"><?php echo htmlspecialchars($payroll['notes'] ?? ''); ?></textarea>
                    </div>

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
        const salaire_base = parseFloat(document.querySelector('input[name="salaire_base"]').value) || 0;
        const prime = parseFloat(document.querySelector('input[name="prime"]').value) || 0;
        const gratification = parseFloat(document.querySelector('input[name="gratification"]').value) || 0;
        const cotisation = parseFloat(document.querySelector('input[name="cotisation_sociale"]').value) || 0;
        const impot = parseFloat(document.querySelector('input[name="impot_revenu"]').value) || 0;
        const autres = parseFloat(document.querySelector('input[name="autres_retenues"]').value) || 0;

        const brut = salaire_base + prime + gratification;
        const net = brut - cotisation - impot - autres;

        document.getElementById('netSalaryDisplay').textContent = '€' + net.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, ' ');

        // Also update hidden input if needed
        const netInput = document.querySelector('input[name="salaire_net"]');
        if (netInput) {
            netInput.value = Math.max(0, net);
        }
    }

    // Calculate on page load
    window.addEventListener('load', calculatePayroll);
</script>