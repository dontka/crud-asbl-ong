<?php
$pageTitle = $pageTitle ?? 'Gestion des Employés';
?>

<div class="main-content">

    <!-- Employees Table -->
    <div class="chart-card" style="margin: var(--spacing-xl);">
        <div class="chart-header">
            <h3>Liste des Employés</h3>
            <div class="nav-actions">
                <a href="/hr/create" class="nav-btn">
                    <i class="fas fa-plus"></i> Ajouter un Employé
                </a>
            </div>
        </div>

        <div class="chart-content">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: var(--gray-50);">
                        <tr>
                            <th style="padding: var(--spacing-md); text-align: left; border-bottom: 2px solid var(--gray-200);">Nom</th>
                            <th style="padding: var(--spacing-md); text-align: left; border-bottom: 2px solid var(--gray-200);">Email</th>
                            <th style="padding: var(--spacing-md); text-align: left; border-bottom: 2px solid var(--gray-200);">Poste</th>
                            <th style="padding: var(--spacing-md); text-align: left; border-bottom: 2px solid var(--gray-200);">Département</th>
                            <th style="padding: var(--spacing-md); text-align: left; border-bottom: 2px solid var(--gray-200);">Date d'Embauche</th>
                            <th style="padding: var(--spacing-md); text-align: center; border-bottom: 2px solid var(--gray-200);">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($employees->data)): ?>
                            <?php foreach ($employees->data as $employee): ?>
                                <tr style="border-bottom: 1px solid var(--gray-200); transition: var(--transition);" onmouseover="this.style.backgroundColor='var(--gray-50)'" onmouseout="this.style.backgroundColor='transparent'">
                                    <td style="padding: var(--spacing-md);">
                                        <strong><?php echo htmlspecialchars($employee->first_name . ' ' . $employee->last_name); ?></strong>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <a href="mailto:<?php echo htmlspecialchars($employee->email); ?>" style="color: var(--primary); text-decoration: none;">
                                            <?php echo htmlspecialchars($employee->email); ?>
                                        </a>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <?php echo htmlspecialchars($employee->position ?? 'N/A'); ?>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <span style="background: rgba(123, 97, 255, 0.1); color: var(--primary); padding: 4px 8px; border-radius: var(--border-radius-sm); font-size: var(--font-size-xs);">
                                            <?php echo htmlspecialchars($employee->department ?? 'N/A'); ?>
                                        </span>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <?php echo date('d/m/Y', strtotime($employee->hire_date)); ?>
                                    </td>
                                    <td style="padding: var(--spacing-md); text-align: center;">
                                        <a href="/hr/<?php echo $employee->id; ?>" title="Voir" style="margin-right: var(--spacing-sm); color: var(--primary);">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="/hr/<?php echo $employee->id; ?>/edit" title="Modifier" style="margin-right: var(--spacing-sm); color: var(--primary);">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="padding: var(--spacing-xl); text-align: center; color: var(--gray-500);">
                                    <p>Aucun employé trouvé</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div style="display: flex; justify-content: center; gap: var(--spacing-sm); margin-top: var(--spacing-lg);">
                    <?php if ($page > 1): ?>
                        <a href="?page=1<?php echo isset($department) && $department ? '&department=' . urlencode($department) : ''; ?><?php echo isset($search) && $search ? '&search=' . urlencode($search) : ''; ?>" class="nav-btn" style="padding: var(--spacing-xs) var(--spacing-sm);">Début</a>
                        <a href="?page=<?php echo $page - 1; ?><?php echo isset($department) && $department ? '&department=' . urlencode($department) : ''; ?><?php echo isset($search) && $search ? '&search=' . urlencode($search) : ''; ?>" class="nav-btn" style="padding: var(--spacing-xs) var(--spacing-sm);">Précédent</a>
                    <?php endif; ?>

                    <span style="padding: var(--spacing-xs) var(--spacing-sm); color: var(--gray-600);">
                        Page <?php echo $page; ?> sur <?php echo $totalPages; ?>
                    </span>

                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?php echo $page + 1; ?><?php echo isset($department) && $department ? '&department=' . urlencode($department) : ''; ?><?php echo isset($search) && $search ? '&search=' . urlencode($search) : ''; ?>" class="nav-btn" style="padding: var(--spacing-xs) var(--spacing-sm);">Suivant</a>
                        <a href="?page=<?php echo $totalPages; ?><?php echo isset($department) && $department ? '&department=' . urlencode($department) : ''; ?><?php echo isset($search) && $search ? '&search=' . urlencode($search) : ''; ?>" class="nav-btn" style="padding: var(--spacing-xs) var(--spacing-sm);">Fin</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Filters -->
    <div class="chart-card" style="margin: var(--spacing-xl);">
        <div class="chart-content">
            <form method="GET" action="/hr" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--spacing-lg); align-items: end;">
                <div>
                    <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600;">Rechercher</label>
                    <input type="text" name="search" placeholder="Nom, email, numéro..."
                        value="<?php echo htmlspecialchars($search ?? ''); ?>"
                        style="width: 100%; padding: var(--spacing-sm); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                </div>
                <div>
                    <label style="display: block; margin-bottom: var(--spacing-sm); font-weight: 600;">Département</label>
                    <select name="department" style="width: 100%; padding: var(--spacing-sm); border: 1px solid var(--gray-300); border-radius: var(--border-radius);">
                        <option value="">Tous les départements</option>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?php echo htmlspecialchars($dept); ?>"
                                <?php echo ($department === $dept) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($dept); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="nav-btn" style="justify-self: start;">
                    <i class="fas fa-search"></i> Filtrer
                </button>
            </form>
        </div>
    </div>


</div>