<?php
$pageTitle = $pageTitle ?? 'Créer un Nouveau Contrat';
$isEdit = isset($contract) && !empty($contract);
$formAction = $isEdit ? '/hr/update-contract/' . $contract['id'] : '/hr/store-contract';
?>

<div class="main-content">

    <!-- Form Container -->
    <div style="max-width: auto; margin: var(--spacing-xl);">
        <div class="chart-card">
            <div class="chart-content" style="padding: var(--spacing-xl);">
                <form method="POST" action="<?php echo $formAction; ?>">
                    <!-- Section: Informations Principales -->
                    <div style="margin-bottom: var(--spacing-xl);">
                        <div style="display: flex; justify-content: space-between; align-items: center;">


                            <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-md); border-bottom: 2px solid var(--gray-200);  align-items: center; gap: var(--spacing-md);">
                                <i class="fas fa-user"></i> Informations Principales
                            </h3>
                            <div class="nav-right">
                                <a href="/hr/contracts" class="nav-btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Retour
                                </a>
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);">
                            <!-- Employee -->
                            <div>
                                <label for="employee_id" style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--text-dark);">
                                    <i class="fas fa-user-circle" style="color: var(--primary-color); margin-right: 6px;"></i>
                                    Employé <span style="color: var(--danger-color);">*</span>
                                </label>
                                <select name="employee_id" id="employee_id" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--gray-300); border-radius: 6px; font-size: 0.95rem; background-color: white; cursor: pointer; transition: border-color 0.2s;">
                                    <option value="">Sélectionner un employé</option>
                                    <?php foreach ($employees ?? [] as $emp): ?>
                                        <option value="<?php echo $emp['id']; ?>" <?php echo ($isEdit && $contract['employee_id'] == $emp['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars(($emp['first_name'] ?? '') . ' ' . ($emp['last_name'] ?? '')); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Contract Type -->
                            <div>
                                <label for="contract_type" style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--text-dark);">
                                    <i class="fas fa-file-alt" style="color: var(--primary-color); margin-right: 6px;"></i>
                                    Type de Contrat <span style="color: var(--danger-color);">*</span>
                                </label>
                                <select name="contract_type" id="contract_type" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--gray-300); border-radius: 6px; font-size: 0.95rem; background-color: white; cursor: pointer;">
                                    <option value="">Sélectionner un type</option>
                                    <option value="CDI" <?php echo ($isEdit && $contract['contract_type'] == 'CDI') ? 'selected' : ''; ?>>CDI</option>
                                    <option value="CDD" <?php echo ($isEdit && $contract['contract_type'] == 'CDD') ? 'selected' : ''; ?>>CDD</option>
                                    <option value="Stage" <?php echo ($isEdit && $contract['contract_type'] == 'Stage') ? 'selected' : ''; ?>>Stage</option>
                                    <option value="Temporaire" <?php echo ($isEdit && $contract['contract_type'] == 'Temporaire') ? 'selected' : ''; ?>>Temporaire</option>
                                    <option value="Freelance" <?php echo ($isEdit && $contract['contract_type'] == 'Freelance') ? 'selected' : ''; ?>>Freelance</option>
                                </select>
                            </div>

                            <!-- Contract Number -->
                            <div>
                                <label for="contract_number" style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--text-dark);">
                                    <i class="fas fa-barcode" style="color: var(--primary-color); margin-right: 6px;"></i>
                                    Numéro de Contrat
                                </label>
                                <input type="text" name="contract_number" id="contract_number" placeholder="ex: CTR-2024-001" value="<?php echo $isEdit ? htmlspecialchars($contract['contract_number'] ?? '') : ''; ?>" style="width: 100%; padding: 10px 12px; border: 1px solid var(--gray-300); border-radius: 6px; font-size: 0.95rem; box-sizing: border-box;">
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--text-dark);">
                                    <i class="fas fa-flag" style="color: var(--primary-color); margin-right: 6px;"></i>
                                    Statut
                                </label>
                                <select name="status" id="status" style="width: 100%; padding: 10px 12px; border: 1px solid var(--gray-300); border-radius: 6px; font-size: 0.95rem; background-color: white; cursor: pointer;">
                                    <option value="active" <?php echo ($isEdit && $contract['status'] == 'active') ? 'selected' : ''; ?>>Actif</option>
                                    <option value="inactive" <?php echo ($isEdit && $contract['status'] == 'inactive') ? 'selected' : ''; ?>>Inactif</option>
                                    <option value="ended" <?php echo ($isEdit && $contract['status'] == 'ended') ? 'selected' : ''; ?>>Terminé</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Dates -->
                    <div style="margin-bottom: var(--spacing-xl);">
                        <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-md); border-bottom: 2px solid var(--gray-200); display: flex; align-items: center; gap: var(--spacing-md);">
                            <i class="fas fa-calendar-alt"></i> Dates du Contrat
                        </h3>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);">
                            <!-- Start Date -->
                            <div>
                                <label for="start_date" style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--text-dark);">
                                    <i class="fas fa-play-circle" style="color: var(--primary-color); margin-right: 6px;"></i>
                                    Date de Début <span style="color: var(--danger-color);">*</span>
                                </label>
                                <input type="date" name="start_date" id="start_date" required value="<?php echo $isEdit ? htmlspecialchars($contract['start_date'] ?? '') : ''; ?>" style="width: 100%; padding: 10px 12px; border: 1px solid var(--gray-300); border-radius: 6px; font-size: 0.95rem; box-sizing: border-box;">
                            </div>

                            <!-- End Date -->
                            <div>
                                <label for="end_date" style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--text-dark);">
                                    <i class="fas fa-stop-circle" style="color: var(--primary-color); margin-right: 6px;"></i>
                                    Date de Fin
                                </label>
                                <input type="date" name="end_date" id="end_date" value="<?php echo $isEdit ? htmlspecialchars($contract['end_date'] ?? '') : ''; ?>" style="width: 100%; padding: 10px 12px; border: 1px solid var(--gray-300); border-radius: 6px; font-size: 0.95rem; box-sizing: border-box;">
                            </div>

                            <!-- Renewal Date -->
                            <div>
                                <label for="renewal_date" style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--text-dark);">
                                    <i class="fas fa-redo" style="color: var(--primary-color); margin-right: 6px;"></i>
                                    Date de Renouvellement
                                </label>
                                <input type="date" name="renewal_date" id="renewal_date" value="<?php echo $isEdit ? htmlspecialchars($contract['renewal_date'] ?? '') : ''; ?>" style="width: 100%; padding: 10px 12px; border: 1px solid var(--gray-300); border-radius: 6px; font-size: 0.95rem; box-sizing: border-box;">
                            </div>

                            <!-- Probation End Date -->
                            <div>
                                <label for="probation_end_date" style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--text-dark);">
                                    <i class="fas fa-hourglass-end" style="color: var(--primary-color); margin-right: 6px;"></i>
                                    Date de Fin de Probation
                                </label>
                                <input type="date" name="probation_end_date" id="probation_end_date" value="<?php echo $isEdit ? htmlspecialchars($contract['probation_end_date'] ?? '') : ''; ?>" style="width: 100%; padding: 10px 12px; border: 1px solid var(--gray-300); border-radius: 6px; font-size: 0.95rem; box-sizing: border-box;">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Détails de l'Emploi -->
                    <div style="margin-bottom: var(--spacing-xl);">
                        <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-md); border-bottom: 2px solid var(--gray-200); display: flex; align-items: center; gap: var(--spacing-md);">
                            <i class="fas fa-briefcase"></i> Détails de l'Emploi
                        </h3>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg);">
                            <!-- Position Title -->
                            <div>
                                <label for="position_title" style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--text-dark);">
                                    <i class="fas fa-heading" style="color: var(--primary-color); margin-right: 6px;"></i>
                                    Titre du Poste
                                </label>
                                <input type="text" name="position_title" id="position_title" placeholder="ex: Gestionnaire RH" value="<?php echo $isEdit ? htmlspecialchars($contract['position_title'] ?? '') : ''; ?>" style="width: 100%; padding: 10px 12px; border: 1px solid var(--gray-300); border-radius: 6px; font-size: 0.95rem; box-sizing: border-box;">
                            </div>

                            <!-- Salary -->
                            <div>
                                <label for="salary" style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--text-dark);">
                                    <i class="fas fa-euro-sign" style="color: var(--primary-color); margin-right: 6px;"></i>
                                    Salaire
                                </label>
                                <input type="number" name="salary" id="salary" step="0.01" placeholder="0.00" value="<?php echo $isEdit ? htmlspecialchars($contract['salary'] ?? '') : ''; ?>" style="width: 100%; padding: 10px 12px; border: 1px solid var(--gray-300); border-radius: 6px; font-size: 0.95rem; box-sizing: border-box;">
                            </div>

                            <!-- Working Hours -->
                            <div>
                                <label for="working_hours" style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--text-dark);">
                                    <i class="fas fa-clock" style="color: var(--primary-color); margin-right: 6px;"></i>
                                    Heures de Travail (par semaine)
                                </label>
                                <input type="number" name="working_hours" id="working_hours" step="0.5" placeholder="35" value="<?php echo $isEdit ? htmlspecialchars($contract['working_hours'] ?? '') : ''; ?>" style="width: 100%; padding: 10px 12px; border: 1px solid var(--gray-300); border-radius: 6px; font-size: 0.95rem; box-sizing: border-box;">
                            </div>

                            <!-- Probation Period -->
                            <div>
                                <label for="probation_period_days" style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--text-dark);">
                                    <i class="fas fa-calendar-check" style="color: var(--primary-color); margin-right: 6px;"></i>
                                    Période de Probation (jours)
                                </label>
                                <input type="number" name="probation_period_days" id="probation_period_days" placeholder="90" value="<?php echo $isEdit ? htmlspecialchars($contract['probation_period_days'] ?? '') : ''; ?>" style="width: 100%; padding: 10px 12px; border: 1px solid var(--gray-300); border-radius: 6px; font-size: 0.95rem; box-sizing: border-box;">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Notes -->
                    <div style="margin-bottom: var(--spacing-xl);">
                        <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-lg); padding-bottom: var(--spacing-md); border-bottom: 2px solid var(--gray-200); display: flex; align-items: center; gap: var(--spacing-md);">
                            <i class="fas fa-sticky-note"></i> Informations Supplémentaires
                        </h3>

                        <div>
                            <label for="notes" style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--text-dark);">
                                <i class="fas fa-pen-fancy" style="color: var(--primary-color); margin-right: 6px;"></i>
                                Notes
                            </label>
                            <textarea name="notes" id="notes" rows="4" placeholder="Ajoutez des notes supplémentaires concernant ce contrat..." style="width: 100%; padding: 10px 12px; border: 1px solid var(--gray-300); border-radius: 6px; font-size: 0.95rem; box-sizing: border-box; resize: vertical; font-family: inherit;"><?php echo $isEdit ? htmlspecialchars($contract['notes'] ?? '') : ''; ?></textarea>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div style="display: flex; gap: var(--spacing-md); justify-content: flex-end; padding-top: var(--spacing-lg); border-top: 1px solid var(--gray-200);">
                        <a href="/hr/contracts" style="padding: 10px 20px; border: 1px solid var(--gray-300); background-color: white; color: var(--text-dark); border-radius: 6px; text-decoration: none; font-weight: 600; transition: all 0.3s; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                        <button type="submit" id="submitBtn" style="padding: 10px 24px; background-color: var(--primary-color); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fas fa-save"></i> <?php echo $isEdit ? 'Éditer le Contrat' : 'Créer le Contrat'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Guidelines Section Header -->
    <div style="max-width: auto; margin: var(--spacing-xl) var(--spacing-xl) var(--spacing-lg); ">
        <h3 style="color: var(--primary-color); margin: 0 0 8px 0; font-size: 1.3rem; display: flex; align-items: center; justify-content: center; gap: 10px;">
            <i class="fas fa-book"></i> Guide d'Aide
            <span id="progressBadge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">0/12</span>
        </h3>
        <p style="color: var(--gray-600); margin: 0; font-size: 0.95rem;">Complétez votre contrat avec les conseils ci-dessous</p>



        <!-- Guidelines Progress Bar -->
        <div style="height: 8px; background-color: var(--gray-200); margin: var(--spacing-md) 0; border-radius: 10px; overflow: hidden;">
            <div id="progressBar" style="height: 100%; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); width: 0%; transition: width 0.6s ease; border-radius: 10px;"></div>
        </div>

        <!-- Toggle Guidelines Button -->
        <div style="max-width: auto; margin: 0 var(--spacing-xl) var(--spacing-xl); text-align: center;">
            <button type="button" id="toggleGuidelines" style="padding: 12px 24px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 20px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                <i class="fas fa-eye-slash"></i> <span id="toggleText">Masquer les indications</span>
            </button>
        </div>

        <!-- Guidelines Section -->
        <div style="max-width: auto; margin: var(--spacing-xl); display: grid;  gap: var(--spacing-lg);" id="guidelinesContainer">
            <!-- Tips Card 1 -->
            <div class="chart-card guidelines-card animated-card" data-category="general">
                <div class="card-header" style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;"></div>
                <div class="chart-content" style="padding: var(--spacing-lg); cursor: pointer; transition: all 0.3s; user-select: none;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-md);">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div class="icon-badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.1rem;">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div>
                                <h4 style="color: var(--primary-color); margin: 0; font-size: 1rem;">Informations Générales</h4>
                                <span class="category-status" style="font-size: 0.8rem; color: var(--gray-500); display: block; margin-top: 2px;">0/4 remplis</span>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="status-indicator" style="width: 10px; height: 10px; border-radius: 50%; background-color: var(--gray-300); display: inline-block;"></span>
                            <i class="fas fa-chevron-down toggle-icon" style="color: var(--primary-color); transition: transform 0.3s; font-size: 1.1rem;"></i>
                        </div>
                    </div>
                    <ul class="guidelines-content" style="margin: 0; padding-left: 20px; color: var(--text-dark); line-height: 1.8; max-height: 500px; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                        <li><strong>Employé:</strong> Sélectionnez l'employé concerné. Seuls les employés actifs sont disponibles.</li>
                        <li><strong>Type de Contrat:</strong> Choisissez entre CDI, CDD, Stage, Temporaire ou Freelance.</li>
                        <li><strong>Numéro de Contrat:</strong> Utilisez un format unique (ex: CTR-2024-001) pour traçabilité.</li>
                        <li><strong>Statut:</strong> Définissez le statut du contrat (Actif par défaut).</li>
                    </ul>
                </div>
            </div>

            <!-- Tips Card 2 -->
            <div class="chart-card guidelines-card animated-card" data-category="dates">
                <div class="card-header" style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%); border-radius: 8px 8px 0 0;"></div>
                <div class="chart-content" style="padding: var(--spacing-lg); cursor: pointer; transition: all 0.3s; user-select: none;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-md);">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div class="icon-badge" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.1rem;">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <h4 style="color: #f5576c; margin: 0; font-size: 1rem;">Dates Importantes</h4>
                                <span class="category-status" style="font-size: 0.8rem; color: var(--gray-500); display: block; margin-top: 2px;">0/4 remplis</span>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="status-indicator" style="width: 10px; height: 10px; border-radius: 50%; background-color: var(--gray-300); display: inline-block;"></span>
                            <i class="fas fa-chevron-down toggle-icon" style="color: #f5576c; transition: transform 0.3s; font-size: 1.1rem;"></i>
                        </div>
                    </div>
                    <ul class="guidelines-content" style="margin: 0; padding-left: 20px; color: var(--text-dark); line-height: 1.8; max-height: 500px; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                        <li><strong>Date de Début:</strong> La date officielle du démarrage du contrat (obligatoire).</li>
                        <li><strong>Date de Fin:</strong> Optionnelle pour les CDI. Doit être après la date de début.</li>
                        <li><strong>Probation:</strong> La date de fin est calculée automatiquement à partir du nombre de jours.</li>
                        <li><strong>Renouvellement:</strong> Optionnel. Date de renouvellement ou de révision du contrat.</li>
                    </ul>
                </div>
            </div>

            <!-- Tips Card 3 -->
            <div class="chart-card guidelines-card animated-card" data-category="employment">
                <div class="card-header" style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%); border-radius: 8px 8px 0 0;"></div>
                <div class="chart-content" style="padding: var(--spacing-lg); cursor: pointer; transition: all 0.3s; user-select: none;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-md);">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div class="icon-badge" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.1rem;">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div>
                                <h4 style="color: #00f2fe; margin: 0; font-size: 1rem;">Conditions d'Emploi</h4>
                                <span class="category-status" style="font-size: 0.8rem; color: var(--gray-500); display: block; margin-top: 2px;">0/4 remplis</span>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="status-indicator" style="width: 10px; height: 10px; border-radius: 50%; background-color: var(--gray-300); display: inline-block;"></span>
                            <i class="fas fa-chevron-down toggle-icon" style="color: #00f2fe; transition: transform 0.3s; font-size: 1.1rem;"></i>
                        </div>
                    </div>
                    <ul class="guidelines-content" style="margin: 0; padding-left: 20px; color: var(--text-dark); line-height: 1.8; max-height: 500px; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                        <li><strong>Titre du Poste:</strong> Le titre exact du poste occupé (ex: Gestionnaire RH).</li>
                        <li><strong>Salaire:</strong> Montant brut mensuel. Format décimal accepté (ex: 2500.50).</li>
                        <li><strong>Heures de Travail:</strong> Heures par semaine (ex: 35 pour temps complet).</li>
                        <li><strong>Probation:</strong> Nombre de jours de période d'essai (généralement 90 jours).</li>
                    </ul>
                </div>
            </div>

            <!-- Tips Card 4 -->
            <div class="chart-card guidelines-card animated-card" data-category="practices">
                <div class="card-header" style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%); border-radius: 8px 8px 0 0;"></div>
                <div class="chart-content" style="padding: var(--spacing-lg); cursor: pointer; transition: all 0.3s; user-select: none;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-md);">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div class="icon-badge" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.1rem;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div>
                                <h4 style="color: #38f9d7; margin: 0; font-size: 1rem;">Bonnes Pratiques</h4>
                                <span class="category-status" style="font-size: 0.8rem; color: var(--gray-500); display: block; margin-top: 2px;">0/4 remplis</span>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="status-indicator" style="width: 10px; height: 10px; border-radius: 50%; background-color: var(--gray-300); display: inline-block;"></span>
                            <i class="fas fa-chevron-down toggle-icon" style="color: #38f9d7; transition: transform 0.3s; font-size: 1.1rem;"></i>
                        </div>
                    </div>
                    <ul class="guidelines-content" style="margin: 0; padding-left: 20px; color: var(--text-dark); line-height: 1.8; max-height: 500px; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                        <li>✓ Remplissez tous les champs obligatoires (*) avant de soumettre.</li>
                        <li>✓ Vérifiez que les dates sont cohérentes entre elles.</li>
                        <li>✓ Utilisez des notes pour ajouter des détails importants.</li>
                        <li>✓ Conservez un numéro de contrat unique pour chaque employé.</li>
                    </ul>
                </div>
            </div>
        </div>


    </div>
</div>
<style>
    /* ===== CORE ANIMATIONS ===== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes successSlideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes errorShake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-4px);
        }

        75% {
            transform: translateX(4px);
        }
    }

    @keyframes pulse {

        0%,
        100% {
            box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.4);
        }

        50% {
            box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
        }
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-2px);
        }
    }

    @keyframes highlightPulse {
        from {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.15) 0%, transparent 100%);
        }

        to {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.05) 0%, transparent 100%);
        }
    }

    @keyframes shimmer {
        0% {
            background-position: -200% 0;
        }

        100% {
            background-position: 200% 0;
        }
    }

    @keyframes badgePulse {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.05);
            opacity: 0.9;
        }
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-10px);
        }

        75% {
            transform: translateX(10px);
        }
    }

    /* ===== FORM FIELDS ===== */
    input,
    select,
    textarea {
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        background: linear-gradient(to bottom, white, #fafbfc);
    }

    input:focus,
    select:focus,
    textarea:focus {
        outline: 0;
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15), inset 0 2px 4px rgba(0, 0, 0, 0.05) !important;
        background-color: rgba(102, 126, 234, 0.02);
        transform: translateY(-2px);
    }

    /* ===== FORM LAYOUT ===== */
    form>div {
        animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        opacity: 0;
    }

    form>div:nth-child(1) {
        animation-delay: 0.1s;
    }

    form>div:nth-child(2) {
        animation-delay: 0.2s;
    }

    form>div:nth-child(3) {
        animation-delay: 0.3s;
    }

    form>div:nth-child(4) {
        animation-delay: 0.4s;
    }

    form>div:nth-child(5) {
        animation-delay: 0.5s;
    }

    form>div>div:last-child>div {
        transition: all 0.3s ease;
    }

    form>div>div:last-child>div:hover {
        transform: translateY(-2px);
    }

    /* ===== BUTTONS ===== */
    #submitBtn,
    #toggleGuidelines {
        position: relative;
        overflow: hidden;
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    #submitBtn::after,
    #toggleGuidelines::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    #submitBtn:active::after,
    #toggleGuidelines:active::after {
        width: 300px;
        height: 300px;
    }

    #submitBtn {
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    #submitBtn:not(:disabled):hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
    }

    #submitBtn:not(:disabled):active {
        transform: translateY(-1px);
    }

    a.nav-btn {
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    a.nav-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* ===== MESSAGES ===== */
    .error-message {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 4px;
        display: none;
    }

    .error-message.show {
        display: block;
        animation: errorShake 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .success-badge {
        background-color: #d4edda;
        color: #155724;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.85rem;
        display: none;
        margin-top: 4px;
    }

    .success-badge.show {
        display: block;
        animation: successSlideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .field-error {
        border-color: #dc3545 !important;
        background-color: #fff5f5;
    }

    /* ===== GUIDELINES CARDS ===== */
    .animated-card {
        position: relative;
        overflow: hidden;
        transition: all 0.35s ease;
        animation: slideInUp 0.6s ease-out forwards;
    }

    .animated-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .animated-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    .animated-card:nth-child(3) {
        animation-delay: 0.3s;
    }

    .animated-card:nth-child(4) {
        animation-delay: 0.4s;
    }

    .guidelines-card {
        user-select: none;
    }

    .guidelines-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .guidelines-card:hover .icon-badge {
        animation: pulse 2s infinite;
    }

    .guidelines-card.collapsed .guidelines-content {
        max-height: 0 !important;
        opacity: 0;
        padding: 0;
        margin: 0 !important;
    }

    .guidelines-card.collapsed .toggle-icon {
        transform: rotate(-90deg);
    }

    /* ===== GUIDELINES CONTENT ===== */
    .toggle-icon {
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .guidelines-content {
        margin: 0;
        padding-left: 20px;
        color: var(--text-dark);
        line-height: 1.8;
        max-height: 500px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hidden-guidelines {
        max-height: 0 !important;
        opacity: 0;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        margin: 0 !important;
        padding: 0 !important;
    }

    .status-indicator {
        transition: all 0.3s ease;
        animation: float 3s ease-in-out infinite;
    }

    .guidelines-card.active-category .status-indicator {
        background-color: #43e97b !important;
        box-shadow: 0 0 10px rgba(67, 233, 123, 0.6);
    }

    .guidelines-card.partial-category .status-indicator {
        background-color: #ffd89b !important;
        box-shadow: 0 0 10px rgba(255, 216, 155, 0.6);
    }

    .category-status {
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .guidelines-card.complete .category-status {
        color: #43e97b !important;
    }

    .guidelines-card.highlight {
        border-left: 4px solid var(--primary-color);
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.05) 0%, transparent 100%);
        animation: highlightPulse 0.6s ease;
    }

    /* ===== TOOLTIPS ===== */
    .field-hint {
        position: relative;
        display: inline-block;
    }

    .field-hint .hint-text {
        visibility: hidden;
        width: 220px;
        background: linear-gradient(135deg, var(--primary-color) 0%, #764ba2 100%);
        color: #fff;
        text-align: left;
        padding: 10px 14px;
        border-radius: 8px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        margin-left: -110px;
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 0.85rem;
        line-height: 1.4;
        pointer-events: none;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        transform: translateY(5px);
    }

    .field-hint:hover .hint-text {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
    }

    .field-hint .hint-text::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -6px;
        border-width: 6px;
        border-style: solid;
        border-color: #764ba2 transparent transparent transparent;
    }

    /* ===== TOGGLES ===== */
    #toggleGuidelines {
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    #toggleGuidelines::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transition: left 0.3s ease;
    }

    #toggleGuidelines:hover::before {
        left: 100%;
    }

    #toggleGuidelines:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    }

    #toggleGuidelines:active {
        transform: translateY(-1px);
    }

    /* ===== PROGRESS ===== */
    #progressBar {
        background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        background-size: 200% 100%;
        animation: shimmer 3s ease infinite;
    }

    #progressBadge {
        animation: badgePulse 2s ease-in-out infinite;
    }
</style>

<script>
    // ===== UTILITIES =====
    const debounce = (fn, wait) => {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => fn(...args), wait);
        };
    };
    const $ = id => document.getElementById(id);
    const $$ = sel => document.querySelectorAll(sel);
    const addClass = (el, cls) => el && el.classList.add(cls);
    const removeClass = (el, cls) => el && el.classList.remove(cls);
    const toggleClass = (el, cls) => el && el.classList.toggle(cls);

    // ===== CONFIG =====
    const CATEGORIES = {
        general: ['employee_id', 'contract_type', 'contract_number', 'status'],
        dates: ['start_date', 'end_date', 'renewal_date', 'probation_end_date'],
        employment: ['position_title', 'salary', 'working_hours', 'probation_period_days']
    };
    const FIELD_HINTS = {
        employee_id: '✓ Sélectionnez l\'employé concerné',
        contract_type: '✓ Type de contrat: CDI, CDD, Stage...',
        start_date: '✓ Date officielle de démarrage',
        position_title: '💼 Titre exact du poste',
        salary: '💰 Montant brut mensuel',
        working_hours: '⏰ Heures par semaine'
    };
    const FIELD_TO_GUIDELINE = {
        employee_id: 'general',
        contract_type: 'general',
        contract_number: 'general',
        status: 'general',
        start_date: 'dates',
        end_date: 'dates',
        renewal_date: 'dates',
        probation_end_date: 'dates',
        position_title: 'employment',
        salary: 'employment',
        working_hours: 'employment',
        probation_period_days: 'employment'
    };

    // ===== STATE =====
    let formModified = false;
    const form = $('form') ? document.querySelector('form') : null;
    const req = [$(element.id) for element in document.querySelectorAll('[required]')];

    // ===== PROGRESS TRACKING =====
    const debouncedUpdate = debounce(() => {
        const progress = $('progressBar'),
            badge = $('progressBadge');
        let totalFilled = 0,
            totalFields = 0;

        Object.entries(CATEGORIES).forEach(([cat, fields]) => {
            const card = document.querySelector(`[data-category="${cat}"]`),
                status = card.querySelector('.category-status'),
                indicator = card.querySelector('.status-indicator');
            let filled = fields.filter(id => $$(id) && $(id)?.value?.trim()).length;

            totalFilled += filled;
            totalFields += fields.length;
            status.textContent = `${filled}/${fields.length} remplis`;

            removeClass(card, 'active-category');
            removeClass(card, 'partial-category');
            if (filled === fields.length) {
                addClass(card, 'active-category');
                addClass(card, 'complete');
                indicator.style.backgroundColor = '#43e97b';
                indicator.style.boxShadow = '0 0 10px rgba(67, 233, 123, 0.6)';
            } else if (filled > 0) {
                addClass(card, 'partial-category');
                indicator.style.backgroundColor = '#ffd89b';
                indicator.style.boxShadow = '0 0 10px rgba(255, 216, 155, 0.6)';
            } else {
                indicator.style.backgroundColor = 'var(--gray-300)';
                indicator.style.boxShadow = 'none';
            }
        });

        const pct = totalFields ? Math.round((totalFilled / totalFields) * 100) : 0;
        progress.style.width = pct + '%';
        badge.textContent = `${totalFilled}/${totalFields}`;
    }, 150);

    // ===== GUIDELINES INTERACTION =====
    $$('.guidelines-card').forEach(card => {
        card.addEventListener('click', (e) => {
            if (e.target.closest('.toggle-icon') || e.currentTarget === card) {
                if (!e.target.closest('.toggle-icon')) return;
                toggleClass(card, 'collapsed');
                const icon = card.querySelector('.toggle-icon');
                icon.style.transform = card.classList.contains('collapsed') ? 'rotate(-90deg)' : 'rotate(0)';
            }
        });
        card.querySelector('.chart-content').addEventListener('click', (e) => {
            if (!e.target.closest('.toggle-icon')) {
                toggleClass(card, 'collapsed');
                const icon = card.querySelector('.toggle-icon');
                icon.style.transform = card.classList.contains('collapsed') ? 'rotate(-90deg)' : 'rotate(0)';
            }
        });
    });

    // ===== TOGGLE ALL =====
    const toggleBtn = $('toggleGuidelines'),
        toggleText = $('toggleText'),
        container = $('guidelinesContainer');
    toggleBtn.addEventListener('click', (e) => {
        e.preventDefault();
        toggleClass(container, 'hidden-guidelines');
        const icon = toggleBtn.querySelector('i'),
            hidden = container.classList.contains('hidden-guidelines');
        icon.className = hidden ? 'fas fa-eye' : 'fas fa-eye-slash';
        toggleText.textContent = hidden ? 'Afficher les indications' : 'Masquer les indications';
    });

    // ===== FIELD FOCUS INTERACTION =====
    const showGuidelinesIfHidden = () => {
        if (container.classList.contains('hidden-guidelines')) {
            removeClass(container, 'hidden-guidelines');
            toggleBtn.querySelector('i').className = 'fas fa-eye-slash';
            toggleText.textContent = 'Masquer les indications';
        }
    };

    Object.entries(FIELD_TO_GUIDELINE).forEach(([fieldId, guideline]) => {
        const field = $(fieldId),
            card = document.querySelector(`[data-category="${guideline}"]`);
        if (!field || !card) return;
        field.addEventListener('focus', () => {
            $$('.guidelines-card').forEach(c => removeClass(c, 'highlight'));
            addClass(card, 'highlight');
            if (card.classList.contains('collapsed')) {
                removeClass(card, 'collapsed');
                card.querySelector('.toggle-icon').style.transform = 'rotate(0)';
            }
            showGuidelinesIfHidden();
        });
        field.addEventListener('blur', () => removeClass(card, 'highlight'));
        field.addEventListener('change', () => {
            debouncedUpdate();
            updateSubmit();
        });
        field.addEventListener('input', debounce(() => {
            debouncedUpdate();
            updateSubmit();
        }, 150));
    });

    // ===== FIELD HINTS =====
    Object.entries(FIELD_HINTS).forEach(([fieldId, text]) => {
        const label = document.querySelector(`label[for="${fieldId}"]`);
        if (!label) return;
        label.parentElement.classList.add('field-hint');
        const hint = document.createElement('span');
        hint.className = 'hint-text';
        hint.textContent = text;
        label.appendChild(hint);
    });

    // ===== AUTO-EXPAND GUIDELINES =====
    const updateGuidelines = () => {
        Object.entries(CATEGORIES).forEach(([cat, fields]) => {
            const card = document.querySelector(`[data-category="${cat}"]`);
            const filled = fields.some(id => $(id)?.value?.trim());
            if (filled && card.classList.contains('collapsed')) {
                removeClass(card, 'collapsed');
                card.querySelector('.toggle-icon').style.transform = 'rotate(0)';
            }
        });
    };

    // ===== FORM VALIDATION =====
    const showError = (field, msg) => {
        addClass(field, 'field-error');
        field.style.animation = 'none';
        setTimeout(() => {
            field.style.animation = 'errorShake 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
        }, 10);
        let err = field.parentElement.querySelector('.error-message');
        if (!err) {
            err = document.createElement('div');
            err.className = 'error-message';
            field.parentElement.appendChild(err);
        }
        err.textContent = '⚠ ' + msg;
        addClass(err, 'show');
    };

    const hideError = (field) => {
        removeClass(field, 'field-error');
        const err = field.parentElement.querySelector('.error-message');
        if (err) removeClass(err, 'show');
    };

    const validate = (field) => {
        if (!field.value.trim()) {
            showError(field, 'Ce champ est obligatoire');
            return false;
        }
        hideError(field);
        return true;
    };

    // ===== SUCCESS MESSAGE =====
    const showSuccess = (field, msg) => {
        hideError(field);
        removeClass(field, 'field-error');
        let badge = field.parentElement.querySelector('.success-badge');
        if (!badge) {
            badge = document.createElement('div');
            badge.className = 'success-badge';
            field.parentElement.appendChild(badge);
        }
        badge.textContent = msg;
        removeClass(badge, 'show');
        setTimeout(() => addClass(badge, 'show'), 10);
        setTimeout(() => removeClass(badge, 'show'), 2500);
    };

    // ===== FORM ELEMENTS =====
    const employee = $('employee_id'),
        type = $('contract_type'),
        start = $('start_date'),
        end = $('end_date'),
        probDays = $('probation_period_days'),
        probEnd = $('probation_end_date'),
        salary = $('salary'),
        submit = $('submitBtn');
    const required = [employee, type, start];

    // ===== DATE CALC =====
    const calcProbEnd = () => {
        if (!start.value || !probDays.value) return;
        const date = new Date(start.value),
            days = parseInt(probDays.value),
            endDate = new Date(date.getTime() + days * 86400000);
        probEnd.value = `${endDate.getFullYear()}-${String(endDate.getMonth() + 1).padStart(2, '0')}-${String(endDate.getDate()).padStart(2, '0')}`;
        probEnd.style.animation = 'none';
        setTimeout(() => {
            probEnd.style.animation = 'successSlideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
        }, 10);
        showSuccess(probEnd, 'Date calculée automatiquement');
        debouncedUpdate();
    };

    // ===== EVENT LISTENERS =====
    required.forEach(field => {
        field.addEventListener('change', () => {
            validate(field);
            updateSubmit();
            debouncedUpdate();
        });
        field.addEventListener('blur', () => validate(field));
    });

    [salary, probDays].forEach(field => {
        field.addEventListener('input', debounce(() => {
            if (field.value) validate(field);
            debouncedUpdate();
            updateSubmit();
        }, 300));
    });

    start.addEventListener('change', () => {
        if (end.value && start.value && new Date(end.value) < new Date(start.value)) showError(end, 'La date de fin doit être après la date de début');
        else hideError(end);
        calcProbEnd();
        updateGuidelines();
        debouncedUpdate();
        updateSubmit();
    });

    end.addEventListener('change', () => {
        if (start.value && end.value && new Date(end.value) < new Date(start.value)) showError(end, 'La date de fin doit être après la date de début');
        else hideError(end);
        debouncedUpdate();
        updateSubmit();
    });

    salary.addEventListener('change', () => {
        if (salary.value) {
            const sal = parseFloat(salary.value);
            if (sal > 0) {
                salary.value = sal.toFixed(2);
                salary.style.animation = 'successSlideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
                showSuccess(salary, '✓ Salaire valide');
            } else showError(salary, 'Le salaire doit être positif');
        }
        updateGuidelines();
        debouncedUpdate();
        updateSubmit();
    });

    probDays.addEventListener('change', () => {
        if (probDays.value) {
            const days = parseInt(probDays.value);
            if (days > 0 && days <= 365) {
                calcProbEnd();
                showSuccess(probDays, `${days} jours de probation`);
            } else showError(probDays, 'La période doit être entre 1 et 365 jours');
        }
        debouncedUpdate();
        updateSubmit();
    });

    // ===== SUBMIT =====
    const updateSubmit = () => {
        const valid = required.every(f => f.value.trim());
        submit.disabled = !valid;
        submit.style.opacity = valid ? '1' : '0.6';
        submit.style.cursor = valid ? 'pointer' : 'not-allowed';
    };

    form.addEventListener('submit', (e) => {
        let valid = true;
        required.forEach(f => {
            if (!validate(f)) valid = false;
        });
        if (start.value && end.value && new Date(end.value) < new Date(start.value)) {
            showError(end, 'La date de fin doit être après la date de début');
            valid = false;
        }
        if (salary.value && isNaN(parseFloat(salary.value))) {
            showError(salary, 'Veuillez entrer un nombre valide');
            valid = false;
        }
        if (!valid) {
            e.preventDefault();
            submit.style.animation = 'shake 0.5s';
            setTimeout(() => {
                submit.style.animation = '';
            }, 500);
        }
    });

    form.addEventListener('change', () => {
        formModified = true;
        updateGuidelines();
    });
    window.addEventListener('beforeunload', (e) => {
        if (formModified) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
    form.addEventListener('submit', () => {
        formModified = false;
    });

    // ===== INIT =====
    updateSubmit();
    debouncedUpdate();
</script>