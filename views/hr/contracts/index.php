<?php
$pageTitle = $pageTitle ?? 'Gestion des Contrats';

// Calculer les statistiques
$stats = [
    'total' => count($contracts ?? []),
    'cdi' => count(array_filter($contracts ?? [], fn($c) => $c['contract_type'] === 'CDI')),
    'cdd' => count(array_filter($contracts ?? [], fn($c) => $c['contract_type'] === 'CDD')),
    'active' => count(array_filter($contracts ?? [], fn($c) => $c['status'] === 'active')),
];
?>

<div class="main-content">
    <!-- Header -->


    <!-- Contracts List -->
    <div class="chart-card" style="margin: var(--spacing-xl);">
        <div style="padding: 5px; border-bottom: 1px solid var(--gray-200); display: flex; ">

            <h3 style="margin: 2px; color: var(--primary-color);"><i class="fas fa-list" style="margin-right: 8px;"></i> Liste des Contrats</h3>
            <div style=" gap: 8px; margin: 2px;">
                <input type="text" id="searchInput" placeholder="Rechercher..." style="padding: 8px 12px; border: 1px solid var(--gray-300); border-radius: 6px; font-size: 0.9rem; transition: all 0.3s;">
                <select id="filterStatus" style="padding: 8px 12px; border: 1px solid var(--gray-300); border-radius: 6px; font-size: 0.9rem; cursor: pointer; transition: all 0.3s;">
                    <option value="">Tous les statuts</option>
                    <option value="active">Actif</option>
                    <option value="inactive">Inactif</option>
                    <option value="ended">Terminé</option>
                </select>
            </div>
            <div class="nav-right" style="margin-left: auto; margin-top: 2px;">
                <a href="/hr/create-contract" class="nav-btn btn-primary" style="transition: all 0.3s;">
                    <i class="fas fa-plus"></i> Nouveau Contrat
                </a>
            </div>
        </div>
        <div class="chart-content" style="padding: 0;">
            <?php if (empty($contracts ?? [])): ?>
                <div style="padding: var(--spacing-xl); text-align: center;">
                    <i class="fas fa-inbox" style="font-size: 3rem; color: var(--gray-300); margin-bottom: 12px; display: block;"></i>
                    <p style="color: var(--gray-500); font-size: 1rem;">Aucun contrat enregistré</p>
                    <a href="/hr/create-contract" style="color: var(--primary-color); text-decoration: none; font-weight: 600; margin-top: 12px; display: inline-block;">
                        <i class="fas fa-plus"></i> Créer le premier contrat
                    </a>
                </div>
            <?php else: ?>
                <div style="overflow-x: auto; margin: var(--spacing-xl);">
                    <table style=" width: 100%; border-collapse: collapse;" id="contractsTable">
                        <thead>
                            <tr style="background-color: var(--gray-50); border-bottom: 2px solid var(--gray-200);">
                                <th style="padding: var(--spacing-md); text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Employé</th>
                                <th style="padding: var(--spacing-md); text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Type</th>
                                <th style="padding: var(--spacing-md); text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Début</th>
                                <th style="padding: var(--spacing-md); text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Fin</th>
                                <th style="padding: var(--spacing-md); text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Statut</th>
                                <th style="padding: var(--spacing-md); text-align: center; font-weight: 600; color: var(--gray-700); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contracts as $contract): ?>
                                <tr class="contract-row" data-status="<?php echo $contract['status']; ?>" style="border-bottom: 1px solid var(--gray-200); transition: all 0.3s; cursor: pointer;">
                                    <td style="padding: var(--spacing-md);">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.9rem;">
                                                <?php echo strtoupper(substr($contract['employee_name'] ?? 'N', 0, 1)); ?>
                                            </div>
                                            <strong style="color: var(--gray-800);"><?php echo htmlspecialchars($contract['employee_name'] ?? 'N/A'); ?></strong>
                                        </div>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <span style="display: inline-block; padding: 4px 12px; background-color: var(--gray-100); color: var(--gray-700); border-radius: 20px; font-size: 0.85rem; font-weight: 500;">
                                            <?php echo htmlspecialchars($contract['contract_type'] ?? '-'); ?>
                                        </span>
                                    </td>
                                    <td style="padding: var(--spacing-md); color: var(--gray-700);">
                                        <i class="fas fa-calendar" style="color: var(--primary-color); margin-right: 6px;"></i>
                                        <?php echo date('d/m/Y', strtotime($contract['start_date'] ?? '')); ?>
                                    </td>
                                    <td style="padding: var(--spacing-md); color: var(--gray-700);">
                                        <?php if (!empty($contract['end_date'])): ?>
                                            <i class="fas fa-calendar-check" style="color: var(--primary-color); margin-right: 6px;"></i>
                                            <?php echo date('d/m/Y', strtotime($contract['end_date'])); ?>
                                        <?php else: ?>
                                            <span style="color: var(--gray-400); font-style: italic;">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: var(--spacing-md);">
                                        <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;
                                            <?php echo ($contract['status'] === 'active') ? 'background-color: #d4edda; color: #155724;' : 'background-color: #f8d7da; color: #721c24;'; ?>">
                                            <i class="fas <?php echo ($contract['status'] === 'active') ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                                            <?php echo ucfirst($contract['status'] ?? '-'); ?>
                                        </span>
                                    </td>
                                    <td style="padding: var(--spacing-md); text-align: center;">
                                        <div style="display: flex; gap: 8px; justify-content: center; transition: all 0.3s;">
                                            <a href="/hr/contract/<?php echo $contract['id']; ?>/edit" class="action-btn" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background-color: var(--gray-100); color: var(--primary-color); border-radius: 6px; text-decoration: none; transition: all 0.3s; border: none; cursor: pointer; font-size: 0.95rem;" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="/hr/contract/<?php echo $contract['id']; ?>/delete" class="action-btn" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contrat?');" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background-color: var(--gray-100); color: #dc3545; border-radius: 6px; text-decoration: none; transition: all 0.3s; border: none; cursor: pointer; font-size: 0.95rem;" title="Supprimer">
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
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--spacing-lg);margin: var(--spacing-xl);">
        <!-- Total Contracts -->
        <div class="chart-card" style="position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);"></div>
            <div class="chart-content" style="padding: var(--spacing-lg);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <p style="color: var(--gray-500); margin: 0 0 8px 0; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Total Contrats</p>
                        <h3 style="margin: 0; color: var(--primary-color); font-size: 2rem;"><?php echo $stats['total']; ?></h3>
                    </div>
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                        <i class="fas fa-file-contract"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- CDI Contracts -->
        <div class="chart-card" style="position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%);"></div>
            <div class="chart-content" style="padding: var(--spacing-lg);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <p style="color: var(--gray-500); margin: 0 0 8px 0; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Contrats CDI</p>
                        <h3 style="margin: 0; color: #f5576c; font-size: 2rem;"><?php echo $stats['cdi']; ?></h3>
                    </div>
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                        <i class="fas fa-briefcase"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- CDD Contracts -->
        <div class="chart-card" style="position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);"></div>
            <div class="chart-content" style="padding: var(--spacing-lg);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <p style="color: var(--gray-500); margin: 0 0 8px 0; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Contrats CDD</p>
                        <h3 style="margin: 0; color: #00f2fe; font-size: 2rem;"><?php echo $stats['cdd']; ?></h3>
                    </div>
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                        <i class="fas fa-calendar"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Contracts -->
        <div class="chart-card" style="position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);"></div>
            <div class="chart-content" style="padding: var(--spacing-lg);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <p style="color: var(--gray-500); margin: 0 0 8px 0; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Contrats Actifs</p>
                        <h3 style="margin: 0; color: #43e97b; font-size: 2rem;"><?php echo $stats['active']; ?></h3>
                    </div>
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<style>
    #searchInput,
    #filterStatus {
        background-color: white;
        color: var(--gray-800);
    }

    #searchInput::placeholder {
        color: var(--gray-400);
    }

    #searchInput:focus,
    #filterStatus:focus {
        outline: 0;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .contract-row {
        transition: all 0.3s ease;
    }

    .contract-row:hover {
        background-color: var(--gray-50);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .action-btn {
        transition: all 0.3s ease !important;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .contract-row.hidden {
        display: none;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const contractsTable = document.getElementById('contractsTable');

    if (contractsTable) {
        const rows = contractsTable.querySelectorAll('tbody tr');

        const filterContracts = () => {
            const searchTerm = searchInput.value.toLowerCase();
            const statusFilter = filterStatus.value;

            rows.forEach(row => {
                const employeeName = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const status = row.getAttribute('data-status');

                const matchesSearch = employeeName.includes(searchTerm);
                const matchesStatus = !statusFilter || status === statusFilter;

                if (matchesSearch && matchesStatus) {
                    row.classList.remove('hidden');
                    row.style.animation = 'fadeInUp 0.3s ease';
                } else {
                    row.classList.add('hidden');
                }
            });
        };

        searchInput.addEventListener('input', filterContracts);
        filterStatus.addEventListener('change', filterContracts);
    }
</script>