<?php $pageTitle = 'Modifier un Projet'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Modifier un Projet</h1>
    <a href="<?php echo BASE_URL; ?>/projects" class="btn btn-secondary">Retour à la liste</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="/projects" method="post" data-validate>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo $project['id']; ?>">

                    <div class="form-group">
                        <label for="name" class="form-label">Nom du projet *</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($project['name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($project['description'] ?? ''); ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date" class="form-label">Date de début</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $project['start_date'] ?? ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date" class="form-label">Date de fin</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $project['end_date'] ?? ''; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="budget" class="form-label">Budget (€)</label>
                        <input type="number" class="form-control" id="budget" name="budget" step="0.01" min="0" value="<?php echo $project['budget'] ?? ''; ?>">
                        <div class="form-text">Laissez vide si pas de budget défini.</div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Statut *</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="planning" <?php echo $project['status'] === 'planning' ? 'selected' : ''; ?>>Planification</option>
                            <option value="active" <?php echo $project['status'] === 'active' ? 'selected' : ''; ?>>Actif</option>
                            <option value="completed" <?php echo $project['status'] === 'completed' ? 'selected' : ''; ?>>Terminé</option>
                            <option value="on_hold" <?php echo $project['status'] === 'on_hold' ? 'selected' : ''; ?>>En attente</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="manager_id" class="form-label">Responsable</label>
                        <select class="form-control" id="manager_id" name="manager_id">
                            <option value="">Sélectionner un responsable</option>
                            <?php if (!empty($managers)): ?>
                                <?php foreach ($managers as $manager): ?>
                                    <option value="<?php echo $manager['id']; ?>" <?php echo ($project['manager_id'] == $manager['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($manager['username']); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <div class="form-text">Seuls les administrateurs et modérateurs peuvent être responsables.</div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        <a href="<?php echo BASE_URL; ?>/projects" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>