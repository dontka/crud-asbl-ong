<?php
$pageTitle = $pageTitle ?? 'Gestion des Compétences';
?>

<div class="main-content">
    
 <!-- Skills List by Category -->
    <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $category): ?>
            <div class="chart-card" style="margin: var(--spacing-xl);">
                <!-- Header -->
    <div class="dashboard-nav">
        <div class="nav-container">
            <div class="nav-left">
                <h1><i class="fas fa-star" style="margin-right: 0.5rem; color: var(--primary);"></i>Gestion des Compétences</h1>
            </div>
            <div class="nav-actions">
                <form method="GET" style="display: flex; gap: var(--spacing-md); align-items: center;">
                    <input type="text" name="search" placeholder="Rechercher une compétence..." 
                        style="padding: var(--spacing-sm); border: 1px solid var(--gray-300); border-radius: var(--border-radius); flex: 1; max-width: 300px;">
                    <button type="submit" class="nav-btn">
                        <i class="fas fa-search"></i> Rechercher
                    </button>
                </form>
                <a href="/hr/skills/create" class="nav-btn btn-primary">
                    <i class="fas fa-plus"></i> Nouvelle Compétence
                </a>
            </div>
        </div>
    </div>
                <div class="chart-header">
                    <h3><i class="fas fa-folder" style="margin-right: 0.5rem;"></i><?php echo htmlspecialchars($category); ?></h3>
                </div>
                <div class="chart-content">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead style="background: var(--gray-50);">
                                <tr>
                                    <th style="padding: var(--spacing-md); text-align: left; border-bottom: 2px solid var(--gray-200); font-weight: 600;">Compétence</th>
                                    <th style="padding: var(--spacing-md); text-align: left; border-bottom: 2px solid var(--gray-200); font-weight: 600;">Description</th>
                                    <th style="padding: var(--spacing-md); text-align: center; border-bottom: 2px solid var(--gray-200); font-weight: 600;">Employés</th>
                                    <th style="padding: var(--spacing-md); text-align: center; border-bottom: 2px solid var(--gray-200); font-weight: 600;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $categorySkills = array_filter($skills ?? [], function($s) use ($category) {
                                    return ($s['category'] ?? null) === $category;
                                });
                                
                                if (empty($categorySkills)): 
                                ?>
                                    <tr>
                                        <td colspan="4" style="padding: var(--spacing-lg); text-align: center; color: var(--gray-500);">
                                            Aucune compétence dans cette catégorie.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($categorySkills as $skill): ?>
                                        <tr style="border-bottom: 1px solid var(--gray-200);">
                                            <td style="padding: var(--spacing-md);"><strong><?php echo htmlspecialchars($skill['name'] ?? ''); ?></strong></td>
                                            <td style="padding: var(--spacing-md); color: var(--gray-600);">
                                                <?php echo htmlspecialchars(substr($skill['description'] ?? '', 0, 100)); ?>
                                                <?php if (strlen($skill['description'] ?? '') > 100): ?>...<?php endif; ?>
                                            </td>
                                            <td style="padding: var(--spacing-md); text-align: center;">
                                                <span style="background: var(--gray-100); padding: 4px 12px; border-radius: var(--border-radius-sm); font-weight: 600; color: var(--primary);">
                                                    <?php echo htmlspecialchars($skill['employee_count'] ?? 0); ?>
                                                </span>
                                            </td>
                                            <td style="padding: var(--spacing-md); text-align: center;">
                                                <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;">
                                                    <a href="/hr/skills/<?php echo $skill['id']; ?>/edit" title="Éditer" 
                                                       style="padding: 6px 10px; background: var(--primary); color: white; border-radius: 4px; text-decoration: none; font-size: 12px;">
                                                        <i class="fas fa-edit"></i> Éditer
                                                    </a>
                                                    <a href="/hr/skills/<?php echo $skill['id']; ?>/delete" title="Supprimer" 
                                                       style="padding: 6px 10px; background: var(--error); color: white; border-radius: 4px; text-decoration: none; font-size: 12px;"
                                                       onclick="return confirm('Confirmer la suppression ?')">
                                                        <i class="fas fa-trash"></i> Suppr.
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="chart-card" style="margin: var(--spacing-xl);">
            <div class="chart-content" style="text-align: center; padding: var(--spacing-xl);">
                <p style="color: var(--gray-500); font-size: var(--font-size-lg);">
                    <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: var(--spacing-md); display: block;"></i>
                    Aucune compétence trouvée.
                </p>
                <a href="/hr/skills/create" class="nav-btn btn-primary" style="margin-top: var(--spacing-lg);">
                    <i class="fas fa-plus"></i> Créer la première compétence
                </a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--spacing-lg); margin: var(--spacing-xl);">
        <div class="chart-card" style="background: linear-gradient(135deg, rgba(123, 97, 255, 0.1), rgba(155, 137, 255, 0.05));">
            <div class="chart-content">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <p style="color: var(--gray-600); font-size: var(--font-size-sm); margin: 0 0 var(--spacing-xs) 0;">Total Compétences</p>
                        <h2 style="color: var(--primary); font-size: var(--font-size-4xl); margin: 0;"><?php echo htmlspecialchars($totalSkills ?? 0); ?></h2>
                    </div>
                    <i class="fas fa-star" style="font-size: 2rem; color: rgba(123, 97, 255, 0.3);"></i>
                </div>
            </div>
        </div>

        <div class="chart-card" style="background: linear-gradient(135deg, rgba(0, 196, 204, 0.1), rgba(0, 212, 170, 0.05));">
            <div class="chart-content">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <p style="color: var(--gray-600); font-size: var(--font-size-sm); margin: 0 0 var(--spacing-xs) 0;">Catégories</p>
                        <h2 style="color: var(--secondary); font-size: var(--font-size-4xl); margin: 0;"><?php echo htmlspecialchars(count($categories ?? [])); ?></h2>
                    </div>
                    <i class="fas fa-tags" style="font-size: 2rem; color: rgba(0, 196, 204, 0.3);"></i>
                </div>
            </div>
        </div>
    </div>

   
    <!-- Quick Stats -->
    <div class="chart-card" style="margin: var(--spacing-xl);">
        <div class="chart-header">
            <h3><i class="fas fa-chart-bar" style="margin-right: 0.5rem;"></i>Statistiques</h3>
        </div>
        <div class="chart-content">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--spacing-lg);">
                <?php 
                $topSkills = $skills ?? [];
                usort($topSkills, function($a, $b) {
                    return ($b['employee_count'] ?? 0) - ($a['employee_count'] ?? 0);
                });
                $topSkills = array_slice($topSkills, 0, 5);
                ?>
                <div>
                    <h4 style="color: var(--gray-700); margin-bottom: var(--spacing-md);">Top 5 Compétences Requises</h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <?php foreach ($topSkills as $skill): ?>
                            <li style="display: flex; justify-content: space-between; padding: var(--spacing-sm) 0; border-bottom: 1px solid var(--gray-100);">
                                <span><?php echo htmlspecialchars($skill['name'] ?? ''); ?></span>
                                <span style="color: var(--primary); font-weight: 600;"><?php echo $skill['employee_count'] ?? 0; ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div>
                    <h4 style="color: var(--gray-700); margin-bottom: var(--spacing-md);">Distribution par Catégorie</h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <?php 
                        $categoryCount = [];
                        foreach ($skills ?? [] as $skill) {
                            $cat = $skill['category'] ?? 'Non catégorisé';
                            $categoryCount[$cat] = ($categoryCount[$cat] ?? 0) + 1;
                        }
                        foreach ($categoryCount as $cat => $count):
                        ?>
                            <li style="display: flex; justify-content: space-between; padding: var(--spacing-sm) 0; border-bottom: 1px solid var(--gray-100);">
                                <span><?php echo htmlspecialchars($cat); ?></span>
                                <span style="background: var(--primary); color: white; padding: 2px 8px; border-radius: 4px; font-size: var(--font-size-sm);"><?php echo $count; ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .nav-actions {
            display: none;
        }

        .chart-card {
            page-break-inside: avoid;
        }
    }
</style>
