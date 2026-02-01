<?php $pageTitle = 'Ajouter un Utilisateur'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Ajouter un Utilisateur</h1>
    <a href="<?php echo BASE_URL; ?>/users" class="btn btn-secondary">Retour à la liste</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="/users" method="post" data-validate>
                    <input type="hidden" name="action" value="store">
                    <div class="form-group">
                        <label for="username" class="form-label">Nom d'utilisateur *</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                        <div class="form-text">Le nom d'utilisateur doit être unique.</div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="form-text">L'email doit être unique.</div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Mot de passe *</label>
                        <input type="password" class="form-control" id="password" name="password" required minlength="6">
                        <div class="form-text">Le mot de passe doit contenir au moins 6 caractères.</div>
                    </div>

                    <div class="form-group">
                        <label for="role" class="form-label">Rôle *</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="visitor">Visiteur</option>
                            <option value="moderator">Modérateur</option>
                            <option value="admin">Administrateur</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Créer l'utilisateur</button>
                        <a href="<?php echo BASE_URL; ?>/users" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>