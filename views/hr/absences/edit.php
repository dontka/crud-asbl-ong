<?php
$pageTitle = $pageTitle ?? 'Édition de l\'Absence';
$isEdit = true;
?>

<div class="main-content">
    <!-- Header 

 <div class="dashboard-nav">
        <div class="nav-container">
            <div class="nav-left">
                <h1><i class="fas fa-calendar-times" style="margin-right: 0.5rem; color: var(--primary);"></i>Éditer Absence</h1>
            </div>
            <div class="nav-actions">
                <a href="/hr/absences" class="nav-btn">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>
   Edit Form Container -->
    <div style="max-width: auto; margin: var(--spacing-xl);">
        <div class="chart-card">
            <div class="chart-content" style="padding: var(--spacing-xl);">
                <div class="chart-header" style="border-bottom: 2px solid var(--gray-100); padding-bottom: var(--spacing-md);">
                    <h3>Détails de l'Absence #<?php echo htmlspecialchars($absence['id'] ?? ''); ?></h3>
                </div>

                <form method="POST" action="/hr/absence/<?php echo $absence['id'] ?? ''; ?>/edit">

                    <!-- Employee Selection -->
                    <div style="margin-bottom: var(--spacing-lg);">
                        <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--gray-700);">
                            <i class="fas fa-user" style="margin-right: 0.5rem; color: var(--primary);"></i>Employé
                        </label>
                        <select name="employe_id" required style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius); font-size: var(--font-size); transition: var(--transition);" onchange="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--gray-300)'">
                            <option value="">Sélectionner un employé</option>
                            <?php foreach ($employees as $emp): ?>
                                <option value="<?php echo $emp['id']; ?>"
                                    <?php echo ($emp['id'] == ($absence['employe_id'] ?? null)) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars(($emp['first_name'] ?? '') . ' ' . ($emp['last_name'] ?? '')); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Absence Type -->
                    <div style="margin-bottom: var(--spacing-lg);">
                        <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--gray-700);">
                            <i class="fas fa-list" style="margin-right: 0.5rem; color: var(--secondary);"></i>Type d'Absence
                        </label>
                        <select name="type" required style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius); font-size: var(--font-size); transition: var(--transition);" onchange="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--gray-300)'">
                            <option value="">Sélectionner un type</option>
                            <?php foreach ($absenceTypes as $key => $label): ?>
                                <option value="<?php echo htmlspecialchars($key); ?>"
                                    <?php echo ($key == ($absence['type'] ?? null)) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Dates Row -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-md); margin-bottom: var(--spacing-lg);">
                        <!-- Start Date -->
                        <div>
                            <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--gray-700);">
                                <i class="fas fa-calendar-check" style="margin-right: 0.5rem; color: var(--success);"></i>Début
                            </label>
                            <input type="date" name="start_date" value="<?php echo htmlspecialchars($absence['start_date'] ?? ''); ?>" required
                                style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius); font-size: var(--font-size); transition: var(--transition);" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--gray-300)'">
                        </div>

                        <!-- End Date -->
                        <div>
                            <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--gray-700);">
                                <i class="fas fa-calendar-times" style="margin-right: 0.5rem; color: var(--error);"></i>Fin
                            </label>
                            <input type="date" name="end_date" value="<?php echo htmlspecialchars($absence['end_date'] ?? ''); ?>" required
                                style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius); font-size: var(--font-size); transition: var(--transition);" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--gray-300)'">
                        </div>
                    </div>

                    <!-- Status -->
                    <div style="margin-bottom: var(--spacing-lg);">
                        <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--gray-700);">
                            <i class="fas fa-check-circle" style="margin-right: 0.5rem; color: var(--info);"></i>Statut
                        </label>
                        <select name="status" required style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius); font-size: var(--font-size); transition: var(--transition);" onchange="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--gray-300)'">
                            <option value="">Sélectionner un statut</option>
                            <?php foreach ($statuses as $key => $label): ?>
                                <option value="<?php echo htmlspecialchars($key); ?>"
                                    <?php echo ($key == ($absence['status'] ?? null)) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-md); margin-top: var(--spacing-xl); padding-top: var(--spacing-md); border-top: 1px solid var(--gray-200);">
                        <a href="/hr/absences" class="nav-btn" style="text-align: center; padding: var(--spacing-md); background: var(--gray-100); color: var(--gray-700); border: 1px solid var(--gray-300); transition: var(--transition);" onmouseover="this.style.background='var(--gray-200)'" onmouseout="this.style.background='var(--gray-100)'">
                            <i class="fas fa-times" style="margin-right: 0.5rem;"></i>Annuler
                        </a>
                        <button type="submit" class="nav-btn btn-primary" style="padding: var(--spacing-md); background: linear-gradient(135deg, var(--primary), var(--primary-light)); border: none; color: white; font-weight: 600; transition: var(--transition);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--shadow-lg)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-md)'">
                            <i class="fas fa-save" style="margin-right: 0.5rem;"></i>Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div style="max-width: auto; margin: var(--spacing-xl) var(--spacing-xl) var(--spacing-lg); ">
        <!-- Current Status Card -->
        <div class="chart-card" style="background: linear-gradient(135deg, rgba(123, 97, 255, 0.1), rgba(0, 196, 204, 0.05)); border: 1px solid rgba(123, 97, 255, 0.2);">
            <div class="chart-header" style="border: none;">
                <h4 style="font-size: var(--font-size-sm); text-transform: uppercase; color: var(--primary); margin: 0;">Statut Actuel</h4>
            </div>
            <div class="chart-content" style="text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; margin: var(--spacing-md) 0;">
                    <span style="display: inline-block; padding: var(--spacing-sm) var(--spacing-md); border-radius: var(--border-radius); 
                            <?php
                            $status = $absence['status'] ?? 'demande';
                            if ($status === 'valide') echo 'background: #d4edda; color: #155724;';
                            elseif ($status === 'refuse') echo 'background: #f8d7da; color: #721c24;';
                            else echo 'background: #fff3cd; color: #856404;';
                            ?>">
                        <?php
                        $statusMap = ['demande' => 'En attente', 'valide' => 'Approuvée', 'refuse' => 'Rejetée'];
                        echo htmlspecialchars($statusMap[$status] ?? $status);
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Info -->
        <div class="chart-card" style="margin-top: var(--spacing-lg);">
            <div class="chart-header" style="border: none;">
                <h4 style="font-size: var(--font-size-sm); text-transform: uppercase; color: var(--gray-700); margin: 0;">Infos</h4>
            </div>
            <div class="chart-content" style="font-size: var(--font-size-sm);">
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-md); padding-bottom: var(--spacing-md); border-bottom: 1px solid var(--gray-200);">
                    <span style="color: var(--gray-600);">ID:</span>
                    <strong style="color: var(--gray-900);"><?php echo htmlspecialchars($absence['id'] ?? ''); ?></strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-md); padding-bottom: var(--spacing-md); border-bottom: 1px solid var(--gray-200);">
                    <span style="color: var(--gray-600);">Type:</span>
                    <strong style="color: var(--gray-900);"><?php echo htmlspecialchars($absenceTypes[$absence['type'] ?? 'conge'] ?? $absence['type'] ?? ''); ?></strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--gray-600);">Durée:</span>
                    <strong style="color: var(--gray-900);">
                        <?php
                        $start = new DateTime($absence['start_date'] ?? '');
                        $end = new DateTime($absence['end_date'] ?? '');
                        $diff = $end->diff($start);
                        echo htmlspecialchars(($diff->days + 1) . ' jour(s)');
                        ?>
                    </strong>
                </div>
            </div>
        </div>

        <!-- Help Text -->
        <div style="background: rgba(55, 66, 250, 0.05); border: 1px solid rgba(55, 66, 250, 0.2); border-radius: var(--border-radius); padding: var(--spacing-md); font-size: var(--font-size-sm); color: var(--info); margin-top: var(--spacing-lg);">
            <p style="margin: 0;"><strong>💡 Conseil:</strong> Modifiez les informations et cliquez sur "Enregistrer" pour mettre à jour.</p>
        </div>
    </div>
</div>
</div>

<style>
    @media (max-width: 1024px) {
        div[style*="grid-template-columns: 1fr 300px"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>