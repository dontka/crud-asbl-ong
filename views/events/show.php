<?php $pageTitle = 'Détails de l\'Événement'; ?>

<div class="row">
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/events">Événements</a></li>
                <li class="breadcrumb-item active"><?php echo htmlspecialchars($event['title']); ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Date:</strong> <?php echo date('d/m/Y H:i', strtotime($event['event_date'])); ?></p>
                        <p><strong>Lieu:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                        <p><strong>Statut:</strong>
                            <span class="badge badge-<?php echo $event['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                <?php echo $event['status'] === 'active' ? 'Actif' : 'Inactif'; ?>
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Capacité:</strong> <?php echo $event['capacity']; ?> personnes</p>
                        <p><strong>Inscrits:</strong> <?php echo $event['registered_count'] ?? 0; ?> personnes</p>
                        <p><strong>Créé le:</strong> <?php echo date('d/m/Y', strtotime($event['created_at'])); ?></p>
                    </div>
                </div>

                <div class="mt-3">
                    <h5>Description</h5>
                    <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Actions</h5>
            </div>
            <div class="card-body">
                <a href="<?php echo BASE_URL; ?>/events?action=edit&id=<?php echo $event['id']; ?>" class="btn btn-primary btn-block mb-2">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="<?php echo BASE_URL; ?>/events" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
            </div>
        </div>
    </div>
</div>