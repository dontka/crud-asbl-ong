<?php $pageTitle = 'Modifier un Don'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Modifier un Don</h1>
    <a href="<?php echo BASE_URL; ?>/donations" class="btn btn-secondary">Retour à la liste</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="/donations" method="post" data-validate>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo $donation['id']; ?>">

                    <div class="form-group">
                        <label for="donor_name" class="form-label">Nom du donateur *</label>
                        <input type="text" class="form-control" id="donor_name" name="donor_name" value="<?php echo htmlspecialchars($donation['donor_name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="donor_email" class="form-label">Email du donateur</label>
                        <input type="email" class="form-control" id="donor_email" name="donor_email" value="<?php echo htmlspecialchars($donation['donor_email'] ?? ''); ?>">
                        <div class="form-text">Optionnel, pour contacter le donateur.</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount" class="form-label">Montant (€) *</label>
                                <input type="number" class="form-control" id="amount" name="amount" step="0.01" min="0.01" value="<?php echo $donation['amount']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="donation_date" class="form-label">Date du don *</label>
                                <input type="date" class="form-control" id="donation_date" name="donation_date" value="<?php echo $donation['donation_date']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="project_id" class="form-label">Projet associé</label>
                        <select class="form-control" id="project_id" name="project_id">
                            <option value="">Don général (sans projet spécifique)</option>
                            <?php if (!empty($projects)): ?>
                                <?php foreach ($projects as $project): ?>
                                    <option value="<?php echo $project['id']; ?>" <?php echo ($donation['project_id'] == $project['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($project['name']); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="payment_method" class="form-label">Méthode de paiement *</label>
                        <select class="form-control" id="payment_method" name="payment_method" required>
                            <option value="cash" <?php echo $donation['payment_method'] === 'cash' ? 'selected' : ''; ?>>Espèces</option>
                            <option value="bank_transfer" <?php echo $donation['payment_method'] === 'bank_transfer' ? 'selected' : ''; ?>>Virement bancaire</option>
                            <option value="online" <?php echo $donation['payment_method'] === 'online' ? 'selected' : ''; ?>>Paiement en ligne</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"><?php echo htmlspecialchars($donation['notes'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        <a href="<?php echo BASE_URL; ?>/donations" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>