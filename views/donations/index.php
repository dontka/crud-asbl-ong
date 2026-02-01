<?php $pageTitle = 'Gestion des Dons'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Dons</h1>
    <a href="<?php echo BASE_URL; ?>/donations?action=create" class="btn btn-primary">Ajouter un don</a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="project_id" class="form-label">Projet</label>
                <select class="form-control" id="project_id" name="project_id">
                    <option value="">Tous les projets</option>
                    <?php if (!empty($projects)): ?>
                        <?php foreach ($projects as $project): ?>
                            <option value="<?php echo $project['id']; ?>" <?php echo $project_id == $project['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($project['name']); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-secondary w-100">Filtrer</button>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <a href="<?php echo BASE_URL; ?>/donations" class="btn btn-outline-secondary w-100">Réinitialiser</a>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <a href="<?php echo BASE_URL; ?>/donations?action=export" class="btn btn-success w-100">Exporter CSV</a>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h4><?php echo number_format($total_amount, 2, ',', ' '); ?> €</h4>
                <p class="text-muted">Total des dons</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h4><?php echo $total_donations; ?></h4>
                <p class="text-muted">Nombre de dons</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h4><?php echo $total_donations > 0 ? number_format($total_amount / $total_donations, 2, ',', ' ') : '0,00'; ?> €</h4>
                <p class="text-muted">Moyenne par don</p>
            </div>
        </div>
    </div>
</div>

<!-- Donations Table -->
<div class="card">
    <div class="card-body">
        <?php if (!empty($donations)): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Donateur</th>
                            <th>Email</th>
                            <th>Montant</th>
                            <th>Date</th>
                            <th>Projet</th>
                            <th>Méthode</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($donations as $donation): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($donation['donor_name']); ?></td>
                                <td><?php echo htmlspecialchars($donation['donor_email'] ?? ''); ?></td>
                                <td><?php echo number_format($donation['amount'], 2, ',', ' '); ?> €</td>
                                <td><?php echo date('d/m/Y', strtotime($donation['donation_date'])); ?></td>
                                <td><?php echo htmlspecialchars($donation['project_name'] ?? 'Général'); ?></td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?php
                                        echo match ($donation['payment_method']) {
                                            'cash' => 'Espèces',
                                            'bank_transfer' => 'Virement',
                                            'online' => 'En ligne',
                                            default => $donation['payment_method']
                                        };
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/donations?action=show&id=<?php echo $donation['id']; ?>" class="btn btn-sm btn-info">Voir</a>
                                    <a href="<?php echo BASE_URL; ?>/donations?action=edit&id=<?php echo $donation['id']; ?>" class="btn btn-sm btn-warning">Modifier</a>
                                    <a href="<?php echo BASE_URL; ?>/donations?action=delete&id=<?php echo $donation['id']; ?>" class="btn btn-sm btn-danger" data-confirm="Êtes-vous sûr de vouloir supprimer ce don ?">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <p class="text-muted">Aucun don trouvé.</p>
                <a href="<?php echo BASE_URL; ?>/donations?action=create" class="btn btn-primary">Ajouter le premier don</a>
            </div>
        <?php endif; ?>
    </div>
</div>
