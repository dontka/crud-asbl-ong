<?php $pageTitle = 'Ajouter un Projet'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Ajouter un Projet</h1>
    <a href="<?php echo BASE_URL; ?>/projects" class="btn btn-secondary">Retour à la liste</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="/projects" method="post" data-validate>
                    <input type="hidden" name="action" value="store">
                    <div class="form-group">
                        <label for="name" class="form-label">Nom du projet *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date" class="form-label">Date de début</label>
                                <input type="date" class="form-control" id="start_date" name="start_date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date" class="form-label">Date de fin</label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="budget" class="form-label">Budget (€)</label>
                        <input type="number" class="form-control" id="budget" name="budget" step="0.01" min="0">
                        <div class="form-text">Laissez vide si pas de budget défini.</div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Statut *</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="planning">Planification</option>
                            <option value="active">Actif</option>
                            <option value="completed">Terminé</option>
                            <option value="on_hold">En attente</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="manager_id" class="form-label">Responsable</label>
                        <select class="form-control" id="manager_id" name="manager_id">
                            <option value="">Sélectionner un responsable</option>
                            <?php if (!empty($managers)): ?>
                                <?php foreach ($managers as $manager): ?>
                                    <option value="<?php echo $manager['id']; ?>"><?php echo htmlspecialchars($manager['username']); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <div class="form-text">Seuls les administrateurs et modérateurs peuvent être responsables.</div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Créer le projet</button>
                        <a href="<?php echo BASE_URL; ?>/projects" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>