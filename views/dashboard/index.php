<?php $pageTitle = 'Dashboard'; ?>

<div class="hero-section fade-in-up">
    <div class="container">
        <h1>Tableau de Bord</h1>
        <p>Bienvenue, <?php echo htmlspecialchars($user['username']); ?> ! Gérez votre ASBL-ONG avec créativité et efficacité.</p>
    </div>
</div>

<div class="container">
    <div class="feature-grid">
        <div class="feature-card">
            <i class="fas fa-users"></i>
            <h3><?php echo $stats['total_members'] ?? 0; ?></h3>
            <p>Membres actifs</p>
            <a href="<?php echo BASE_URL; ?>/members" class="btn btn-primary">Voir les membres</a>
        </div>

        <div class="feature-card">
            <i class="fas fa-project-diagram"></i>
            <h3><?php echo $stats['total_projects'] ?? 0; ?></h3>
            <p>Projets actifs</p>
            <a href="<?php echo BASE_URL; ?>/projects" class="btn btn-primary">Voir les projets</a>
        </div>

        <div class="feature-card">
            <i class="fas fa-calendar-alt"></i>
            <h3><?php echo $stats['total_events'] ?? 0; ?></h3>
            <p>Événements totaux</p>
            <a href="<?php echo BASE_URL; ?>/events" class="btn btn-primary">Voir les événements</a>
        </div>

        <div class="feature-card">
            <i class="fas fa-euro-sign"></i>
            <h3><?php echo number_format($stats['total_donations'] ?? 0, 2, ',', ' '); ?> €</h3>
            <p>Total des dons</p>
            <a href="<?php echo BASE_URL; ?>/donations" class="btn btn-primary">Voir les dons</a>
        </div>

        <div class="feature-card">
            <i class="fas fa-calendar-check"></i>
            <h3><?php echo $stats['upcoming_events'] ?? 0; ?></h3>
            <p>Événements à venir (30j)</p>
            <a href="<?php echo BASE_URL; ?>/events" class="btn btn-primary">Voir les événements</a>
        </div>

        <div class="feature-card">
            <i class="fas fa-hand-holding-heart"></i>
            <h3><?php echo $stats['recent_donations_count'] ?? 0; ?></h3>
            <p>Dons récents (30j)</p>
            <a href="<?php echo BASE_URL; ?>/donations" class="btn btn-primary">Voir les dons</a>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Derniers membres</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_members)): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($recent_members as $member): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?>
                                <small class="text-muted"><?php echo date('d/m/Y', strtotime($member['join_date'])); ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Aucun membre récent.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Événements à venir</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($upcoming_events)): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($upcoming_events as $event): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($event['title']); ?>
                                <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($event['event_date'])); ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Aucun événement à venir.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Dons récents</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_donations)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Donateur</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                    <th>Projet</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_donations as $donation): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($donation['donor_name']); ?></td>
                                        <td><?php echo number_format($donation['amount'], 2, ',', ' '); ?> €</td>
                                        <td><?php echo date('d/m/Y', strtotime($donation['donation_date'])); ?></td>
                                        <td><?php echo htmlspecialchars($donation['project_name'] ?? 'Général'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Aucun don récent.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>