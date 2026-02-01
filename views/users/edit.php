<?php $pageTitle = 'Modifier un Utilisateur'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Modifier un Utilisateur</h1>
    <a href="<?php echo BASE_URL; ?>/users" class="btn btn-secondary">Retour à la liste</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="/users" method="post" data-validate>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

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
                        <label for="role" class="form-label">Rôle *</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="visitor" <?php echo $user['role'] === 'visitor' ? 'selected' : ''; ?>>Visiteur</option>
                            <option value="moderator" <?php echo $user['role'] === 'moderator' ? 'selected' : ''; ?>>Modérateur</option>
                            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrateur</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        <a href="<?php echo BASE_URL; ?>/users" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>