<?php $pageTitle = 'Gestion des Événements'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Événements</h1>
    <a href="<?php echo BASE_URL; ?>/events?action=create" class="btn btn-primary">Ajouter un événement</a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-6">
                <label for="status" class="form-label">Statut</label>
                <select class="form-control" id="status" name="status">
                    <option value="">Tous</option>
                    <option value="planned" <?php echo $status === 'planned' ? 'selected' : ''; ?>>Planifié</option>
                    <option value="ongoing" <?php echo $status === 'ongoing' ? 'selected' : ''; ?>>En cours</option>
                    <option value="completed" <?php echo $status === 'completed' ? 'selected' : ''; ?>>Terminé</option>
                    <option value="cancelled" <?php echo $status === 'cancelled' ? 'selected' : ''; ?>>Annulé</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-secondary w-100">Filtrer</button>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <a href="<?php echo BASE_URL; ?>/events" class="btn btn-outline-secondary w-100">Réinitialiser</a>
            </div>
        </form>
    </div>
</div>

<!-- Events Table -->
<div class="card">
    <div class="card-body">
        <?php if (!empty($events)): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Date</th>
                            <th>Lieu</th>
                            <th>Participants max</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $event): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($event['title']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($event['event_date'])); ?></td>
                                <td><?php echo htmlspecialchars($event['location'] ?? ''); ?></td>
                                <td><?php echo $event['max_participants'] ?? '-'; ?></td>
                                <td>
                                    <span class="badge bg-<?php
                                                            echo match ($event['status']) {
                                                                'planned' => 'secondary',
                                                                'ongoing' => 'success',
                                                                'completed' => 'info',
                                                                'cancelled' => 'danger',
                                                                default => 'secondary'
                                                            };
                                                            ?>">
                                        <?php
                                        echo match ($event['status']) {
                                            'planned' => 'Planifié',
                                            'ongoing' => 'En cours',
                                            'completed' => 'Terminé',
                                            'cancelled' => 'Annulé',
                                            default => $event['status']
                                        };
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/events?action=show&id=<?php echo $event['id']; ?>" class="btn btn-sm btn-info">Voir</a>
                                    <a href="<?php echo BASE_URL; ?>/events?action=edit&id=<?php echo $event['id']; ?>" class="btn btn-sm btn-warning">Modifier</a>
                                    <a href="<?php echo BASE_URL; ?>/events?action=delete&id=<?php echo $event['id']; ?>" class="btn btn-sm btn-danger" data-confirm="Êtes-vous sûr de vouloir supprimer cet événement ?">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <p class="text-muted">Aucun événement trouvé.</p>
                <a href="<?php echo BASE_URL; ?>/events?action=create" class="btn btn-primary">Ajouter le premier événement</a>
            </div>
        <?php endif; ?>
    </div>
</div>
