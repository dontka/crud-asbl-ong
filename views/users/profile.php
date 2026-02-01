<?php $pageTitle = 'Mon Profil'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Mon Profil</h1>
    <a href="<?php echo BASE_URL; ?>/dashboard" class="btn btn-secondary">Retour au dashboard</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Informations du profil</h5>
            </div>
            <div class="card-body">
                <form action="/profile" method="post" data-validate>
                    <div class="form-group">
                        <label for="username" class="form-label">Nom d'utilisateur *</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                        <div class="form-text">Le nom d'utilisateur doit être unique.</div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        <div class="form-text">L'email doit être unique.</div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" minlength="6">
                        <div class="form-text">Laissez vide pour conserver le mot de passe actuel. Minimum 6 caractères.</div>
                    </div>

                    <div class="form-group">
                        <p><strong>Rôle :</strong> <?php
                                                    echo match ($user['role']) {
                                                        'admin' => 'Administrateur',
                                                        'moderator' => 'Modérateur',
                                                        'visitor' => 'Visiteur',
                                                        default => $user['role']
                                                    };
                                                    ?></p>
                        <p><strong>Date d'inscription :</strong> <?php echo date('d/m/Y', strtotime($user['created_at'])); ?></p>
                        <p><strong>Dernière modification :</strong> <?php echo date('d/m/Y H:i', strtotime($user['updated_at'])); ?></p>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Mettre à jour le profil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>