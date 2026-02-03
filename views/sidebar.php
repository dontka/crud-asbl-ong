<!-- Floating Sidebar -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<aside class="floating-sidebar" id="floatingSidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <h2 class="sidebar-title">Menu</h2>
        <button class="sidebar-close" id="sidebarClose" aria-label="Fermer la barre latérale">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Sidebar Content -->
    <nav class="sidebar-nav">
        <!-- Modules Principaux -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Modules Principaux</div>

            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="<?php echo BASE_URL; ?>/dashboard" class="sidebar-link">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="<?php echo BASE_URL; ?>/members" class="sidebar-link">
                        <i class="fas fa-users"></i>
                        <span>Membres</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="<?php echo BASE_URL; ?>/projects" class="sidebar-link">
                        <i class="fas fa-project-diagram"></i>
                        <span>Projets</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="<?php echo BASE_URL; ?>/events" class="sidebar-link">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Événements</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="<?php echo BASE_URL; ?>/donations" class="sidebar-link">
                        <i class="fas fa-hand-holding-heart"></i>
                        <span>Dons</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Fonctionnalités Avancées -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Fonctionnalités Avancées</div>

            <!-- Gestion RH -->
            <div class="sidebar-submenu">
                <button class="sidebar-submenu-toggle" data-target="hr-menu">
                    <i class="fas fa-users-cog"></i>
                    <span>Gestion RH</span>
                    <i class="fas fa-chevron-right toggle-icon"></i>
                </button>
                <ul class="sidebar-submenu-items" id="hr-menu" style="display: none;">
                    <li><a href="<?php echo BASE_URL; ?>/hr" class="sidebar-link-sub">
                            <i class="fas fa-id-card"></i> Dossiers Salariés
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/hr/contracts" class="sidebar-link-sub">
                            <i class="fas fa-file-contract"></i> Gestion Contrats
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/hr/absences" class="sidebar-link-sub">
                            <i class="fas fa-calendar-times"></i> Absences & Congés
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/hr/payroll" class="sidebar-link-sub">
                            <i class="fas fa-money-bill-wave"></i> Paie
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/hr/recruitment" class="sidebar-link-sub">
                            <i class="fas fa-briefcase"></i> Recrutement
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/hr/skills" class="sidebar-link-sub">
                            <i class="fas fa-star"></i> Compétences & Formations
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/hr/evaluations" class="sidebar-link-sub">
                            <i class="fas fa-chart-line"></i> Évaluations
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/hr/dashboard" class="sidebar-link-sub">
                            <i class="fas fa-th-large"></i> Tableau de Bord RH
                        </a></li>
                </ul>
            </div>

            <!-- Gestion Financière -->
            <div class="sidebar-submenu">
                <button class="sidebar-submenu-toggle" data-target="finance-menu">
                    <i class="fas fa-coins"></i>
                    <span>Gestion Financière</span>
                    <i class="fas fa-chevron-right toggle-icon"></i>
                </button>
                <ul class="sidebar-submenu-items" id="finance-menu" style="display: none;">
                    <li><a href="<?php echo BASE_URL; ?>/finance/budgets" class="sidebar-link-sub">
                            <i class="fas fa-chart-pie"></i> Budgétisation
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/finance/accounting" class="sidebar-link-sub">
                            <i class="fas fa-book"></i> Comptabilité
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/finance/reconciliation" class="sidebar-link-sub">
                            <i class="fas fa-align-justify"></i> Rapprochement Bancaire
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/finance/invoicing" class="sidebar-link-sub">
                            <i class="fas fa-receipt"></i> Facturation
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/finance/payments" class="sidebar-link-sub">
                            <i class="fas fa-wallet"></i> Gestion Paiements
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/finance/reports" class="sidebar-link-sub">
                            <i class="fas fa-file-pdf"></i> Rapports Financiers
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/finance/taxes" class="sidebar-link-sub">
                            <i class="fas fa-percent"></i> Gestion Fiscale
                        </a></li>
                </ul>
            </div>

            <!-- Gestion Projets -->
            <div class="sidebar-submenu">
                <button class="sidebar-submenu-toggle" data-target="projects-menu">
                    <i class="fas fa-tasks"></i>
                    <span>Gestion Projets</span>
                    <i class="fas fa-chevron-right toggle-icon"></i>
                </button>
                <ul class="sidebar-submenu-items" id="projects-menu" style="display: none;">
                    <li><a href="<?php echo BASE_URL; ?>/projects/list" class="sidebar-link-sub">
                            <i class="fas fa-list"></i> Liste des Projets
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/projects/gantt" class="sidebar-link-sub">
                            <i class="fas fa-chart-gantt"></i> Gantt
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/projects/kanban" class="sidebar-link-sub">
                            <i class="fas fa-columns"></i> Kanban
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/projects/tasks" class="sidebar-link-sub">
                            <i class="fas fa-check-square"></i> Gestion des Tâches
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/projects/resources" class="sidebar-link-sub">
                            <i class="fas fa-cube"></i> Ressources
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/projects/risks" class="sidebar-link-sub">
                            <i class="fas fa-exclamation-triangle"></i> Risques
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/projects/reporting" class="sidebar-link-sub">
                            <i class="fas fa-chart-bar"></i> Reporting
                        </a></li>
                </ul>
            </div>

            <!-- CRM & Relations -->
            <div class="sidebar-submenu">
                <button class="sidebar-submenu-toggle" data-target="crm-menu">
                    <i class="fas fa-handshake"></i>
                    <span>CRM & Relations</span>
                    <i class="fas fa-chevron-right toggle-icon"></i>
                </button>
                <ul class="sidebar-submenu-items" id="crm-menu" style="display: none;">
                    <li><a href="<?php echo BASE_URL; ?>/crm/contacts" class="sidebar-link-sub">
                            <i class="fas fa-address-book"></i> Contacts
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/crm/interactions" class="sidebar-link-sub">
                            <i class="fas fa-comments"></i> Interactions
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/crm/segmentation" class="sidebar-link-sub">
                            <i class="fas fa-filter"></i> Segmentation
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/crm/campaigns" class="sidebar-link-sub">
                            <i class="fas fa-bullhorn"></i> Campagnes
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/crm/engagement" class="sidebar-link-sub">
                            <i class="fas fa-heart"></i> Engagement & Fidélisation
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/crm/scoring" class="sidebar-link-sub">
                            <i class="fas fa-trophy"></i> Scoring
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/crm/preferences" class="sidebar-link-sub">
                            <i class="fas fa-cog"></i> Préférences & Consentements
                        </a></li>
                </ul>
            </div>

            <!-- Gestion Documentaire -->
            <div class="sidebar-submenu">
                <button class="sidebar-submenu-toggle" data-target="documents-menu">
                    <i class="fas fa-file-alt"></i>
                    <span>Gestion Documentaire</span>
                    <i class="fas fa-chevron-right toggle-icon"></i>
                </button>
                <ul class="sidebar-submenu-items" id="documents-menu" style="display: none;">
                    <li><a href="<?php echo BASE_URL; ?>/documents/ged" class="sidebar-link-sub">
                            <i class="fas fa-folder"></i> GED
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/documents/versions" class="sidebar-link-sub">
                            <i class="fas fa-history"></i> Versioning
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/documents/workflows" class="sidebar-link-sub">
                            <i class="fas fa-code-branch"></i> Workflows Validation
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/documents/signatures" class="sidebar-link-sub">
                            <i class="fas fa-pen"></i> Signatures Électroniques
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/documents/archiving" class="sidebar-link-sub">
                            <i class="fas fa-archive"></i> Archivage Légal
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/documents/search" class="sidebar-link-sub">
                            <i class="fas fa-search"></i> Recherche Plein Texte
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/documents/compliance" class="sidebar-link-sub">
                            <i class="fas fa-shield-alt"></i> Conformité RGPD
                        </a></li>
                    <li><a href="<?php echo BASE_URL; ?>/documents/audit" class="sidebar-link-sub">
                            <i class="fas fa-clipboard-list"></i> Audit Trail
                        </a></li>
                </ul>
            </div>
        </div>

        <!-- Administration -->
        <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['role'], ['admin', 'moderator'])): ?>
            <div class="sidebar-section">
                <div class="sidebar-section-title">Administration</div>

                <ul class="sidebar-menu">
                    <li class="sidebar-menu-item">
                        <a href="<?php echo BASE_URL; ?>/users" class="sidebar-link">
                            <i class="fas fa-user-shield"></i>
                            <span>Gestion Utilisateurs</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo BASE_URL; ?>/settings" class="sidebar-link">
                            <i class="fas fa-cogs"></i>
                            <span>Paramètres</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo BASE_URL; ?>/logs" class="sidebar-link">
                            <i class="fas fa-history"></i>
                            <span>Journaux</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="<?php echo BASE_URL; ?>/documentation" class="sidebar-link">
                            <i class="fas fa-book"></i>
                            <span>Documentation</span>
                        </a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Support -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Support</div>

            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="<?php echo BASE_URL; ?>/help" class="sidebar-link">
                        <i class="fas fa-question-circle"></i>
                        <span>Aide</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="<?php echo BASE_URL; ?>/documentation" class="sidebar-link">
                        <i class="fas fa-book"></i>
                        <span>Documentation</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="user-details">
                <p class="user-name"><?php echo isset($_SESSION['user']['username']) ? htmlspecialchars($_SESSION['user']['username']) : 'Utilisateur'; ?></p>
                <p class="user-role"><?php echo isset($_SESSION['user']['role']) ? htmlspecialchars($_SESSION['user']['role']) : 'Invité'; ?></p>
            </div>
        </div>
        <a href="<?php echo BASE_URL; ?>/logout" class="logout-link" title="Déconnexion">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>
</aside>

<!-- Sidebar Toggle Button (for when sidebar is closed) -->
<button class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Ouvrir la barre latérale" title="Menu">
    <i class="fas fa-bars"></i>
</button>