<?php

/**
 * Vue d'accueil de la documentation
 * Phase 7.3: Documentation et Maintenance - Intégration in situ
 */
?>

<div class="documentation-container">
    <div class="doc-header">
        <h1><i class="fas fa-book"></i> Documentation du système</h1>
        <p class="doc-subtitle">Guide complet pour utilisateurs, développeurs et administrateurs</p>
    </div>

    <div class="doc-grid">
        <div class="doc-card">
            <div class="doc-card-header">
                <i class="fas fa-user-friends"></i>
                <h3>Guide d'utilisation</h3>
            </div>
            <div class="doc-card-content">
                <p>Apprenez à utiliser toutes les fonctionnalités du système CRUD ASBL-ONG.</p>
                <ul>
                    <li>Connexion et rôles utilisateurs</li>
                    <li>Gestion des membres</li>
                    <li>Organisation d'événements</li>
                    <li>Suivi des projets et dons</li>
                    <li>Rapports et exports</li>
                </ul>
            </div>
            <div class="doc-card-footer">
                <a href="/documentation?action=userGuide" class="btn btn-primary">
                    <i class="fas fa-eye"></i> Consulter le guide
                </a>
            </div>
        </div>

        <div class="doc-card">
            <div class="doc-card-header">
                <i class="fas fa-cogs"></i>
                <h3>Documentation technique</h3>
            </div>
            <div class="doc-card-content">
                <p>Informations techniques pour les développeurs et administrateurs système.</p>
                <ul>
                    <li>Architecture MVC</li>
                    <li>Schéma de base de données</li>
                    <li>API et sécurité</li>
                    <li>Migrations et déploiement</li>
                </ul>
            </div>
            <div class="doc-card-footer">
                <a href="/documentation?action=technicalDoc" class="btn btn-secondary">
                    <i class="fas fa-code"></i> Voir la documentation
                </a>
            </div>
        </div>

        <div class="doc-card">
            <div class="doc-card-header">
                <i class="fas fa-tools"></i>
                <h3>Plan de maintenance</h3>
            </div>
            <div class="doc-card-content">
                <p>Procédures de maintenance, sauvegarde et mise à jour du système.</p>
                <ul>
                    <li>Sauvegardes automatiques</li>
                    <li>Monitoring système</li>
                    <li>Mises à jour de sécurité</li>
                    <li>Procédures d'urgence</li>
                </ul>
            </div>
            <div class="doc-card-footer">
                <a href="/documentation?action=maintenance" class="btn btn-warning">
                    <i class="fas fa-wrench"></i> Plan de maintenance
                </a>
            </div>
        </div>

        <div class="doc-card">
            <div class="doc-card-header">
                <i class="fas fa-plug"></i>
                <h3>Référence API</h3>
            </div>
            <div class="doc-card-content">
                <p>Documentation complète des points d'entrée API du système.</p>
                <ul>
                    <li>Authentification</li>
                    <li>Gestion des membres</li>
                    <li>Événements et projets</li>
                    <li>Dons et rapports</li>
                </ul>
            </div>
            <div class="doc-card-footer">
                <a href="/documentation?action=api" class="btn btn-info">
                    <i class="fas fa-terminal"></i> Référence API
                </a>
            </div>
        </div>
    </div>

    <div class="doc-quick-links">
        <h2><i class="fas fa-link"></i> Liens rapides</h2>
        <div class="quick-links-grid">
            <a href="index.php?controller=dashboard&action=index" class="quick-link">
                <i class="fas fa-tachometer-alt"></i>
                <span>Tableau de bord</span>
            </a>
            <a href="/members" class="quick-link">
                <i class="fas fa-users"></i>
                <span>Gestion membres</span>
            </a>
            <a href="/events" class="quick-link">
                <i class="fas fa-calendar"></i>
                <span>Événements</span>
            </a>
            <a href="/projects" class="quick-link">
                <i class="fas fa-project-diagram"></i>
                <span>Projets</span>
            </a>
            <a href="/donations" class="quick-link">
                <i class="fas fa-donate"></i>
                <span>Dons</span>
            </a>
            <a href="monitor.php" class="quick-link" target="_blank">
                <i class="fas fa-heartbeat"></i>
                <span>Monitoring</span>
            </a>
        </div>
    </div>

    <div class="doc-info">
        <div class="info-box">
            <h3><i class="fas fa-info-circle"></i> À propos de cette documentation</h3>
            <p>Cette documentation est intégrée directement dans le système pour un accès facile et rapide. Elle est automatiquement mise à jour avec les nouvelles versions du système.</p>
            <p><strong>Dernière mise à jour :</strong> <?php echo date('d/m/Y'); ?></p>
            <p><strong>Version du système :</strong> 1.0</p>
        </div>
    </div>
</div>

<style>
    .documentation-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .doc-header {
        text-align: center;
        margin-bottom: 40px;
        padding: 30px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .doc-header h1 {
        margin: 0 0 10px 0;
        font-size: 2.5em;
    }

    .doc-subtitle {
        margin: 0;
        font-size: 1.2em;
        opacity: 0.9;
    }

    .doc-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }

    .doc-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .doc-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .doc-card-header {
        background: #f8f9fa;
        padding: 20px;
        text-align: center;
        border-bottom: 1px solid #dee2e6;
    }

    .doc-card-header i {
        font-size: 2em;
        color: #007bff;
        margin-bottom: 10px;
    }

    .doc-card-header h3 {
        margin: 0;
        color: #333;
    }

    .doc-card-content {
        padding: 20px;
    }

    .doc-card-content ul {
        margin: 15px 0 0 0;
        padding-left: 20px;
    }

    .doc-card-content li {
        margin-bottom: 5px;
        color: #666;
    }

    .doc-card-footer {
        padding: 20px;
        background: #f8f9fa;
        text-align: center;
        border-top: 1px solid #dee2e6;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background: #0056b3;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #545b62;
    }

    .btn-warning {
        background: #ffc107;
        color: #212529;
    }

    .btn-warning:hover {
        background: #e0a800;
    }

    .btn-info {
        background: #17a2b8;
        color: white;
    }

    .btn-info:hover {
        background: #138496;
    }

    .doc-quick-links {
        margin-bottom: 40px;
    }

    .doc-quick-links h2 {
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }

    .quick-links-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
    }

    .quick-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        background: white;
        border-radius: 8px;
        text-decoration: none;
        color: #333;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .quick-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        color: #007bff;
    }

    .quick-link i {
        font-size: 2em;
        margin-bottom: 10px;
        color: #007bff;
    }

    .quick-link span {
        font-weight: 500;
        text-align: center;
    }

    .doc-info {
        margin-top: 40px;
    }

    .info-box {
        background: #e9ecef;
        padding: 30px;
        border-radius: 10px;
        border-left: 5px solid #007bff;
    }

    .info-box h3 {
        color: #333;
        margin-top: 0;
    }

    .info-box p {
        margin: 10px 0;
        color: #666;
    }

    @media (max-width: 768px) {
        .doc-grid {
            grid-template-columns: 1fr;
        }

        .quick-links-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .doc-header h1 {
            font-size: 2em;
        }
    }
</style>