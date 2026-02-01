<?php $pageTitle = 'Détails du Don'; ?>

<div class="row">
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/donations">Dons</a></li>
                <li class="breadcrumb-item active">Don #<?php echo $donation['id']; ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Détails du Don</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Montant:</strong> <?php echo number_format($donation['amount'], 2, ',', ' '); ?> €</p>
                        <p><strong>Méthode de paiement:</strong> <?php echo htmlspecialchars($donation['payment_method'] ?? 'Non spécifié'); ?></p>
                        <p><strong>Statut:</strong>
                            <span class="badge badge-success">
                                Confirmé
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Donateur:</strong> <?php echo htmlspecialchars($donation['donor_name'] ?? 'Anonyme'); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($donation['donor_email'] ?? 'N/A'); ?></p>
                        <p><strong>Date:</strong> <?php echo date('d/m/Y H:i', strtotime($donation['created_at'])); ?></p>
                    </div>
                </div>

                <?php if (!empty($donation['notes'])): ?>
                    <div class="mt-3">
                        <h5>Notes</h5>
                        <p><?php echo nl2br(htmlspecialchars($donation['notes'])); ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($donation['project_id'])): ?>
                    <div class="mt-3">
                        <h5>Projet associé</h5>
                        <p><a href="<?php echo BASE_URL; ?>/projects?action=show&id=<?php echo $donation['project_id']; ?>">
                                Voir le projet
                            </a></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Actions</h5>
            </div>
            <div class="card-body">
                <a href="<?php echo BASE_URL; ?>/donations?action=edit&id=<?php echo $donation['id']; ?>" class="btn btn-primary btn-block mb-2">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="<?php echo BASE_URL; ?>/donations" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
            </div>
        </div>
    </div>
</div>