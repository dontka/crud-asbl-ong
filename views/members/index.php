<?php $pageTitle = 'Gestion des Membres'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Membres</h1>
    <div>
        <a href="<?php echo BASE_URL; ?>/members?action=export<?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($status) ? '&status=' . urlencode($status) : ''; ?>" class="btn btn-success me-2">
            <i class="fas fa-download"></i> Exporter CSV
        </a>
        <a href="<?php echo BASE_URL; ?>/members?action=create" class="btn btn-primary">Ajouter un membre</a>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Rechercher</label>
                <input type="text" class="form-control" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Nom, prénom ou email">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Statut</label>
                <select class="form-control" id="status" name="status">
                    <option value="">Tous</option>
                    <option value="active" <?php echo $status === 'active' ? 'selected' : ''; ?>>Actif</option>
                    <option value="inactive" <?php echo $status === 'inactive' ? 'selected' : ''; ?>>Inactif</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-secondary w-100">Filtrer</button>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <a href="<?php echo BASE_URL; ?>/members" class="btn btn-outline-secondary w-100">Réinitialiser</a>
            </div>
        </form>
    </div>
</div>

<!-- Members Table -->
<div class="card">
    <div class="card-body">
        <?php if (!empty($members)): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Date d'adhésion</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $member): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($member['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($member['first_name']); ?></td>
                                <td><?php echo htmlspecialchars($member['email']); ?></td>
                                <td><?php echo htmlspecialchars($member['phone'] ?? ''); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($member['join_date'])); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $member['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                        <?php echo $member['status'] === 'active' ? 'Actif' : 'Inactif'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/members?action=show&id=<?php echo $member['id']; ?>" class="btn btn-sm btn-info">Voir</a>
                                    <a href="<?php echo BASE_URL; ?>/members?action=edit&id=<?php echo $member['id']; ?>" class="btn btn-sm btn-warning">Modifier</a>
                                    <a href="<?php echo BASE_URL; ?>/members?action=delete&id=<?php echo $member['id']; ?>" class="btn btn-sm btn-danger" data-confirm="Êtes-vous sûr de vouloir supprimer ce membre ?">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <p class="text-muted">Aucun membre trouvé.</p>
                <a href="<?php echo BASE_URL; ?>/members?action=create" class="btn btn-primary">Ajouter le premier membre</a>
            </div>
        <?php endif; ?>
    </div>
</div>