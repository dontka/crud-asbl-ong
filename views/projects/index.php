<?php $pageTitle = 'Gestion des Projets'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Projets</h1>
    <a href="<?php echo BASE_URL; ?>/projects?action=create" class="btn btn-primary">Ajouter un projet</a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-6">
                <label for="status" class="form-label">Statut</label>
                <select class="form-control" id="status" name="status">
                    <option value="">Tous</option>
                    <option value="planning" <?php echo $status === 'planning' ? 'selected' : ''; ?>>Planification</option>
                    <option value="active" <?php echo $status === 'active' ? 'selected' : ''; ?>>Actif</option>
                    <option value="completed" <?php echo $status === 'completed' ? 'selected' : ''; ?>>Terminé</option>
                    <option value="on_hold" <?php echo $status === 'on_hold' ? 'selected' : ''; ?>>En attente</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-secondary w-100">Filtrer</button>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <a href="<?php echo BASE_URL; ?>/projects" class="btn btn-outline-secondary w-100">Réinitialiser</a>
            </div>
        </form>
    </div>
</div>

<!-- Projects Table -->
<div class="card">
    <div class="card-body">
        <?php if (!empty($projects)): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th>Budget</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $project): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($project['name']); ?></td>
                                <td><?php echo htmlspecialchars(substr($project['description'] ?? '', 0, 50)) . (strlen($project['description'] ?? '') > 50 ? '...' : ''); ?></td>
                                <td><?php echo $project['start_date'] ? date('d/m/Y', strtotime($project['start_date'])) : '-'; ?></td>
                                <td><?php echo $project['end_date'] ? date('d/m/Y', strtotime($project['end_date'])) : '-'; ?></td>
                                <td><?php echo $project['budget'] ? number_format($project['budget'], 2, ',', ' ') . ' €' : '-'; ?></td>
                                <td>
                                    <span class="badge bg-<?php
                                                            echo match ($project['status']) {
                                                                'planning' => 'secondary',
                                                                'active' => 'success',
                                                                'completed' => 'info',
                                                                'on_hold' => 'warning',
                                                                default => 'secondary'
                                                            };
                                                            ?>">
                                        <?php
                                        echo match ($project['status']) {
                                            'planning' => 'Planification',
                                            'active' => 'Actif',
                                            'completed' => 'Terminé',
                                            'on_hold' => 'En attente',
                                            default => $project['status']
                                        };
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/projects?action=show&id=<?php echo $project['id']; ?>" class="btn btn-sm btn-info">Voir</a>
                                    <a href="<?php echo BASE_URL; ?>/projects?action=edit&id=<?php echo $project['id']; ?>" class="btn btn-sm btn-warning">Modifier</a>
                                    <a href="<?php echo BASE_URL; ?>/projects?action=delete&id=<?php echo $project['id']; ?>" class="btn btn-sm btn-danger" data-confirm="Êtes-vous sûr de vouloir supprimer ce projet ?">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <p class="text-muted">Aucun projet trouvé.</p>
                <a href="<?php echo BASE_URL; ?>/projects?action=create" class="btn btn-primary">Ajouter le premier projet</a>
            </div>
        <?php endif; ?>
    </div>
</div>
