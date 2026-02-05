<?php
$pageTitle = $pageTitle ?? 'Compétence';
$isEdit = isset($skill) && $skill;
?>

<div class="main-content">
    <!-- Header -->
    <div class="dashboard-nav">
        <div class="nav-container">
            <div class="nav-left">
                <h1><i class="fas fa-star" style="margin-right: 0.5rem; color: var(--primary);"></i><?php echo $isEdit ? 'Éditer' : 'Créer'; ?> Compétence</h1>
            </div>
            <div class="nav-actions">
                <a href="/hr/skills" class="nav-btn">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div style="margin: var(--spacing-xl); max-width: 700px;">
        <div class="chart-card">
            <div class="chart-header" style="border-bottom: 2px solid var(--gray-100); padding-bottom: var(--spacing-md);">
                <h3><?php echo $isEdit ? 'Éditer Compétence #' . htmlspecialchars($skill['id']) : 'Nouvelle Compétence'; ?></h3>
            </div>

            <div class="chart-content">
                <?php if (!empty($errors)): ?>
                    <div style="background: #fee; border: 1px solid #fcc; border-radius: var(--border-radius); padding: var(--spacing-md); margin-bottom: var(--spacing-lg); color: #c33;">
                        <h4 style="margin-top: 0;">Erreurs de validation :</h4>
                        <ul style="margin: 0; padding-left: var(--spacing-lg);">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" style="display: grid; gap: var(--spacing-lg);">
                    <!-- Name Field -->
                    <div>
                        <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--gray-700);">
                            <i class="fas fa-tag" style="margin-right: 0.5rem; color: var(--primary);"></i>Nom de la Compétence
                        </label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($skill['name'] ?? ''); ?>" required
                            placeholder="Ex: PHP, JavaScript, Gestion de projet..."
                            style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius); font-size: 1rem;">
                        <small style="color: var(--gray-600); display: block; margin-top: 4px;">Le nom unique de la compétence</small>
                    </div>

                    <!-- Category Field -->
                    <div>
                        <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--gray-700);">
                            <i class="fas fa-folder" style="margin-right: 0.5rem; color: var(--secondary);"></i>Catégorie
                        </label>
                        <select name="category" style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius); font-size: 1rem;">
                            <option value="">Sélectionner une catégorie</option>
                            <option value="Technique" <?php echo ($skill['category'] ?? '') === 'Technique' ? 'selected' : ''; ?>>Technique</option>
                            <option value="Gestion" <?php echo ($skill['category'] ?? '') === 'Gestion' ? 'selected' : ''; ?>>Gestion</option>
                            <option value="Communication" <?php echo ($skill['category'] ?? '') === 'Communication' ? 'selected' : ''; ?>>Communication</option>
                            <option value="Langues" <?php echo ($skill['category'] ?? '') === 'Langues' ? 'selected' : ''; ?>>Langues</option>
                            <option value="Autres" <?php echo ($skill['category'] ?? '') === 'Autres' ? 'selected' : ''; ?>>Autres</option>
                        </select>
                        <small style="color: var(--gray-600); display: block; margin-top: 4px;">Catégorisez la compétence pour mieux l'organiser</small>
                    </div>

                    <!-- Description Field -->
                    <div>
                        <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600; color: var(--gray-700);">
                            <i class="fas fa-align-left" style="margin-right: 0.5rem; color: var(--warning);"></i>Description
                        </label>
                        <textarea name="description" placeholder="Décrivez cette compétence, ses applications, le niveau attendu..."
                            style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--gray-300); border-radius: var(--border-radius); min-height: 120px; font-size: 1rem; font-family: inherit; resize: vertical;"><?php echo htmlspecialchars($skill['description'] ?? ''); ?></textarea>
                        <small style="color: var(--gray-600); display: block; margin-top: 4px;">Informations supplémentaires sur cette compétence</small>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-md); padding-top: var(--spacing-md); border-top: 1px solid var(--gray-200);">
                        <a href="/hr/skills" class="nav-btn" style="text-align: center; padding: var(--spacing-md); background: var(--gray-100); color: var(--gray-700); border: 1px solid var(--gray-300); text-decoration: none;">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                        <button type="submit" class="nav-btn btn-primary" style="padding: var(--spacing-md); background: linear-gradient(135deg, var(--primary), var(--primary-light)); border: none; color: white; font-weight: 600; cursor: pointer;">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .nav-actions {
            display: none;
        }
    }
</style>
