<?php
$pageTitle = $pageTitle ?? 'Gestion des Contrats';
?>

<div class="main-content">
    <!-- Header Navigation -->
    <!-- Contracts Table Section -->
    <div class="chart-card" style="margin: 2rem 1rem;">
        <div style="padding: 2rem; border-bottom: 2px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: var(--primary-color); font-size: 1.3rem; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-list"></i> Liste des Contrats
                <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; margin-left: auto;"><?php echo count($contracts ?? []); ?> contrats</span>
            </h3>
            <div class="nav-right">
                <a href="/hr/create-contract" class="nav-btn btn-primary">
                    <i class="fas fa-plus"></i> Nouveau Contrat
                </a>
            </div>
        </div>

        <div class="chart-content" style="padding: 0;">
            <?php if (empty($contracts ?? [])): ?>
                <div style="padding: 3rem; text-align: center;">
                    <i class="fas fa-inbox" style="font-size: 3rem; color: var(--gray-300); margin-bottom: 1rem; display: block;"></i>
                    <h4 style="color: var(--gray-500); margin: 1rem 0;">Aucun contrat enregistré</h4>
                    <p style="color: var(--gray-400); margin-bottom: 1.5rem;">Commencez par créer votre premier contrat</p>
                    <a href="/hr/create-contract" class="nav-btn btn-primary" style="display: inline-block;">
                        <i class="fas fa-plus"></i> Créer le premier contrat
                    </a>
                </div>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: var(--gray-50); border-bottom: 2px solid var(--gray-200);">
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--primary-color);">
                                    <i class="fas fa-user"></i> Employé
                                </th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--primary-color);">
                                    <i class="fas fa-file-alt"></i> Type
                                </th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--primary-color);">
                                    <i class="fas fa-calendar"></i> Début
                                </th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--primary-color);">
                                    <i class="fas fa-calendar-times"></i> Fin
                                </th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--primary-color);">
                                    <i class="fas fa-flag"></i> Statut
                                </th>
                                <th style="padding: 1rem; text-align: center; font-weight: 600; color: var(--primary-color);">
                                    <i class="fas fa-cogs"></i> Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contracts as $index => $contract): ?>
                                <tr style="border-bottom: 1px solid var(--gray-200); transition: all 0.3s ease; animation: slideInUp 0.4s ease-out <?php echo (0.05 * $index); ?>s both;" onmouseover="this.style.backgroundColor='var(--gray-50)'" onmouseout="this.style.backgroundColor='transparent'">
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.9rem;">
                                                <?php echo strtoupper(substr($contract['employee_name'] ?? 'N', 0, 1)); ?>
                                            </div>
                                            <div>
                                                <strong style="display: block; color: var(--gray-900);"><?php echo htmlspecialchars($contract['employee_name'] ?? 'N/A'); ?></strong>
                                                <small style="color: var(--gray-500);">ID: <?php echo htmlspecialchars($contract['id'] ?? '-'); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <span style="display: inline-block; padding: 6px 12px; border-radius: 6px; font-size: 0.875rem; font-weight: 600;
                                            <?php
                                            $type = $contract['contract_type'] ?? '';
                                            if ($type === 'CDI') echo 'background-color: rgba(67, 233, 123, 0.15); color: #155724;';
                                            elseif ($type === 'CDD') echo 'background-color: rgba(79, 172, 254, 0.15); color: #004085;';
                                            else echo 'background-color: rgba(255, 107, 107, 0.15); color: #721c24;';
                                            ?>">
                                            <?php echo htmlspecialchars($type); ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; color: var(--gray-700); font-weight: 500;">
                                        <?php echo date('d/m/Y', strtotime($contract['start_date'] ?? '')); ?>
                                    </td>
                                    <td style="padding: 1rem; color: var(--gray-700);">
                                        <?php if (!empty($contract['end_date'])): ?>
                                            <span style="font-weight: 500;"><?php echo date('d/m/Y', strtotime($contract['end_date'])); ?></span>
                                        <?php else: ?>
                                            <span style="color: var(--gray-400); font-style: italic;">Indéterminé</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 20px; font-size: 0.875rem; font-weight: 600;
                                            <?php
                                            $status = $contract['status'] ?? '';
                                            if ($status === 'active' || $status === 'actif') {
                                                echo 'background-color: rgba(67, 233, 123, 0.2); color: #155724;';
                                            } elseif ($status === 'ended' || $status === 'termine') {
                                                echo 'background-color: rgba(255, 107, 107, 0.2); color: #721c24;';
                                            } else {
                                                echo 'background-color: rgba(255, 193, 7, 0.2); color: #856404;';
                                            }
                                            ?>">
                                            <i class="fas <?php echo ($status === 'active' || $status === 'actif') ? 'fa-check-circle' : (($status === 'ended' || $status === 'termine') ? 'fa-times-circle' : 'fa-pause-circle'); ?>"></i>
                                            <?php echo ucfirst($status ?? '-'); ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <div style="display: flex; gap: 8px; justify-content: center;">
                                            <a href="/hr/contract/<?php echo $contract['id']; ?>/edit" class="btn-link" style="padding: 6px 10px; background-color: rgba(102, 126, 234, 0.15); color: var(--primary-color); border-radius: 6px; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center; justify-content: center;" onmouseover="this.style.backgroundColor='rgba(102, 126, 234, 0.25)'; this.style.transform='scale(1.1)'" onmouseout="this.style.backgroundColor='rgba(102, 126, 234, 0.15)'; this.style.transform='scale(1)'">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="/hr/contract/<?php echo $contract['id']; ?>/delete" class="btn-link" style="padding: 6px 10px; background-color: rgba(255, 71, 87, 0.15); color: #dc3545; border-radius: 6px; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center; justify-content: center;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contrat ?');" onmouseover="this.style.backgroundColor='rgba(255, 71, 87, 0.25)'; this.style.transform='scale(1.1)'" onmouseout="this.style.backgroundColor='rgba(255, 71, 87, 0.15)'; this.style.transform='scale(1)'">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- KPI Statistics Section -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin: 2rem 1rem;">
        <!-- Total Contracts -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 1.5rem; border-radius: 12px; color: white; box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3); transition: all 0.3s ease; cursor: default;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(102, 126, 234, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 16px rgba(102, 126, 234, 0.3)'">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="margin: 0 0 8px 0; font-size: 0.9rem; opacity: 0.9; color: rgba(255,255,255,0.9);">Total de Contrats</p>
                    <h2 style="margin: 0; font-size: 2.5rem; font-weight: 700;"><?php echo count($contracts ?? []); ?></h2>
                </div>
                <i class="fas fa-file-contract" style="font-size: 2.5rem; opacity: 0.3;"></i>
            </div>
        </div>

        <!-- Active Contracts -->
        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); padding: 1.5rem; border-radius: 12px; color: white; box-shadow: 0 8px 16px rgba(67, 233, 123, 0.3); transition: all 0.3s ease; cursor: default;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(67, 233, 123, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 16px rgba(67, 233, 123, 0.3)'">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="margin: 0 0 8px 0; font-size: 0.9rem; opacity: 0.9; color: rgba(255,255,255,0.9);">Contrats Actifs</p>
                    <h2 style="margin: 0; font-size: 2.5rem; font-weight: 700;"><?php echo count(array_filter($contracts ?? [], fn($c) => $c['status'] === 'active' || $c['status'] === 'actif')); ?></h2>
                </div>
                <i class="fas fa-check-circle" style="font-size: 2.5rem; opacity: 0.3;"></i>
            </div>
        </div>

        <!-- CDI Contracts -->
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 1.5rem; border-radius: 12px; color: white; box-shadow: 0 8px 16px rgba(245, 87, 108, 0.3); transition: all 0.3s ease; cursor: default;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(245, 87, 108, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 16px rgba(245, 87, 108, 0.3)'">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="margin: 0 0 8px 0; font-size: 0.9rem; opacity: 0.9; color: rgba(255,255,255,0.9);">Contrats CDI</p>
                    <h2 style="margin: 0; font-size: 2.5rem; font-weight: 700;"><?php echo count(array_filter($contracts ?? [], fn($c) => ($c['contract_type'] ?? $c['type'] ?? '') === 'CDI')); ?></h2>
                </div>
                <i class="fas fa-handshake" style="font-size: 2.5rem; opacity: 0.3;"></i>
            </div>
        </div>

        <!-- CDD Contracts -->
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 1.5rem; border-radius: 12px; color: white; box-shadow: 0 8px 16px rgba(79, 172, 254, 0.3); transition: all 0.3s ease; cursor: default;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(79, 172, 254, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 16px rgba(79, 172, 254, 0.3)'">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="margin: 0 0 8px 0; font-size: 0.9rem; opacity: 0.9; color: rgba(255,255,255,0.9);">Contrats CDD</p>
                    <h2 style="margin: 0; font-size: 2.5rem; font-weight: 700;"><?php echo count(array_filter($contracts ?? [], fn($c) => ($c['contract_type'] ?? $c['type'] ?? '') === 'CDD')); ?></h2>
                </div>
                <i class="fas fa-calendar-check" style="font-size: 2.5rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>


</div>

<style>
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn-link {
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    table tbody tr {
        transition: all 0.3s ease;
    }

    table tbody tr:hover {
        background-color: var(--gray-50);
    }

    @media (max-width: 768px) {
        [style*="grid-template-columns: repeat"] {
            grid-template-columns: 1fr !important;
        }

        table {
            font-size: 0.85rem;
        }

        table th,
        table td {
            padding: 0.75rem !important;
        }
    }
</style>