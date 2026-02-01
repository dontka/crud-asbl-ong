<?php $pageTitle = 'Ajouter un Événement'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Ajouter un Événement</h1>
    <a href="<?php echo BASE_URL; ?>/events" class="btn btn-secondary">Retour à la liste</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="/events" method="post" data-validate>
                    <input type="hidden" name="action" value="store">
                    <div class="form-group">
                        <label for="title" class="form-label">Titre *</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_date" class="form-label">Date et heure *</label>
                                <input type="datetime-local" class="form-control" id="event_date" name="event_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="location" class="form-label">Lieu</label>
                                <input type="text" class="form-control" id="location" name="location">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="organizer_id" class="form-label">Organisateur</label>
                                <select class="form-control" id="organizer_id" name="organizer_id">
                                    <option value="">Sélectionner un organisateur</option>
                                    <?php if (!empty($organizers)): ?>
                                        <?php foreach ($organizers as $organizer): ?>
                                            <option value="<?php echo $organizer['id']; ?>"><?php echo htmlspecialchars($organizer['username']); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="max_participants" class="form-label">Participants maximum</label>
                                <input type="number" class="form-control" id="max_participants" name="max_participants" min="1">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Statut *</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="planned">Planifié</option>
                            <option value="ongoing">En cours</option>
                            <option value="completed">Terminé</option>
                            <option value="cancelled">Annulé</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Créer l'événement</button>
                        <a href="<?php echo BASE_URL; ?>/events" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>