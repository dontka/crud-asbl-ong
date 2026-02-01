<?php $pageTitle = 'Gestion des Utilisateurs'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Utilisateurs</h1>
    <a href="<?php echo BASE_URL; ?>/users?action=create" class="btn btn-primary">Ajouter un utilisateur</a>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-body">
        <?php if (!empty($users)): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom d'utilisateur</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <span class="badge bg-<?php
                                                            echo match ($user['role']) {
                                                                'admin' => 'danger',
                                                                'moderator' => 'warning',
                                                                'visitor' => 'info',
                                                                default => 'secondary'
                                                            };
                                                            ?>">
                                        <?php
                                        echo match ($user['role']) {
                                            'admin' => 'Administrateur',
                                            'moderator' => 'Modérateur',
                                            'visitor' => 'Visiteur',
                                            default => $user['role']
                                        };
                                        ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/users?action=edit&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-warning">Modifier</a>
                                    <?php if ($user['id'] != $_SESSION['user']['id']): ?>
                                        <a href="<?php echo BASE_URL; ?>/users?action=delete&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" data-confirm="Êtes-vous sûr de vouloir supprimer cet utilisateur ?">Supprimer</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <p class="text-muted">Aucun utilisateur trouvé.</p>
                <a href="<?php echo BASE_URL; ?>/users?action=create" class="btn btn-primary">Ajouter le premier utilisateur</a>
            </div>
        <?php endif; ?>
    </div>
</div>
