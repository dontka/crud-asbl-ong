<?php $pageTitle = 'Détails du Membre'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?></h1>
    <div>
        <a href="<?php echo BASE_URL; ?>/members?action=edit&id=<?php echo $member['id']; ?>" class="btn btn-warning">Modifier</a>
        <a href="<?php echo BASE_URL; ?>/members" class="btn btn-secondary">Retour à la liste</a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Informations personnelles</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Prénom</dt>
                    <dd class="col-sm-9"><?php echo htmlspecialchars($member['first_name']); ?></dd>

                    <dt class="col-sm-3">Nom</dt>
                    <dd class="col-sm-9"><?php echo htmlspecialchars($member['last_name']); ?></dd>

                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9"><?php echo htmlspecialchars($member['email']); ?></dd>

                    <dt class="col-sm-3">Téléphone</dt>
                    <dd class="col-sm-9"><?php echo htmlspecialchars($member['phone'] ?? 'Non spécifié'); ?></dd>

                    <dt class="col-sm-3">Adresse</dt>
                    <dd class="col-sm-9"><?php echo nl2br(htmlspecialchars($member['address'] ?? 'Non spécifiée')); ?></dd>

                    <dt class="col-sm-3">Date d'adhésion</dt>
                    <dd class="col-sm-9"><?php echo date('d/m/Y', strtotime($member['join_date'])); ?></dd>

                    <dt class="col-sm-3">Statut</dt>
                    <dd class="col-sm-9">
                        <span class="badge bg-<?php echo $member['status'] === 'active' ? 'success' : 'secondary'; ?>">
                            <?php echo $member['status'] === 'active' ? 'Actif' : 'Inactif'; ?>
                        </span>
                    </dd>

                    <dt class="col-sm-3">Date de création</dt>
                    <dd class="col-sm-9"><?php echo date('d/m/Y H:i', strtotime($member['created_at'])); ?></dd>

                    <dt class="col-sm-3">Dernière modification</dt>
                    <dd class="col-sm-9"><?php echo date('d/m/Y H:i', strtotime($member['updated_at'])); ?></dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?php echo BASE_URL; ?>/members?action=edit&id=<?php echo $member['id']; ?>" class="btn btn-warning">Modifier les informations</a>
                    <a href="mailto:<?php echo htmlspecialchars($member['email']); ?>" class="btn btn-info">Envoyer un email</a>
                    <?php if (!empty($member['phone'])): ?>
                        <a href="tel:<?php echo htmlspecialchars($member['phone']); ?>" class="btn btn-info">Appeler</a>
                    <?php endif; ?>
                    <a href="<?php echo BASE_URL; ?>/members?action=delete&id=<?php echo $member['id']; ?>" class="btn btn-danger" data-confirm="Êtes-vous sûr de vouloir supprimer ce membre ? Cette action est irréversible.">Supprimer le membre</a>
                </div>
            </div>
        </div>
    </div>
</div>
