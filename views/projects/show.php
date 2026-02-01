<?php $pageTitle = 'Détails du Projet'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?php echo htmlspecialchars($project['name']); ?></h1>
    <div>
        <a href="<?php echo BASE_URL; ?>/projects?action=edit&id=<?php echo $project['id']; ?>" class="btn btn-warning">Modifier</a>
        <a href="<?php echo BASE_URL; ?>/projects" class="btn btn-secondary">Retour à la liste</a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Informations du projet</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Nom</dt>
                    <dd class="col-sm-9"><?php echo htmlspecialchars($project['name']); ?></dd>

                    <dt class="col-sm-3">Description</dt>
                    <dd class="col-sm-9"><?php echo nl2br(htmlspecialchars($project['description'] ?? 'Aucune description')); ?></dd>

                    <dt class="col-sm-3">Date de début</dt>
                    <dd class="col-sm-9"><?php echo $project['start_date'] ? date('d/m/Y', strtotime($project['start_date'])) : 'Non définie'; ?></dd>

                    <dt class="col-sm-3">Date de fin</dt>
                    <dd class="col-sm-9"><?php echo $project['end_date'] ? date('d/m/Y', strtotime($project['end_date'])) : 'Non définie'; ?></dd>

                    <dt class="col-sm-3">Budget</dt>
                    <dd class="col-sm-9"><?php echo $project['budget'] ? number_format($project['budget'], 2, ',', ' ') . ' €' : 'Non défini'; ?></dd>

                    <dt class="col-sm-3">Statut</dt>
                    <dd class="col-sm-9">
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
                    </dd>

                    <dt class="col-sm-3">Responsable</dt>
                    <dd class="col-sm-9"><?php echo htmlspecialchars($project['manager_name'] ?? 'Non assigné'); ?></dd>

                    <dt class="col-sm-3">Date de création</dt>
                    <dd class="col-sm-9"><?php echo date('d/m/Y H:i', strtotime($project['created_at'])); ?></dd>

                    <dt class="col-sm-3">Dernière modification</dt>
                    <dd class="col-sm-9"><?php echo date('d/m/Y H:i', strtotime($project['updated_at'])); ?></dd>
                </dl>
            </div>
        </div>

        <!-- Donations liées au projet -->
        <?php if (!empty($project_donations)): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Dons reçus pour ce projet</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Donateur</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($project_donations as $donation): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($donation['donor_name']); ?></td>
                                        <td><?php echo number_format($donation['amount'], 2, ',', ' '); ?> €</td>
                                        <td><?php echo date('d/m/Y', strtotime($donation['donation_date'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th><?php echo number_format(array_sum(array_column($project_donations, 'amount')), 2, ',', ' '); ?> €</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?php echo BASE_URL; ?>/projects?action=edit&id=<?php echo $project['id']; ?>" class="btn btn-warning">Modifier le projet</a>
                    <a href="<?php echo BASE_URL; ?>/donations?project_id=<?php echo $project['id']; ?>" class="btn btn-success">Voir les dons</a>
                    <a href="<?php echo BASE_URL; ?>/projects?action=delete&id=<?php echo $project['id']; ?>" class="btn btn-danger" data-confirm="Êtes-vous sûr de vouloir supprimer ce projet ? Cette action est irréversible.">Supprimer le projet</a>
                </div>
            </div>
        </div>
    </div>
</div>
